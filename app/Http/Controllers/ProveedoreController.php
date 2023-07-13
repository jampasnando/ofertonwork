<?php

namespace App\Http\Controllers;

use App\Models\Proveedore;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProveedoresExport;
class ProveedoreController extends Controller
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
        $lista=Proveedore::paginate(100);
        return view("proveedores.index")->with("lista",$lista);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("proveedores.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validar=$this->validate($request,[
            "nombre"=>"required|string",
            
        ]);
        Proveedore::create($request->all());
        return back()->with("guardado","Proveedor guardado!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proveedore  $proveedore
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedore $proveedore)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proveedore  $proveedore
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $unprov=Proveedore::findOrFail($id);
        return view("proveedores.edit")->with("unprov",$unprov);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proveedore  $proveedore
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $datos=request()->except(["_token","_method"]);
        Proveedore::where("id","=",$id)->update($datos);
        return back()->with("provmodificado","Proveedor Modificado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proveedore  $proveedore
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Proveedore::destroy($id);
        return back()->with("proveliminado","Proveedor Eliminado");
    }
    public function exportarproveedores(){
        $hoy=date("d-m-Y H:i:s");
        return Excel::download(new ProveedoresExport(),"Proveedores_".$hoy.".xlsx");
    }
}
