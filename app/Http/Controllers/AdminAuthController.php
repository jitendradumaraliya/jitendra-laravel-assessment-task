<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class AdminAuthController extends Controller
{
    public function users(Request $request)
    {
        if(!auth()->guard('admin')->check()) {
            return redirect()->to('/admin/login');
        }

        $query = User::query();

        $query->selectRaw("*,TIMESTAMPDIFF(year, `dob`, '2021-11-18') as age");

        $filter = [];
        if($request->method() == 'POST') {

            if ($request->has('manglik') && !empty($request->manglik)) {
                $query->whereIn('manglik', $request->manglik);
            }

            if ($request->has('income_min') && !empty($request->income_min) && $request->has('income_max') && !empty($request->income_max)) {
                $query->havingBetween('annual_income', [$request->income_min, $request->income_max]);
            }

            if ($request->has('gender') && !empty($request->gender)) {
                $query->whereIn('gender', $request->gender);
            }

            if ($request->has('family_type') && !empty($request->family_type)) {
                $query->whereIn('family_type', $request->family_type);
            }

            if ($request->has('age') && !empty($request->age) && $request->age!=null) {
                $query->whereRaw("TIMESTAMPDIFF(year, `dob`, '".date('Y-m-d')."')=".$request->age);
            }

            $users = $query->orderBy('id',"DESC")->get();

            $filter = $request->all();
        }else{
            $users = $query->orderBy('id',"DESC")->paginate(10);
        }
        return view('admin-dashboard',compact('users','filter'));
    }

    public function create()
    {
        return view('admin-login');
    }

    public function store()
    {
        if (auth()->guard('admin')->attempt(request(['email', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'The email or password is incorrect, please try again'
            ]);
        }

        return redirect('/admin');
    }

    public function destroy()
    {
        auth()->guard('admin')->logout();

        return redirect()->to('/admin/login');
    }
}
