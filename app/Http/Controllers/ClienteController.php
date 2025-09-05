<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use DB;
use Illuminate\Http\Request;
use DataTables;
use App\Exports\ClientesExport;
use Maatwebsite\Excel\Facades\Excel;
class ClienteController extends Controller
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
        return view("clientes.index");
    }
    public function cargaclientes()
    {
        // $lista=DB::table("clientes")->orderBy("nombre");
        // $lista=DB::table('clientes')
        // ->select('clientes.*',DB::raw('count(clientes.id) as cant'))
        // ->leftJoin('ventas','clientes.id','=','ventas.idcliente')
        // ->groupBy(['clientes.id','clientes.nombre','clientes.telefono','clientes.nit','clientes.direccion']);
        // $lista=DB::select("select clientes.*,count(*) as cant from clientes left join ventas on clientes.id=ventas.idcliente group by clientes.id,clientes.nombre,clientes.telefono,clientes.nit,clientes.direccion,clientes.rubro");
        $lista=DB::select("select clientes.*,sum(if(ventas.id is null,0,1)) as cant from clientes left join ventas on clientes.id=ventas.idcliente group by clientes.id,clientes.nombre,clientes.telefono,clientes.nit,clientes.direccion,clientes.rubro order by cant desc");
        // return DataTables::queryBuilder($lista)
        return DataTables::of($lista)
        ->addColumn("action",function($uncli){
            $idcli=$uncli->id;
            $botones='<button onclick="verkardex(this,'.$idcli.')" class="btn btn-info btn-sm">Kardex</button>&nbsp;<button onclick="editar(this,'.$idcli.')" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalnuevoreg">Editar</button>&nbsp;<button onclick="eliminar('.$idcli.')" class="btn btn-danger btn-sm">Borrar</button>'; 
            return $botones;
        })->make(true);
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
        $recibido=$request->input();
        // $nuevoreg=json_decode($recibido[0],true);
        $hoy=date("Y-m-d H:i:s");
        $recibido[0]["fechareg"]=$hoy;
        Cliente::insert($recibido[0]);
        return json_encode("registrado");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return request();
        $datos=request()->except(["_token","_method"]);
        // return $datos;
        Cliente::where("id",$id)->update($datos);
        return back()->with("avisito","MODIFICACIÓN REGISTRADA");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */ 
    public function destroy($id)
    {
        Cliente::destroy($id);
        return back()->with("avisito","Cliente Eliminado");
    }
    public function buscacliente(Request $request){
        $datos=$request->input();
        $texto=$datos[0]["texto"];
        $listaclis=DB::select("select * from clientes where nombre like '$texto%' or nit like '$texto%' or telefono like '$texto%' order by nombre");
        return $listaclis;
    }
    public function guardanuevocliente2(Request $request){
        $nuevocli=$request->input();
        Cliente::insert($nuevocli);
        $nuevito=Cliente::orderBy('id', 'desc')->first();
        return $nuevito;
    }
    public function exportarclientes(){
        $hoy=date("d-m-Y H:i:s");
        return Excel::download(new ClientesExport(),"Clientes_".$hoy.".xlsx");
    }
}
