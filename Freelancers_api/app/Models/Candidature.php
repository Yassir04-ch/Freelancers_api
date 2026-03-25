<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
      use HasFactory; 
 
    protected $fillable = ['freelancer_id','mission_id','motivation_letter','price','status', ];
 
 
    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }
 
    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }
}
