<?php
namespace App\Repositories;
use App\Models\Experience;

class ExperienceRepository{
    public function experiences($id){
        $experiences = Experience::where("freelancer_id",$id)->get();
        return $experiences;
    }

    public function createExperience(array $data){
      $experience = Experience::create($data);
      return $experience;
    }

}