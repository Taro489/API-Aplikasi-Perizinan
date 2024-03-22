<?php

namespace App\Http\Controllers\Api;

use App\Models\Permittion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DataTransaction;
use Illuminate\Support\Facades\Validator;

class PermittionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permittions = Permittion::where('userId', auth()->user()->id)->get();
        if(!$permittions->isEmpty()){
            return new DataTransaction(200, 'Data perizinan tersedia', $permittions);
        }
        return new DataTransaction(404, 'Data perizinan tidak tersedia', $permittions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->level === 3){
            $validated = Validator::make($request->all(), [
                'subject' => 'required',
                'description' => 'required|max:255'
            ]);
    
            if ($validated->fails()) {
                return response()->json($validated->errors());
            }
    
            $permittion = Permittion::create([
                'userId' => auth()->user()->id,
                'subject' => $request->subject,
                'description' => $request->description
            ]);

            return new DataTransaction(true, 'Berhasil menambahkan perizinan!', $permittion);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permittion  $permittion
     * @return \Illuminate\Http\Response
     */
    public function show(Permittion $permittion)
    {
        if(Auth::user()->level === 3){
            $data = [];
            $permittion = Permittion::findOrFail($permittion->id);
            if($permittion->isApplied == true){
                $data['status'] = 'Diizinkan';
            }else{
                $data['status'] = 'Belum diizinkan';
            }
            $data['data'] = $permittion;
            return new DataTransaction(true, 'Berikut status perizinan!', $data);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permittion  $permittion
     * @return \Illuminate\Http\Response
     */
    public function edit(Permittion $permittion)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permittion  $permittion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permittion $permittion)
    {
        if(Auth::user()->level === 3){
            $validated = Validator::make($request->all(), [
                'subject' => 'required',
                'description' => 'required|max:255'
            ]);
    
            if ($validated->fails()) {
                return response()->json($validated->errors());
            }
    
            $datas = [
                'subject' => $request->subject,
                'description' => $request->description
            ];

            $permittion = Permittion::where('id', $permittion->id)->update($datas);

            return new DataTransaction(true, 'Berhasil mengubah perizinan!', $permittion);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permittion  $permittion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permittion $permittion)
    {
        if(Auth::user()->level === 3){
            Permittion::Destroy($permittion->id);

            $data = [
                'status' => 'OK',
                'message' => 'Deleted!'
            ];
            
            return new DataTransaction(true, 'Berhasil menghapus perizinan!', $data);
        }else{
            $data = [
                'status' => 403,
                'message' => 'Forbidden'
            ];
            return response()->json($data);
        }
    }
}
