<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserService
{
     public function getAllUsers(){
         return User::all();
     }

     public function getUserById($id){
        return User::find($id);
     }

     public function createUser($data){
         $this->uploadImageIfExists($data);
         return User::create($data);
     }

     public function updateUser($id,$data){
         $user = User::find($id);

         if($user){
             $this->uploadImageIfExists($data, $user);
             $user->update($data);
         }
         return $user;
     }

     public function deleteUser($id){
       //  $user = User::find($id);

      // if($user){
        //   if($user->image){
            //   Storage::disk('images_user')->delete($user->image);
         //  }
         //  $user->delete();
     //  }

       //  return $user;
     }

protected function uploadImageIfExists(&$data, $user = null){
      if(isset($data['avatar']) && $data['avatar']->isValid()){
           $avatarName = Str::random(12). "." . $data['avatar']->getCilentOriginalExtension();
           $data['avatar']->storeAs('', $avatarName, 'avatar_user');

           if($user && $user->image){
               Storage::disk('avatar_user')->delete($user->image);
           }

           $data['avatar'] = $avatarName;

    }
}

}
