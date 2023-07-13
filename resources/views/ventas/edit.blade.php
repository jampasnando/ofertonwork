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
    <h1 class="card-header">Modificar Venta</h1> <br>   
    <form action="" method="post" id="formuventa">
        @csrf
        <input type="hidden" name="id_venta" id="id_venta" value="{{$unaventa[0]->idventa}}">
        <div class="cabeceraventa">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Deposito</span>
                <select class="form-select" aria-label="Default select example" id="deposito" style="background: aliceblue" disabled>
                    @foreach ($depositos as $undepot)
                        <option value="{{$undepot->id}}" {{$unaventa[0]->idneg==$undepot->id?"selected":""}}>{{$undepot->nombre}}</option>
                    @endforeach
                </select>
                <div class="input-group mb-3">
                    <div class="input-group mb-3">
                        <input type="hidden" name="idvendedor" id="idvendedor" value='{{$unaventa[0]->vendedor}}'>
                        <span class="input-group-text" id="basic-addon2">Vendedor</span>
                        <input type="text" class="form-control" placeholder="Buscar vendedor" id="vendedor" style="background: lightyellow" value="{{$unaventa[0]->nombre}}">
                        <a href="" class="btn btn-secondary" id="borrarvendedor" style="display:none" onclick="borrarvendedor(event)">X</a>
                        <div class="resultadobusq2" id="resultadobusq2"></div>
                    </div>
                    
                </div>
            </div>
            
            
        </div>
        
    
    <br>
    <div>
        <table class="table table-stripped table-hover" id="tb_modifventa" >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Producto</th>
                <th scope="col">ComisionUnit</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
               
                <th scope="col">Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
             @foreach ($detalle as $undet)
                 <tr>
                     <td>{{$loop->iteration}} <input type="hidden" id="id_det" name="id_det" value="{{$undet->id}}"></td>
                     <td>{{$undet->descripcion}}</td>
                     <td><input type="number" name="com_{{$loop->iteration}}" id="com_{{$loop->iteration}}" value="{{$undet->comision}}"></td>
                     <td><input type="number" name="pf_{{$loop->iteration}}" id="pf_{{$loop->iteration}}" value="{{$undet->preciofinal}}" onchange='cambiacant(this)'></td>
                     <td><input type="number" name="cant_{{$loop->iteration}}" id="cant_{{$loop->iteration}}" value="{{$undet->cuantos}}" onchange='cambiacant(this)'></td>
                    
                     <td>{{$undet->preciofinal*$undet->cuantos}}</td>
                 </tr>
             @endforeach
             <tr style="line-height: 3em;"><td></td><td></td><td></td><td></td><td style="font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="font-weight:bold;font-size:1.5em">0</td></tr>
            </tbody>
          </table>
          <table class="table">
             
          </table>
          
    </div >
    <br>
        {{-- <div class="complementos">
              <div class="row">
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">*Cliente</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" id="cliente" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO" value='{{$unaventa[0]->cliente}}'>
                      </div>
                </div>
                <div class="col">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">*Telefono</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" id="telefono" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO" value='{{$unaventa[0]->telefono}}'>
                      </div>
                </div>
            </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">NIT</span>
                <input type="text" class="form-control" id="nit" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value={{$unaventa[0]->nit}}>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Pago con</span>
                <select class="form-select" aria-label="Default select example" id="formapago">
                    <option value="contado" {{$unaventa[0]->formapago=="contado"?"selected":""}}>Efectivo</option>
                    <option value="tarjeta" {{$unaventa[0]->formapago=="tarjeta"?"selected":""}}>Tarjeta</option>
                    <option value="cheque" {{$unaventa[0]->formapago=="cheque"?"selected":""}}>Cheque</option>
                    <option value="deposito" {{$unaventa[0]->formapago=="deposito"?"selected":""}}>Depósito</option> 
                    <option value="transferencia" {{$unaventa[0]->formapago=="transferencia"?"selected":""}}>Transferencia</option> 
                    <option value="credito" {{$unaventa[0]->formapago=="credito"?"selected":""}}>Crédito</option>
                </select>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Comentario</span>
                <input type="text" class="form-control" id="comentario" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" value='{{$unaventa[0]->comentario}}'>
              </div>
        </div> --}}
        <div class="complementos">
            <div class="row">
                <div class="col-8">
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm" style="background: lemonchiffon">Recibido</span>
                        <input type="number" class="form-control" aria-label="Sizing example input" id="recibido" aria-describedby="inputGroup-sizing-sm"  title="RECIBIDO" onkeyup="recibidocambio()">
                        <span class="input-group-text" id="inputGroup-sizing-sm" style="background: lemonchiffon">Cambio</span>
                        <input type="number" class="form-control" aria-label="Sizing example input" id="cambio" aria-describedby="inputGroup-sizing-sm"  title="CAMBIO" readonly>
                    </div>
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm">*Cliente</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" id="cliente" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" readonly value="{{$unaventa[0]->cliente}}">
                        <span class="input-group-text" style="cursor:pointer;background:gray;color:white;" onclick="document.getElementById('cliente').value='';document.getElementById('telefono').value='';document.getElementById('nit').value='';" title="Borra campos cliente,teléfono y nit">X</span>
                        <span class="input-group-text bg-warning" data-bs-toggle="modal" data-bs-target="#modalnuevocli" style="cursor:pointer;">+</span>
                        <input type="hidden" id="idcliente"  value="333">
                      </div>
                      <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm" >*Telefono</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" id="telefono" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO" readonly  value="{{$unaventa[0]->telefono}}">
                      </div>
                      <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm" >NIT</span>
                        <input type="text" class="form-control " id="nit" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly  value="{{$unaventa[0]->nit}}">
                            <span class="input-group-text" style="margin-left: 5px;" id="inputGroup-sizing-sm">Fecha</span>
                            <input type="text" class="form-control text-center" id="fechax" autocomplete="off" readonly placeholder="HOY"  value="{{$unaventa[0]->fecha}}">
                    </div>
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Comentario</span>
                        <input type="text" class="form-control" id="comentario" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm"  value="{{$unaventa[0]->comentario}}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        <input type="hidden" name="json" id="json" value="{{$unaventa[0]->pagomixto}}">
                        <div class="col-8 w-100">
                            <div class="input-group mb-3">
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >Efectivo</span>
                                    <input type="number" value="{{$unaventa[0]->formapago=="efectivo" || $unaventa[0]->formapago=="contado" ? $unaventa[0]->pago:"0"}}" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="efectivo" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >Tarjeta</span>
                                    <input type="number" value="{{$unaventa[0]->formapago=="tarjeta" ? $unaventa[0]->pago:"0"}}" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="tarjeta" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >Cheque</span>
                                    <input type="number" value="{{$unaventa[0]->formapago=="cheque" ? $unaventa[0]->pago:"0"}}" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="cheque" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >Depósito</span>
                                    <input type="number" value="{{$unaventa[0]->formapago=="deposito" ? $unaventa[0]->pago:"0"}}" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="depositobancario" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >Transferencia</span>
                                    <input type="number" value="{{$unaventa[0]->formapago=="transferencia" ? $unaventa[0]->pago:"0"}}" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="transferencia" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >QR</span>
                                    <input type="number" value="{{$unaventa[0]->formapago=="qr" ? $unaventa[0]->pago:"0"}}" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="qr" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50 bg-info fw-bold" id="inputGroup-sizing-sm" >Pagado</span>
                                    <input type="number" value="0" class="form-control bg-info fw-bold" style="text-align:right;" aria-label="Sizing example input" id="totalformapago" aria-describedby="inputGroup-sizing-sm" readonly>
                                </div>
                                <div class="input-group" id="divcredito">
                                    <span class="input-group-text w-50 fw-bold" style="background: hotpink;" id="inputGroup-sizing-sm" >Crédito</span>
                                    <input type="number" value="0" class="form-control fw-bold" style="text-align:right;background:hotpink" aria-label="Sizing example input" id="credito" aria-describedby="inputGroup-sizing-sm" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">    
                    
                </div>
                <div class="col" style="background:lightblue;" id="divformaspago">
                    
                   
                    <div id="acredito" class="d-none">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-sm" >A cuenta</span>
                                    <input type="number" class="form-control" aria-label="Sizing example input" id="pago" aria-describedby="inputGroup-sizing-sm" value="0" onkeyup="recalculasaldo()">
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Forma</span>
                                    <select class="form-select" aria-label="Default select example" id="formapagoacuenta">
                                        <option value="contado">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="cheque">Cheque</option> 
                                        <option value="deposito">Depósito</option> 
                                        <option value="transferencia">Transferencia</option> 
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm" >Saldo</span>
                            <input type="number" class="form-control" aria-label="Sizing example input" id="saldo" aria-describedby="inputGroup-sizing-sm" value="0" readonly>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </form>
        <div class="col-12" style="text-align: center">
            <a href="{{route('ventas.index')}}" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-warning" onclick="eliminaventa()">ELIMINAR ESTA VENTA</button>
            <button class="btn btn-primary" onclick="guardaventa()">GUARDAR CAMBIOS</button>
        </div>
        <form action="eliminaventa" method="post" id="form_eliminaventa">
            @csrf
            <input type="hidden" name="id_vtaelim" id="id_vtaelim" value="{{$unaventa[0]->idventa}}">
        </form>
</div>
<script>
    window.addEventListener("load",function(){
        casbusq2=document.getElementById("vendedor");
        if(document.getElementById("json").value!="null" && document.getElementById("json").value!=""){
            elmixto=JSON.parse(document.getElementById("json").value);
            console.log("elmixto: ",elmixto);
            Object.entries(elmixto).forEach(unmixto => {
                [key,value]=unmixto;
                if(key=="deposito"){key="depositobancario"};
                document.getElementById(key).value=value;
            });
        }
       
        // calculatotal();
        casbusq2.addEventListener("keyup",function(){
            if(casbusq2.value.length>1){
                document.getElementById("borrarvendedor").style="display:block";
                fetch("buscavendedor?vendedor="+casbusq2.value,{method:"get"})
                .then(response=>response.text())
                .then(datos=>{
                    document.getElementById("resultadobusq2").style.display="block";
                    document.getElementById("resultadobusq2").innerHTML=datos;
                });
            }
            else{
                document.getElementById("resultadobusq2").style.display="none";
                document.getElementById("resultadobusq2").innerHTML="";
            }
        });
        casbusq2.addEventListener("blur",function(){
            if(casbusq2.value.length==0){
                borrarvendedor(event);
            }
        });
       calculatotal();
    });
    function guardaventa(){
        
        tabla=document.getElementById("tb_modifventa");
        nrofilas=tabla.rows.length;
        if(nrofilas==1 || document.getElementById("cliente").value==""){
            alert("Formulario Incompleto \r\nDebe haber al menos un producto en venta y el cliente no puede estar en blanco");
        }
        else{
            dataenvio=[];
            prods=[];
            for(i=1;i<nrofilas-1;i++){
                unprod={
                    id_det:tabla.rows[i].cells[0].querySelector("input").value,
                    preciofinal:tabla.rows[i].cells[3].querySelector("input").value,
                    cuantos:tabla.rows[i].cells[4].querySelector("input").value,
                    comision:tabla.rows[i].cells[2].querySelector("input").value
                };
                prods.push(unprod);
            }
            pagomixto={};
            contformaspago=0;
            pagox=0;
            if(xefectivo>0){pagomixto={...pagomixto,efectivo:xefectivo};formapagox="efectivo";contformaspago++;pagox+=xefectivo;}
            if(xtarjeta>0){pagomixto={...pagomixto,tarjeta:xtarjeta};formapagox="tarjeta";contformaspago++;pagox+=xtarjeta;}
            if(xcheque>0){pagomixto={...pagomixto,cheque:xcheque};formapagox="cheque";contformaspago++;pagox+=xcheque;}
            if(xdepositobancario>0){pagomixto={...pagomixto,deposito:xdepositobancario};formapagox="deposito";contformaspago++;pagox+=xdepositobancario;}
            if(xtransferencia>0){pagomixto={...pagomixto,transferencia:xtransferencia};formapagox="transferencia";contformaspago++;pagox+=xtransferencia;}
            if(xqr>0){pagomixto={...pagomixto,qr:xqr};formapagox="qr";contformaspago++;pagox+=xqr;}
            if(xcredito>0){pagomixto={...pagomixto,credito:xcredito};formapagox="credito";contformaspago++;}
            if(contformaspago>1){formapagox="mixto";}
            saldox=total - pagox;
            dataenvio=[
                {
                    cliente:document.getElementById("cliente").value,
                    telefono:document.getElementById("telefono").value,
                    nit:document.getElementById("nit").value,
                    vendedor:document.getElementById("idvendedor").value,
                    detalle:prods,
                    total:document.getElementById("total").innerText,
                    formapago:formapagox,
                    comentario:document.getElementById("comentario").value,
                    idneg:document.getElementById("deposito").value,
                    idventa:document.getElementById("id_venta").value,
                    pago:pagox,
                    saldo:saldox,
                    pagomixto:JSON.stringify(pagomixto)
                }
            ];
            console.log("venta a guardar: ",dataenvio);
            fetch('actualizaventa', {
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
                if(res=="registrado"){
                    alert("CAMBIOS REGISTRADO, PUEDE IR A OTRO MENÚ");
                }
            });
        }
        
    }
    function elimina(prod){
        
        fila=prod.parentElement.parentElement.rowIndex;
        document.getElementById("tb_modifventa").deleteRow(fila);
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
        fila.cells[5].innerText=fila.cells[3].querySelector("input").value * fila.cells[4].querySelector("input").value ;
        console.log("nuevacant: ",input.value);
        calculatotal();
        
    }
    function calculatotal(){
        total=0;
        tabla=document.getElementById("tb_modifventa");
        nro=tabla.rows.length;
        for(k=1;k<nro-1;k++){
            total=total + tabla.rows[k].cells[5].innerText*1;
        }
        document.getElementById("total").innerText=total;
        recalculatotalformapago();
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
    function eliminaventa(){
        if(confirm("ESTÁ SEGURO DE ELIMINAR ESTA VENTA? \n\r se devolverá al inventario las cantidades Originales de esta venta eliminada")){
            
            document.getElementById("form_eliminaventa").submit();
        }
    }
    function recalculasaldo(){
        document.getElementById("saldo").value=parseFloat(document.getElementById("total").innerText) - parseFloat(document.getElementById("pago").value);
    }
    function recalculatotalformapago(){
        xefectivo=parseFloat(document.getElementById("efectivo").value);
        xtarjeta=parseFloat(document.getElementById("tarjeta").value);
        xcheque=parseFloat(document.getElementById("cheque").value);
        xdepositobancario=parseFloat(document.getElementById("depositobancario").value);
        xtransferencia=parseFloat(document.getElementById("transferencia").value);
        xqr=parseFloat(document.getElementById("qr").value);
        
        totalformaspago=(xefectivo + xtarjeta + xcheque + xdepositobancario + xtransferencia +xqr).toFixed(2);
        document.getElementById("totalformapago").value=totalformaspago;
        console.log("totales: ",total, totalformaspago);
        if(total==totalformaspago){
            console.log("entra iguales");
            // document.getElementById("divformaspago").style.background="lightblue";
            document.getElementById("credito").value=0;
            // document.getElementById("divcredito").style.display="none";
        }
        else{
            console.log("entra desiguales");
            // document.getElementById("divformaspago").style.background="orangered";
            document.getElementById("credito").value=total-totalformaspago;
            // document.getElementById("divcredito").style.display="";
        }
        xcredito=parseFloat(document.getElementById("credito").value);

    }
</script>
@endsection
