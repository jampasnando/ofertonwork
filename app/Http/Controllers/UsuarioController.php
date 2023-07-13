<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Deposito;
use App\Models\Vendedore;
use App\Models\Marca;
use Session;
class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Session::forget("usr");
        return view("usuarios.formuingreso");
    }
    public function validausr(Request $request){
        // return $request;

        $login=$request->login;
        $pass=$request->password;
        $usr=Vendedore::where("email",$login)->where("password",$pass)->where("estado","activo")->get();
        $depositos=Deposito::all();
        // return $usr;
        if(count($usr)>0){
            if($usr[0]->rol=="Vendedores"){
                $depositos=Deposito::where("id","<>","5")->where("id","<>","6")->get();
                session(["usr"=>$usr[0]]);
                return view("ventas.solosaldos")->with("depositos",$depositos)->with("usr",$usr[0])->with("nomvendedor","")->with("carnet","");
            }
            else{
                if($usr[0]->rol=="Administradores"){
                    // return view("ventas.solovendedor")->with("dep",$usr[0]->ciudad);
                    session(["usr"=>$usr[0]]);
                    return view("welcome");
                    
                }
                else{
                    if($usr[0]->rol=="Enc. Tienda y caja"){
                        session(["usr"=>$usr[0]]);
                        return view("ventas.createventavendedor")->with("depositos",$depositos);
                    }
                    else{
                        if($usr[0]->rol=="editor"){

                            session(["usr"=>$usr[0]]);
                            $marcas=Marca::orderBy("nombre")->get();
                            return view("inventario.imagenes")->with("marcas",$marcas);
                        }
                    }
                }
            }
            // if($usr[0]->email=="saldos@ferreteria.com"){
            //     return view("ventas.solosaldos")->with("depositos",$depositos)->with("usr",$usr[0]);
            // }
            // else{
            //     if($usr[0]->ciudad!="100"){
            //         // return view("ventas.solovendedor")->with("dep",$usr[0]->ciudad);
            //         session(["usr"=>$usr[0]]);
            //         return view("ventas.createventavendedor")->with("depositos",$depositos);
            //     }
            //     else{
            //         session(["usr"=>$usr[0]]);
            //         return view("welcome");
            //     }
            // }
        }
        else{
            return "No encontrado vuelva atrás";
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
