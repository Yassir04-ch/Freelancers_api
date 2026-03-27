<?php

namespace App\Services;

use App\Models\Freelancer;
use App\Models\Mission;
use App\Models\Notification;
use App\Repositories\MissionRepository;

class MissionService
{
    private $repository;

    public function __construct(MissionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listMissions()
    {
        $missions = $this->repository->missions();
        return $missions;
    }

    public function showMission(Mission $mission)
    {
        $mission = $mission->load(['client.user', 'category']);
        return $mission;
        
    }

    public function createMission($validated, $user)
    {
        $data = [
            'client_id'   => $user->client->id,
            'category_id' => $validated['category_id'],
            'titre'       => $validated['titre'],
            'description' => $validated['description'],
            'budget'      => $validated['budget'],
            'duration'    => $validated['duration'],
            'status'      => "ouverte",
        ];

        $mission = $this->repository->create($data);

        $freelacers = Freelancer::all();
        foreach($freelacers as $freelancer){
            Notification::create([
              'client_id'=>$user->client->id,
              'freelancer_id'=> $freelancer->id,
              'title'=> 'nouvele mission',
              'message'=> 'une nouvelle mission a été publiée'.$mission->titre
          ]);
        }
        return $mission;

    }

    public function updateMission($validated, $mission, $user)
    {
        if ($mission->client_id !== $user->client->id) {
            return ['success'=>false,'message'=>"non autorisée",'code'=>403]; 
        }

         if ($mission->status == "en_cours" || $mission->status == "terminee") {
            return ['success'=>false,'message'=>"impossible de modifier une mission en cours ou terminee",'code'=>422]; 
         }

        $this->repository->update($mission, $validated);
        return ['success'=>true,'message'=> "mission a été modifier avec success",'code'=>200];     
    }

    public function cancelMission($mission, $user)
    {
        if ($mission->client_id !== $user->client->id) {
            return ['success'=>false,'message'=>"non autorisée",'code'=>403]; 
        }

        if ($mission->status === "en_cours") {
            return ['success'=>false,'message'=>"impossible de modifier une mission en cours ou terminee",'code'=>422]; 
        }

        $this->repository->update($mission, ['status' => "annulee"]);
        return ['success'=>true,'message'=>"mission est annulee",'code'=>422]; 
    }
}