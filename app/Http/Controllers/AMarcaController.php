<?php

namespace App\Http\Controllers;

use App\Models\A_marca;
use Illuminate\Http\Request;
use App\Exports\AMarcaExport;
use Maatwebsite\Excel\Facades\Excel;
class AMarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $marcas=A_marca::paginate(100);
        return view("marcas.index")->with("marcas",$marcas);
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
     * @param  \App\Models\A_marca  $a_marca
     * @return \Illuminate\Http\Response
     */
    public function show(A_marca $a_marca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\A_marca  $a_marca
     * @return \Illuminate\Http\Response
     */
    public function edit(A_marca $a_marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\A_marca  $a_marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, A_marca $a_marca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\A_marca  $a_marca
     * @return \Illuminate\Http\Response
     */
    public function destroy(A_marca $a_marca)
    {
        //
    }
    public function exportar(){
        return Excel::download(new AMarcaExport,"listaMarcas.xlsx");
    }
}
