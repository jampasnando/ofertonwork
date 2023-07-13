<?php

namespace App\Http\Controllers;

use App\Models\Cierre;
use App\Models\Detalleventa;
use Illuminate\Http\Request;
use DB;
use App\Exports\DetalleventaExport;
use Maatwebsite\Excel\Facades\Excel;
class CierreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware("micheck");
    }
    public function index()
    {
        $meses=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        // return (int)date("m");
        $mes=$meses[(int)date("m")];
        $ano=date("Y");
        if(session("usr")->rol!="Enc. Tienda y caja"){
            $lista=Cierre::orderBy("fecha","desc")->get();
            return view("ventas.cierres")->with("lista",$lista)->with("mesanox",$mes." ".$ano);
        }  
        else{
            $deposito=session("usr")->ciudad;
            $idusr=session("usr")->id;
            $lista=Cierre::where("deposito",$deposito)->where("idusr",$idusr)->orderBy("fecha","desc")->get();
            return view("ventas.cierres")->with("lista",$lista)->with("mesanox",$mes." ".$ano);
        }      
    }
    public function listacierres(Request $request)
    {
        $mesano=explode(" ",$request->mesano);
        $mes=$mesano[0];
        $ano=$mesano[1];
        $meses=["Enero"=>1,"Febrero"=>2,"Marzo"=>3,"Abril"=>4,"Mayo"=>5,"Junio"=>6,"Julio"=>7,"Agosto"=>8,"Septiembre"=>9,"Octubre"=>10,"Noviembre"=>11,"Diciembre"=>12];
        if(session("usr")->rol!="Enc. Tienda y caja"){
            $lista=Cierre::whereMonth("fecha",$meses[$mes])->whereYear("fecha",$ano)->orderBy("fecha","desc")->get();
            return view("ventas.cierres")->with("lista",$lista)->with("mesanox",$mes." ".$ano);
        }  
        else{
            $deposito=session("usr")->ciudad;
            $idusr=session("usr")->id;
            $lista=Cierre::where("deposito",$deposito)->where("idusr",$idusr)->orderBy("fecha","desc")->get();
            return view("ventas.cierres")->with("lista",$lista)->with("mesanox",$mes." ".$ano);
        }      
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
     * @param  \App\Models\Cierre  $cierre
     * @return \Illuminate\Http\Response
     */
    public function show(Cierre $cierre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cierre  $cierre
     * @return \Illuminate\Http\Response
     */
    public function edit(Cierre $cierre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cierre  $cierre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cierre $cierre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cierre  $cierre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cierre $cierre)
    {
        //
    }
    public function detallecierres(Request $request){
        
        $fechacierre=$request->fechacierre;
        $obs=$request->obs;
        $idcierre=$request->idcierre;
        // $detalle=DB::select("select detalleventas.id,descripcion,cuantos,precioventa,cierre,fecha,cliente,preciofinal from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa where cierre='$fechacierre' order by fecha desc");
        $respaldos=DB::select("select respaldos from cierres where fecha='$fechacierre'");
        $detalle=DB::select("select tb2.id,tb2.descripcion,tb2.nombre,vendedores.nombre as vendedor,tb2.cliente,tb2.fecha,tb2.cierre,tb2.cuantos,tb2.preciofinal,tb2.total from (select tb1.*,depositos.nombre from (select detalleventas.id,descripcion,idneg,detalleventas.vendedor,cliente,fecha,cierre,cuantos,preciofinal,cuantos*preciofinal as total from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa where cierre='$fechacierre') as tb1 inner join depositos on tb1.idneg=depositos.id) as tb2 inner join vendedores on tb2.vendedor=vendedores.id");
        return view("ventas.detallecierre")->with("detalle",$detalle)->with("obs",$obs)->with("fechacierre",$fechacierre)->with("idcierre",$idcierre)->with("respaldos",$respaldos);
    }
    public function exportardetallecierre(Request $request){
        $ciudad=session("usr")->ciudad;
        return Excel::download(new DetalleventaExport($request->fechacierre),"Cierre_".$request->fechacierre."_".$ciudad.".xlsx");
    }

    public function respaldos(Request $request){
        return $request->fechacierre;
    }

    public function suberespaldos(Request $request){
        $idcierre=$request->idcierre;
        $imagenes=[];
        if($archs=$request->file("imagenes")){
            foreach ($archs as $arch) {
                $nomarch=md5(rand(1000,10000))."_".$idcierre.".".$arch->getClientOriginalExtension();
                $arch->move("respaldos",$nomarch);
                $imagenes[]=$nomarch;
            }
        }
        $elcierre=Cierre::find($idcierre);
        if($elcierre->respaldos!=null){
            $antes=explode("|",$elcierre->respaldos);
            $ahora=array_merge($antes,$imagenes);
        }
        else{
            $ahora=$imagenes;
        }
        $elcierre->respaldos=implode("|",$ahora);
        $elcierre->save();
        return back();
    }
}
