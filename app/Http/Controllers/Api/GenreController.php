<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Validator;


class GenreController extends Controller
{
    public function index()
    {
        $genre = Genre::latest()->get();
        $response =[
            'succes' => true,
            'message' => 'Data genre',
            'data' => $genre,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
{
    //validasi data
    $validator = Validator::make($request->all(), [
        'nama_genre' => 'required|unique:genres',
    ], [
        'nama_genre.required' => 'Masukan genre',
        'nama_genre.unique' => 'genre Sudah Digunakan',
    ]);

    if($validator->fails()){
        return response()->json([
            'succes' => false,
            'message' => 'Silahkan Isi Dengan Benar',
            'data' => $validator->erors(),
        ], 401);
    } else {
        $genre = new Genre;
        $genre->nama_genre = $request->nama_genre;
        $genre->save();
    }

    if($genre){
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
        $genre = Genre::find($id);

        if($genre) {
            return response()->json([
                'succes' => true,
                'message' => 'Detail genre',   
                'data' => $genre,        
            ], 200);
        } else {
            return response()->json([
                'succes' => false,
                'message' => 'genre tidak ditemukan', 
                'data' => '',          
            ], 404);
        }
    }
    public function update(Request $request, $id)
    {
        //validasi data
        $validator = Validator::make($request->all(), [
        ], [
            'nama_genre.required' => 'Masukan genre',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Dengan Benar',
                'data' => $validator->erors(),
            ], 400);
        } else {
            $genre = Genre::find($id);
            $genre->nama_genre = $request->nama_genre;
            $genre->save();
        }
    
        if($genre){
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
    $genre = Genre::find($id);
    if($genre) {
    $genre ->delete();
    return response()->json([
        'success' => true,
        'message' => 'data' .$genre->nama_genre . 'berhasil'
    ], 200);

    } else {
        return response()->json([
            'success' => true,
            'message' => 'tidak ditemukan'
        ], 404);    
    }

    }
}
