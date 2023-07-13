@extends(session("usr")->rol=="Enc. Tienda y caja"?"layouts.plantillavendedor":'layouts.plantillabase') 
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div class="titulodetallecierre"><h3>Detalle Cierre Caja <span style="color:darkorange">{{implode("-",array_reverse(explode("-",explode(" ",$fechacierre)[0])))." ".explode(" ",$fechacierre)[1]}}</span></h3>
            
        </div>
        <div style="display: flex;justify-content:space-between;">
            <div>
                <a href="{{route("exportardetallecierre",$fechacierre)}}" class="btn btn-warning">Exportar a Excel</a>
                | Respaldos:
                 @php
                    if($respaldos[0]->respaldos!=null){
                        $cad=explode("|",$respaldos[0]->respaldos);
                        $cont=[];
                        for($i=0;$i<count($cad);$i++){
                            echo "<a href='".url("/respaldos/".$cad[$i])."' target='_blank'>".($i+1)."</a>&nbsp;";
                        }
                    }
                     
                 @endphp
            </div>
            
            {{-- <a href="{{route("cierre.respaldos",["fechacierre"=>$fechacierre])}}" class="btn btn-secondary">Respaldos</a> --}}
            <form action="{{route("cierre.suberespaldos")}}" method="post" enctype="multipart/form-data" style="float:right">
                {{-- <div class="mb-3"> --}}
                    @csrf
                    <div style="display: flex">
                        <span>Respaldos:</span> <input class="form-control" type="file" id="imagenes" name="imagenes[]" multiple>
                        <input type="hidden" name="idcierre" id="idcierre" value="{{$idcierre}}">
                        <button href="#" class="btn btn-info" type="submit">Subir</button>
                    </div>
                    
                  {{-- </div> --}}
            </form>
        </div>
        
        
        <table class="table table-light " id="tb_detallecierre">
            <thead class="thead-light">
                <tr>
                    {{-- <th></th> --}}
                    <th>N</th>
                    <th>Descripcion</th>
                    <th>FechaVenta</th>
                    <th>FechaCierre</th>
                    <th>Cuantos</th>
                    <th>PrecioVenta</th>
                    <th>Total</th>
                    
                    {{-- <th>ComisionTotal</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($detalle as $key=>$unprod)
                    <tr >
                        {{-- <td><input type="checkbox" name="ch_{{$key+1}}" id="ch_{{$key+1}}" onchange="cambia(this)" checked></td> --}}
                        <td>{{$loop->iteration}} <input type="hidden" name="id_{{$loop->iteration}}" id="id_{{$loop->iteration}}" value="{{$unprod->id}}"></td>
                        <td>{{$unprod->descripcion}}</td>
                        <td>{{implode("-",array_reverse(explode("-",explode(" ",$unprod->fecha)[0])))." ".explode(" ",$unprod->fecha)[1]}}</td>
                        @if (!is_null($unprod->cierre))
                            <td>{{implode("-",array_reverse(explode("-",explode(" ",$unprod->cierre)[0])))." ".explode(" ",$unprod->cierre)[1]}}</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{$unprod->cuantos}}</td>
                        <td>{{$unprod->preciofinal}}</td>
                        <td>{{$unprod->cuantos * $unprod->preciofinal}}</td>
                        
                        
                    </tr>
                @endforeach
                <tr><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td></tr>
            </tbody>
        </table>
        <label for="obs">Apuntes, observaciones, nro de recibo, etc:</label>
        <input type="text" name="obs" id="obs" class="form-control" value="{{$obs}}">
        {{-- <form action="{{route("guardacierredecaja")}}" method="post" id="formucierre">
            @csrf
            <div class="col-12">
                <label for="obs">Apuntes, observaciones, nro de recibo, etc:</label>
                <input type="text" name="obs" id="obs" class="form-control">
                <input type="hidden" name="totalx" id="totalx" class="form-control">
            </div>
            <input type="hidden" name="ids" id="ids">
        </form> --}}
        {{-- <div class="col-12" style="text-align: center">
            <button class="btn btn-warning" onclick="registrarcierre()">Registrar Cierre de Caja</button>
        </div> --}}
        {{-- <div>{{$lista->links()}}</div> --}}
@endsection
<script>
    window.onload=function(){totaliza();}

    function totaliza(){
        tb=document.getElementById("tb_detallecierre");
        nrofilas=tb.rows.length-1;
        total=0;
        for(k=1;k<nrofilas;k++){
                total=total + parseFloat(tb.rows[k].cells[6].innerText);
        }
        document.getElementById("total").innerText=total;
        document.getElementById("totalx").value=total;
    }
</script>