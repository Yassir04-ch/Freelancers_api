<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienceRequest;
use App\Models\Experience;
use App\Services\ExperienceService;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{

    private $service;

    public function __construct(ExperienceService $service)
    {
        $this->service = $service;
    }
    public function index($id)
    {
        $experience =  $this->service->experiences($id);
        return response()->json([
            "success" => true,
            "message" => "les experiences de freelancer est :",
            "data" => $experience
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExperienceRequest $request)
    {
        $validated = $request->validated();
        $experience = $this->service->createexperience($validated, $request->user());
        return response()->json([
            "success" => true,
            "message" => "experience create avec success",
            "data" => $experience
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExperienceRequest $request, Experience $experience)
    {
        $validated = $request->validated();
        $result = $this->service->updateExperience($validated,$experience,$request->user());
        return response()->json([
            "success"=>$result['success'],
            'message'=>$result['message'],
        ],$result['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Experience $experience)
    {
        $result = $this->service->deleteExperience($experience, $request->user());
 
        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['code']);
    }
}
