<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\A_categoria;
use App\Models\A_sala;
use App\Models\A_lectura;
use DB;
class AReporte extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todo=[];
        $todox=[];
        return view("reportes.index")->with("todo",$todo)->with("todox",$todox);
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
    
    public function recibeformu(Request $miformu){
       $ciudad=$miformu->ciudad;
       $mes=$miformu->mes;
       $ano=$miformu->ano;
       if(($ciudad!="")&&($mes>0)){
            //$tabla=DB::select("select tb3.nombre as sala,tb4.categoria,tb4.nombre as marca,tb3.caras from (select tb2.nombre,tb1.marca,tb1.caras from (SELECT * FROM a_lecturas where month(fecha)='".$mes."') as tb1 inner join (select * from a_salas where ciudad='".$ciudad."') as tb2 on tb1.sala=tb2.id) as tb3 inner join (select a_marcas.id,a_marcas.nombre,a_categorias.categoria from a_marcas inner join a_categorias on a_marcas.categoria=a_categorias.id) as tb4 on tb3.marca=tb4.id order by sala,categoria,marca");
            $tabla=DB::select("select tbA.nomsala as sala,tbA.categoria,tbA.nombre as marca,tbB.caras from (select tb2.* from (select tb1.idsala,nomsala,idmarca,nombre,a_categorias.categoria from (select a_salas.id as idsala,a_salas.nombre as nomsala,a_marcas.id as idmarca,a_marcas.nombre,a_marcas.categoria from a_salas,a_marcas where a_salas.ciudad='".$ciudad."') as tb1 inner join a_categorias on tb1.categoria=a_categorias.id) as tb2 inner join (select DISTINCT sala from a_lecturas where month(fecha)='".$mes."' and year(fecha)='".$ano."') as tb3 on tb2.idsala=tb3.sala order by nomsala,categoria,nombre) as tbA left join (select tbz.* from (select tbx.sala,tbx.marca,tbx.caras from (select * from a_lecturas where month(fecha)='".$mes."' and year(fecha)='".$ano."') as tbx inner join (select sala,marca,max(fecha) as fecha from a_lecturas where month(fecha)='".$mes."' and year(fecha)='".$ano."' group by sala,marca) as tby on tbx.sala=tby.sala and tbx.marca=tby.marca and tbx.fecha=tby.fecha) as tbz inner join (select id from a_salas where ciudad='".$ciudad."') as tbw on tbz.sala=tbw.id order by sala,marca) as tbB on tbA.idsala=tbB.sala and tbA.idmarca=tbB.marca order by sala,categoria,marca");
                $todo=[];
                $marcas=[];
                $categorias=[];
                $bsala="";
                $bcat="";
                foreach($tabla as $i=>$unreg){
                    if($i==0){
                        $bsala=$unreg->sala;
                        $bcat=$unreg->categoria;
                        $marcas[]=$unreg;
                    }
                    else{
                        if($unreg->sala!=$bsala){
                            $categorias[]=["cat"=>$bcat,"marcas"=>$marcas];
                            $marcas=[];
                            $todo[]=["sala"=>$bsala,"categorias"=>$categorias];
                            $categorias=[];
                            $bcat=$unreg->categoria;
                            $bsala=$unreg->sala;
                            $marcas[]=$unreg;
                        }
                        else{
                            if($unreg->categoria!=$bcat){
                                $categorias[]=["cat"=>$bcat,"marcas"=>$marcas];
                                $marcas=[];
                                $bcat=$unreg->categoria;
                                $marcas[]=$unreg;
                            }
                            else{
                                $marcas[]=$unreg;
                            }
                        }
                    }
                    
                }
                $categorias[]=["cat"=>$bcat,"marcas"=>$marcas];
                $todo[]=["sala"=>$bsala,"categorias"=>$categorias];

                $totales=[];
                for($q=0;$q<500;$q++){
                    $totales[$q]=0;
                }
                // $limite=0;
                foreach($todo as $i=>$salas){
                    $p=0;
                    foreach($salas["categorias"] as $j=>$categorias){
                        $sum=0;
                        foreach($categorias["marcas"] as $k=>$marcas){
                            $sum=$sum+(int)($marcas->caras);
                            $totales[$p]+=(int)($marcas->caras);
                            $p++;
                        }

                        $todo[$i]["categorias"][$j]["total"]=$sum;
                            $totales[$p]+=$sum;
                            $p++;

                        foreach($categorias["marcas"] as $k=>$marcas){
                            if($sum>0){
                                $marcas->porcentaje=round((($marcas->caras)/$sum)*100);
                                $totales[$p]+=round((($marcas->caras)/$sum)*100);
                                $p++;
                            }
                            else{
                                $marcas->porcentaje="?";
                                $totales[$p]+=0;
                                $p++;
                            }
                            
                        }
                    }
                }
                $meses=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
                // return $todo;
                // if($todo[0]["sala"]!=""){
                //     return view("reportes.index")->with("todo",$todo)->with("ciudad",$ciudad)->with("mes",$meses[$mes])->with("totales",$totales)->with("ano",$ano)->with("limite",$p);
                // }
                // else{
                //     $todo=[];
                //     return view("reportes.index")->with("todo",$todo)->with("ciudad","")->with("mes","")->with("ano","");
                // }
            ///////////////////////////////////////////// SEGUNDA TABLA //////////////////////////////////////////////////////
            $mesx=$mes-1;$anox=$ano;
            if($mesx==0){$mesx=12;$anox=$ano-1;}
            $tablax=DB::select("select tbA.nomsala as sala,tbA.categoria,tbA.nombre as marca,tbB.caras from (select tb2.* from (select tb1.idsala,nomsala,idmarca,nombre,a_categorias.categoria from (select a_salas.id as idsala,a_salas.nombre as nomsala,a_marcas.id as idmarca,a_marcas.nombre,a_marcas.categoria from a_salas,a_marcas where a_salas.ciudad='".$ciudad."') as tb1 inner join a_categorias on tb1.categoria=a_categorias.id) as tb2 inner join (select DISTINCT sala from a_lecturas where month(fecha)='".$mesx."' and year(fecha)='".$anox."') as tb3 on tb2.idsala=tb3.sala order by nomsala,categoria,nombre) as tbA left join (select tbz.* from (select tbx.sala,tbx.marca,tbx.caras from (select * from a_lecturas where month(fecha)='".$mesx."' and year(fecha)='".$anox."') as tbx inner join (select sala,marca,max(fecha) as fecha from a_lecturas where month(fecha)='".$mesx."' and year(fecha)='".$anox."' group by sala,marca) as tby on tbx.sala=tby.sala and tbx.marca=tby.marca and tbx.fecha=tby.fecha) as tbz inner join (select id from a_salas where ciudad='".$ciudad."') as tbw on tbz.sala=tbw.id order by sala,marca) as tbB on tbA.idsala=tbB.sala and tbA.idmarca=tbB.marca order by sala,categoria,marca");
                $todox=[];
                $marcas=[];
                $categorias=[];
                $bsala="";
                $bcat="";
                foreach($tablax as $i=>$unreg){
                    if($i==0){
                        $bsala=$unreg->sala;
                        $bcat=$unreg->categoria;
                        $marcas[]=$unreg;
                    }
                    else{
                        if($unreg->sala!=$bsala){
                            $categorias[]=["cat"=>$bcat,"marcas"=>$marcas];
                            $marcas=[];
                            $todox[]=["sala"=>$bsala,"categorias"=>$categorias];
                            $categorias=[];
                            $bcat=$unreg->categoria;
                            $bsala=$unreg->sala;
                            $marcas[]=$unreg;
                        }
                        else{
                            if($unreg->categoria!=$bcat){
                                $categorias[]=["cat"=>$bcat,"marcas"=>$marcas];
                                $marcas=[];
                                $bcat=$unreg->categoria;
                                $marcas[]=$unreg;
                            }
                            else{
                                $marcas[]=$unreg;
                            }
                        }
                    }
                    
                }
                $categorias[]=["cat"=>$bcat,"marcas"=>$marcas];
                $todox[]=["sala"=>$bsala,"categorias"=>$categorias];

                $totalesx=[];
                for($q=0;$q<500;$q++){
                    $totalesx[$q]=0;
                }
                // $limite=0;
                foreach($todox as $i=>$salas){
                    $px=0;
                    foreach($salas["categorias"] as $j=>$categorias){
                        $sum=0;
                        foreach($categorias["marcas"] as $k=>$marcas){
                            $sum=$sum+(int)($marcas->caras);
                            $totalesx[$px]+=(int)($marcas->caras);
                            $px++;
                        }

                        $todox[$i]["categorias"][$j]["total"]=$sum;
                            $totalesx[$px]+=$sum;
                            $px++;

                        foreach($categorias["marcas"] as $k=>$marcas){
                            if($sum>0){
                                $marcas->porcentaje=round((($marcas->caras)/$sum)*100);
                                $totalesx[$px]+=round((($marcas->caras)/$sum)*100);
                                $px++;
                            }
                            else{
                                $marcas->porcentaje="?";
                                $totalesx[$px]+=0;
                                $px++;
                            }
                            
                        }
                    }
                }
                $meses=["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
                // return $todox;
                if(($todo[0]["sala"]!="")&&($todox[0]["sala"]!="")){
                    // return $todo;
                    return view("reportes.index")->with("todo",$todo)->with("ciudad",$ciudad)->with("mes",$meses[$mes])->with("totales",$totales)->with("ano",$ano)->with("limite",$p)->with("todox",$todox)->with("mesx",$meses[$mesx])->with("anox",$anox)->with("totalesx",$totalesx)->with("limitex",$px);
                }
                else{
                    $todox=[];
                    // return view("reportes.index")->with("todo",$todo)->with("ciudad","")->with("mes","")->with("ano","");
                    return view("reportes.index")->with("todo",$todo)->with("ciudad",$ciudad)->with("mes",$meses[$mes])->with("totales",$totales)->with("ano",$ano)->with("limite",$p)->with("todox",$todox)->with("mesx",$meses[$mesx])->with("anox",$anox)->with("totalesx",$totalesx)->with("limitex",$px);
                }
            /////////////////////////////////////////////////////////// TABLA ANTERIOR HASTA AQUI /////////////////////////////////////////
               
        }
        else{
            // $todo=[];
            // return view("reportes.index")->with("todo",$todo)->with("ciudad","")->with("mes","")->with("ano","");
        }
    }
}
