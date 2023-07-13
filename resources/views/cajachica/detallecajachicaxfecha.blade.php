@extends('layouts.plantillabase')
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
    <form action="detallecajachicaxfecha2" method="post" id="formuencabezado">
        @csrf
        <div class="titulo">
            <h4 class="card-header">Detalle Caja Chica</h4>
            <div class="deposito">
                <select name="deposito" id="deposito" onchange="document.getElementById('formuencabezado').submit()" class="form-control">
                    @if (count($apertura)>0)
                        @foreach ($depositos as $undepot)
                        @if ($apertura[0]->deposito==$undepot->id)
                            <option value="{{$undepot->id}}" selected="selected">{{$undepot->nombre}}</option>
                        @else
                            <option value="{{$undepot->id}}">{{$undepot->nombre}}</option>
                        @endif

                        @endforeach
                    @else
                        @foreach ($depositos as $undepot)
                            @if ($deposito==$undepot->id)
                            <option value="{{$undepot->id}}" selected="selected">{{$undepot->nombre}}</option>
                            @else
                            <option value="{{$undepot->id}}">{{$undepot->nombre}}</option>
                            @endif    
                            
                        @endforeach
                    @endif
                    
                </select>
            </div>
            @if (count($apertura)>0)
                <input type="text" id="fechax" name="fechax" onchange="document.getElementById('formuencabezado').submit()" autocomplete="off" style="border:0;background:lemonchiffon;text-align:center" value="{{implode("-",array_reverse(explode("-",$apertura[0]->fecha)))}}" readonly>
            @else
                <input type="text" id="fechax" name="fechax" onchange="document.getElementById('formuencabezado').submit()" autocomplete="off" style="border:0;background:lemonchiffon;text-align:center" value="{{date("d-m-Y")}}" readonly>
            @endif
           
        </div>
    </form>
    
    
    

    <br>  
    <div class="cabeceraventa">
        @if (count($apertura)>0)
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Apertura Bs:</span>
                <input type="text" class="form-control" id="apertura" style="background: lightyellow" value="{{$apertura[0]->apertura}}" disabled>
                <span class="input-group-text" id="basic-addon2">Gastado:</span>
                <input type="text" class="form-control" id="gastado" style="background: lightyellow" value="{{$apertura[0]->gastado}}" disabled>
                <span class="input-group-text" id="basic-addon2">Saldo:</span>
                <input type="text" class="form-control" id="saldo" style="background: lightyellow" value="{{$apertura[0]->apertura - $apertura[0]->gastado}}" disabled>
            </div>
        @else
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Apertura Bs:</span>
                <input type="text" class="form-control" id="apertura" style="background: lightyellow" value="" disabled>
                <span class="input-group-text" id="basic-addon2">Gastado:</span>
                <input type="text" class="form-control" id="gastado" style="background: lightyellow" value="" disabled>
                <span class="input-group-text" id="basic-addon2">Saldo:</span>
                <input type="text" class="form-control" id="saldo" style="background: lightyellow" value="" disabled>
            </div>
        @endif
        
        <div class="input-group mb-3">
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
                <th scope="col">Fecha</th>
                <th scope="col">Concepto</th>
                <th scope="col" style="text-align: right">Monto</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($gastado as $ungasto)
                <tr>
                    <td>
                       {{-- <span onclick="elimina(this,{{$ungasto}})" style="color:red;padding:0 0.5em;cursor:pointer">X</span> --}}
                       {{$loop->iteration}}
                    </td>
                    <td>{{$ungasto->fecha}}</td>
                    <td>
                        {{$ungasto->concepto}}
                       {{-- <input type="text" name="concepto_1" id="concepto_1" size="60"> --}}
                    </td>
                    <td style="text-align: right;">
                        {{$ungasto->monto}}
                       {{-- <input type="number" name="monto_1" id="monto_1" style="text-align: right" value="0" onkeyup="recalcula()" onmouseup="recalcula()"> --}}
                    </td>
                    
                </tr>
                @endforeach
            
            </tbody>
        </table>
          <table class="tb_totalcajachica">
              <tr><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="text-align:right;font-weight:bold;font-size:1.5em">0</td></tr>
          </table>
    </div >
    </form>
    {{-- <button onclick="mas()" class="btn btn-light" style="border:1px solid orange">+</button> --}}
    <br>
    <br>
    {{-- <div class="input-group mb-3">
        <span class="input-group-text">Comentario</span>
        <input type="text" class="form-control" id="comentario" >
    </div> --}}
{{-- 
        <div class="col-12" style="text-align: center">
            <a href="{{route('ventas.index')}}" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" onclick="guardacaja()" id="btnguardar">Registrar Gastos</button>
        </div> --}}
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
    window.onload=function(){
        $("#fechax").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat:"dd-mm-yy",
                        closeText: 'Cerrar',
                        prevText: '<Ant',
                        nextText: 'Sig>',
                        currentText: 'Hoy',
                        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
                        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
                        weekHeader: 'Sm',
                        firstDay: 1,
                        isRTL: false,
                        showMonthAfterYear: false,
                        yearSuffix: ''
        });
        tabla=document.getElementById("tb_cajachica");
        recalcula();
    }
    
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
                document.getElementById("gastado").value=res;
                document.getElementById("saldo").value=parseFloat(document.getElementById("apertura").value - res);
                // window.location.replace("{{route('nuevaventa')}}");
        });
    }
    function elimina(elemento,ungasto){
        if(confirm("Está seguro de eliminar este gasto de caja chica del depósito elegido?")){
            console.log(ungasto);
            // dataenvio={idgasto:ungasto.id};
            fetch('eliminadecajachica', {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: JSON.stringify(ungasto)
            })
            .then(res => res.json())
            .then(res => {
                console.log("desdeserver: ",res);
                if(res=="eleminado"){
                fila=elemento.parentElement.parentElement.rowIndex;
                document.getElementById("tb_cajachica").deleteRow(fila);
                recalcula();
                }
                

            });

        }
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
            valor=tabla.rows[k].cells[3].innerText;
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