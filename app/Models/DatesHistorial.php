<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatesHistorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','action','date_info_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
