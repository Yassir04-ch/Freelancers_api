<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
 use HasFactory;
 
    protected $fillable = ['client_id','freelancer_id','title','message' ];
 
  
        public function client()
        {
            return $this->belongsTo(Client::class);
        }  
        public function freelancer()
        {
            return $this->belongsTo(Freelancer::class);
        }
 
    }
