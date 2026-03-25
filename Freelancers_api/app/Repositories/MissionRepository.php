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
        $mission = Mission::with(['client.user', 'category'])->find($id);
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