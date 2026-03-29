<?php
namespace App\Repositories;

use App\Models\Candidature;
use App\Models\Mission;
use App\Models\User;

class AdminRepository {

   public function users(){
     $users  = User::with(['freelancer','role','client'])->get();
     return $users;
   }

public function statUsers(): array
    {
        $countuser =  User::count();
        $countfree = User::where('role', 'freelancer')->count();
        $countclient =  User::where('role', 'client')->count();
        return ['countuser'=>$countuser,'countfree'=> $countfree,'countclient'=>$countclient];
    }


    public function statMission(){
        $countmission = Mission::count();
        $missionover = Mission::where('status', 'ouverte')->count();
        $missionencour = Mission::where('status', 'en_cours')->count();
        $missionterminer = Mission::where('status', 'terminee')->count();
        $missionanulle = Mission::where('status', 'annulee')->count();
        return ['countmission' =>$countmission ,'missionover' =>$missionover,
        'missionencour' =>$missionencour,'missionterminer'=>$missionterminer,'missionanulle' => $missionanulle];
    }

    public function statiCandidatures(){
        $countcandida = Candidature::count();
        $candidapadin = Candidature::where('status', 'pending')->count();
        $candidaaccept = Candidature::where('status', 'accepted')->count();
        $candidarefuse = Candidature::where('status', 'refused')->count();
          return ['total'=>$countcandida,'pending'  =>$candidapadin ,'accepted' =>$candidaaccept,'rejected' => $candidarefuse];
    }


   public function desactiverUser(User $user){
    $user->update(['is_active'=>false]);
    $user->tokens()->delete();
    }

    public function activerUser(User $user){
    $user->update(['is_active'=>true]);
    }
   
   public function deletUser(User $user){
     $user->tokens()->delete();
     $user->delete();
   }

    public function getAllMissions()
    {
        return Mission::with(['client.user', 'category'])->get();
    }
    
     public function deleteMission(Mission $mission)
    {
        $mission->delete();
    }

}