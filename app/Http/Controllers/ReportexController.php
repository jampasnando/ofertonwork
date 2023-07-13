<?php

namespace App\Http\Controllers;

use App\Models\Reportex;
use Illuminate\Http\Request;
use DB;
class ReportexController extends Controller
{
    public function __construct(){
        $this->middleware("micheck");
    }
   public function comisiones(){
       $res=DB::select("select vendedores.nombre,vendedores.id,tb1.* from (select vendedor,sum(if(pagocomision is null,comision*cuantos,0)) as pendientes,sum(if(pagocomision is null,cuantos,0)) as nroprods from detalleventas group by vendedor) as tb1 left join vendedores on tb1.vendedor=vendedores.id where pendientes>0 order by nombre");
       $lista=[];
       foreach ($res as $key => $unreg) {
            $lista[]=$unreg;
       }
        return view("reportes.comisiones")->with("lista",$lista);
   }
   public function comisionespagadas(){
    $res=DB::select("select vendedores.nombre,vendedores.id,tb1.* from (select vendedor,sum(if(not(pagocomision is null),comision*cuantos,0)) as pagadas,sum(if(not(pagocomision is null),cuantos,0)) as nroprods from detalleventas group by vendedor) as tb1 left join vendedores on tb1.vendedor=vendedores.id where pagadas>0 order by nombre");
    $lista=[];
    foreach ($res as $key => $unreg) {
         $lista[]=$unreg;
    }
     return view("reportes.comisionespagadas")->with("lista",$lista);
}
   public function pagacomision(Request $request){
    $res=DB::select("select tb2.*,depositos.nombre from (select tb1.*,ventas.fecha,ventas.idneg from (select * from detalleventas where pagocomision is null and vendedor='".$request->idv."') as tb1 inner join ventas on tb1.idventa=ventas.idventa) as tb2 inner join depositos on tb2.idneg=depositos.id");
    //    $res=DB::select("select tb1.*,ventas.fecha from (select * from detalleventas where pagocomision is null and vendedor='".$request->idv."') as tb1 inner join ventas on tb1.idventa=ventas.idventa");
       $lista=[];
       foreach ($res as $undetalle) {
           $lista[]=$undetalle;
       }
       return view("ventas.pagacomision")->with("idv",$request->idv)->with("nombre",$request->nombre)->with("lista",$lista);
   }
   public function detallecompagada(Request $request){
    $res=DB::select("select tb1.*,ventas.fecha from (select * from detalleventas where not(pagocomision is null) and vendedor='".$request->idv."') as tb1 inner join ventas on tb1.idventa=ventas.idventa");
    $lista=[];
    foreach ($res as $undetalle) {
        $lista[]=$undetalle;
    }
    return view("ventas.detallecompagada")->with("idv",$request->idv)->with("nombre",$request->nombre)->with("lista",$lista);
}
   public function guardapagocomision(Request $request){
       $ids=json_decode($request->ids);
       $obs=$request->obs;
       $hoy=date("Y-m-d H:i:s");
       for($k=0;$k<count($ids);$k++){
           $upd=DB::update("update detalleventas set pagocomision='$hoy',observaciones='$obs' where id='".$ids[$k]."'");
       }  
       return $this->comisiones("");
    //    return view("reportes.comisiones");
   }
   public function ventasxprod(){
       $lista=DB::select("select inventarios.idprod,descripcion,deposito,cant from inventarios inner join (SELECT idprod,sum(cuantos) as cant FROM `detalleventas` group by idprod) as tb1 on inventarios.id=tb1.idprod order by cant desc");
       return view("reportes.ventasxprod")->with("lista",$lista);
   }
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
     * @param  \App\Models\Reportex  $reportex
     * @return \Illuminate\Http\Response
     */
    public function show(Reportex $reportex)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reportex  $reportex
     * @return \Illuminate\Http\Response
     */
    public function edit(Reportex $reportex)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reportex  $reportex
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reportex $reportex)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reportex  $reportex
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reportex $reportex)
    {
        //
    }
}
