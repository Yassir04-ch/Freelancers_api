<?php
namespace App\Services;
use App\Http\Repositories\AdminRepository;
use App\Models\Mission;
use App\Models\User;


class AdminService{
    private $repository;

    public function __construct(AdminRepository $repository)
    { 
        $this->repository = $repository;
    }

    public function users()
    {
        $users = $this->repository->users();
        return $users;
    }


      public function dashboard($admin)
    {

        if($admin->role->name != 'admin'){
             return response()->json([
                    'success' => false,
                    'message' => 'action non autorisé.',
                ], 403);
        }

        $users =  $this->repository->statUsers();
        $missions = $this->repository->statMission();
        $condidatures =  $this->repository->statiCandidatures();
        return ['users'=>$users,'missions'=>$missions,'candidatures' =>$condidatures];
    }

        public function activerUser($admin, User $user)
    {

      if($admin->role->name != 'admin'){
             return response()->json([
                    'success' => false,
                    'message' => 'action non autorisé.',
                ], 403);
        }
        if ($user->is_active) {
            return ['success' => false, 'message' =>'Compte est active', 'code' => 422];
        }
 
        $user = $this->repository->activerUser($user);
        return ['success' => true, 'message' => "compte est activé", 'code' => 200];
    }
 
    public function desactiverUser($admin, User $user)
    {
     if($admin->role->name != 'admin'){
             return response()->json([
                    'success' => false,
                    'message' => 'action non autorisé.',
                ], 403);
        }
 
        if (!$user->is_active) {
            return ['success' => false, 'message' => 'Compte dejà désactivé', 'code' => 422];
        }
 
        $user = $this->repository->desactiverUser($user);
        return ['success' => true, 'message' => 'Compte est désactivé','code' => 200];
    }
 
    public function deleteUser($admin, User $user)
    {
        if($admin->role->name != 'admin'){
             return response()->json([
                    'success' => false,
                    'message' => 'action non autorisé.',
                ], 403);
        }
        $this->repository->deletUser($user);
        return ['success' => true, 'message' => 'user est supprimé', 'code' => 200];
    }

     public function missions()
    {
        return $this->repository->getAllMissions();
    }
 
    public function deleteMission($admin, Mission $mission)
    {
         if($admin->role->name != 'admin'){
             return response()->json([
                    'success' => false,
                    'message' => 'action non autorisé.',
                ], 403);
        }

        $this->repository->deleteMission($mission);
        return ['success' => true, 'message' => 'mission est supprimé', 'code' => 200];
    }
}