<?php

namespace App\Http\Controllers\Api;

use App\Models\Permittion;
use Illuminate\Http\Request;
use App\Models\AcceptPermittions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DataTransaction;
use Illuminate\Support\Facades\Validator;

class AcceptPermittionController extends Controller
{
    public function acceptState(Request $request){ 
        if(Auth::user()->level === 2){
            $validated = Validator::make($request->all(), [
                'comment' => 'required|max:255',
                'isAccepted' => 'required'
            ]);
            
            if ($validated->fails()) {
                return response()->json($validated->errors());
            }
            
            $message = "";
            if($request->isAccepted == true){
                $message = "Perizinan berhasil diberikan!";
            }else{
                $message = "Perizinan berhasil ditolak!";
            }

            $user = AcceptPermittions::create([
                'verificatorId' => $request->verificatorId,
                'permittionId' => $request->permittionId,
                'comment' => $request->comment,
                'isAccepted' => $request->isAccepted
            ]);
    
            return new DataTransaction(true, $message, $user);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }

    public function showAllPermittions(){
        if(Auth::user()->level === 1){
            $permittions = Permittion::all();
            if(!$permittions->isEmpty()){
                return new DataTransaction(true, 'Data perizinan tersedia', $permittions);
            }
            return new DataTransaction(false, 'Data perizinan tidak tersedia', []);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }
}
