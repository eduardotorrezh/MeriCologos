<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id','doctor_id','shift_id','dates_infos_id','date','service','estado','payed','initial_date','end_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function patient(){
        return $this->belongsTo(User::class,'patient_id');
    }

    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }

    public function shift(){
        return $this->belongsTo(Shifts::class,'shift_id');
    }

    public function dates_info(){
        return $this->belongsTo(DatesInfo::class,'dates_infos_id');
    }

}
