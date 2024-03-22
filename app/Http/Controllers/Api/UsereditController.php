<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DataTransaction;
use Illuminate\Support\Facades\Validator;

class UsereditController extends Controller
{
    public function index(){
        if(Auth::user()->level === 1){
            $users = User::all()->except(Auth::id());
            if(!$users->isEmpty()){
                return new DataTransaction(200, 'Data pengguna tersedia', $users);
            }
            return new DataTransaction(404, 'Data pengguna tidak tersedia', []);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }

    public function addVerificator(Request $request){
        if(Auth::user()->level === 1){
            $validated = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|max:255'
            ]);
    
            if ($validated->fails()) {
                return response()->json($validated->errors());
            }
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'level' => 2
            ]);

            return new DataTransaction(true, 'Berhasil menambahkan verifikator!', $user);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }

    public function promoteToVerificator(Request $request){
        if(Auth::user()->level === 1){
            $validated = Validator::make($request->all(), [
                'id' => 'required'
            ]);
    
            if ($validated->fails()) {
                return response()->json($validated->errors());
            }

            $data = [
                "level" => 2
            ];

            $user = User::FindOrFail($request->id)->update($data);   

            return new DataTransaction(true, 'Berhasil mengubah user ke verifikator!', $user);
        }else{
            return response()->json(403);
        }
    }

    public function updatePasswordUser(Request $request, User $user){
        if(Auth::user()->level === 3 || Auth::user()->level === 1){
            $datas = [
                'password' =>  Hash::make($request->password)
            ];

            $update = User::where('id', $user->id)->update($datas);

            return new DataTransaction(true, 'Berhasil mengubah password!', $update);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }

    public function verifiedUserRegister(User $user){
        if(Auth::user()->level === 2){
            if($user->isVerified == false){
                $datas = [
                    'isVerified' =>  true
                ];
    
                $update = User::where('id', $user->id)->update($datas);
    
                return new DataTransaction(true, 'Berhasil memverifikasi pengguna!', $update);
            }else{
                return new DataTransaction(false, 'Pengguna sudah diverifikasi!', []);
            }
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }
}
