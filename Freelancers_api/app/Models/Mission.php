<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
     protected $fillable = ['client_id','category_id','titre','description','budget','duration','status',
    ];
 
 
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
 
    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
 
    public function candidates()
    {
        return $this->hasMany(Candidature::class);
    }
 
 
    public function technology()
    {
        return $this->belongsToMany(Technology::class);
    }
 
    
}
