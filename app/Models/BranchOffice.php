<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchOffice extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name','status'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function branchOffice(){
        return $this->belongsTo(BranchOffice::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
