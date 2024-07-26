<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Aktor;
use Illuminate\Http\Request;
use Validator;


class AktorController extends Controller
{
    public function index()
    {
        $aktor = Aktor::latest()->get();
        $response =[
            'succes' => true,
            'message' => 'Data aktor',
            'data' => $aktor,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
{
    //validasi data
    $validator = Validator::make($request->all(), [
        'nama_aktor' => 'required|unique:aktors',
        'biodata' => 'required',
    ], [
        'nama_aktor.required' => 'Masukan aktor',
        'nama_aktor.unique' => 'aktor Sudah Digunakan',
        'biodata.required' => 'Masukan biodata',
        'biodata.unique' => 'biodata Sudah Digunakan',
    ]);

    if($validator->fails()){
        return response()->json([
            'succes' => false,
            'message' => 'Silahkan Isi Dengan Benar',
            'data' => $validator->erors(),
        ], 400);
    } else {
        $aktor = new Aktor;
        $aktor->nama_aktor = $request->nama_aktor;
        $aktor->biodata = $request->biodata;
        $aktor->save();
    }

    if($aktor){
        return response()->json([
            'succes' => true,
            'message' => 'Data Berhasil Disimpan',
        ], 200);
    } else {
        return response()->json([
            'succes' => false,
            'message' => 'data gagal disimpan',
        ], 400);
    }
}
    public function show($id)
    {
        $aktor = Aktor::find($id);

        if($aktor) {
            return response()->json([
                'succes' => true,
                'message' => 'Detail aktor',   
                'data' => $aktor,        
            ], 200);
        } else {
            return response()->json([
                'succes' => false,
                'message' => 'aktor tidak ditemukan', 
                'data' => '',          
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        //validasi data
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required',
            'biodata' =>'required'
        ], [
            'nama_aktor.required' => 'Masukan aktor',
            'biodata.required' => 'Masukan biodata',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Dengan Benar',
                'data' => $validator->erors(),
            ], 400);
        } else {
            $aktor = Aktor::find($id);
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->biodata = $request->biodata;
            $aktor->save();
        }
    
        if($aktor){
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diperbarui',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'data gagal disimpan',
            ], 400);
        }
    }
    public function destroy($id) 
    {
    $aktor = Aktor::find($id);
    if($aktor) {
    $aktor ->delete();
    return response()->json([
        'success' => true,
        'message' => 'data' .$aktor->nama_aktor,$aktor->biodata . 'berhasil dihapus',
    ], 200);

    } else {
        return response()->json([
            'success' => true,
            'message' => 'tidak ditemukan'
        ], 404);    
    }

    }
}
