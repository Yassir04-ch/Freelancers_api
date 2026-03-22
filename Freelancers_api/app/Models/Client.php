<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'user_id',
        'entreprise',
        'description',
    ];
 
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function missions()
    {
        return $this->hasMany(Mission::class);
    }
 
     public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

      public function notification()
    {
        return $this->belongsTo(Notification::class,'client_id');
    }
}
