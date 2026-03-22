<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
      protected $fillable = ['freelancer_id','name','type','date_debut','date_fin','description'];
 
 
    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }
}
