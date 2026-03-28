<?php
namespace App\Services;
use App\Http\Repositories\AdminRepository;
use App\Models\User;

class AdminService{
    private $repository;

    public function __construct(AdminRepository $repository)
    { 
        $this->repository = $repository;
    }

    public function getAllUsers()
    {
        $users = $this->repository->users();
        return $users;
    }

        public function activerUser(User $user)
    {
        if ($user->is_active) {
            return ['success' => false, 'message' =>'Compte est active', 'code' => 422];
        }
 
        $user = $this->repository->activerUser($user);
        return ['success' => true, 'message' => "compte est activé", 'code' => 200];
    }
 
    public function desactiverUser(User $user)
    {
 
        if (!$user->is_active) {
            return ['success' => false, 'message' => 'Compte dejà désactivé', 'code' => 422];
        }
 
        $user = $this->repository->desactiverUser($user);
        return ['success' => true, 'message' => 'Compte est désactivé','code' => 200];
    }
 
    public function deleteUser(User $user)
    {
        $this->repository->deletUser($user);
        return ['success' => true, 'message' => 'user est supprimé', 'code' => 200];
    }

     public function getAllMissions()
    {
        return $this->repository->getAllMissions();
    }
 
    public function moderateMission(Mission      $mission): array
    {
        $mission->update(['is_moderated' => !$mission->is_moderated]);
        $status = $mission->is_moderated ? 'bloquée' : 'débloquée';
        return ['success' => true, 'message' => "Mission {$status}.", 'data' => $mission, 'code' => 200];
    }
 
    public function deleteMission(Mission $mission): array
    {
        $this->repository->deleteMission($mission);
        return ['success' => true, 'message' => 'Mission supprimée.', 'code' => 200];
    }


}