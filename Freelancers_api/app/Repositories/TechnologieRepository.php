<?php

namespace App\Repositories;
use App\Models\Technology;

class TechnologieRepository{

    public function technologies()
    {
        $technologies = Technology::all();
        return $technologies;
    }

    public function createTechnology(string $name)
    {
        $technology = Technology::create(['name' => $name]);
        return $technology;

    }

    public function deleteTechnology(Technology $technology)
    {
        $technology->delete();
    }
}