<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\UserRepo;

class UserController extends Controller
{
    protected $user=null;
    
    public function __construct(UserRepo $user){
        $this->user=$user;
    }

    public function getAllUsers(){
        $data=$this->user->getAllUsers();

        return response()->json(['data'=>$data],$data->status);
    }

}
