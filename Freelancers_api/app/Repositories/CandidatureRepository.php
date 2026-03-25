<?php
namespace App\Repositories;
use App\Models\Candidature;

class CandidatureRepository
{
   public function candidatures(){
        $candidatures = Candidature::with(['freelancer.user','mission']);
        return $candidatures;
        
    }

   public  function findCandidature($id){
       $candidature = Candidature::find($id);
       $candidature->load(['freelancer.user','mission']);
       return $candidature;
    }

    public function create(array $data){
        $candidature = Candidature::create($data);
        return $candidature;
    }

    public function update(Candidature $condidature , array $data){
        $condidature->update($data);
        return $condidature;
    }

}