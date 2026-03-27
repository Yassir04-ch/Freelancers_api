<?php

namespace App\Services;

use App\Models\Candidature;
use App\Models\Notification;
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
        if ($user->role->name !== "freelancer") {
            return ['success' => false, 'message' => 'action non autorisée. ', 'code' => 403];
        }
        
        $candida = Candidature::where('mission_id',$validated['mission_id'])->where('freelancer_id',$user->freelancer->id)->first();
         if ($candida) {
            return ['success' => false, 'message' => 'vous avez déja postulé', 'code' => 422];
        }

        $data =[
          'freelancer_id'=>$user->freelancer->id,
          'motivation_letter' => $validated['motivation_letter'],
          'mission_id'=>$validated['mission_id'],
          'price'=> $validated['price'],
          'status'=>"pending"
        ];

        $candidature = $this->repository->create($data);

        Notification::create([
            'freelancer_id'=>$user->freelancer->id,
            'client_id'=> $candidature->mission->client->id,
            'title'=> 'nouvele condidature',
            'message'=> 'Nouvelle candidature dans votre mission',
        ]);

        $candidature->load(['freelancer.user','mission']);
            return ['success' => true, 'message' => 'condidature creer avec success', 'code' => 201];
    }

    public function acceptCandidature($candidature,$user){

    if ($user->role->name != 'client' || $candidature->mission->client_id != $user->client->id) {
            return ['success' => false, 'message' => 'action non autorisée.', 'code' => 403];
       }

       $candidature->update(['status'=>'accepted']);
       $candidature->mission->update(['status'=>'en_cours']);
         Notification::create([
            'client_id'=>$user->client->id,
            'freelancer_id'=> $candidature->mission->user->freelancer->id,
            'title'=> 'condidature accepter',
            'message'=> 'votre candidature a été accepter',
          ]);

      return ['success' => true,'message' => 'accepter le candidature avec success', 'code' => 200];
     }

     public function refuserCandidature($candidature,$user){

        if (!$user->role->name == 'client' || $candidature->mission->client_id !== $user->client->id) {
              return ['success' => false, 'message' => 'action non autorisée.', 'code' => 403];
        }

        if($candidature->status == 'accepted'){
              return ['success' => false, 'message' => 'impossible refuser une candidate accepted', 'code' => 422];
        }
            $candidature->update(['status'=>'refused']);
              Notification::create([
                'client_id'=>$user->client->id,
                'freelancer_id'=> $candidature->mission->user->freelancer->id,
                'title'=> 'condidature refuser',
                'message'=> 'votre candidature a été refuser',
             ]);

          return ['success' => true,'message' => 'refuser le candidature avec success', 'code' => 200];
    }

    public function updateCandidature($validated,$candidature,$user){
        
        if($candidature->freelancer_id !== $user->freelancer->id){
            return ['success' => false, 'message' => 'non autorisée', 'code' => 403];
        }
        if($candidature->status == "accepted" || $candidature->status == "refused"){
            return ['success' => false, 'message' => 'impossible de modifier une candidature acceptée ou refusée.', 'code' => 422];
        }
      
       $this->repository->update($candidature , $validated);
        return ['success' => true, 'message' => 'candidature a été modifier avec success.', 'code' => 200];
    }

     public function deleteCandidature( $candidature, $user): array
    {
           
        if ($candidature->freelancer_id !== $user->freelancer->id) {
             return ['success' => false, 'message' => 'action non autorisée.', 'code' => 403];
        }
 
        if ($candidature->status === "accepted") {
                return ['success' => false, 'message' => 'impossible de retirer une candidature acceptée.', 'code' => 422];
        }
 
        $this->repository->delete($candidature);

        return ['success' => true, 'message' => 'candidature retirée.', 'code' => 200];
    }




}