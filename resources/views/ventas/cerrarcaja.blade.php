@extends(session("usr")->rol=="Enc. Tienda y caja"?"layouts.plantillavendedor":'layouts.plantillabase') 
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div class="titulo"><h3>Cerrar Caja <span style="color:darkorange"></span></h3></div>
        <table class="table table-light " id="tb_cierrecaja">
            <thead class="thead-light">
                <tr>
                    <th><input type="checkbox" name="chtodo" id="chtodo" onchange="cambiatodo(this)" checked></th>
                    <th>N</th>
                    <th>Descripcion</th>
                    <th>Dep</th>
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
                        <td><input type="checkbox" name="ch_{{$key+1}}" id="ch_{{$key+1}}" onchange="cambia(this)" checked></td>
                        <td>{{$loop->iteration}} <input type="hidden" name="id_{{$loop->iteration}}" id="id_{{$loop->iteration}}" value="{{$unprod->id}}"></td>
                        <td>{{$unprod->descripcion}}</td>
                        <td>{{$unprod->idneg}}</td>
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
                <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td></tr>
            </tbody>
        </table>
        <form action="{{route("guardacierredecaja")}}" method="post" id="formucierre">
            @csrf
            <div class="col-12">
                <label for="obs">Apuntes, observaciones, nro de recibo, etc:</label>
                <input type="text" name="obs" id="obs" class="form-control">
                <input type="hidden" name="totalx" id="totalx" class="form-control">
            </div>
            <input type="hidden" name="ids" id="ids">
        </form>
        <div class="col-12" style="text-align: center">
            <button class="btn btn-warning" onclick="registrarcierre()">Registrar Cierre de Caja</button>
        </div>
        {{-- <div>{{$lista->links()}}</div> --}}
@endsection
<script>
    window.onload=function(){totaliza();}
    function registrarcierre(){
        if(confirm("Está seguro de registrar el cierre de caja de los seleccionados?")){
            console.log("si");
            tb=document.getElementById("tb_cierrecaja");
            nrofilas=tb.rows.length-1;
            ids=[];
            for(k=1;k<nrofilas;k++){
                tiq=document.getElementById("ch_"+k);
                if(tiq.checked){
                    ids.push(tiq.parentElement.parentElement.cells[1].querySelector("input").value);
                }
            }
            console.log("ids tiqueados: ",ids);
            document.getElementById("ids").value=JSON.stringify(ids);
            document.getElementById("formucierre").submit();      
        }
    }
    function cambia(chk){
        console.log(chk.checked);
        color="";
        if(chk.checked){
            color="lightyellow";
        }
        else{
            color="snow";
        }
        chk.parentElement.style.background="red";
        celdas=chk.parentElement.parentElement.querySelectorAll("td");
        for(i=0;i<celdas.length;i++){
            celdas[i].style.background=color;
        }
        totaliza();
    }
    function cambiatodo(chktodo){
        console.log(chktodo.checked);
        color="";
        if(chktodo.checked){
            color="lightyellow";
        }
        else{
            color="snow";
        }
        tb=document.getElementById("tb_cierrecaja");
        nrofilas=tb.rows.length-1;
        for(j=1;j<nrofilas;j++){
            tb.rows[j].cells[0].querySelector("input").checked=chktodo.checked;
            celdas=tb.rows[j].querySelectorAll("td");
            for(i=0;i<celdas.length;i++){
                celdas[i].style.background=color;
            }
        }
        
        totaliza();
    }
    function totaliza(){
        tb=document.getElementById("tb_cierrecaja");
        nrofilas=tb.rows.length-1;
        total=0;
        for(k=1;k<nrofilas;k++){
            if(document.getElementById("ch_"+k).checked){
                total=total + parseFloat(tb.rows[k].cells[8].innerText);
            }
        }
        document.getElementById("total").innerText=total;
        document.getElementById("totalx").value=total;
    }
</script>