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
      $experience->load('freelancer.user');
      return $experience;
    }

     public function deleteExperience($experience){
      $experience->delete($experience);
    }

    public function updateExperience($validated,$experience){
       $experience->update($validated);
    }

}