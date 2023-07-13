<?php

namespace App\Http\Controllers;

use App\Models\Hist_traspaso;
use Illuminate\Http\Request;

class HistTraspasoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista=Hist_traspaso::orderBy("fecha","desc")->get();
        return view("inventario.hist_traspasos")->with("lista",$lista);
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
     * @param  \App\Models\Hist_traspaso  $hist_traspaso
     * @return \Illuminate\Http\Response
     */
    public function show(Hist_traspaso $hist_traspaso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hist_traspaso  $hist_traspaso
     * @return \Illuminate\Http\Response
     */
    public function edit(Hist_traspaso $hist_traspaso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hist_traspaso  $hist_traspaso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hist_traspaso $hist_traspaso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hist_traspaso  $hist_traspaso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hist_traspaso $hist_traspaso)
    {
        //
    }
}
