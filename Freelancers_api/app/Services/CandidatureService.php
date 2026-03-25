<?php

namespace App\Services;

use App\Models\Candidature;
use App\Repositories\CandidatureRepository;

class CandidatureService{
    private $repository;

    public function __construct(CandidatureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listCandidatures()
    {
        $candidatures = $this->repository->candidatures();
        return $candidatures;
    }

    public function showCandidature(Candidature $condidature)
    {
      $condidature->load(['freelancer.user','mission']);
      return $condidature;
    }

    public function createCandidature($validated,$user){
        $data =[
          'freelancer_id'=>$user->freelancer->id,
          'motivation_letter' => $validated['motivation_letter'],
          'mission_id'=>$validated['mission_id'],
          'price'=> $validated['price'],
          'status'=>"pending"
        ];

        $candidature = $this->repository->create($data);
        return $candidature;
    }

    public function acceptCandidature($candidature){
       $candidature->update(['status'=>"'accepted"]);
    }
     public function refuserCandidature($candidature){
       $candidature->update(['status'=>"'refused"]);
    }

    public function updateCandidature($validated,$candidature,$user){

     if($candidature->freelancer_id !== $user->freelancer->id){
       
     }
    }
}