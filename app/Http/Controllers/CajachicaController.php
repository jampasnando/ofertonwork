<?php

namespace App\Http\Controllers;

use App\Models\Cajachica;
use App\Models\Deposito;
use App\Models\Aperturacajachica;
use Illuminate\Http\Request;
use DB;
class CajachicaController extends Controller
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
        
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depositos=Deposito::all();
        $depusr=session("usr")->ciudad;
        $hoy=date("Y-m-d");
        $apertura=Aperturacajachica::where("fecha",$hoy)->where("deposito",$depusr)->get();
        $gastado=Cajachica::where("fecha","like",$hoy."%")->where("deposito",$depusr)->groupBy("deposito")->sum("monto");
        // return $gastado;
        if(count($apertura)>0){
            return view("cajachica.create")->with("depositos",$depositos)->with("apertura",$apertura)->with("gastado",$gastado);
        }
        else{
            // $ayer=date('Y-m-d',strtotime("-1 days"));
            $ultimo=DB::select("select max(fecha) as ayer from aperturacajachicas where deposito='$depusr'");
            // return $ultimo;
            if($ultimo[0]->ayer!=null){
                $ayer=$ultimo[0]->ayer;
                $saldoayer=Aperturacajachica::where("fecha",$ayer)->where("deposito",$depusr)->get();
                $v=["deposito"=>$depusr,"fecha"=>$hoy,"apertura"=>$saldoayer[0]["saldo"],"gastado"=>0,"saldo"=>$saldoayer[0]["saldo"]];
                Aperturacajachica::insert($v);
                $apertura=Aperturacajachica::where("fecha",$hoy)->where("deposito",$depusr)->get();
                return view("cajachica.create")->with("depositos",$depositos)->with("apertura",$apertura)->with("gastado",$gastado);
            }
            else{
                $nuevito=["deposito"=>$depusr,"fecha"=>$hoy,"apertura"=>0,"gastado"=>0,"saldo"=>0];
                Aperturacajachica::insert($nuevito);
                $apertura=Aperturacajachica::where("fecha",$hoy)->where("deposito",$depusr)->get();
                return view("cajachica.create")->with("depositos",$depositos)->with("apertura",$apertura)->with("gastado",$gastado);
            }
           
        }
    }
    public function detallecajachicaxfecha(){
        $depositos=Deposito::all();
        $hoy=date("Y-m-d");
        $deposito=1;
        $apertura=Aperturacajachica::where("fecha",$hoy)->where("deposito",$deposito)->get();
        $gastado=Cajachica::where("fecha","like",$hoy."%")->where("deposito",$deposito)->orderBy("fecha","desc")->get();
        return view("cajachica.detallecajachicaxfecha")->with("depositos",$depositos)->with("apertura",$apertura)->with("gastado",$gastado)->with("deposito",$deposito);
    }
    public function detallecajachicaxfecha2(Request $request){
        $parametros=$request->input();
        // return $parametros;
        $depositos=Deposito::all();
        $hoy=implode("-",array_reverse(explode("-",$parametros["fechax"])));
        $deposito=$parametros["deposito"];
        $apertura=Aperturacajachica::where("fecha",$hoy)->where("deposito",$deposito)->get();
        $gastado=Cajachica::where("fecha","like",$hoy."%")->where("deposito",$deposito)->orderBy("fecha","desc")->get();
        return view("cajachica.detallecajachicaxfecha")->with("depositos",$depositos)->with("apertura",$apertura)->with("gastado",$gastado)->with("deposito",$deposito);
    }
    public function eliminadecajachica(Request $request){
        $parametros=$request->input();
        $monto=$parametros["monto"];
        $dep=$parametros["deposito"];
        $partesfecha=explode(" ",$parametros["fecha"]);
        $fecha=$partesfecha[0];
        $estaapertura=Aperturacajachica::where("fecha",$fecha)->where("deposito",$dep);
        $estaapertura->gastado=$estaapertura->gastado - $monto;
        $estaapertura->saldo=$estaapertura->saldo + $monto;
        $estaapertura->save();
        $idgasto=$parametros["id"];
        Cajachica::where("id",$idgasto)->delete();
        return json_encode("eliminado");
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
    public function storecajachica(Request $request){
        $caja=$request->input();
       $datos=$caja["datos"];
       $idusr=$caja["idusr"];
       $dep=$caja["deposito"];
       $hoy=date("Y-m-d H:i:s");
       $hoyx=date("Y-m-d");
       $suma=0;
       foreach ($datos as $undato) {
           $insertar=["deposito"=>$dep,"concepto"=>$undato["concepto"],"monto"=>$undato["valor"],"fecha"=>$hoy,"usuario"=>$idusr,"respaldos"=>""];
           $suma=$suma + $undato["valor"];
            Cajachica::insert($insertar);
       }
    //    $gastado=Cajachica::where("fecha","like",$hoyx."%")->where("deposito",$dep)->groupBy("deposito")->sum("monto");
       $apertura=Aperturacajachica::where("fecha",$hoyx)->where("deposito",$dep)->get();
       $apertura[0]["gastado"]=$apertura[0]["gastado"] + $suma;
       $apertura[0]["saldo"]=$apertura[0]["saldo"] - $suma;
       $apertura[0]->save();
       $nuevoestado=["gastado"=>$apertura[0]["gastado"],"saldo"=> $apertura[0]["saldo"]];
       return json_encode($nuevoestado);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cajachica  $cajachica
     * @return \Illuminate\Http\Response
     */
    public function show(Cajachica $cajachica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cajachica  $cajachica
     * @return \Illuminate\Http\Response
     */
    public function edit(Cajachica $cajachica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cajachica  $cajachica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cajachica $cajachica)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cajachica  $cajachica
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cajachica $cajachica)
    {
        //
    }
}
