<?php

namespace App\Http\Controllers\Api;

use App\Models\Permittion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DataTransaction;

class PermittionAppliedController extends Controller
{
    public function applyPermittion(Permittion $permittion){
        if(Auth::user()->level === 3){
            $datas = [
                'isApplied' => true 
            ];

            $permittions = Permittion::findOrFail($permittion->id)->update($datas);

            return new DataTransaction(true, 'Berhasil mengajukan perizinan!', $permittions);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }
    
    public function cancelPermittion(Permittion $permittion){
        if(Auth::user()->level === 3){
            $datas = [
                'isApplied' => false 
            ];

            $permittions = Permittion::findOrFail($permittion->id)->update($datas);

            return new DataTransaction(true, 'Berhasil membatalkan perizinan!', $permittions);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }
}
