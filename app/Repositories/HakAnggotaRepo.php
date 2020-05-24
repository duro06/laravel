<?php
namespace App\Repositories;

use App\Members;
use App\User;
use App\HakAnggota;

use Illuminate\Support\Facades\DB;

class HakAnggotaRepo {

    public function add($req){
      
        $req->validate([
            'nama'=>'required|string',    
        ]);
        DB::beginTransaction();
        try {

            $Hak = HakAnggota::create([
                'nama'=> $req->nama, // 
            ]);
            
        DB::commit();    
            return (object) [
                'status'=>201,
                'data'=> $Hak,
                ] ; 

        } catch (\Exception $e) {
            //jika ada error, maka akasn dirollback sehingga tidak ada data yang tersimpan 
        DB::rollback();
            //pesan gagal akan di-return
            return (object) [
                'status' => 400,
                'message' => $e->getMessage()
            ] ;
        }

    }

    public function getData(){
      $member = HakAnggota::orderBy(request()->sortby, request()->sortbydesc)
                ->when(request()->q, function($member) {
                    $member = $member->where('name', 'LIKE', '%' . request()->q . '%');
                })->paginate(request()->per_page);

      return (object) ['data'=>$member,'status'=>200];
    }

    public function edit($req){
      $req->validate([
        'id'=>'required',
        'nama'=>'required|string'
      ]);

      // $hak=HakAnggota::find($req->id);
      $hak=HakAnggota::where('id',$req->id)->update(['nama'=>$req->nama]);

      if($hak){
        return (object) ['data'=>$hak, 'status'=>200];
      }else{
        return (object) ['message'=>'Some Error Occured please try Again', 'status'=>500];

      }
    }

    public function delete_data($req){
      $hak=HakAnggota::where('id',$req->id)->delete();

      if($hak){
        return (object) ['message'=>'deleted', 'status'=>200];
      }else{
        return (object) ['message'=>'Some Error Occured please try Again', 'status'=>500];

      }

    }

    public function Trash(){
      $data=HakAnggota::onlyTrashed()->get();

      return (object) ['data'=>$data, 'status'=>200];
    }

    public function restore_data($req){
      $data=HakAnggota::onlyTrashed()->where('id',$req->id);

      $data->restore();

      return (object) ['data'=>$data, 'status'=>200];

    }
}