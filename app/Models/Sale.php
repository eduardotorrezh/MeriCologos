<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_info_id','user_id','amount','sale_info_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function datesInfo(){
        return $this->belongsTo(DatesInfo::class,'date_info_id');
    }
    public function user_id(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function sale_info(){
        return $this->belongsTo(SaleInfo::class,'sale_info_id');
    }
}
