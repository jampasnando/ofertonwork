<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Deposito;
use App\Models\Proveedore;
use App\Models\Detallecompra;
use App\Models\Inventario;
use App\Models\Pago;
use DB;


use Illuminate\Http\Request;

class CompraController extends Controller
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
        return view("compras.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depositos=Deposito::all();
        $proveedores=Proveedore::orderBy("nombre")->get();
        return view("compras.create")->with("depositos",$depositos)->with("proveedores",$proveedores);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // return $request;
        $hoy=date("Y-m-d H:i:s");
        $compra=$request->input();
        $detalle=$compra[0]["detalle"];
        unset($compra[0]["detalle"]);
        $credito=$compra[0]["credito"];
        unset($compra[0]["credito"]);
        $idcompra=uniqid();
        $compra[0]["idcompra"]=$idcompra;
        $compra[0]["fecha"]=$hoy;
        $compra[0]["comprador"]=$compra[0]["idusr"];
        $proveedor=$compra[0]["proveedor"];
        Compra::insert($compra);
        foreach ($detalle as $undet) {
           
            $unprod=Inventario::findOrFail($undet["idprod"]);
            $unprod->cantidad=$unprod->cantidad + $undet["cuantos"];
            $unprod->preciolocal=$undet["preciolocal"];
            $unprod->precioventa=$undet["precioventa"];
            $unprod->comision=$undet["comision"];
            $unprod->save();
            unset($undet["precioventa"]);
            unset($undet["comision"]);
            $undet["idcompra"]=$idcompra;
            $undet["registrado"]=$hoy;
            Detallecompra::insert($undet);
        }
        if($credito!=""){
            $credito["proveedor"]=$proveedor;
            $credito["fecha"]=$hoy;
            Pago::insert($credito);
        }
        return $compra;    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show(Compra $compra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Compra $compra)
    {
        //
    }
    public function detalleunacompra(Request $request){
        $compra=Compra::find($request->id);
        $detalle=Detallecompra::where("idcompra",$request->idcompra)->get();
        $pagos=Pago::where("idcompra",$request->idcompra)->get();
        return view("compras.detalleunacompra")->with("compra",$compra)->with("detalle",$detalle)->with("pagos",$pagos);  
    }
    public function registrapago(Request $request){
        $unpago=$request->except(["_token","_method"]);
        $unpago["fecha"]=date("Y-m-d H:i:s");
        unset($unpago["id"]);
        Pago::insert($unpago);
        $idcompra=$unpago["idcompra"];

        return $this->detalleunacompra($request);

    }
    public function indexcreditos(){
        // $lista=DB::select("select tb1.*,pagado,ultfecha,dias from (select proveedor,round(sum(total),2) as acumulado from compras where formapago='credito' group by proveedor) as tb1 left join (select proveedor,round(sum(monto),2) as pagado,max(fecha) as ultfecha, datediff(now(),max(pagos.fecha)) as dias from pagos group by proveedor) as tb2 on tb1.proveedor=tb2.proveedor");
        $lista=DB::select("select proveedor,round(sum(total),2) as total,round(sum(pagado),2) as pagado,max(ultfecha) as ultfecha,min(dias) as dias from (select proveedor,total,pagado,ultfecha,dias from (select * from compras where formapago='credito') as tb1 left join (select idcompra,round(sum(monto),2) as pagado,max(fecha) as ultfecha, datediff(now(),max(pagos.fecha)) as dias from pagos group by idcompra) as tb2 on tb1.idcompra=tb2.idcompra) as tb3 group by proveedor");
        return view("compras.indexcreditos")->with("lista",$lista);
    }
    public function comprasdetdeudas(Request $request){
        $prov=$request->proveedor;
        $datosprov=DB::select("select tb1.*,pagado,ultfecha,dias from (select proveedor,round(sum(total),2) as acumulado from compras where formapago='credito' and proveedor='$prov' group by proveedor) as tb1 left join (select proveedor,round(sum(monto),2) as pagado,max(fecha) as ultfecha, datediff(now(),max(pagos.fecha)) as dias from pagos where proveedor='$prov' group by proveedor) as tb2 on tb1.proveedor=tb2.proveedor");
        $lista=DB::select("select * from( SELECT id,total as monto,formapago as tipopago,fecha,comentario as observacion,datediff(now(),fecha) as dias, 'deuda',proveedor FROM `compras` where proveedor='$prov' and formapago='credito' UNION SELECT id,monto,tipopago,fecha,observacion,datediff(now(),fecha) as dias,'pago',proveedor FROM `pagos` where proveedor='$prov' ) as tb1 order by fecha desc");
        return view("compras.detalledeudaunprov")->with("datosprov",$datosprov)->with("lista",$lista);
    }
    
}
