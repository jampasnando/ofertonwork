<?php

namespace App\Http\Controllers;

use App\Models\Preventa;
use Illuminate\Http\Request;
use DB;
class PreventaController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Preventa  $preventa
     * @return \Illuminate\Http\Response
     */
    public function show(Preventa $preventa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Preventa  $preventa
     * @return \Illuminate\Http\Response
     */
    public function edit(Preventa $preventa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Preventa  $preventa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Preventa $preventa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Preventa  $preventa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Preventa $preventa)
    {
        //
    }
    public function obtienereservas(Request $request){
        $datos=$request->input();
        $dep=$datos[0]["dep"];
        $reservas=DB::select("select tb1.*,vendedores.nombre from (select *,date_format(fechareg,'%d-%m-%Y %H:%m') as fecharegx,datediff(date_add(fechareg, interval tiempo day),now()) as faltan,date_format(date_add(fechareg, interval tiempo day),'%d-%m-%Y %H:%m') as vence from preventas where deposito='$dep' and tiempo>0 and datediff(date_add(fechareg, interval tiempo day),now())>=0) as tb1 inner join vendedores on tb1.vendedor=vendedores.id order by fechareg desc");
        return $reservas;
    }
}
