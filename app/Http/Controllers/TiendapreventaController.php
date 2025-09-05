<?php

namespace App\Http\Controllers;

use App\Models\Tiendapreventa;
use App\Models\Deposito;
use DB;
use Illuminate\Http\Request;

class TiendapreventaController extends Controller
{
    public function __construct(){
        $this->middleware("micheck");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meses=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        $mes= (int)date("m");
        // $mes=$meses[(int)date("m")];
        $ano=date("Y");
        // if(session("usr")->rol!="Enc. Tienda y caja"){
        //     $lista=Cierre::orderBy("fecha","desc")->get();
        //     return view("ventas.cierres")->with("lista",$lista)->with("mesanox",$mes." ".$ano);
        // }  
        // else{
            $deposito=session("usr")->ciudad;
            $idusr=session("usr")->id;
            $lista= Tiendapreventa::whereMonth("fecha_creacion",$mes)->whereYear("fecha_creacion",$ano)->where("deposito",$deposito)->orderBy("estado","asc")->orderBy("fecha_creacion","desc")->get();
            // return json_encode($mes);
            return view("tiendapreventas.index")->with("lista",$lista)->with("mesanox",$mes." ".$ano);
        // }      
    }
    public function listapreventasmes(Request $request)
    {
        $deposito=session("usr")->ciudad;
        $mesano=explode(" ",$request->mesano);
        $mes=$mesano[0];
        $ano=$mesano[1];
        $meses=["Enero"=>1,"Febrero"=>2,"Marzo"=>3,"Abril"=>4,"Mayo"=>5,"Junio"=>6,"Julio"=>7,"Agosto"=>8,"Septiembre"=>9,"Octubre"=>10,"Noviembre"=>11,"Diciembre"=>12];
        // if(session("usr")->rol!="Enc. Tienda y caja"){
        //     $lista=Cierre::whereMonth("fecha",$meses[$mes])->whereYear("fecha",$ano)->orderBy("fecha","desc")->get();
        //     return view("ventas.cierres")->with("lista",$lista)->with("mesanox",$mes." ".$ano);
        // }  
        // else{
            $deposito=session("usr")->ciudad;
            $idusr=session("usr")->id;
            $lista=Tiendapreventa::whereMonth("fecha_creacion",$meses[$mes])->whereYear("fecha_creacion",$ano)->where("deposito",$deposito)->orderBy("estado","asc")->orderBy("fecha_creacion","desc")->get();
            return view("tiendapreventas.index")->with("lista",$lista)->with("mesanox",$mes." ".$ano);
        // }      
    }

    function detalleventatienda(Request $request){
        // return $request->id;
        // $aux=$request->input();
        // $datos=json_encode($aux);
        $preventa=Tiendapreventa::where("id",$request->id)->get();
        $preventa[0]->idprev=$request->id;
        // return $preventa;
        $depositos=Deposito::all();
        return view("ventas.createventatienda")->with("datos",json_encode($preventa[0]))->with("depositos",$depositos);
    }
    public function configuracion(){
        $config=DB::select("select * from configapp");
        // $promos=DB::select("select tb1.*,depositos.id as iddep,depositos.nombre from (select promos.producto,promos.fechareg,inventarios.* from promos inner join inventarios on promos.producto=inventarios.id) as tb1 inner join depositos on tb1.deposito=depositos.id");
        $promos=DB::select("select tb1.*,depositos.id as iddep,depositos.nombre from depositos left join (select promos.producto,promos.fechareg,inventarios.* from promos inner join inventarios on promos.producto=inventarios.id) as tb1  on tb1.deposito=depositos.id where depositos.id <5");
        $undep="";
        $iddep="";
        $cont=0;
        $regsundep=[];
        $filas=[];
        foreach ($promos as $key => $unapromo) {
            if($cont==0){
                $undep=$unapromo->nombre;
                $iddep=$unapromo->iddep;
                $regsundep[]=$unapromo;
                $cont++;
            }
            else{
                if($unapromo->nombre==$undep){
                    $regsundep[]=$unapromo;
                    $cont++;
                }
                else{
                    $filas[]=["nombre"=>$undep,"iddep"=>$iddep,"promos"=>$regsundep];
                    $regsundep=[];
                    $undep=$unapromo->nombre;
                    $iddep=$unapromo->iddep;
                    $regsundep[]=$unapromo;
                }
            }
        }
        if($cont>0){$filas[]=["nombre"=>$undep,"iddep"=>$iddep,"promos"=>$regsundep];}
        return view("market.configuracion")->with("config",$config)->with("promos",$filas);
    }
    public function actualizaconfig(Request $request){
        // return $request;
        DB::table("configapp")->update([
            "whatsapp"=>$request->whatsapp,
            "nrocuenta"=>$request->nrocuenta,
            "banco"=>$request->banco,
            "titularcuenta"=>$request->titularcuenta,
        ]);
        $config=DB::select("select * from configapp");
        return view("market.configuracion")->with("config",$config);
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
     * @param  \App\Models\Tiendapreventa  $tiendapreventa
     * @return \Illuminate\Http\Response
     */
    public function show(Tiendapreventa $tiendapreventa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tiendapreventa  $tiendapreventa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tiendapreventa $tiendapreventa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tiendapreventa  $tiendapreventa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tiendapreventa $tiendapreventa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tiendapreventa  $tiendapreventa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tiendapreventa $tiendapreventa)
    {
        //
    }
}
