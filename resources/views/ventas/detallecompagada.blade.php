@extends('layouts.plantillabase')
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div class="titulo"><h3>Comisiones pagadas a <span style="color:darkorange">{{$nombre}}</span></h3></div>
        <table class="table table-light table-stripped table-hover" id="tbx">
            <thead class="thead-light">
                <tr>
                    <th></th>
                    <th>N</th>
                    <th>Descripcion</th>
                    <th>Fecha</th>
                    <th>PrecioVenta</th>
                    <th>PrecioFinal</th>
                    <th>Cantidad</th>
                    <th>ComisinUnit</th>
                    <th>ComisionTotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $key=>$unprod)
                    <tr>
                        <td></td>
                        <td>{{$loop->iteration}} <input type="hidden" name="id_{{$loop->iteration}}" id="id_{{$loop->iteration}}" value="{{$unprod->id}}"></td>
                        <td>{{$unprod->descripcion}}</td>
                        <td>{{implode("-",array_reverse(explode("-",explode(" ",$unprod->fecha)[0])))." ".explode(" ",$unprod->fecha)[1]}}</td>
                        <td>{{$unprod->precioventa}}</td>
                        <td>{{$unprod->preciofinal}}</td>
                        <td>{{$unprod->cuantos}}</td>
                        <td>{{$unprod->comision}}</td>
                        <td>{{$unprod->cuantos * $unprod->comision}}</td>
                        {{-- <td><a href="{{route('pagacomision',$unprod->id)}}" class="btn btn-warning">Pagar</a></td> --}}
                    </tr>
                @endforeach
                <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td></tr>
            </tbody>
        </table>
        {{-- <div>{{$lista->links()}}</div> --}}
@endsection
<script>
    window.onload=function(){totaliza();}
    // function registrarpago(){
    //     if(confirm("Está seguro de registrar el pago de los Seleccionados?")){
    //         console.log("si");
    //         tb=document.getElementById("tb");
    //         nrofilas=tb.rows.length-1;
    //         ids=[];
    //         for(k=1;k<nrofilas;k++){
    //             tiq=document.getElementById("ch_"+k);
    //             if(tiq.checked){
    //                 ids.push(tiq.parentElement.parentElement.cells[1].querySelector("input").value);
    //             }
    //         }
    //         console.log("ids tiqueados: ",ids);
    //         document.getElementById("ids").value=JSON.stringify(ids);
    //         document.getElementById("formupago").submit();      
    //     }
    // }
    // function cambia(chk){
    //     console.log(chk.checked);
    //     color="";
    //     if(chk.checked){
    //         color="lightyellow";
    //     }
    //     else{
    //         color="snow";
    //     }
    //     chk.parentElement.style.background="red";
    //     celdas=chk.parentElement.parentElement.querySelectorAll("td");
    //     for(i=0;i<celdas.length;i++){
    //         celdas[i].style.background=color;
    //     }
    //     totaliza();
    // }
    function totaliza(){
        tb=document.getElementById("tbx");
        nrofilas=tb.rows.length-1;
        total=0;
        for(k=1;k<nrofilas;k++){
           
                total=total + parseFloat(tb.rows[k].cells[8].innerText);
        
        }
        document.getElementById("total").innerText=total;
    }
</script>