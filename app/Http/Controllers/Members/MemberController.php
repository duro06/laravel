<?php

namespace App\Http\Controllers\Members;

use App\Members;
use IUMemberRepo;
use App\Repositories\MemberRepo;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    protected $member=null;
    public function __construct(MemberRepo $member){
        $this->member=$member;
    }
    public function getMembers(){
        $q=request()->q;
        $ss=request()->ss;

        $member=$this->member->getAllMembers($q,$ss);

        // $member->load('status:id,name');
        return response()->json([
            'status' => 'success', 
            'data' => $member,
            'q'=>$q,
            'ss'=>$ss
            ]);
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
                case 0:
                    $id_kop='KP0000'.$id_koperasi;
                    break;
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

        // return $koperasi;
        return $id_kop;

    }

    public function update_status(Request $request){
        $request->validate([
            'id'=>'required',
            'status'=>'required'            
        ]);
        if($request->status==2 && $request->simPok==0){
            return response()->json([
                'message'=>'Simpanan Pokok tidak boleh kosong'
            ],422);
        }else{

            $member=Members::find($request->id);

            $member->status=$request->status;
            $member->simpanan_pokok=$request->simPok;

            if($member->save()){
                return response()->json(['member'=>$member,'message'=>'sukses'],200);
            }else{
                $message = [
                    'message'=>'some errors occured, Please try again',
                    'member'=>$member,
                    'status_code'=>500
                ];
                return response()->json($message,500);
            }

        }
        
        // $data=[
        //     'id'=>$request->id,
        //     'status'=>$request->status,    
        // ];
        // $anggota=Members::find($request->id);
        

        // return response()->json(
        //     ['req'=>$data,'mem'=>$member,'angg'=>$anggota]
        // );
    }

    public function getMemberById(){

        $member=Members::find(request()->q);

        return response()->json([
            'status'=>'success',
            'data'=>$member
            ]);
    }

    public function update_image(Request $request, Members $member)
    {   

            $old_path = $member->image;
            if($request->hasFile('image')) {
                $request->validate([
                    'image'=>'required|image|mimes:jpeg,png,jpg'
                ]);
                $path = $request->file('image')->store('members_images');
                $member->image = $path;

                if ($old_path != '' || $old_path != null) {
                    Storage::delete($old_path);
                }      
                
            }

            if ($member->save()) {
                return response()->json($member,200);
            } else {
                return response()->json([
                    'message'       => 'Error on Updated',
                    'status_code'   => 500
                ],500);
            } 
        
    }

    public function update_profile(Request $request, Members $member){
        $request->validate([
            'name'=>'required',
            'alamat'=>'required',            
            'telepon'=>'required'            
        ]);
        $member->name=$request->name;
        $member->telepon=$request->telepon;
        $member->alamat=$request->alamat;
        
        if ($member->save()) {
            return response()->json($member,200);
        } else {
            return response()->json([
                'message'       => 'Error on Updated',
                'status_code'   => 500
            ],500);
        } 
    }

}
