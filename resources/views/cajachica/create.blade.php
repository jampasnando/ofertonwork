@extends('layouts.plantillavendedor')
@section('contenido')
<div class="cajachica">
   
    @if (session("guardado"))
            <div class="alert alert-success">{{session("guardado")}}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
               
            </div>
        @endif
    <h1 class="card-header">Registrar en Caja Chica</h1> <br>  
    <div class="cabeceraventa">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon2">Apertura Bs:</span>
            <input type="text" class="form-control" id="apertura" style="background: lightyellow" value="{{$apertura[0]->apertura}}" disabled>
            <span class="input-group-text" id="basic-addon2">Gastado:</span>
            <input type="text" class="form-control" id="gastado" style="background: lightyellow" value="{{$gastado}}" disabled>
            <span class="input-group-text" id="basic-addon2">Saldo:</span>
            <input type="text" class="form-control" id="saldo" style="background: lightyellow" value="{{$apertura[0]->apertura - $gastado}}" disabled>
        </div>
        <div class="input-group mb-3">
            <input type="hidden" name="depoculot" id="depoculto" value="{{session('usr')->ciudad}}">
            <span class="input-group-text" id="inputGroup-sizing-sm">Deposito</span>
            <select class="form-select" aria-label="Default select example" id="deposito" style="background: aliceblue" disabled>
                @foreach ($depositos as $undepot)
                    @if ($apertura[0]->deposito==$undepot->id)
                        <option value="{{$undepot->id}}" selected="selected">{{$undepot->nombre}}</option>
                    @else
                        <option value="{{$undepot->id}}">{{$undepot->nombre}}</option>
                    @endif
                    
                @endforeach
            </select>

            <div class="usroriginal">
                <input type="hidden" id="id_usroriginal" value="{{session('usr')->id}}">
                <input type="hidden" id="nom_usroriginal" value="{{session('usr')->nombre}}">
            </div>
            <div class="input-group mb-3">
                <div class="input-group mb-3">
                    <input type="hidden" name="idvendedor" id="idvendedor" value='{{session('usr')->id}}'>
                    <input type="hidden" name="idusr" id="idusr" value="{{session('usr')->id}}">
                    <span class="input-group-text" id="basic-addon2">Vendedor</span>
                    <input type="text" class="form-control" id="vendedor" style="background: aliceblue" value="{{session('usr')->nombre}}" disabled>
                </div>
                
            </div>
        </div>
        
        
    </div> 
    <form action="" method="post" id="formuventa">
        @csrf
    <br>
    <div>
        <table class="table table-stripped table-hover" id="tb_cajachica">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Concepto</th>
                <th scope="col" style="text-align: right">Monto</th>
              </tr>
            </thead>
            <tbody>
             <tr>
                 <td>
                    <span onclick="elimina(this)" style="color:red;padding:0 0.5em">X</span>1
                 </td>
                 <td>
                    <input type="text" name="concepto_1" id="concepto_1" size="60">
                 </td>
                 <td style="text-align: right;">
                    <input type="number" name="monto_1" id="monto_1" style="text-align: right" value="0" onkeyup="recalcula()" onmouseup="recalcula()">
                 </td>
                 
             </tr>
            </tbody>
        </table>
          <table class="tb_totalcajachica">
              <tr><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="text-align:right;font-weight:bold;font-size:1.5em">0</td></tr>
          </table>
    </div >
    </form>
    <button onclick="mas()" class="btn btn-light" style="border:1px solid orange">+</button>
    <br>
    <br>
    {{-- <div class="input-group mb-3">
        <span class="input-group-text">Comentario</span>
        <input type="text" class="form-control" id="comentario" >
    </div> --}}

        <div class="col-12" style="text-align: center">
            {{-- <a href="{{route('ventas.index')}}" class="btn btn-danger">Cancelar</a> --}}
            <button class="btn btn-primary" onclick="guardacaja()" id="btnguardar">Registrar Gastos</button>
        </div>
</div>
<script>
    // window.addEventListener("load",function(){

    // });
    tabla=document.getElementById("tb_cajachica");
    function mas(){
        nro=tabla.rows.length;
        fila=tabla.insertRow();
        celda=fila.insertCell();
        celda.innerHTML="<span style='color:red;padding:0 0.5em' onclick='elimina(this)' >X</span>" + nro;
        celda=fila.insertCell();
        celda.innerHTML="<input type='text' name='concepto_"+nro+"' id='concepto_"+nro+"' size='60'>";
        celda=fila.insertCell();
        celda.style="text-align:right";
        celda.innerHTML="<input type='number' name='monto_"+nro+"' id='monto_"+nro+"' style='text-align:right' value='0' onkeyup='recalcula()' onmouseup='recalcula()'>";
    }
    function guardacaja(){
        nrofilas=tabla.rows.length;
        total=0;
        datos=[];
        for(k=1;k<nrofilas;k++){
            concepto=tabla.rows[k].cells[1].querySelector("input").value;
            valor=tabla.rows[k].cells[2].querySelector("input").value;  
            if(concepto!="" && parseFloat(valor)>=0){
                unpar={concepto:concepto,valor:valor};
                datos.push(unpar);
            }
        }
        dataenvio={idusr:document.getElementById("id_usroriginal").value,deposito:document.getElementById("deposito").value,datos:datos};
        console.log("dataenvio: ",dataenvio);
        fetch('guardacajachica', {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: JSON.stringify(dataenvio)
            })
            .then(res => res.json())
            .then(res => {
                console.log("desdeBD: ",res);
                alert("Gasto REGISTRADO");
                tabladet=document.getElementById("detalleventa");
                document.getElementById("formuventa").reset();
                while(tabla.rows.length>1){
                    tabla.deleteRow(-1);
                }
                document.getElementById("total").innerText="0";
                console.log("res: ",res);
                document.getElementById("gastado").value=res.gastado;
                document.getElementById("saldo").value=parseFloat(document.getElementById("apertura").value - res.gastado);
                // window.location.replace("{{route('nuevaventa')}}");
            });
    }
    function elimina(elemento){
        
        fila=elemento.parentElement.parentElement.rowIndex;
        document.getElementById("tb_cajachica").deleteRow(fila);
        recalcula();
    }

    // function cambiacant(input){
    //     celda=input.parentElement;
    //     fila=celda.parentElement;
    //     fila.cells[4].innerText=fila.cells[2].querySelector("input").value * fila.cells[3].querySelector("input").value ;
    //     console.log("nuevacant: ",input.value);
    //     calculatotal();  
    // }
    function recalcula(){
        console.log("recalcula...");
        total=0;
        nro=tabla.rows.length;
        for(k=1;k<nro;k++){
            valor=tabla.rows[k].cells[2].querySelector("input").value;
            total=total + parseFloat(valor);
        }
        document.getElementById("total").innerText=total;
        if(total>parseFloat(document.getElementById("saldo").value)){
            document.getElementById("total").style.background="red";
        }
        else{
            document.getElementById("total").style.background="";
        }
    }
</script>
@endsection