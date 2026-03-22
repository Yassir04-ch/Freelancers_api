<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['name','type'];

 
    public function missions()
    {
        return $this->hasMany(Mission::class);
    }
}
