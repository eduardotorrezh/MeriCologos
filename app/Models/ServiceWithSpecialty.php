<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceWithSpecialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id','specialty_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function service(){
        return $this->belongsTo(Service::class);
    }
    
    public function specialty(){
        return $this->belongsTo(Specialty::class);
    }
}
