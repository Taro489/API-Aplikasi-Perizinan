<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\DataTransaction;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function register(Request $request)
    {
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
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function authentication(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            if(auth()->user()->level == 1){
                return response()->json([
                    'status' => true,
                    'message' => 'Selamat datang Admin!',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'data' => auth()->user()
                ]);
            }else if(auth()->user()->level == 2){
                return response()->json([
                    'status' => true,
                    'message' => 'Selamat datang Verifikator!',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'data' => auth()->user()
                ]);
            }else{
                return response()->json([
                    'status' => true,
                    'message' => 'Selamat datang User!',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'data' => auth()->user()
                ]);
            }
        }

        return new DataTransaction(false, 'Login gagal', $request);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        return new DataTransaction(true, 'Logout berhasil', $request);
    }
}
