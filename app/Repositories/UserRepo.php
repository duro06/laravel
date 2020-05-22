<?php
namespace App\Repositories;

use App\User;
use App\Members;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserRepo {

  public function link_with($req){
    $member=Members::find($req->id);

    $user=User::find(Auth::id());
    
    $member->user_id=$user->id;
    $member->image=$user->image;
    
    $user->member_id=$member->id;
    
    if($user->save()&&$member->save()){

      return (object) ['user'=>$user,'member'=>$member,'status'=>200];
    
    }else{
    
      return (object) ['status'=>500];
    
    }
  }
  public function unlink_with(){

    $user=User::find(Auth::id());
    $member=Members::find($user->member_id);
    
    $member->user_id=null;
    $member->image=null;
    
    $user->member_id=null;
    
    if($user->save()&&$member->save()){

      return (object) ['user'=>$user,'member'=>$member,'status'=>200];
    
    }else{
    
      return (object) ['status'=>500];
    
    }
  }
}