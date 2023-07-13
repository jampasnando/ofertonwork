<?php

namespace App\Http\Controllers;

use App\Models\Vendedore;
use App\Models\Deposito;
use App\Exports\UsuariosExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VendedoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista=Vendedore::paginate(100);
        return view("vendedores.index")->with("lista",$lista);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depositos=Deposito::all();
        return view("vendedores.create")->with("depositos",$depositos);
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
        $validar=$this->validate($request,[
            "nombre"=>"required|string",
            
        ]);
        Vendedore::create($request->all());
        return back()->with("guardado","Vendedor guardado!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendedore  $vendedore
     * @return \Illuminate\Http\Response
     */
    public function show(Vendedore $vendedore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendedore  $vendedore
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unvendedor=Vendedore::findOrFail($id);
        $depositos=Deposito::all();
        return view("vendedores.edit")->with("unvendedor",$unvendedor)->with("depositos",$depositos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendedore  $vendedore
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware("micheck");
    }
    public function update(Request $request, $id)
    {
        $datos=request()->except(["_token","_method"]);
        Vendedore::where("id","=",$id)->update($datos);
        return back()->with("vendedormodificado","Vendedor Modificado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendedore  $vendedore
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Vendedore::destroy($id);
        return back()->with("vendedoreliminado","Vendedor Eliminado");
    }
    public function exportarusuarios(){
        $hoy=date("d-m-Y H:i:s");
        return Excel::download(new UsuariosExport(),"Usuarios_".$hoy.".xlsx");
    }
}
