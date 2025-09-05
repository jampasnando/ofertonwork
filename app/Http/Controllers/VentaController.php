<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Inventario;
use App\Models\Vendedore;
use App\Models\Detalleventa;
use App\Models\Deposito;
use App\Models\Cierre;
use App\Models\Bitacora;
use App\Models\Cobro;
use App\Models\Tiendapreventa;

use DB;
use App\Exports\VentasExport;
use App\Exports\VentasRangofechas;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware("micheck");
    }
    public function buscaprod(Request $request){
        $txt=$request->texto;
        // $resbusq=Inventario::select("id","descripcion","cantidad","precioventa","preciolocal","comision","idprod")->where("idprod","like",$request->texto."%")->where("deposito","=",$request->dep)->take(10)->get();
        $resbusq=Inventario::select("id","descripcion","cantidad","precioventa","preciolocal","comision","idprod")
        ->where("deposito","=",$request->dep)
        ->where(function($query) use ($txt){
            $query->where("idprod","like",$txt."%")
            ->orWhere("descripcion","like","%".$txt."%");
        })->take(15)->get();
        return view("ventas.buscados")->with("resbusq",$resbusq);
    }
    public function buscaprodxapromo(Request $request){
        $txt=$request->texto;
        // $resbusq=Inventario::select("id","descripcion","cantidad","precioventa","preciolocal","comision","idprod")->where("idprod","like",$request->texto."%")->where("deposito","=",$request->dep)->take(10)->get();
        $resbusq=Inventario::select("id","descripcion","cantidad","precioventa","preciolocal","comision","idprod","imagenes")
        ->where("deposito","=",$request->dep)
        ->where(function($query) use ($txt){
            $query->where("idprod","like",$txt."%")
            ->orWhere("descripcion","like","%".$txt."%");
        })->take(15)->get();
        return view("ventas.buscadosxapromo")->with("resbusq",$resbusq);
    }
    public function buscaprodxamover(Request $request){
        $txt=$request->texto;
        $resbusq=Inventario::select("id","descripcion","cantidad","precioventa","preciolocal","comision","idprod")
        ->where("deposito","=",$request->dep)
        ->where(function($query) use ($txt){
            $query->where("idprod","like",$txt."%")
            ->orWhere("descripcion","like","%".$txt."%");
        })->take(10)->get();
        return view("ventas.buscados")->with("resbusq",$resbusq);
    }
    public function buscaprodsolosaldos(Request $request){
        $texto=$request->texto;
        $resbusq=Inventario::select("id","descripcion","cantidad","precioventa","preciolocal","comision","idprod","deposito")
        ->where("deposito","=",$request->dep)
        // ->where("idprod","like",$request->texto."%")
        ->where(function ($query) use($texto){
            $query->where("idprod","like",$texto."%")
            ->orWhere("descripcion","like","%".$texto."%");
        })
        ->take(10)->get();
        return view("ventas.buscadossolosaldos")->with("resbusq",$resbusq);
}
    public function buscavendedor(Request $request){
        $resbusq=Vendedore::select("id","nombre")->where("nombre","like","%".$request->vendedor."%")->take(10)->get();
        return view("ventas.buscadosvendedores")->with("resbusq",$resbusq);
}
    public function index()
    {
        // $ventas=Venta::all();
        // return view("ventas.index")->with("ventas",$ventas);
        return view("ventas.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depositos=Deposito::all();
        return view("ventas.create")->with("depositos",$depositos);
    }
    public function createventavendedor()
    {
        $depositos=Deposito::all();
        return view("ventas.createventavendedor")->with("depositos",$depositos);
    }
    // public function createsolosaldos()
    // {
    //     $depositos=Deposito::all();
    //     return view("ventas.solosaldos")->with("depositos",$depositos);
    // }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $venta=$request->input();
        $detalle=$venta[0]["detalleventa"];
        unset($venta[0]["detalleventa"]);
        $idventa=uniqid();
        $venta[0]["idventa"]=$idventa;
        if($venta[0]["fecha"]==""){
            $venta[0]["fecha"]=date("Y-m-d H:i:s");
        }
        else{
            $fechax= $venta[0]['fecha'];
            $venta[0]['fecha']=implode("-",array_reverse(explode("-",$fechax)));
        }
        $venta[0]["pagomixto"]=null;
        Venta::insert($venta);
        foreach ($detalle as $undet) {
            $undet["idventa"]=$idventa;
            Detalleventa::insert($undet);
            $unprod=Inventario::findOrFail($undet["idprod"]);
            $unprod->cantidad=$unprod->cantidad - $undet["cuantos"];
            $unprod->save();
        }
       
        return $venta;
    }
    public function storeventavendedor(Request $request)
    {
        $venta=$request->input();
        $detalle=$venta[0]["detalleventa"];
        unset($venta[0]["detalleventa"]);
        $idventa=uniqid();
        $venta[0]["idventa"]=$idventa;
        if($venta[0]["fecha"]==""){
            $venta[0]["fecha"]=date("Y-m-d H:i:s");
        }
        else{
            $fechax= $venta[0]['fecha'];
            $venta[0]['fecha']=implode("-",array_reverse(explode("-",$fechax)));
        }
        if($venta[0]["formapago"]!="mixto"){
            $venta[0]["pagomixto"]=null;
        }
        
        Venta::insert($venta);
        $hoy=date("Y-m-d H:i:s");
        $usuario=session("usr");
        $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"venta","query"=>json_encode($venta),"ventaEncCaja"];
        Bitacora::create($bitacora);
        foreach ($detalle as $undet) {
            $undet["idventa"]=$idventa;
            Detalleventa::insert($undet);
            $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"detalleventa","query"=>json_encode($undet),"obs"=>"cuantos"];
            Bitacora::create($bitacora);
            $unprod=Inventario::findOrFail($undet["idprod"]);
            $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"detalleventa","query"=>json_encode($unprod),"obs"=>"antes"];
            Bitacora::create($bitacora);
            $unprod->cantidad=$unprod->cantidad - $undet["cuantos"];
            $unprod->save();
            
            $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"detalleventa","query"=>json_encode($unprod),"obs"=>"despues"];
            Bitacora::create($bitacora);
        }
       
        return $venta;
    }
    public function registraventawebapp(Request $request)
    {
        $venta=$request->input();
        $detalle=$venta[0]["detalleventa"];
        $idprev=$venta[0]["idprev"];
        unset($venta[0]["detalleventa"]);
        unset($venta[0]["idprev"]);
        $idventa=uniqid();
        $venta[0]["idventa"]=$idventa;
        if($venta[0]["fecha"]==""){
            $venta[0]["fecha"]=date("Y-m-d H:i:s");
        }
        else{
            $fechax= $venta[0]['fecha'];
            $venta[0]['fecha']=implode("-",array_reverse(explode("-",$fechax)));
        }
        if($venta[0]["formapago"]!="mixto"){
            $venta[0]["pagomixto"]=null;
        }
        
        $resventa=Venta::insert($venta);
        $lapreventa=Tiendapreventa::findOrFail($idprev);
        $lapreventa->estado="vendido";
        $lapreventa->save();
        $hoy=date("Y-m-d H:i:s");
        $usuario=session("usr");
        $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"venta","query"=>json_encode($venta),"ventaEncCaja"];
        Bitacora::create($bitacora);
        foreach ($detalle as $undet) {
            $undet["idventa"]=$idventa;
            Detalleventa::insert($undet);
            $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"detalleventa","query"=>json_encode($undet),"obs"=>"cuantos"];
            Bitacora::create($bitacora);
            try {
                //code...
                $unprod=Inventario::findOrFail($undet["idprod"]);
                $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"detalleventa","query"=>json_encode($unprod),"obs"=>"antes"];
                Bitacora::create($bitacora);
                $unprod->cantidad=$unprod->cantidad - $undet["cuantos"];
                $unprod->save();
                
                $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"detalleventa","query"=>json_encode($unprod),"obs"=>"despues"];
                Bitacora::create($bitacora);
            } catch (\Throwable $th) {
                //throw $th;
            }
            
           
        }
       
        // return $venta;
        return json_encode("registrado");
    }
    // public function storecajachica(Request $request)
    // {
    //     $caja=$request->input();
    //     // $datos=$caja[0]["datos"];
    //     // unset($venta[0]["detalleventa"]);
    //     // $idventa=uniqid();
    //     // $venta[0]["idventa"]=$idventa;
    //     // $venta[0]["fecha"]=date("Y-m-d H:i:s");
    //     // Venta::insert($venta);
    //     // foreach ($detalle as $undet) {
    //     //     $undet["idventa"]=$idventa;
    //     //     Detalleventa::insert($undet);
    //     //     $unprod=Inventario::findOrFail($undet["idprod"]);
    //     //     $unprod->cantidad=$unprod->cantidad - $undet["cuantos"];
    //     //     $unprod->save();
    //     // }
    //    $datos=$caja["datos"];
    //    foreach ($datos as $undato) {
    //        return json_encode($undato["concepto"]);
    //    }
    //     // return ($caja["datos"][0]);
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $venta)
    {
        $unaventa=DB::select("select tb1.* ,nombre from (select * from ventas where idventa='$venta->idventa') as tb1 inner join vendedores on tb1.vendedor=vendedores.id");
        $detalle=Detalleventa::where("idventa",$venta->idventa)->get();
        $depositos=Deposito::all();
        $vendedores=Vendedore::all();
        return view("ventas.edit")->with("unaventa",$unaventa)->with("detalle",$detalle)->with("depositos",$depositos)->with("vendedores",$vendedores);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        //
    }
    public function detallev(Request $request){
        $vendedores=Vendedore::where("estado","activo")->get();
        if(session("usr")->rol!="Enc. Tienda y caja"){
            $fecha=$request->fecha;
            if($fecha==""){
                $fecha=date("Y-m-d");
            }
            // $detalle=DB::select("select tb3.*,inventarios.proveedor,inventarios.idprod from (select detalleventas.id,detalleventas.idprod,detalleventas.preciolocal,detalleventas.precioventa,detalleventas.preciofinal,detalleventas.cuantos,detalleventas.descripcion,detalleventas.cierre,tb2.idneg,tb2.cliente,tb2.telefono,tb2.formapago,tb2.fecha,tb2.nombre,tb2.idventa,tb2.total,tb2.pago,tb2.saldo,tb2.pagomixto  from (select tb1.*,vendedores.nombre from (select idventa,idneg,cliente,telefono,formapago,fecha,vendedor,total,pago,saldo,pagomixto from ventas  where fecha like '$fecha%') as tb1 left join vendedores on tb1.vendedor=vendedores.id) as tb2 inner join detalleventas on tb2.idventa=detalleventas.idventa) as tb3 inner join inventarios on tb3.idprod=inventarios.id order by fecha desc");
            $detalle=DB::select("select tb3.*,inventarios.proveedor,inventarios.idprod from (select detalleventas.id,detalleventas.idprod,detalleventas.preciolocal,detalleventas.precioventa,detalleventas.preciofinal,detalleventas.cuantos,detalleventas.descripcion,detalleventas.cierre,tb2.idneg,tb2.cliente,tb2.telefono,tb2.formapago,tb2.fecha,tb2.nombre,tb2.idventa,tb2.total,tb2.pago,tb2.saldo,tb2.pagomixto  from (select tb1.*,vendedores.nombre from (select idventa,idneg,cliente,telefono,formapago,fecha,vendedor,total,pago,saldo,pagomixto from ventas  where fecha like '$fecha%') as tb1 left join vendedores on tb1.vendedor=vendedores.id) as tb2 inner join detalleventas on tb2.idventa=detalleventas.idventa) as tb3 left join inventarios on tb3.idprod=inventarios.id order by fecha desc");

            return view("ventas.ventasdetallado")->with("detalle",$detalle)->with("fecha",$fecha)->with("vendedores",$vendedores);
    
        }
        else{
            $fecha=$request->fecha;
            $idneg=session("usr")->ciudad;
            $idusr=session("usr")->id;
            if($fecha==""){
                $fecha=date("Y-m-d");
            }
            // $detalle=DB::select("select detalleventas.id,descripcion,cuantos,precioventa,cierre,fecha,cliente,preciofinal,idneg,formapago,idusr from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa where idneg='$idneg' and idusr='$idusr' and fecha like '$fecha%' order by fecha desc");
            $detalle=DB::select("select tb3.*,inventarios.proveedor from (select detalleventas.idprod,detalleventas.preciolocal,detalleventas.precioventa,detalleventas.preciofinal,detalleventas.cuantos,detalleventas.descripcion,detalleventas.cierre,tb2.idneg,tb2.cliente,tb2.telefono,tb2.formapago,tb2.fecha,tb2.nombre,tb2.idventa,tb2.total,tb2.pago,tb2.saldo,pagomixto from (select tb1.*,vendedores.nombre from (select idventa,idneg,cliente,telefono,formapago,fecha,vendedor,total,pago,saldo,pagomixto from ventas  where idneg='$idneg' and idusr='$idusr' and fecha like '$fecha%') as tb1 left join vendedores on tb1.vendedor=vendedores.id) as tb2 inner join detalleventas on tb2.idventa=detalleventas.idventa) as tb3 inner join inventarios on tb3.idprod=inventarios.id order by fecha desc");
            // return $detalle;
            return view("ventas.ventasdetallado")->with("detalle",$detalle)->with("fecha",$fecha)->with("vendedores",$vendedores);
        }
       
    }
    // public function detallev(Request $request){
    //     if(session("usr")->rol!="Enc. Tienda y caja"){
    //         $fecha=$request->fecha;
    //         if($fecha==""){
    //             $fecha=date("Y-m-d");
    //              $detalle=DB::select("select detalleventas.id,descripcion,cuantos,precioventa,cierre,fecha,cliente,preciofinal,idneg,formapago from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa where fecha like '$fecha%' order by fecha desc");
    //             return view("ventas.ventasdetallado")->with("detalle",$detalle)->with("fecha",$fecha);
    //         }
    //         else{
    //             $detalle=DB::select("select detalleventas.id,descripcion,cuantos,precioventa,cierre,fecha,cliente,preciofinal,idneg,formapago from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa  where fecha like '$fecha%' order by fecha desc");
    //             return view("ventas.ventasdetallado")->with("detalle",$detalle)->with("fecha",$fecha);
    //         }
    
    //     }
    //     else{
    //         $fecha=$request->fecha;
    //         $idneg=session("usr")->ciudad;
    //         $idusr=session("usr")->id;
    //         if($fecha==""){
    //             $fecha=date("Y-m-d");
    //              $detalle=DB::select("select detalleventas.id,descripcion,cuantos,precioventa,cierre,fecha,cliente,preciofinal,idneg,formapago,idusr from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa where idneg='$idneg' and idusr='$idusr' and fecha like '$fecha%' order by fecha desc");
    //             return view("ventas.ventasdetallado")->with("detalle",$detalle)->with("fecha",$fecha);
    //         }
    //         else{
    //             $detalle=DB::select("select detalleventas.id,descripcion,cuantos,precioventa,cierre,fecha,cliente,preciofinal,idneg,formapago,idusr from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa  where idneg='$idneg' and idusr='$idusr' and fecha like '$fecha%' order by fecha desc");
    //             return view("ventas.ventasdetallado")->with("detalle",$detalle)->with("fecha",$fecha);
    //         }
    //     }
       
    // }
    public function detalleunaventa(Request $request){
        return $request;
    }
    public function paracerrarcaja(){
        if(session("usr")->rol!="Enc. Tienda y caja"){
            $detalle=DB::select("select detalleventas.id,descripcion,cuantos,precioventa,cierre,fecha,preciofinal,idneg from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa where cierre is null order by fecha desc");
            return view("ventas.cerrarcaja")->with("detalle",$detalle);
        }
        else{
            $idneg=session("usr")->ciudad;
            $idusr=session("usr")->id;
            $detalle=DB::select("select detalleventas.id,descripcion,cuantos,precioventa,cierre,fecha,preciofinal,idneg,idusr from detalleventas inner join ventas on detalleventas.idventa=ventas.idventa where idneg='$idneg' and idusr='$idusr' and cierre is null order by fecha desc");
            return view("ventas.cerrarcaja")->with("detalle",$detalle);
        }
       
    }
    public function guardacierredecaja(Request $request){
        $idusr=session("usr")->id;
        $ids=json_decode($request->ids);
        $obs=$request->obs;
        $hoy=date("Y-m-d H:i:s");
        for($k=0;$k<count($ids);$k++){
            $upd=DB::update("update detalleventas set cierre='$hoy' where id='".$ids[$k]."'");
        } 
        $cierre=["total"=>$request->totalx,"observacion"=>$request->obs,"fecha"=>$hoy,"deposito"=>session("usr")->ciudad,"idusr"=>$idusr];
        Cierre::insert($cierre);
        // return $this->detallev({});
        return \Redirect::route('cierres');
    }
    public function ventasdetalladovendedor(Request $request){
        $carnet=$request->elcarnet;
        $vendedor=Vendedore::where("carnet",$carnet)->get();
        if(count($vendedor)>0){
            $idvendedor=$vendedor[0]->id;
            $nomvendedor=$vendedor[0]->nombre;
            $fecha=$request->fecha;
            if($fecha==""){
                $fecha=date("Y-m-d");
            }
            // $detalle=DB::select("select tb3.*,inventarios.comision from (select detalleventas.idprod,detalleventas.preciolocal,detalleventas.precioventa,detalleventas.preciofinal,detalleventas.cuantos,detalleventas.descripcion,detalleventas.cierre,detalleventas.comision as comisfinal,tb2.idneg,tb2.cliente,tb2.telefono,tb2.formapago,tb2.fecha,tb2.nombre from (select tb1.*,vendedores.nombre from (select idventa,idneg,cliente,telefono,formapago,fecha,vendedor from ventas  where vendedor='$idvendedor' and fecha like '$fecha%') as tb1 inner join vendedores on tb1.vendedor=vendedores.id) as tb2 inner join detalleventas on tb2.idventa=detalleventas.idventa) as tb3 inner join inventarios on tb3.idprod=inventarios.id order by fecha desc");
            $detalle=DB::select("select tb3.*,inventarios.comision from (select detalleventas.idprod,detalleventas.preciolocal,detalleventas.precioventa,detalleventas.preciofinal,detalleventas.cuantos,detalleventas.descripcion,detalleventas.cierre,detalleventas.comision as comisfinal,detalleventas.pagocomision,tb2.idneg,tb2.cliente,tb2.telefono,tb2.formapago,tb2.fecha,tb2.nombre from (select tb1.*,vendedores.nombre from (select idventa,idneg,cliente,telefono,formapago,fecha,vendedor from ventas  where vendedor='$idvendedor') as tb1 inner join vendedores on tb1.vendedor=vendedores.id) as tb2 inner join detalleventas on tb2.idventa=detalleventas.idventa) as tb3 inner join inventarios on tb3.idprod=inventarios.id order by fecha desc");

            return view("ventas.ventasdetalladovendedor")->with("detalle",$detalle)->with("fecha",$fecha)->with("nomvendedor",$nomvendedor)->with("carnet",$carnet);

        }
        else{
            return "Carnet no valido";
        }
    }
    public function ventassinvendedor(Request $request){
        $carnet=$request->carnet;
        $nomvendedor=$request->nomvendedor;
        $lista=DB::select("select tb3.*,descripcion,precioventa,preciofinal,cuantos,comision from (select tb2.*,depositos.nombre as deposito from (select ventas.idventa,ventas.idneg,cliente,telefono,fecha,tb1.* from ventas inner join (SELECT id as idv,nombre FROM `vendedores` where nombre='PENDIENTE DE VENTA' or rol='Enc. Tienda y caja' and estado='activo') as tb1 on ventas.vendedor=tb1.idv) as tb2 inner join depositos on tb2.idneg=depositos.id) as tb3 inner join detalleventas on tb3.idventa=detalleventas.idventa where comision>0 order by fecha desc,idventa");
        return view("ventas.ventassinvendedor")->with("lista",$lista)->with("nomvendedor",$nomvendedor)->with("carnet",$carnet);
    }
    public function actualizaventa(Request $request)
    {
        $venta=$request->input();
        $idventa=$venta[0]["idventa"];
        $registro=Venta::where("idventa",$idventa)->get();
        $registro[0]->idneg=$venta[0]["idneg"];
        $registro[0]->vendedor=$venta[0]["vendedor"];
        $registro[0]->cliente=$venta[0]["cliente"];
        $registro[0]->telefono=$venta[0]["telefono"];
        $registro[0]->nit=$venta[0]["nit"];
        $registro[0]->formapago=$venta[0]["formapago"];
        $registro[0]->cliente=$venta[0]["cliente"];
        $registro[0]->comentario=$venta[0]["comentario"];
        $registro[0]->total=$venta[0]["total"];
        $registro[0]->pago=$venta[0]["pago"];
        $registro[0]->saldo=$venta[0]["saldo"];
        if($venta[0]["formapago"]=="mixto"){
            $registro[0]->pagomixto=$venta[0]["pagomixto"];
        }
        else{
            $registro[0]->pagomixto=null;
        }
        // return $registro;
        $registro[0]->save();

        $detalle=$venta[0]["detalle"];
        foreach ($detalle as $undet) {
            $undetalleantiguo=Detalleventa::findOrFail($undet["id_det"]);
            $prodinventario=Inventario::findOrFail($undetalleantiguo->idprod);
            $difcant=$undet["cuantos"] - $undetalleantiguo["cuantos"];
            if($difcant!=0){
                    $prodinventario->cantidad=$prodinventario->cantidad - $difcant;
                    $prodinventario->save();
            }
            $undetalleantiguo->preciofinal=$undet["preciofinal"];
            $undetalleantiguo->comision=$undet["comision"];
            $undetalleantiguo->cuantos=$undet["cuantos"];
            $undetalleantiguo->vendedor=$venta[0]["vendedor"];
            $undetalleantiguo->save();
        }
       
        return json_encode("registrado");
    }
    public function eliminaventa(Request $request){
        $hoy=date("Y-m-d H:i:s");
        $usuario=session("usr");
        $idventa=$request->id_vtaelim;
        $detalle=Detalleventa::where("idventa",$idventa)->get();
        foreach ($detalle as $undet) {
            $idprod=$undet->idprod;
            $cantidad=$undet->cuantos;
            $elprod=Inventario::findOrFail($idprod);
            $elprod->cantidad=$elprod->cantidad + $cantidad;
            $elprod->save();
            $undet->delete();
        }
        Venta::where("idventa",$idventa)->delete();
        return $this->index();

    }
    public function exportarventas(){
        $hoy=date("d-m-Y H:i:s");
        return Excel::download(new VentasExport(),"VentasHasta_".$hoy.".xlsx");
    }
    public function exportarporfechas(Request $request){
        $fechaini=$request->fechaini;
        $fechafin=$request->fechafin;
        return Excel::download(new VentasRangofechas($fechaini,$fechafin),"VentasRango_".$fechaini."_".$fechafin.".xlsx");
    }
    public function verkardex(Request $request){
        // return $request;
        $idcli=$request->idcli;
        $cliente=Cliente::where("id",$idcli)->get();
        $nombrecli=$cliente[0]->nombre;
        // $cobros=DB::select("select id,monto,formapago,fechareg,comentario,monto,monto,idusr from cobros where idcliente='$idcli'")->toArray();
        $cobros=DB::table(DB::raw('(SELECT *,id as idcobro,concat("C-",comentario) as comentariox FROM `cobros` where idcliente='.$idcli.') as tb1'))
        ->select('idcobro','monto','formapago','fechareg','comentariox','monto','monto','nombre')
        ->join('vendedores','tb1.idusr','=','vendedores.id');
        $ventas=DB::table(DB::raw('(SELECT * FROM `ventas` where idcliente='.$idcli.') as tb1'))
        ->select('idventa','total','formapago','fecha','comentario','pago','saldo','nombre')
        ->join('vendedores','tb1.idusr','=','vendedores.id')
        ->union($cobros)
        ->orderBy("fecha",'asc')
        ->get();
        return view("ventas.verkardex")->with("ventas",$ventas)->with("nombrecli",$nombrecli)->with("idcli",$idcli);
    }
    public function historialqueries(Request $request){
        $mesano=explode(" ",$request->mesano);
        $mes=$mesano[0];
        $ano=$mesano[1];
        $meses=["Enero"=>1,"Febrero"=>2,"Marzo"=>3,"Abril"=>4,"Mayo"=>5,"Junio"=>6,"Julio"=>7,"Agosto"=>8,"Septiembre"=>9,"Octubre"=>10,"Noviembre"=>11,"Diciembre"=>12];
        $lista=Bitacora::whereMonth("fecha",$meses[$mes])->whereYear("fecha",$ano)->orderBy("fecha","desc")->get();
            return view("ventas.historialqueries")->with("lista",$lista)->with("mesanox",$mes." ".$ano);
    }
    public function indexhistorialqueries()
    {
        // $meses=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        $meses=["Enero"=>1,"Febrero"=>2,"Marzo"=>3,"Abril"=>4,"Mayo"=>5,"Junio"=>6,"Julio"=>7,"Agosto"=>8,"Septiembre"=>9,"Octubre"=>10,"Noviembre"=>11,"Diciembre"=>12];
        $mes=(int)date("m");
        $ano=date("Y");
        $lista=Bitacora::whereMonth("fecha",$mes)->whereYear("fecha",$ano)->orderBy("fecha","desc")->get();
        return view("ventas.historialqueries")->with("lista",$lista)->with("mesanox",$mes." ".$ano);
    }

    public function listapreventas(Request $request){

    }

}
