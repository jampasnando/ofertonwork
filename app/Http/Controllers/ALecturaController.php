<?php

namespace App\Http\Controllers;

use App\Models\A_lectura;
use Illuminate\Http\Request;
use App\Exports\ALecturaExport;
use Maatwebsite\Excel\Facades\Excel;
class ALecturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $lecturas=A_lectura::paginate(100);
        return view("lecturas.index")->with("lecturas",$lecturas);
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
     * @param  \App\Models\A_lectura  $a_lectura
     * @return \Illuminate\Http\Response
     */
    public function show(A_lectura $a_lectura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\A_lectura  $a_lectura
     * @return \Illuminate\Http\Response
     */
    public function edit(A_lectura $a_lectura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\A_lectura  $a_lectura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, A_lectura $a_lectura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\A_lectura  $a_lectura
     * @return \Illuminate\Http\Response
     */
    public function destroy(A_lectura $a_lectura)
    {
        //
    }
    public function exportar(){
        return Excel::download(new ALecturaExport,"lecturas.xlsx");
    }
}
