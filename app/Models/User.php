<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
//    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'dob',
        'gender',
        'annual_income',
        'occupation',
        'family_type',
        'manglik',
        'partner_expected_income_min',
        'partner_expected_income_max',
        'partner_occupation',
        'partner_family_type',
        'partner_manglik',
        'google_id',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }
    public function setPartnerOccupationAttribute($value){
        if(!empty($value)) {
            $this->attributes['partner_occupation'] = implode(", ", $value);
        }
    }
    public function setPartnerFamilyTypeAttribute($value){
        if(!empty($value)) {
            $this->attributes['partner_family_type'] = implode(", ", $value);
        }
    }

    public function getPartnerOccupationAttribute(){
        if(!empty($this->partner_occupation)) {
            return explode(", ", $this->partner_occupation);
        }
        return [];
    }
    public function getPartnerFamilyTypeAttribute(){
        if(!empty($this->partner_family_type)) {
            return implode(", ", $this->partner_family_type);
        }

        return [];
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'partner_expected_income_min' => 'integer',
        'partner_expected_income_max' => 'integer',
    ];
}
