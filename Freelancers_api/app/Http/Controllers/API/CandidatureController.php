<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\CandidatureRequest;
use App\Models\Candidature;
use App\Services\CandidatureService;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    private $service;

    public function __construct(CandidatureService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
       return response()->json([
        "success" => true,
        "data" => $this->service->listCandidatures(),
       ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CandidatureRequest $request)
    {
        $validated = $request->validated();
        $result = $this->service->createCandidature($validated,$request->user());

        return response()->json([
            "success" => $result['success'],
            "message"=>$result['message']
        ],$result['code']);
    }

    /**
     * Display the specified resource.
     */
      public function show(Candidature $candidature)
    {
        return response()->json([
            'success' => true,
            'data'    => $this->service->showCandidature($candidature),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CandidatureRequest $request, Candidature $candidature)
    {
        $result = $this->service->updateCandidature(
            $request->validated(),
            $candidature,
            $request->user()
        );
 
        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['code']);

    }

   public function accept(Request $request, Candidature $candidature)
    {
        $result = $this->service->acceptCandidature($candidature, $request->user());
 
        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
         ], $result['code']);
    }
 
    public function refuse(Request $request, Candidature $candidature)
    {
        $result = $this->service->refuserCandidature($candidature, $request->user());
 
        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
         ], $result['code']);
    }
 
    public function destroy(Request $request, Candidature $candidature)
    {
        $result = $this->service->deleteCandidature($candidature, $request->user());
 
        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['code']);
    }
}
