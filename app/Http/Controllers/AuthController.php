<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function users()
    {
        if(!auth()->check()) {
            return redirect()->to('/login');
        }

        DB::enableQueryLog();
        $query = User::query();

        $user = auth()->user();

        $select = [];

        $select[] = "(CASE WHEN manglik = '".$user->partner_manglik."' THEN 25 ELSE 0 END)";
        $select[] = "(CASE WHEN annual_income BETWEEN '".$user->partner_expected_income_min."' AND ".$user->partner_expected_income_max." THEN 25 ELSE 0 END)";

        if(!empty($user->partner_occupation)){
            $perc = round(25/count($user->partner_occupation));
            foreach ($user->partner_occupation as $item){
                $select[] = "(CASE WHEN occupation LIKE '".$item."' THEN ".$perc." ELSE 0 END)";
            }
        }

        if(!empty($user->partner_family_type)){
            $perc = round(25/count($user->partner_family_type));
            foreach ($user->partner_family_type as $item){
                $select[] = "(CASE WHEN family_type LIKE '".$item."' THEN ".$perc." ELSE 0 END)";
            }
        }

        $query->selectRaw("*,(".implode("+",$select).") as percent_of_total");

        $query->having('percent_of_total','>',0);
//        dd($query->toSql());

        $users = $query->orderBy('percent_of_total',"DESC")->paginate(10);

//        dd(DB::getQueryLog());

        return view('welcome',compact('users'));
    }

    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        if (auth()->attempt(request(['email', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'The email or password is incorrect, please try again'
            ]);
        }

        return redirect('/');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect()->to('/');
    }

    public function socialRedirect(){
        $redirectUrl = route('user.social.callback');
        return Socialite::with('google')->redirectUrl($redirectUrl)->redirect();
    }

    public function socialCallback(Request $request){
        if($request->has('error')){
            return redirect()->route('user.login');
        }

        try {
            $redirectUrl = route('user.social.callback');
            $socialUser = Socialite::driver('google')->redirectUrl($redirectUrl)->stateless()->user();
        }catch (\Exception $exception){
            return redirect()->route('user.login');
        }


        $socialId = $socialUser->getId();

        $name = explode(" ",$socialUser->getName());

        $user = [
            'first_name' => $name[0],
            'last_name' => isset($name[1]) ? $name[1] :'',
        ];

        if(!empty($socialUser->getEmail())){
            $user['email'] = $socialUser->getEmail();
        }else{
            $user['email'] = $socialUser->getEmail();
        }

        $user['google_id'] = $socialId;

        $dbUser = User::where(function ($q) use($user){
            $q->where('google_id', $user['google_id']);
            if(!empty($user['email'])) {
                $q->orWhere("email", $user['email']);
            }
        })->first();

        // if user already exist with email then we need to associate that user with google user id :: Jitendra
        if(!empty($dbUser)){
            $dbUser->google_id = $socialId;
            $dbUser->save();

            auth()->loginUsingId($dbUser->id);

            return redirect()->to('/');

        }else{

            // if user not exist with email or google id we need to get additional registration fields from user    :: Jitendra

            session(['social_user' => json_encode($user)]);

            return redirect()->route('user.register');
        }

    }
}
