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
    <h1 class="card-header">Registrar Compra</h1> <br>   
    <input type="hidden" id="id_usr" value="{{session('usr')->id}}">
    <form action="" method="post" id="formu">
        @csrf
        <div class="cabeceraventa">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Para Deposito</span>
                <select class="form-select" aria-label="Default select example" id="deposito" style="background: aliceblue" onchange="cambiadeposito()">
                    @foreach ($depositos as $undepot)
                        <option value="{{$undepot->id}}">{{$undepot->nombre}}</option>
                    @endforeach
                </select>
                {{-- <div class="input-group mb-3">
                    <div class="input-group mb-3">
                        <input type="hidden" name="idvendedor" id="idvendedor" value='132'>
                        <span class="input-group-text" id="basic-addon2">Comprador</span>
                        <input type="text" class="form-control" placeholder="Buscar vendedor" id="vendedor" style="background: lightyellow" value="Tienda Cbba">
                        <a href="" class="btn btn-secondary" id="borrarvendedor" style="display:none" onclick="borrarvendedor(event)">X</a>
                        <div class="resultadobusq2" id="resultadobusq2"></div>
                    </div>
                    
                </div> --}}
            </div>
            
            
        </div>
        
    
    <br>
    <div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar producto" id="texto" autofocus>
            <a href="" class="btn btn-secondary" id="borrar" style="display:none" onclick="borrar(event)">X</a>
            <span class="input-group-text" id="basic-addon2">Buscar</span>
            <div class="resultadobusq" id="resultadobusq"></div>
        </div>
        <table class="table table-stripped table-hover" id="detallecompra" >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Producto</th>
                <th scope="col">PrecioCompra</th>
                <th scope="col">PrecioVenta</th>
                <th scope="col">Comision</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Subtotal</th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
          </table>
          <table class="table">
              <tr><td></td><td></td><td></td><td></td><td></td><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: <input type="number" name="total" id="total" value="0" style="text-align:right;font-weight:bold"></td>
                {{-- <td id="total" style="text-align:right;font-weight:bold;font-size:1.5em">
                    0
                </td> --}}
            </tr>
          </table>
          
    </div >
    <br>
        <div class="complementos">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">*Proveedor</span>
                <select name="proveedor" id="proveedor" class="form-control">
                    @foreach ($proveedores as $unprov)
                        <option value="{{$unprov->nombre}}">{{$unprov->nombre}}</option>
                    @endforeach
                </select>
                {{-- <input type="text" class="form-control" aria-label="Sizing example input" id="proveedor" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO"> --}}
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">NIT</span>
                <input type="text" class="form-control" id="nit" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Pago con</span>
                <select class="form-select" aria-label="Default select example" id="formapago" onchange="cambiapago()">
                    <option value="contado">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="cheque">Cheque</option>
                    <option value="deposito">Depósito</option>
                    <option value="transferencia">Transferencia</option>
                    <option value="credito">Credito</option>  
                </select>
                <span class="input-group-text" id="inputGroup-sizing-sm">Factura</span>
                <input type="text" class="form-control" id="factura" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">

              </div>
              <div class="input-group mb-3" style="display:none" id="divcredito">
                    <table>
                        <tr>
                            <td>
                              <span class="input-group-text" id="inputGroup-sizing-sm">A cuenta</span>
                              <input type="number" class="form-control" id="monto" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value="0">
                            </td>
                            <td>
                              <span class="input-group-text" id="inputGroup-sizing-sm">TipoPago</span>
                              <select class="form-select" aria-label="Default select example" id="tipopago" >
                                  <option value="contado">Efectivo</option>
                                  <option value="tarjeta">Tarjeta</option>
                                  <option value="cheque">Cheque</option>
                                  <option value="deposito">Depósito</option>
                                  <option value="transferencia">Transferencia</option>
                              </select>
                            </td>
                            <td>
                              <span class="input-group-text" id="inputGroup-sizing-sm">Observación</span>
                              <input type="text" class="form-control" id="observacion" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </td>
                        </tr>
                    </table>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Comentario</span>
                <input type="text" class="form-control" id="comentario" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
              </div>
        </div>
    </form>
        <div class="col-12" style="text-align: center">
            <a href="{{route('compras.index')}}" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" onclick="guardacompra(this)" id="btnguardar">Registrar Compra y Actualizar Inventario</button>
        </div>
</div>
<script>
    window.addEventListener("load",function(){
        console.log("pagina cargada");
        casbusq=document.getElementById("texto");
        casbusq.addEventListener("keyup",function(){
            dep=document.getElementById("deposito").value;
            console.log("dep: ",dep);
            if(casbusq.value.length>1){
                document.getElementById("borrar").style="display:block";
                fetch("buscaprod?texto="+casbusq.value+"&dep="+dep,{method:"get"})
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
    function guardacompra(btn){
        btn.disabled=true;
        tabla=document.getElementById("detallecompra");
        nrofilas=tabla.rows.length;
        if(document.getElementById("proveedor").value==""){
            alert("Formulario Incompleto \r\nDebe haber al menos un producto en compra y el proveedor no puede estar en blanco");
        }
        else{
            dataenvio=[];
            prods=[];
            for(i=1;i<nrofilas;i++){
                unprod={idprod:tabla.rows[i].cells[0].querySelector("input").value,preciolocal:tabla.rows[i].cells[2].querySelector("input").value,precioventa:tabla.rows[i].cells[3].querySelector("input").value,comision:tabla.rows[i].cells[4].querySelector("input").value,cuantos:tabla.rows[i].cells[5].querySelector("input").value,descripcion:tabla.rows[i].cells[1].innerText};
                prods.push(unprod);
            }
            credito="";
            if(document.getElementById("formapago").value=="credito"){
                credito={monto:document.getElementById("monto").value,tipopago:document.getElementById("tipopago").value,observacion:document.getElementById("observacion").value}
            }
            
            dataenvio=[{proveedor:document.getElementById("proveedor").value,nit:document.getElementById("nit").value,detalle:prods,total:document.getElementById("total").value,idusr:document.getElementById("id_usr").value,formapago:document.getElementById("formapago").value,factura:document.getElementById("factura").value, comentario:document.getElementById("comentario").value,idneg:document.getElementById("deposito").value,credito:credito}];
            console.log(" a guardar: ",dataenvio);
            fetch('guardanuevacompra', {
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
                alert(" REGISTRADA");
                document.getElementById("btnguardar").disabled=false;
                tabladet=document.getElementById("detallecompra");
                document.getElementById("formu").reset();
                while(tabladet.rows.length>1){
                    tabladet.deleteRow(-1);
                }
                document.getElementById("total").innerText="0";
                document.getElementById("divcredito").style.display="none";
                // window.location.replace("{{route('nuevaventa')}}");
            });
        }
        
    }
    function elegido(id,descr,precioventa,preciolocal,comision,cantidad){
        console.log(id,descr);
        tabla=document.getElementById("detallecompra");
        nro=tabla.rows.length;
        fila=tabla.insertRow();
        celda=fila.insertCell();
        celda.innerHTML="<span style='color:red;cursor:pointer' onclick='elimina(this)'>X</span>&nbsp" + nro+"<input type='hidden' value='"+id+"' name='id_"+nro+"' id='id_"+nro+"'>";
        celda=fila.insertCell();
        celda.innerHTML=descr;
        fila.title="Actualmente #"+cantidad;
        celda=fila.insertCell();
        celda.innerHTML="<input type='number' value='"+preciolocal+"' name='pc_"+nro+"' id='pc_"+nro+"'  class='form-control' style='text-align:right'>";
        celda=fila.insertCell();
        celda.style.width="9em";
        celda.innerHTML="<input type='number' value='"+precioventa+"' name='pfinal_"+nro+"' id='pfinal_"+nro+"' onchange='cambiacant(this)'  class='form-control' style='text-align:right'>";
        celda=fila.insertCell();
        celda.style.width="9em";
        celda.innerHTML="<input type='number' value='"+comision+"' name='com_"+nro+"' id='com_"+nro+"' class='form-control' style='text-align:right'>";
        celda=fila.insertCell();
        celda.style.width="7em";
        celda.innerHTML="<input type='number' value='1' name='c_"+nro+"' id='c_"+nro+"' onchange='cambiacant(this)'  class='form-control' style='text-align:center'>";
        celda=fila.insertCell();
        celda.style.textAlign="right";
        celda.innerText=preciolocal;
        document.getElementById("resultadobusq").innerHTML="";
        document.getElementById("texto").value="";
        calculatotal();
    }
    function elimina(prod){
        
        fila=prod.parentElement.parentElement.rowIndex;
        document.getElementById("detallecompra").deleteRow(fila);
    }
    function cambiadeposito(){
        tabla=document.getElementById("detallecompra");
        while(tabla.rows.length>1){
            tabla.deleteRow(-1);
        }
        document.getElementById("total").value=0;
    }
    function vendedorelegido(id,nombre){
        document.getElementById("vendedor").value=nombre;
        document.getElementById("idvendedor").value=id;
        document.getElementById("resultadobusq2").innerHTML="";
        document.getElementById("borrarvendedor").style="display:none";
        document.getElementById("resultadobusq2").style.display="none";

    }
    function cambiacant(input){
        celda=input.parentElement;
        fila=celda.parentElement;
        fila.cells[6].innerText=(fila.cells[2].querySelector("input").value * fila.cells[5].querySelector("input").value).toFixed(2);
        console.log("nuevacant: ",input.value);
        calculatotal();
    }
    function calculatotal(){
        total=0;
        tabla=document.getElementById("detallecompra");
        nro=tabla.rows.length;
        for(k=1;k<nro;k++){
            total=total + tabla.rows[k].cells[6].innerText*1;
        }
        document.getElementById("total").value=total.toFixed(2);
    }
    function borrar(e){
        e.preventDefault();
        document.getElementById("texto").value="";
        document.getElementById("borrar").style="display:none";
        document.getElementById("resultadobusq").innerHTML="";
    }
    function borrarvendedor(e){
        e.preventDefault();
        document.getElementById("resultadobusq2").style.display="none";
        document.getElementById("vendedor").value="Tienda";
        document.getElementById("idvendedor").value="136";
        document.getElementById("borrarvendedor").style="display:none";
        document.getElementById("resultadobusq2").innerHTML="";
    }
    function cambiapago(){
        console.log("formapago: ",document.getElementById("formapago").value);
        formap=document.getElementById("formapago").value;
        if(formap=="credito"){
            document.getElementById("divcredito").style="background: lightsteelblue;display:flex;justify-content:center;";
        }
        else{
            document.getElementById("divcredito").style.display="none";
        }
    }
</script>
@endsection
