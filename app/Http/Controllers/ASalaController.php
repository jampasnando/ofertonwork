<?php

namespace App\Http\Controllers;

use App\Models\A_sala;
use Illuminate\Http\Request;
use App\Exports\ASalaExport;
use Maatwebsite\Excel\Facades\Excel;
class ASalaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $salas=A_sala::paginate(10);

        return view("salas.index")->with("salas",$salas);
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
     * @param  \App\Models\A_sala  $a_sala
     * @return \Illuminate\Http\Response
     */
    public function show(A_sala $a_sala)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\A_sala  $a_sala
     * @return \Illuminate\Http\Response
     */
    public function edit(A_sala $a_sala)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\A_sala  $a_sala
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, A_sala $a_sala)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\A_sala  $a_sala
     * @return \Illuminate\Http\Response
     */
    public function destroy(A_sala $a_sala)
    {
        //
    }
    public function exportar(){
        return Excel::download(new ASalaExport, 'listaSalas.xlsx');
    }
}
