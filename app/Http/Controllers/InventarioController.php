<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Deposito;
use App\Models\Proveedore;
use App\Models\Marca;
use App\Models\Bitacora;
use App\Models\Hist_traspaso;
use DB;
use Illuminate\Http\Request;
use App\Imports\InventarioImport;
use App\Imports\ActualizaInvImport;
use App\Exports\InventarioExport;
use Maatwebsite\Excel\Facades\Excel;

class InventarioController extends Controller
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
        $depositos=Deposito::all();
            return view("inventario.index")->with("depositos",$depositos);
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
        $marcas=Marca::orderBy("nombre")->get();
        return view("inventario.create")->with("depositos",$depositos)->with("proveedores",$proveedores)->with("marcas",$marcas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // public function store(Request $request)
    // {
    //     return $request;
    //     $validar=$this->validate($request,[
    //         "idprod"=>"required|max:30",
    //         "descripcion"=>"required"
    //     ]);
    //     Inventario::create($request->all());
    //     return back()->with("guardado","Producto guardado!");
    // }

    public function store(Request $request)
    {
        $hoy=date("Y-m-d H:i:s");
        $usuario=session("usr");
        $validar=$this->validate($request,[
            "idprod"=>"required|max:30",
            "descripcion"=>"required"
        ]);
        $depositos =$request->deposito;
        if ($depositos==""){
            return back()->with("guardado","ERROR ERROR ERROR ERRRO FALTA ELEGIR DEPOSITO!, NO SE GUARDÓ");
        }
        // return $depositos;
        $requestoriginal=$request;
        foreach ($depositos as $key => $undep) {
            $requestoriginal["deposito"]=$undep;
            Inventario::create($requestoriginal->all());
            $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"insertar","query"=>json_encode($requestoriginal->all()),""];
            Bitacora::create($bitacora);
        }
       
        
        return back()->with("guardado","Producto guardado!");
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show(Inventario $inventario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unprod=Inventario::findOrFail($id);
        $depositos=Deposito::all();
        return view("inventario.edit")->with("unprod",$unprod)->with("depositos",$depositos);
    }
    public function mover($id)
    {
        $unprod=Inventario::select("inventarios.*","depositos.nombre")->join("depositos","inventarios.deposito","=","depositos.id")->where("inventarios.id","=",$id)->get()[0];
        $depositos=Deposito::all();
        return view("inventario.mover")->with("unprod",$unprod)->with("depositos",$depositos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request;
        $hoy=date("Y-m-d H:i:s");
        $usuario=session("usr");
        $id=$request->id;
        $chktodos=$request->todos;
        $idprodoriginal=$request->idprodoriginal;
        
        // return $id." -- ".$chktodos." -- ".$idprod;
        if($chktodos){
            $datos=request()->except(["_token","_method","todos","deposito","idprodoriginal","cantidad"]);
            Inventario::where("idprod","=",$idprodoriginal)->update($datos);
            $obs="para idprod=".$idprodoriginal;
            $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"editar","query"=>json_encode($datos),"obs"=>$obs];
            Bitacora::create($bitacora);
            return back()->with("prodmodificado","Producto Modificado en TODOS LOS DEPÓSITOS");
        } 
        else {
            $datos=request()->except(["_token","_method","todos","idprodoriginal"]);
            Inventario::where("id","=",$id)->update($datos);
            $obs="para id=".$id;
            $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"editar","query"=>json_encode($datos),"obs"=>$obs];
            Bitacora::create($bitacora);
            return back()->with("prodmodificado","Producto Modificado");
        }
        
    }
    public function registramover(Request $request)
    {
        $usr=session("usr")->id;
        // return $usr;
        $datos=request()->except(["_token","_method"]);
        $produ=json_decode($datos["prodjason"],true);
        $buscaendestino=Inventario::where("idprod",$datos["idprod"])->where("deposito",$datos["depositodestino"])->get();
        if(count($buscaendestino)>0){
            $invaumentado=$buscaendestino[0]["cantidad"] + $datos["cantidad"];
            $invreducido=$produ["cantidad"] - $datos["cantidad"];
            Inventario::where(["deposito"=>$datos["depositodestino"],"idprod"=>$datos["idprod"]])->update(["cantidad"=>$invaumentado]);
            Inventario::where(["deposito"=>$produ["deposito"],"idprod"=>$produ["idprod"]])->update(["cantidad"=>$invreducido]);
        }
        else{
            $invreducido=$produ["cantidad"] - $datos["cantidad"];
            Inventario::where(["deposito"=>$produ["deposito"],"idprod"=>$produ["idprod"]])->update(["cantidad"=>$invreducido]);
            $produ["deposito"]=$datos["depositodestino"];
            $produ["cantidad"]=$datos["cantidad"];
            Inventario::create($produ);
           
        }
        $historico=$produ;
        $historico["depdestino"]=$datos["depositodestino"];
        $historico["traspasado"]=$datos["cantidad"];
        $historico["fecha"]=date("Y-m-d H:i:s");
        $historico["usuario"]=$usr;
        $historico["observaciones"]=$datos["comentario"];
        Hist_traspaso::create($historico);
        return redirect()->route('inventario.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hoy=date("Y-m-d H:i:s");
        $usuario=session("usr");
        Inventario::destroy($id);
        $bitacora=["fecha"=>$hoy,"usuario"=>$usuario,"motivo"=>"eliminar","query"=>$id,""];
        Bitacora::create($bitacora);
        return back()->with("prodeliminado","Producto Eliminado");
    }
    public function importar(){
        return view("inventario.formuimportar");
    }
    public function guardaimportarinv(Request $request){
        $arch=$request->file("arch");
        Inventario::truncate();
        Excel::import(new InventarioImport,$arch);
        return $this->index();
    }
    public function guardaimportarinvmas(Request $request){
        $arch=$request->file("arch");
        Excel::import(new InventarioImport,$arch);
        return $this->index();
    }
    public function plantillaexcel(){
        $arch= public_path(). "/misarchivos/importarinventario.xlsx";   

        return response()->download($arch);
    }
    public function plantillaActInv(){
        $arch= public_path(). "/misarchivos/plantillaActualizarInventario.xlsx";   

        return response()->download($arch);
    }
    public function exportarinv(){
        $hoy=date("d-m-Y H_i_s");
        $arch="inventario_".$hoy.".xlsx";
        return Excel::download(new InventarioExport,$arch);
    }
    public function guardaimportaractualizacion(Request $request){
        $arch=$request->file("arch");
        Excel::import(new ActualizaInvImport,$arch);
        return $this->index();
    }
    public function obtieneimagenesmarca(Request $request){
        $datos=$request->input();
        $marca=$datos[0]["idmarca"];
        $imagenes=DB::select("select distinct idprod,descripcion,imagenes from inventarios where marca='$marca'");
        return $imagenes;
    }
    public function subeimagen(Request $request){
        $idprod=$request->idprod;
        if($arch=$request->file("file")){
            $nomarch=md5(rand(1000,10000)).".".$arch->getClientOriginalExtension();
            $arch->move("images",$nomarch);
            Inventario::where("idprod",$idprod)->update(["imagenes"=>$nomarch]);
            return ["nombre"=>$nomarch];
        }
        else{
            return json_encode("nosube");
        }
    }
    public function imagenesadmin(){
        $marcas=Marca::orderBy("nombre")->get();
        return view("inventario.imagenes")->with("marcas",$marcas);
    }
    public function buscaprodkardex(Request $request){
        $datos=$request->input();
        $texto=$datos[0]["texto"];
        $listaprods=DB::select("select deposito,idprod,descripcion,id,cantidad from inventarios where idprod like '$texto%' or descripcion like '%$texto%' limit 20");
        return $listaprods;
    }
    public function kardexprod(){
        return view("inventario.kardexprod");
    }
    public function obtienekardexprod(Request $request){
        $datos=$request->input();
        $id=$datos[0]["id"];
        $historial=DB::select("select tb2.*,vendedores.email,date_format(tb2.fecha,'%d-%m-%Y %H:%m') as fechax from (select tb1.*,ventas.fecha,ventas.cliente,ventas.idusr from (SELECT id,idventa,'venta' as tipo,preciofinal,cuantos FROM detalleventas where idprod='$id') as tb1 inner join ventas on tb1.idventa=ventas.idventa) as tb2 left join vendedores on tb2.idusr=vendedores.id UNION select tb2.*,vendedores.email,date_format(registrado,'%d-%m-%Y %H:%m') as fechax from (select tb1.*,compras.proveedor,compras.idusr from (select id,idcompra,'compra' as tipo,preciolocal,cuantos,registrado from detallecompras where idprod='$id') as tb1 inner join compras on tb1.idcompra=compras.idcompra) as tb2 left join vendedores on tb2.idusr=vendedores.id ORDER BY fecha");
        return $historial;
    }
    public function inventario2(Request $request){
        $depositos=Deposito::all();
        $req=$request->input();
        if(count($req)>0){
            return $rep;
        }
        else{
            // $lista=inventario::select("inventarios.*","depositos.nombre")->join("depositos","inventarios.deposito","=","depositos.id")->get();
             return view("inventario.index2")->with("depositos",$depositos)->with("lista",[]);
        }
        // $depositos=Deposito::all();
        // $lista=inventario::select("inventarios.*","depositos.nombre")->join("depositos","inventarios.deposito","=","depositos.id")->get();
        // return view("inventario.index2")->with("depositos",$depositos)->with("lista",$lista);
        
    }
    public function moverenmasa(){
        $depositos=Deposito::all();
        return view("inventario.moverenmasa")->with("depositos",$depositos);
    }
    public function registramoverenmasa(Request $request)
    {
        $datos=$request->input();
        $usr=session("usr")->id;
        $origen=$datos[0]["origen"];
        $destino=$datos[0]["destino"];
        $comentario=$datos[0]["comentario"];
        $productos= $datos[0]["productos"];
        foreach ($productos as $unprod) {
            $buscaendestino=Inventario::where("idprod",$unprod["idprod"])->where("deposito",$destino)->get();
            $produorigen=Inventario::where(["deposito"=>$origen,"idprod"=>$unprod["idprod"]])->get();
            $historico=json_decode($produorigen[0],true);
            if(count($buscaendestino)>0){
                $invaumentado=$buscaendestino[0]["cantidad"]*1 + $unprod["mover"]*1;
                $invreducido=$produorigen[0]["cantidad"]*1 - $unprod["mover"]*1;
                Inventario::where(["deposito"=>$destino,"idprod"=>$unprod["idprod"]])->update(["cantidad"=>$invaumentado]);
                Inventario::where(["deposito"=>$origen,"idprod"=>$unprod["idprod"]])->update(["cantidad"=>$invreducido]);
            }
            else{
                $invreducido=$produorigen[0]["cantidad"]*1 - $unprod["mover"]*1;
                Inventario::where(["deposito"=>$origen,"idprod"=>$unprod["idprod"]])->update(["cantidad"=>$invreducido]);
                $produorigen[0]["deposito"]=$destino;
                $produorigen[0]["cantidad"]=$unprod["mover"];
                $nuevoregendestino=json_decode($produorigen[0],true);
                Inventario::create($nuevoregendestino);
                $historico["cantidad"]=0;
            }
            // $historico=json_decode($produorigen[0],true);
            $historico["depdestino"]=$destino;
            $historico["origen"]=$origen;
            $historico["traspasado"]=$unprod["mover"];
            $historico["fecha"]=date("Y-m-d H:i:s");
            $historico["usuario"]=$usr;
            if($comentario==""){$comentario="(sin comentario)";}
            $historico["observaciones"]=$comentario;
            Hist_traspaso::create($historico);
            
        }
        return json_encode("registrado");
        
    }

}
