<?php

namespace App\Http\Controllers;
use App\Models\Tiendapreventa;
use App\Models\Promo;

use Illuminate\Http\Request;
use DB;
class MarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $prods=DB::select("SELECT * from inventarios where categoria='Herramientas' and marca='GLADIATOR' and imagenes<>'' limit 0,12");
        $prods=DB::select("SELECT * from inventarios where imagenes<>'' and cantidad>0 limit 15");
        $categorias=DB::select("select distinct categoria from inventarios where imagenes<>'' and cantidad>0 order by categoria");
        $marcas=DB::select("select marca,count(*) as cant from inventarios where imagenes<>'' and cantidad>0 group by marca order by cant desc  ");
        $config=DB::select("select * from configapp");

        return view("market.index")->with("prods",$prods)->with("marcas",$marcas)->with("categorias",$categorias)->with("config",$config);
    }
    public function indexcliente(Request $request,$id)
    {
        // $datos=$request->input();
        $datos=json_decode(base64_decode($id));
        // return json_encode($datos);
        $unprod=DB::select("SELECT * from inventarios where id='".$datos->id."'");
        $vendedor=DB::select("select id,nombre,telefono from vendedores where id='".$datos->vendedor."'");
        $config=DB::select("select * from configapp");
        $paraencriptar=["id"=>$unprod[0]->id,"vendedor"=>$vendedor[0]->id];
        $encriptado=base64_encode(json_encode($paraencriptar));
        // return json_encode($unprod[0]);
        $prods=DB::select("SELECT * from inventarios where imagenes<>'' and cantidad>0 limit 15");
        $categorias=DB::select("select distinct categoria from inventarios where imagenes<>'' and cantidad>0 order by categoria");
        $marcas=DB::select("select marca,count(*) as cant from inventarios where imagenes<>'' and cantidad>0 group by marca order by cant desc  ");
        return view("market.index")->with("prods",$prods)->with("marcas",$marcas)->with("categorias",$categorias)->with("unprod",$unprod)->with("vendedor",$vendedor)->with("encriptado",$encriptado)->with("config",$config);
    }
    public function obtieneprodsajax(Request $request){
        $entrada=$request->input();
        // return $entrada;
        // return json_encode($entrada[0]["marca"]);
        $limiteinf=$entrada[0]["limite"];
        $filtros=["true"];
        if($entrada[0]["marca"]!="Todas"){$filtros[]="marca='".$entrada[0]["marca"]."'";}
        if($entrada[0]["categoria"]!="Todas"){$filtros[]="categoria='".$entrada[0]["categoria"]."'";}
        if($entrada[0]["sucursal"]!=0){$filtros[]="deposito='".$entrada[0]["sucursal"]."'";}
        if($entrada[0]["buscar"]!=''){$filtros[]="descripcion like '%".$entrada[0]["buscar"]."%'";}
        $query="SELECT * from inventarios where imagenes<>'' and cantidad>0 and ".implode(" and ",$filtros)." limit $limiteinf,15";
        $prods=DB::select($query);
        return json_encode($prods);
    }
    public function guardacarritoprev(Request $request){
        // $datos=$request->input();
        // return json_encode("hola");s
        $datos=$request->all();
        // return $datos[0];
        $guardara=["json"=>json_encode($request->all()),"cliente"=>$datos[0]['cliente'],"celular"=>$datos[0]['celular'],"metodopago"=>$datos[0]['metodopago'],"deposito"=>$datos[0]["deposito"],"origen"=>$datos[0]["origen"],"fecha_creacion"=>date("Y-m-d H:i:s"),"estado"=>"pendiente"];
        $nuevo=Tiendapreventa::create($guardara);
        return $nuevo;
    }

    public function guardaprodenpromo(Request $request){
        // return $request;
        $hoy=date("Y-m-d H:i:s");
        $guardar=["deposito"=>$request->deposito,"producto"=>$request->id,"fechareg"=>$hoy];
        Promo::insert($guardar);
        return back();
    }
    public function quitarprodpromo(Request $request){
        // return $request;
        Promo::where("producto",$request->idquitar)->delete();
        return back();
    }
    public function obtienepromosdesuc(Request $request){
        // return $request;
        $promos=DB::select("select inventarios.* from (select * from promos where deposito='".$request->suc."') as tb1 inner join inventarios where tb1.producto=inventarios.id");
        return $promos;
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
