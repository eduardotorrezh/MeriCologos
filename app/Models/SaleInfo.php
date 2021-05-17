<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInfo extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'pay_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function datesInfo(){
        return $this->hasOne(Sale::class);
    }

}
