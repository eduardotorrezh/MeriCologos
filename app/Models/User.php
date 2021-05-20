<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'active',
        'absences',
        'phone',
        'name',
        'last_name',
        'email',
        'password',
        'branch_office_id',
        "status_patient",
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }

    public function branchOffice(){
        return $this->belongsTo(BranchOffice::class);
    }
    
    public function doctorWithSpecialties(){
        return $this->hasMany(DoctorWithSpecialty::class);
    }

    public function dates(){
        return $this->hasMany(Date::class,'patient_id','id');
    }
}
