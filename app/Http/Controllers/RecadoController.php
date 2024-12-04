<?php

namespace App\Http\Controllers;

use App\Models\Recado;
use Illuminate\Http\Request;

class RecadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Recado::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'sender'=>'required',
                'recipient'=>'required',
                'message'=>'required'
            ], [
                'required' => 'O campo :attribute é obrigatório'
            ]);

            $recado = Recado::create($request->all());

            return response()->json(['success'=>true, 'msg'=>'Recado cadastrado!', 'data'=>$recado], 200);

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
            return Recado::findOrfail($id);

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
            $recado = Recado::findOrFail($id);
            if ($request->has('sender')){
                $recado->sender = $request->sender;
            }
            if ($request->has('recipient')){
                $recado->recipient = $request->recipient;
            }
            $recado->save();
            return response()->json(['success'=>true, 'msg'=>'Editado!', 'data'=>$recado]);
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
            Recado::findOrFail($id)->delete();

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
