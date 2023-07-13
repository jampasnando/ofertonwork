<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Deposito;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista=Servicio::all();
        $depositos=Deposito::all();
        $hoy=date("d-m-Y");
        return view("servicios.index")->with("lista",$lista)->with("depositos",$depositos)->with("hoy",$hoy);
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
    public function __construct(){
        $this->middleware("micheck");
    }
    public function store(Request $request)
    {
        $recibido=$request->input();
        // $nuevoreg=json_decode($recibido[0],true);
        $hoy=date("Y-m-d H:i:s");
        $recibido[0]["fechareg"]=$hoy;
        Servicio::insert($recibido[0]);
        return json_encode("registrado");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicio $servicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       
        $datos=request()->except(["_token","_method"]);
        // return $datos;
        Servicio::where("id",$id)->update($datos);
        return back()->with("avisito","MODIFICACIÓN REGISTRADA");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Servicio::destroy($id);
        return back()->with("avisito","Servicio Eliminado");
    }
}
