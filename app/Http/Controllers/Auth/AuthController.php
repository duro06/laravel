<?php

namespace App\Http\Controllers\Auth;

use Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    //register 
    public function register(Request $request){
        $request->validate([
            'name'      =>  'required|string|max:100',
            'email'     =>  'required|string|email|unique:users',
            'password'  =>  'required|string|confirmed',
            'alamat'  =>  'required|string',
            'telepon'  =>  'required',
            'role'  =>  'required|string',
        ]);

        $user = new User();

        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->alamat    = $request->alamat;
        $user->telepon    = $request->telepon;
        $user->role    = $request->role;
        $user->status    = 0;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            return response()->json([
                'message'       => 'User Created Successfully',
                'status_code'   => 201
            ],201);
        }else {
            return response()->json([
                'message'       => 'Some error occured, Please Try again',
                'status_code'   => 500
            ],500);
        }
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;

    }

    public function logout(Request $request){
        
        // $request->user()->tokens()->where('id', $id)->delete();

        $request->user()->tokens()->delete();

        return response()->json('logout',201);
    }

    public function update_profile(Request $request, User $user){

        $request->validate([
            'name'=>'required',
            'alamat'=>'required',            
            'telepon'=>'required'            
        ]);
        $user->name=$request->name;
        $user->telepon=$request->telepon;
        $user->alamat=$request->alamat;
        
        if ($user->save()) {
            return response()->json($user,200);
        } else {
            return response()->json([
                'message'       => 'Error on Updated',
                'status_code'   => 500
            ],500);
        } 

    }

    public function update_image(Request $request, User $user)
    {   
        
        $old_path = $user->image;
        if($request->hasFile('image')) {
            $request->validate([
                'image'=>'required|image|mimes:jpeg,png,jpg'
            ]);
            $path = $request->file('image')->store('users_images');
            $user->image = $path;

            if ($old_path != '' || $old_path != null) {
                Storage::delete($old_path);
            }      
            
        }

        if ($user->save()) {
            return response()->json($user,200);
        } else {
            return response()->json([
                'message'       => 'Error on Updated',
                'status_code'   => 500
            ],500);
        } 
    }
}
