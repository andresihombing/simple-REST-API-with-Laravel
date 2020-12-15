<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{    
    public function index()
    {
        //get data from table posts
        $posts = Siswa::latest()->get();

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Data Post',
            'data'    => $posts  
        ], 200);
    }

    public function show($id)
    {
        //find post by ID
        $post = Siswa::findOrfail($id);

        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $post 
        ], 200);
    }

    public function store(Request $request)
    {        
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'alamat' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //save to database
        $post = Siswa::create([
            'nama'     => $request->nama,
            'alamat'   => $request->alamat
        ]);

        //success save to database
        if($post) {
            return response()->json([
                'success' => true,
                'message' => 'Post Created',
                'data'    => $post  
            ], 201);

        } 

        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Post Failed to Save',
        ], 409);
    }

    public function update(Request $request, Siswa $siswa)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'alamat' => 'required',
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        //find post by ID        
        $post = Siswa::findOrFail($siswa->id);
        
        if($post) {
            //update post
            $post->update([
                'nama'     => $request->nama,
                'alamat'   => $request->alamat
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $post  
            ], 200);
        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }

    public function destroy($id)
    {
        echo "sadfsad";die();
        //find post by ID
        $post = Siswa::findOrfail($id);

        if($post) {
            //delete post
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post Deleted',
            ], 200);

        }

        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Post Not Found',
        ], 404);
    }
}
