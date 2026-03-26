<?php
namespace App\Services;
use App\Models\Experience;
use App\Repositories\ExperienceRepository;

class ExperienceService{
    private $repository;

    public function __construct(ExperienceRepository $repository)
    {
       $this->repository = $repository;
    }

    public function experiences($id){
        $experience = $this->repository->experiences($id);
        $experience->load('freelancer.user');
        return $experience;
    }

    public function createexperience($validated,$user){
         
      $data =[
        'name'=>$validated['name'],
        'date_debut'=>$validated['date_debut'],
        'date_fin'=>$validated['date_fin'],
        'description'=>$validated['description']
      ];
        $experience = $this->repository->createExperience($data);
        return $experience;
    }
}
