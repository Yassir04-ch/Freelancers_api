<?php

namespace App\Repositories;

use App\Models\Mission;

class MissionRepository
{
    public function missions()
    {
        return Mission::with(['client.user', 'category'])->get();
    }

    public function findMission($id)
    {
        $mission = Mission::find($id);
        $mission->load(['client.user', 'category']);
        return $mission;
    }

    public function create(array $data)
    {
        $mission = Mission::create($data);
        return $mission;
    }

    public function update(Mission $mission, array $data)
    {
        $mission->update($data);
        return $mission;
    }
}