<?php

namespace App\Services;

use App\Models\Mission;
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
        return $mission;

    }

    public function updateMission($validated, $mission, $user)
    {
        $message = "";
        $code = 200;
        if ($mission->client_id !== $user->client->id) {
           $message = "non autorisée";
           $code = 403;
        }

         if ($mission->status == "en_cours" || $mission->status == "terminee") {
             $message = "impossible de modifier une mission en cours ou terminee";
             $code = 422;
        }

        $missionup = $this->repository->update($mission, $validated);
        return [$missionup,$message,$code];     
    }

    public function cancelMission($mission, $user)
    {
        if ($mission->client_id !== $user->client->id) {
            abort(403, 'non autorisee.');
        }

        if ($mission->status === "en_cours") {
            abort(422, 'impossible de modifier une mission en cours ou terminee.');
        }

        $missionup = $this->repository->update($mission, ['status' => "annulee"]);
        return $missionup;
    }
}