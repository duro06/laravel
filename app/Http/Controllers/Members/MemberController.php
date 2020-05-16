<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Members;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    public function getMembers(){
        $q=request()->q;
        $ss=request()->ss;
        if($q!=null){
            $member = Members::orderBy(request()->sortby, request()->sortbydesc)
                ->when(request()->q, function($member) {
                    $member = $member->where('name', 'LIKE', '%' . request()->q . '%');
                })->paginate(request()->per_page);

        }else{
            $member = Members::orderBy(request()->sortby, request()->sortbydesc)
                ->when(request()->ss, function($member) {
                    $member = $member->where('status', 'LIKE', '%' . request()->ss . '%');
                })->paginate(request()->per_page);

        }

        // $member->load('status:id,name');
        return response()->json([
            'status' => 'success', 
            'data' => $member,
            'q'=>$q,
            'ss'=>$ss
            ]
        );
    }

    public function store(Request $request){

        $request->validate([
            'name'=>'required|string',
            'alamat'=>'required|string',
            'telepon'=>'required|numeric'
        ]);

        $id_kop = $this->makeIdKop($request->id_koperasi);

        
        if($request->simPok){
            $simpok=$request->simPok;
            $status=2;
        }else{
            $simpok=0;
            $status=1;
        }

        // return response()->json(['koperasi'=>$koperasi, 'req'=>$request]);
        // return response()->json(['id_Kop'=>$id_kop, 'req'=>$request]);

        DB::beginTransaction();
        try {

            $member = Members::create([
                'id_koperasi' => $id_kop,
                'name' => $request->name,
                'alamat'=>$request->alamat,
                'telepon'=>$request->telepon,
                'simpanan_pokok'=>$simpok,
                'status'=> $status,
                'image'=>'/users_images/nouser.png',  
                'id_kelompok'=>'null'  
            ]);
                                
            //apabila tidak terjadi error, penyimpanan diverifikasi
            DB::commit();    
            return response()->json([
                'status'=>'sukses',
                'data'=>$member,
                // 'admin'=>$admin
                // 'message'=>$member->reff,
                ], 200);    

        } catch (\Exception $e) {
            //jika ada error, maka akasn dirollback sehingga tidak ada data yang tersimpan 
            DB::rollback();
            //pesan gagal akan di-return
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage(),
                
            ], 400);
        }

    }

    public function makeIdKop($req){

        if($req){            
            $koperasi=strlen($req);
            switch ($koperasi) {
                case 1:
                    $id_kop='KP0000'.$req;
                    break;
                case 2:
                    $id_kop='KP000'.$req;
                    break;
                case 3:
                    $id_kop='KP00'.$req;
                    break;
                case 4:
                    $id_kop='KP0'.$req;
                    break;
                case 5:
                    $id_kop='KP'.$req;
                    break;
                
                default:
                    $id_kop='KP'.$req;
                    break;
            }
        }else{
            $value = DB::table('members')->max('id');
            $id_koperasi = $value+1;
            $koperasi=strlen($value);
            switch ($koperasi) {
                case 1:
                    $id_kop='KP0000'.$id_koperasi;
                    break;
                case 2:
                    $id_kop='KP000'.$id_koperasi;
                    break;
                case 3:
                    $id_kop='KP00'.$id_koperasi;
                    break;
                case 4:
                    $id_kop='KP0'.$id_koperasi;
                    break;
                case 5:
                    $id_kop='KP'.$id_koperasi;
                    break;
                
                default:
                    $id_kop='KP'.$id_koperasi;
                    break;
            }

        }

        return $id_kop;

    }
}
