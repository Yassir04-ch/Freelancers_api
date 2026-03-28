<?php
namespace App\Http\Repositories;

use App\Models\User;

class AdminRepository {

   public function users(){
     $users  = User::with(['freelancer','role','client'])->get();
     return $users;
   }

   public function desactiveruser(User $user){
    $user->update(['is_active'=>false]);
    $user->tokens()->delete();
    return $user;
   }

    public function activeruser(User $user){
    $user->update(['is_active'=>true]);
     return $user;
   }
   
   

}