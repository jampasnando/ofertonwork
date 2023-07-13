<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $prods=DB::select("SELECT * from inventarios where categoria='Herramientas' and marca='GLADIATOR' and imagenes<>'' limit 0,12");
        $prods=DB::select("SELECT * from inventarios where imagenes<>'' and cantidad>0 limit 15");
        $categorias=DB::select("select distinct categoria from inventarios where imagenes<>'' and cantidad>0 order by categoria");
        $marcas=DB::select("select marca,count(*) as cant from inventarios where imagenes<>'' and cantidad>0 group by marca order by cant desc  ");
        return view("market.index")->with("prods",$prods)->with("marcas",$marcas)->with("categorias",$categorias);
    }
    public function obtieneprodsajax(Request $request){
        $entrada=$request->input();
        // return $entrada;
        // return json_encode($entrada[0]["marca"]);
        $limiteinf=$entrada[0]["limite"];
        $filtros=["true"];
        if($entrada[0]["marca"]!="Todas"){$filtros[]="marca='".$entrada[0]["marca"]."'";}
        if($entrada[0]["categoria"]!="Todas"){$filtros[]="categoria='".$entrada[0]["categoria"]."'";}
        if($entrada[0]["sucursal"]!=0){$filtros[]="deposito='".$entrada[0]["sucursal"]."'";}
        if($entrada[0]["buscar"]!=''){$filtros[]="descripcion like '%".$entrada[0]["buscar"]."%'";}
        $query="SELECT * from inventarios where imagenes<>'' and cantidad>0 and ".implode(" and ",$filtros)." limit $limiteinf,15";
        $prods=DB::select($query);
        return json_encode($prods);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
