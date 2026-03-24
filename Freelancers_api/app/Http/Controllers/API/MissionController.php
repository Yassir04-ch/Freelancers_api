<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\MissionRequest;
use App\Models\Mission;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $missions = Mission::with(['client.user', 'category'])->get();

           return response()->json([
            'success' => true,
            'data'    => $missions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MissionRequest $request)
    {
        $validated = $request->validated();
          $user = $request->user();
 
        $mission = Mission::create([
            'client_id'   => $user->client->id,
            'category_id' => $validated['category_id'],
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'budget'      => $validated['budget'],
            'duration'    => $validated['duration'],
            'status'      => "ouverte",
        ]);
 
        return response()->json([
            'success' => true,
            'message' => 'créée avec succès.',
            'data'    => $mission->load(['client.user', 'category']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mission $mission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mission $mission)
    {
          $user = $request->user();
        $validated =   $request->validated();
 
         if ($mission->client_id !== $user->client->id) {
            return response()->json([
                'success' => false,
                'message' => 'non autorisée.',
            ], 403);
        }
 
         if ($mission->status == "en_cours" || $mission->status == "terminee") {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de modifier une mission en cours ou terminée.',
            ], 422);
        }
 
        $mission->update($validated);
 
        return response()->json([
            'success' => true,
            'message' => 'Mission mise à jour.',
            'data'    => $mission->load(['client.user', 'category']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Mission $mission)
    {
         $user = $request->user();
 
        if ($mission->client_id !== $user->client->id) {
            return response()->json([
                'success' => false,
                'message' => 'non autorisée.',
            ], 403);
        }
 
        if ($mission->status === "en_cours" ) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible d\'annuler une mission en cours.',
            ], 422);
        }
 
        $mission->update(['status' =>"annulee"]);
 
        return response()->json([
            'success' => true,
            'message' => 'Mission annulée.',
        ]);
    }
}
