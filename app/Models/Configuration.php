<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'wsp_message_doctor','wsp_message_client','min_time_cancel_date','max_time_create_date'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
