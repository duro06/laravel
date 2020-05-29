<?php

namespace App\Http\Controllers\Members;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\HakAnggotaRepo;

class HakMemberController extends Controller
{
    protected $member=null;
    public function __construct(HakAnggotaRepo $member){
        $this->member=$member;
    }

    public function getData(){
        $data=$this->member->getData();

        return response()->json(['data'=>$data],$data->status);
    }

    public function addHak(Request $request){
        $data=$this->member->add($request);

        return response()->json(['data'=>$data],$data->status);
    }

    public function editData(Request $request){
        $data=$this->member->edit($request);

        return response()->json(['data'=>$data],$data->status);
    }

    public function deleteData(Request $request){
        $data=$this->member->delete_data($request);

        return response()->json(['data'=>$data],$data->status);
    }

    public function sampah(){
        $data=$this->member->Trash();

        return response()->json(['data'=>$data],$data->status);
    }

    public function restoreData(Request $request){
        $data=$this->member->restore_data($request);

        return response()->json(['data'=>$data],$data->status);
    }
}
