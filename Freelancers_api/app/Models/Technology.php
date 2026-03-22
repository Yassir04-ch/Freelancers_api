<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technology extends Model
{
     protected $fillable = ['name'];
 
    public function freelancers()
    {
        return $this->belongsToMany(Freelancer::class, 'freelancer_technology');
    }

     public function missions()
    {
        return $this->belongsToMany(Mission::class, 'mission_technology');
    }
}
