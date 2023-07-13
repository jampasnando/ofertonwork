<?php

namespace App\Http\Controllers;

use App\Models\A_categoria;
use Illuminate\Http\Request;
use App\Exports\ACategoriaExport;
use Maatwebsite\Excel\Facades\Excel;
class ACategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cats=A_categoria::paginate(10);
        return view("categorias.index")->with("cats",$cats);
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
     * @param  \App\Models\A_categoria  $a_categoria
     * @return \Illuminate\Http\Response
     */
    public function show(A_categoria $a_categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\A_categoria  $a_categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(A_categoria $a_categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\A_categoria  $a_categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, A_categoria $a_categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\A_categoria  $a_categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(A_categoria $a_categoria)
    {
        //
    }
    public function exportar(){
        return Excel::download(new ACategoriaExport,"listaCategorias.xlsx");
    }
}
