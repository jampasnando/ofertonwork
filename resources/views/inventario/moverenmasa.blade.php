@extends('layouts.plantillabase')
@section('contenido')
<div class="nuevoprod">
   
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
    <h1 class="card-header">Mover varios productos</h1> <br>  

    <div class="cabeceraventa">
        <div class="input-group mb-3">
            {{-- <input type="hidden" name="depoculot" id="depoculto" value="{{session('usr')->ciudad}}"> --}}
            
            <span class="input-group-text" id="inputGroup-sizing-sm">Deposito Origen</span>
            <select class="form-select" aria-label="Default select example" id="deposito" style="background: lightyellow" onchange="cambiaorigen()">
                @foreach ($depositos as $undepot)
                    <option value="{{$undepot->id}}">{{$undepot->nombre}}</option>
                @endforeach
            </select>
            <span class="input-group-text" id="inputGroup-sizing-sm">Deposito Destino</span>
            <select class="form-select" aria-label="Default select example" id="depositodestino" style="background: lightyellow">
                @foreach ($depositos as $undepot)
                    <option value="{{$undepot->id}}">{{$undepot->nombre}}</option>
                @endforeach
            </select>
            {{-- ////////////////////////////////////////////////// --}}
            <div class="usroriginal">
                <input type="hidden" id="id_usroriginal" value="{{session('usr')->id}}">
                <input type="hidden" id="nom_usroriginal" value="{{session('usr')->nombre}}">
            </div>
            <div class="input-group mb-3">
                <div class="input-group mb-3">
                    <input type="hidden" name="idvendedor" id="idvendedor" value='{{session('usr')->id}}'>
                    <input type="hidden" name="idusr" id="idusr" value="{{session('usr')->id}}">
                    <span class="input-group-text" id="basic-addon2">Responsable</span>
                    <input type="text" class="form-control" placeholder="Buscar vendedor" id="vendedor" style="background: aliceblue;" value="{{session('usr')->nombre}}" readonly>
                    {{-- <a href="" class="btn btn-secondary" id="borrarvendedor" style="display:none" onclick="borrarvendedor(event)">X</a> --}}
                    {{-- <div class="resultadobusq2" id="resultadobusq2"></div> --}}
                </div>
                
            </div>
            {{-- ////////////////////////////////////////////////// --}}

        </div>
        
        
    </div> 
    <form action="" method="post" id="formuventa">
        @csrf
    <br>
    <div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar producto" id="texto" autofocus>
            <a href="" class="btn btn-secondary" id="borrar" style="display:none" onclick="borrar(event)">X</a>
            <span class="input-group-text" id="basic-addon2">Buscar</span>
            <div class="resultadobusq" id="resultadobusq"></div>
        </div>
        <table class="table table-stripped table-hover" id="detalleventa" >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">CantidadActual</th>
                <th scope="col">Mover</th>
                {{-- <th scope="col">Subtotal</th> --}}
                <th></th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
          </table>
          {{-- <table class="table">
              <tr><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="text-align:right;font-weight:bold;font-size:1.5em">0</td></tr>
          </table> --}}
          
    </div >
    <br>
        
        <div class="complementos">
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Comentario</span>
                <input type="text" class="form-control" id="comentario" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" style="background: lightyellow">
              </div>
        </div>
    </form>
        <div class="col-12" style="text-align: center">
            <a href="{{route('nuevaventavendedor')}}" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" onclick="guardamover()" id="btnguardar">Registrar Movimientos</button>
        </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
    Date.prototype.today = function () { 
        return ((this.getDate() < 10)?"0":"") + this.getDate() + (((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) + this.getFullYear();
    }

    // For the time now
    Date.prototype.timeNow = function () {
        return ((this.getHours() < 10)?"0":"") + this.getHours() + ((this.getMinutes() < 10)?"0":"") + this.getMinutes() + ((this.getSeconds() < 10)?"0":"") + this.getSeconds();
    }
    window.onload=function(){
        
    }
    window.addEventListener("load",function(){
        console.log("pagina cargada");
        casbusq=document.getElementById("texto");
        document.getElementById("deposito").value="";
        document.getElementById("depositodestino").value="";
        casbusq.addEventListener("keyup",function(){
            if(casbusq.value.length>1){
                dep=document.getElementById("deposito").value;
                document.getElementById("borrar").style="display:block";
                fetch("buscaprodxamover?texto="+casbusq.value+"&dep="+dep,{method:"get"})
                .then(response=>response.text())
                .then(datos=>{
                    document.getElementById("resultadobusq").innerHTML=datos;
                });
            }
            else{
                document.getElementById("resultadobusq").innerHTML="";
            }
        });
    });

    function guardamover(){
        if(document.getElementById("deposito").value!="" && document.getElementById("depositodestino").value!="" && document.getElementById("deposito").value!=document.getElementById("depositodestino").value )
        {
            // document.title="venta_"+document.getElementById("deposito").value+"_" + new Date().today() + new Date().timeNow();
            document.getElementById("btnguardar").disabled=true;
            tabla=document.getElementById("detalleventa");
            nrofilas=tabla.rows.length;
            if(nrofilas==1){
                alert("NO HAY NINGÚN PRODUCTO EN LA LISTA PARA MOVER");
                return false;
            }
            else{
                dataenvio=[];
                prods=[];
                for(i=1;i<nrofilas;i++){
                    // preciov_original=tabla.rows[i].cells[5].querySelector("input:first-child").value;
                    // preciofinalx=tabla.rows[i].cells[2].querySelector("input").value;
                    cuantos=tabla.rows[i].cells[3].querySelector("input").value;
                    mover=tabla.rows[i].cells[4].querySelector("input").value;
                    idprod=tabla.rows[i].cells[5].querySelector("input").value;
                    if(parseFloat(cuantos)>=parseFloat(mover)){
                        unprod={id:tabla.rows[i].cells[0].querySelector("input").value,mover:mover,idprod:idprod};
                        prods.push(unprod);
                    }
                    else{
                        alert("ERROR EN CANTIDADES EN LA FILA "+i);
                        document.getElementById("btnguardar").disabled=false;
                        return false;
                    }
                }
                dataenvio=[{productos:prods,idusr:document.getElementById("idusr").value,comentario:document.getElementById("comentario").value,origen:document.getElementById("deposito").value,destino:document.getElementById("depositodestino").value}];
                console.log("enviará: ",dataenvio);
                fetch('registramoverenmasa', {
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
                    alert("TRASPASOS REGISTRADOS");
                    document.getElementById("btnguardar").disabled=false;
                    tabladet=document.getElementById("detalleventa");
                    document.getElementById("formuventa").reset();
                    while(tabladet.rows.length>1){
                        tabladet.deleteRow(-1);
                    }
                    document.getElementById("comentario").value="";
                    document.getElementById("deposito").value="";
                    document.getElementById("depositodestino").value="";
                });
            }
        }
        else{
            alert("INCOHERENCIAS EN DEPÓSITO ORIGEN O DEPÓSITO DESTINO");
            document.getElementById("btnguardar").disabled=false;
        }

        
    }
    function elegido(id,descr,precioventa,preciolocal,comision,cantidad,idprod){
        console.log(id,descr,idprod);
        tabla=document.getElementById("detalleventa");
        nro=tabla.rows.length;
        fila=tabla.insertRow();
        fila.title="Quedan "+cantidad+ " unidades";
        celda=fila.insertCell();
        celda.innerHTML="<span style='color:red;cursor:pointer' onclick='elimina(this)'>X</span>&nbsp" + nro+"<input type='hidden' value='"+id+"' name='id_"+nro+"' id='id_"+nro+"'>";
        celda=fila.insertCell();
        celda.innerHTML=descr + "<input type='hidden' value='"+preciolocal+"' name='pc_"+nro+"' id='pc_"+nro+"'>";
        if(parseFloat(cantidad)<=0){
            celda.style.color="red";
        }
        celda=fila.insertCell();
        celda.style.width="9em";
        celda.innerHTML="<input type='number' value='"+precioventa+"' name='pfinal_"+nro+"' id='pfinal_"+nro+"' onchange='cambiacant(this)'  class='form-control' style='text-align:right' disabled>";
        celda=fila.insertCell();
        celda.style.width="7em";
        celda.innerHTML="<input type='number' value='"+cantidad+"' name='co_"+nro+"' id='co_"+nro+"'  class='form-control' style='text-align:center' disabled>";
        celda=fila.insertCell();
        celda.style.width="7em";
        celda.innerHTML="<input type='number' value='1' name='c_"+nro+"' id='c_"+nro+"'  class='form-control' style='text-align:center'>";
        // celda=fila.insertCell();
        // celda.style.textAlign="right";
        // celda.innerText=precioventa;
        celda=fila.insertCell();
        celda.innerHTML="<input type='hidden' value='"+idprod+"'>";
        document.getElementById("resultadobusq").innerHTML="";
        document.getElementById("texto").value="";
    }
    function elimina(prod){
        fila=prod.parentElement.parentElement.rowIndex;
        document.getElementById("detalleventa").deleteRow(fila);
        idprody=prod.parentElement.parentElement.cells[5].querySelector("input:nth-child(3)").value;
    }

    function cambiacant(input){
        celda=input.parentElement;
        fila=celda.parentElement;
        fila.cells[4].innerText=fila.cells[2].querySelector("input").value * fila.cells[3].querySelector("input").value ;
        console.log("nuevacant: ",input.value);
    }

    function borrar(e){
        e.preventDefault();
        document.getElementById("texto").value="";
        document.getElementById("borrar").style="display:none";
        document.getElementById("resultadobusq").innerHTML="";
    }
    function cambiaorigen(){
        tabladet=document.getElementById("detalleventa");
        document.getElementById("formuventa").reset();
        while(tabladet.rows.length>1){
            tabladet.deleteRow(-1);
        }
    }

</script>
@endsection