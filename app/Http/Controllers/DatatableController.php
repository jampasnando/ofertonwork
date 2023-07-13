<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventario;
use App\Models\Deposito;
use App\Models\Venta;
use App\Models\Compra;
use DB;
use DataTables;
class DatatableController extends Controller
{
    public function __construct(){
        $this->middleware("micheck");
    }
    public function inventarioz(Request $request){
        $posts=$request->input();
        $deposito=$posts["deposito"];
        // return json_encode(["dep"=>$deposito]);
        if($deposito!=null){
            $productos=inventario::select("inventarios.*","depositos.nombre")->leftjoin("depositos","inventarios.deposito","=","depositos.id")->where("depositos.nombre","=",$deposito)->get();
        }
        else{
            $productos=inventario::select("inventarios.*","depositos.nombre")->leftjoin("depositos","inventarios.deposito","=","depositos.id")->get();
        }
        // $productos=inventario::select("inventarios.*","depositos.nombre")->leftjoin("depositos","inventarios.deposito","=","depositos.id")->get();
        return DataTables::of($productos)
            ->addcolumn('actions',function($productos){
                $unprod=$productos->id;
                $paramfer="";
                $correo=session("usr")->email;
                if(strpos($correo,"inventarios.com")!==false){
                    return '<div style="display:flex"><a href="editaprod/'.$unprod.'" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                  </svg></a>&nbsp;&nbsp<button class="btn btn-danger" onclick="eliminaprod('.$unprod.')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                  <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg></button>&nbsp;&nbsp<a href="mover/'.$unprod.'" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>
                  </svg></a>'.$paramfer.'</div>';
                }
                else{
                    return '<div style="display:flex"><a href="#" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
              </svg></a>&nbsp;&nbsp<button class="btn btn-danger" onclick="eliminaprod('.$unprod.')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
              <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
            </svg></button>&nbsp;&nbsp<a href="mover/'.$unprod.'" class="btn btn-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z"/>
              </svg></a>'.$paramfer.'</div>';
                }
                
                
                    // return '<a href="{{route(\'editaprod\',$productos->id)}}" class="btn btn-secondary">Editar</a><form action="{{route(\'eliminaprod\',$unprod->id)}}" method="post">@csrf @method("DELETE") <button type="submit" class="btn btn-danger" onclick="return confirm(\'Está seguro de eliminar este producto?\')">Borrar</button></form>';
            })->rawColumns(['actions'])->toJson();
    }   

    public function ventasz(Request $request){
        $fecha=$request->get("fecha");
        // print_r($fecha);
        if($fecha!=""){
            $ventas=Venta::where("fecha","like",$fecha."%")->get();
        }
        else{
            $fecha=date("Y-m-d");
            $ventas=Venta::where("fecha","like",$fecha."%")->get();
        }
        return datatables()->of($ventas)
            ->addcolumn('actions',function($ventas){
                $idventa=$ventas->idventa;
                return '<div style="display:flex"><button onclick="editar(\''.$idventa.'\')" class="btn btn-warning">Ver</button></div>';
            })->rawColumns(['actions'])->toJson();
    }
    public function compras(Request $request){
        // $fecha=$request->get("fecha");
        // if($fecha!=""){
        //     $compras=DB::select("select *,(total - pagado) as deuda from compras left join (select idcompra as idcomprax,sum(monto) as pagado from pagos group by idcompra) as tb1 on compras.idcompra=tb1.idcomprax where fecha like '$fecha%' order by fecha desc ");
        // }
        // else{
        //     $fecha=date("Y-m-d");
        //     $compras=DB::select("select *,(total - pagado) as deuda from compras left join (select idcompra as idcomprax,sum(monto) as pagado from pagos group by idcompra) as tb1 on compras.idcompra=tb1.idcomprax where fecha like '$fecha%' order by fecha desc ");
        // }
        $compras=DB::select("select *,round(total - pagado,2) as deuda from compras left join (select idcompra as idcomprax,sum(monto) as pagado from pagos group by idcompra) as tb1 on compras.idcompra=tb1.idcomprax order by fecha desc");
        return DataTables::of($compras)
            ->addcolumn('actions',function($compras){
                $id=$compras->id;
                $idcompra=$compras->idcompra;
                return '<div style="display:flex"><a href="'.route("compras.detalleunacompra",["id"=>$id,"idcompra"=>$idcompra]).'" class="btn btn-secondary">Ver</a><button class="btn btn-danger" onclick="eliminacompra('.$idcompra.')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
              </svg></button></div>';
            })->rawColumns(['actions'])->toJson();
    }
}   
