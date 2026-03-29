<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Services\TechnologieService;
use Illuminate\Http\Request;

class TechnologyController extends Controller
{

   private $service;

   public function __construct(TechnologieService $service)
   {
    $this->service = $service;
   }
   
    public function index()
    {
    
        return response()->json([
            'success' => true,
            'data'    => $this->service->technologies(),
        ]);
    }

     public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string']);
        $result = $this->service->createTechnology($validated['name']);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
         ], $result['code']);
    }

     public function destroy(Technology $technology)
    {

        $result = $this->service->deleteTechnology($technology);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['code']);
    }
}
