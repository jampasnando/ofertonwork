<?php

namespace App\Http\Controllers;

use App\Models\Cupon;
use Illuminate\Http\Request;
use DB;
class CuponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $depositos=DB::select("");
        // return view("inventario.index")->with("depositos",$depositos);
    }
    public function verificacupon(Request $request){
        $cupon=$request->input();
        $unvendedor=$cupon[0]["unvendedor"];
        if($unvendedor==""){
            $verificado=DB::select("select tb1.*,vendedores.id as idvendedor,vendedores.nombre,vendedores.telefono from (select * from cupons where cupon='".$cupon[0]["cupon"]."' and vigente='1') as tb1 inner join vendedores on tb1.vendedor=vendedores.id");
        }
        else{
            $verificado=DB::select("select * from cupons where cupon='".$cupon[0]["cupon"]."'");
        }
        
        return json_encode($verificado);
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
     * @param  \App\Models\Cupon  $cupon
     * @return \Illuminate\Http\Response
     */
    public function show(Cupon $cupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cupon  $cupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Cupon $cupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cupon  $cupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cupon $cupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cupon  $cupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cupon $cupon)
    {
        //
    }
}
