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
    $member->alamat=$user->alamat;
    $member->telepon=$user->telepon;
    $member->role=$user->role;
    
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
    $member->role='anggota';
    
    $user->member_id=null;
    
    if($user->save()&&$member->save()){

      return (object) ['user'=>$user,'member'=>$member,'status'=>200];
    
    }else{
    
      return (object) ['status'=>500];
    
    }
  }
  public function getAllUsers(){
    $user = User::orderBy(request()->sortby, request()->sortbydesc)
                ->when(request()->q, function($user) {
                    $user = $user->where('name', 'LIKE', '%' . request()->q . '%');
                })->paginate(request()->per_page);

    return (object) ['status'=>200,'data'=>$user];
  }
}