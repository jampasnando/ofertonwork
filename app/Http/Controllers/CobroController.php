<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Models\Bitacora;
use Illuminate\Http\Request;

class CobroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $usuario=session("usr");
        $recibido=$request->input();
        $hoy=date("Y-m-d H:i:s");
        $recibido[0]["fechareg"]=$hoy;
        $ejecuta=Cobro::insert($recibido[0]);
        $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"NUEVO COBRO","query"=>json_encode($recibido),"nuevoCobro"];
        Bitacora::create($bitacora);
        return json_encode($ejecuta);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function show(Cobro $cobro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function edit(Cobro $cobro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cobro $cobro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cobro $cobro)
    {
        
    }
    public function eliminacobro(Request $request){
        // Cobro::destroy($request->idcobro);
        $hoy=date("Y-m-d H:i:s");
        $usuario=session("usr");
        $que=$request->input();
        $reg=Cobro::find($que[0]["idcobro"]);
        Cobro::destroy($que[0]["idcobro"]);
        $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"elim COBRO","query"=>json_encode($reg),"elimCobro"];
        Bitacora::create($bitacora);
        // return json_encode($que);
        return back()->with("avisito","Cobro Eliminado");
    }
}
