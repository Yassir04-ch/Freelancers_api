<?php
namespace App\Repositories;
use App\Models\Candidature;

class CandidatureRepository
{
   public function candidatures(){
        $candidatures = Candidature::with(['freelancer.user','mission'])->get();
        return $candidatures;
        
    }

   public  function findCandidature($id){
       $candidature = Candidature::with(['freelancer.user','mission'])->find($id);
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

    public function delete(Candidature $candidature): void
    {
        $candidature->delete();
    }

}