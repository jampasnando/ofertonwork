<?php

namespace App\Http\Controllers;

use App\Models\A_lidere;
use Illuminate\Http\Request;
use App\Exports\ALidereExport;
use Maatwebsite\Excel\Facades\Excel;
class ALidereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $usuarios=A_lidere::paginate(100);
        return view("lideres.index")->with("usuarios",$usuarios);
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
     * @param  \App\Models\A_lidere  $a_lidere
     * @return \Illuminate\Http\Response
     */
    public function show(A_lidere $a_lidere)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\A_lidere  $a_lidere
     * @return \Illuminate\Http\Response
     */
    public function edit(A_lidere $a_lidere)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\A_lidere  $a_lidere
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, A_lidere $a_lidere)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\A_lidere  $a_lidere
     * @return \Illuminate\Http\Response
     */
    public function destroy(A_lidere $a_lidere)
    {
        //
    }
    public function exportar(){
        return Excel::download(new ALidereExport,"listaUsuarios.xlsx");
    }
}
