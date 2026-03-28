<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mission;
use App\Models\User;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller 
{
    private $service;
    public function __construct(AdminService $service)
    {
      $this->service = $service;
    }

       public function dashboard(Request $request)
    { 
        $admin = $request->user();
        $data =  $this->service->dashboard($admin);
        return response()->json([
            'success' => true,
            'data'=>$data,
        ]);
    }

     public function users()
    {
        $users = $this->service->users();

        return response()->json([
            'success' => true,
            'data'    => $users,
        ]);
    }

      public function activerUser(Request $request,User $user)
    {
        $admin = $request->user();
        $result = $this->service->activerUser($admin,$user);
 
        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['code']);
    }


     public function deactiverUser(Request $request, User $user)
    { 
        $admin = $request->user();
        $result = $this->service->desactiverUser($admin,$user);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['code']);
    }

     public function deleteUser(Request $request, User $user)
    { 
        $admin = $request->user();

        $result = $this->service->deleteUser($admin,$user);
        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['code']);
    }

      public function missions(Request $request)
    {
        $missions = $this->service->missions();

        return response()->json([
            'success' => true,
            'data'    => $missions,
        ]);
    }

      public function deleteMission(Request $request, Mission $mission)
    {
        $admin = $request->user();
        $result = $this->service->deleteMission($admin,$mission);
 
        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['code']);
    }


}