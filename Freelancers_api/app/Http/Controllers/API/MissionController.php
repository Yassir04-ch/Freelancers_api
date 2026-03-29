<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MissionRequest;
use App\Services\MissionService;
use App\Models\Mission;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    private $service;

    public function __construct(MissionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => $this->service->listMissions()
        ],200);
    }

    public function store(MissionRequest $request)
    { 
        $validated = $request->validated();
        $mission = $this->service->createMission($validated, $request->user());

        return response()->json([
            'success' => true,
            'message' => 'crée avec succès.',
            'data'    => $mission,
        ], 201);
    }

    public function show(Mission $mission)
    {
        return response()->json([
            'success' => true,
            'data'    => $this->service->showMission($mission),
        ]);
    }

    public function update(MissionRequest $request, Mission $mission)
    {
        $validated = $request->validated();

        $result = $this->service->updateMission($validated, $mission, $request->user());

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ],$result['code']);
    }

    public function destroy(Request $request, Mission $mission)
    {
        $result = $this->service->cancelMission($mission, $request->user());

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ],$result['code']);
    }

    public function termineeMission(Request $request,Mission $mission){
        $result = $this->service->termineeMission($mission ,$request->user());
        return response()->json([
            'success'=>$result['success'],
            'message'=>$result['message'],
        ],$result['code']);
    }
}