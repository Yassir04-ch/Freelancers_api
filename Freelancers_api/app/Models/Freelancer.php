<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Freelancer extends Model
{
    use HasFactory , HasApiTokens;
 
    protected $fillable = ['user_id','rating','portfolio','price','availability',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
 
    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'freelancer_technology');
    }
 
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
 
    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }
 
}
