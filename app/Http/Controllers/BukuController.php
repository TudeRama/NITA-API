<?php

namespace App\Http\Controllers;

use App\Models\buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=buku::all();
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi=$request->validate([
            'namaBuku'=>'required',
            'kodeBuku'=>'required',
            'author'=>'required',
            'image'=>'required|file|mimes:png,jpg',
            'kategori'=>'required'
        ]);

        try {
            $fileName = time().$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('uploads/buku',$fileName);
            $validasi['image']=$path;
            $response = buku::create($validasi);
            return response()->json([
                'success' => true,
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'=>'Err',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi=$request->validate([
            'namaBuku'=>'required',
            'kodeBuku'=>'required',
            'author'=>'required',
            'image'=>'',
            'kategori'=>'required'
        ]);

        try {
            if($request->file('image')){
                $fileName = time().$request->file('image')->getClientOriginalName();
                $path = $request->file('image')->storeAs('uploads/buku',$fileName);
                $validasi['image']=$path;
            }
            $response = buku::find($id);
            $response->update($validasi);
            return response()->json([
                'success' => true,
                'message' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message'=>'Err',
                'errors'=>$e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku=buku::find($id);
        $buku->delete();
        return response()->json([
            'success'=>TRUE,
            'message'=>'Success'
        ]);
    }
}
