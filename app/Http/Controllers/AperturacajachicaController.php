<?php

namespace App\Http\Controllers;

use App\Models\Aperturacajachica;
use App\Models\Deposito;
use Illuminate\Http\Request;

class AperturacajachicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deposito="1";
        $depositos=Deposito::all();
        $registros=Aperturacajachica::where("deposito",$deposito)->orderBy("fecha","desc")->get();
        return view('cajachica.aperturacajachica')->with("registros",$registros)->with("depositos",$depositos)->with("dep",$deposito);
    }
    public function aperturacajachica2(Request $request){
        $datos=$request->input();
        $deposito=$datos["deposito"];
        $depositos=Deposito::all();
        $registros=Aperturacajachica::where("deposito",$deposito)->orderBy("fecha","desc")->get();
        return view('cajachica.aperturacajachica')->with("registros",$registros)->with("depositos",$depositos)->with("dep",$deposito);
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
       

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aperturacajachica  $aperturacajachica
     * @return \Illuminate\Http\Response
     */
    public function show(Aperturacajachica $aperturacajachica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aperturacajachica  $aperturacajachica
     * @return \Illuminate\Http\Response
     */
    public function edit(Aperturacajachica $aperturacajachica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aperturacajachica  $aperturacajachica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $unapertura=$request->input();
        $ida=$unapertura[0]["id"];
        $elregistro=Aperturacajachica::findOrFail($ida);
        $elregistro->apertura=$unapertura[0]["apertura"];
        $elregistro->saldo=$unapertura[0]["apertura"] - $unapertura[0]["gastado"];
        $elregistro->save();
        return $elregistro;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aperturacajachica  $aperturacajachica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aperturacajachica $aperturacajachica)
    {
        //
    }
}
