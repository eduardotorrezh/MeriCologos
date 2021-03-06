<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatesInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'assistance','paid','locket'
    ];

    protected $casts = [
        'assistance' => 'boolean',
        'paid' => 'boolean',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function Dates(){
        return $this->hasMany(Date::class,'dates_infos_id');
    }


}
