<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Mentor::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'=>'required',
                'email'=>'required',
                'cpf'=>'required'
            ], [
                'required' => 'O campo :attribute é obrigatório'
            ]);

            $mentor = Mentor::create($request->all());

            return response()->json(['success'=>true, 'msg'=>'Mentor cadastrado!', 'data'=>$mentor], 200);

        } catch (\Throwable $th) {
            return response()->json(['success'=>false, 'msg'=>$th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return Mentor::findOrfail($id);

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $mentor = Mentor::findOrFail($id);
            if ($request->has('name')){
                $mentor->name = $request->name;
            }
            if ($request->has('email')){
                $mentor->email = $request->email;
            }
            $mentor->save();
            return response()->json(['success'=>true, 'msg'=>'Editado!', 'data'=>$mentor]);
        } catch (\Throwable $th) {
            return response()->json(['success'=>false, 'msg'=>$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Mentor::findOrFail($id)->delete();

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
