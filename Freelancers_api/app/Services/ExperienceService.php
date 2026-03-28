<?php

namespace App\Services;

use App\Models\Experience;
use App\Repositories\ExperienceRepository;

class ExperienceService
{
    private $repository;

    public function __construct(ExperienceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function experiences($id)
    {
        $experience = $this->repository->experiences($id);
        $experience->load('freelancer.user');
        return $experience;
    }

    public function createExperience($validated, $user)
    {
        $data = [
            'name' => $validated['name'],
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'],
            'description' => $validated['description'],
            'freelancer_id' => $user->freelancer->id
        ];
        $experience = $this->repository->createExperience($data);
        return $experience;
    }

    public function updateExperience($validated,$experience,$user){
        if($experience->freelancer->id != $user->freelancer->id){
            return ['success'=>false,'message'=>'action non autorisée','code'=>422];
        }

       $this->repository->updateExperience($validated,$experience);
       return ['success'=>true,'message'=>"experience a été modifier avec success" ,'code'=>200];
    }

    public function deleteExperience($experience,$user)
    {

        if ($experience->freelancer_id !== $user->freelancer->id) {
            return ['success' => false, 'message' => 'action non autorisée', 'code' =>403];
        }

        $this->repository->deleteExperience($experience);

        return ['success' => true, 'message' => 'Experience deleted', 'code' =>200];
    }
}
