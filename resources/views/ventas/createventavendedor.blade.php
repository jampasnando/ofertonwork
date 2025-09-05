@extends('layouts.plantillavendedor')
<style>
    #tablaclis td{
        border-right: 1px solid lightgray;
        padding: 0 5px;
    }
</style>
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
    <h4 class="card-header">Registrar Venta</h4> <br>
    <div class="reservas">
        <div class="titres"><h5>Reservas</h5></div>
        <table id="tbreservas">
            <tr>
                <th>Prod</th>
                <th>Cliente</th>
                <th>Celular</th>
                
            </tr>
        </table>
        <div class="divactres"><button onclick="actualizareservas()">Actualizar</button></div>
    </div>
    <div class="cabeceraventa">
        <div class="input-group">
            <input type="hidden" name="depoculot" id="depoculto" value="{{session('usr')->ciudad}}">
            
            <span class="input-group-text" id="inputGroup-sizing-sm">Deposito</span>
            <select class="form-select" aria-label="Default select example" id="deposito" style="background: aliceblue" disabled>
                @foreach ($depositos as $undepot)
                    <option value="{{$undepot->id}}">{{$undepot->nombre}}</option>
                @endforeach
            </select>
            {{-- ////////////////////////////////////////////////// --}}
            <div class="usroriginal">
                <input type="hidden" id="id_usroriginal" value="{{session('usr')->id}}">
                <input type="hidden" id="nom_usroriginal" value="{{session('usr')->nombre}}">
            </div>
            <div class="input-group">
                <div class="input-group">
                    <input type="hidden" name="idvendedor" id="idvendedor" value='{{session('usr')->id}}'>
                    <input type="hidden" name="idusr" id="idusr" value="{{session('usr')->id}}">
                    <span class="input-group-text" id="basic-addon2">Vendedor</span>
                    <input type="text" class="form-control" placeholder="Buscar vendedor" id="vendedor" style="background: lightyellow" value="{{session('usr')->nombre}}">
                    <a href="" class="btn btn-secondary" id="borrarvendedor" style="display:none" onclick="borrarvendedor(event)">X</a>
                    <div class="resultadobusq2" id="resultadobusq2"></div>
                </div>
                
            </div>
            {{-- ////////////////////////////////////////////////// --}}

        </div>
        
        
    </div> 
    <form action="" method="post" id="formuventa" class="mt-3">
        @csrf
    <div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Buscar producto" id="texto" autofocus>
            <a href="" class="btn btn-secondary" id="borrar" style="display:none" onclick="borrar(event)">X</a>
            {{-- <span class="input-group-text" id="basic-addon2">Buscar</span> --}}
            <button class="btn border" onclick="buscar()">Buscar</button>
            <div class="resultadobusq" id="resultadobusq"></div>
        </div>
        <table class="table table-stripped table-hover" id="detalleventa" >
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Subtotal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
             
            </tbody>
          </table>
          <table class="table">
              <tr><td></td><td style="text-align:right;font-weight:bold;font-size:1.5em">Total: </td><td id="total" style="text-align:right;font-weight:bold;font-size:1.5em">0</td></tr>
          </table>
          
    </div >
        {{-- <div class="row">
            <div class="col">
                <div class="input-group mb-1">
                   
                </div>
            </div>
            <div class="col">
                <div class="input-group mb-1">
                    
                </div>
            </div>
            <div class="col">
               
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
                        <input type="text" class="form-control" aria-label="Sizing example input" id="cliente" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO" data-bs-toggle="modal" data-bs-target="#exampleModalCenter" readonly>
                        <span class="input-group-text" style="cursor:pointer;background:gray;color:white;" onclick="document.getElementById('cliente').value='';document.getElementById('telefono').value='';document.getElementById('nit').value='';" title="Borra campos cliente,teléfono y nit">X</span>
                        <span class="input-group-text bg-warning" data-bs-toggle="modal" data-bs-target="#modalnuevocli" style="cursor:pointer;">+</span>
                        <input type="hidden" id="idcliente"  value="333">
                      </div>
                      <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm" >*Telefono</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" id="telefono" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO" readonly>
                      </div>
                      <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm" >*Rubro</span>
                        <input type="text" class="form-control" aria-label="Sizing example input" id="rubro" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO" readonly>
                      </div>
                      <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm" >NIT</span>
                        <input type="text" class="form-control " id="nit" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" readonly>
                            <span class="input-group-text" style="margin-left: 5px;" id="inputGroup-sizing-sm">Fecha</span>
                            <input type="text" class="form-control text-center" id="fechax" autocomplete="off" readonly placeholder="HOY">
                    </div>
                    <div class="input-group mb-1">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Comentario</span>
                        <input type="text" class="form-control" id="comentario" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                    </div>
                </div>
                <div class="col-4">
                    <div class="row">
                        {{-- <div class="col-4 h-100 bg-warning">
                            <span class="input-group-text bg-transparent" id="inputGroup-sizing-sm">Pago con:</span>
                        </div> --}}
                        <div class="col-8 w-100">
                            <div class="input-group mb-3">
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >Efectivo</span>
                                    <input type="number" value="0" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="efectivo" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >Tarjeta</span>
                                    <input type="number" value="0" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="tarjeta" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >Cheque</span>
                                    <input type="number" value="0" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="cheque" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >Depósito</span>
                                    <input type="number" value="0" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="depositobancario" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >Transferencia</span>
                                    <input type="number" value="0" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="transferencia" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50" id="inputGroup-sizing-sm" >QR</span>
                                    <input type="number" value="0" onkeyup="recalculatotalformapago()" onchange="recalculatotalformapago()" class="form-control" style="text-align:right;" aria-label="Sizing example input" id="qr" aria-describedby="inputGroup-sizing-sm">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text w-50 bg-info fw-bold" id="inputGroup-sizing-sm" >Pagado</span>
                                    <input type="number" value="0" class="form-control bg-info fw-bold" style="text-align:right;" aria-label="Sizing example input" id="totalformapago" aria-describedby="inputGroup-sizing-sm" readonly>
                                </div>
                                <div class="input-group" id="divcredito" style="display: none;">
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
            <a href="{{route('nuevaventavendedor')}}" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" onclick="guardaventa()" id="btnguardar">Registrar Venta</button>
        </div>
</div>
<button data-bs-toggle="modal" data-bs-target="#alertarebaja" style="display:none;" id="btnalerta"></button>
{{-- ////////////////////////////////////////////////////////////// MODAL REBAJA DE PRECIO /////////////////////////////////////////////////////////////////////// --}}
<div class="modal fade" id="alertarebaja" tabindex="-1" role="dialog" aria-labelledby="alertarebaja" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content" style="background: red;color:white;">
        <div class="modal-header">
            <h5 class="modal-title">Aviso</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="equisequis">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <h4>ESTE PRODUCTO ESTÁ SIENDO REBAJADO A MÁS DEL 10%, SE PONDRÁ UN COMENTARIO DESCRIPTIVO AL GUARDAR LA VENTA</h4>
        </div>
        
      </div>
    </div>
    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}
  </div>
{{-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
{{-- ////////////////////////////////////////////////////////////// MODAL BUSCA CLIENTE /////////////////////////////////////////////////////////////////////// --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <input type="text" class="form-control" id="buscacli" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" onkeypress="cambiatxt(event,this)" placeholder="Buscar cliente...">
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="equis">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="tablaclis"></table>
        </div>
        
      </div>
    </div>
  </div>
{{-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
{{-- ////////////////////////////////////////////////////////////// MODAL NUEVO CLIENTE /////////////////////////////////////////////////////////////////////// --}}
<div class="modal fade" id="modalnuevocli" tabindex="-1" role="dialog" aria-labelledby="modalnuevocliTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Nuevo Cliente</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="equiscli">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >*Nombre</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="nuevocli" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Telf</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="nuevotelf" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >NIT</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="nuevonit" aria-describedby="inputGroup-sizing-sm"  required title="REQUERIDO">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Rubro</span>
                <select class="form-select" aria-label="Default select example" id="nuevorubro" style="background: aliceblue">
                    <option value="">--Elije una opción--</option>
                    <option value="Carpinteria madera aluminio">Carpinteria madera aluminio </option>
                    <option value="⁠Cerrajería o Soldador">⁠Cerrajería o Soldador </option>
                    <option value="⁠Hobby">⁠Hobby </option>
                    <option value="⁠Construcción">⁠Construcción </option>
                    <option value="⁠Jardinería">⁠Jardinería</option>
                    <option value="Agronomía">Agronomía</option>
                    <option value="⁠Mecánica ">⁠Mecánica </option>
                    <option value="⁠otros">⁠otros</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Dirección</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="nuevadir" aria-describedby="inputGroup-sizing-sm"  required title="REQUERIDO">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-success" onclick="guardanuevocli()" id="btnguardarcli">Registrar Nuevo Cliente</button>
        </div>
      </div>
    </div>
  </div>
{{-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
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
        var modalalerta = document.getElementById('alertarebaja');
    }
    window.addEventListener("load",function(){
        console.log("pagina cargada");
        casbusq=document.getElementById("texto");
        document.getElementById("deposito").value=document.getElementById("depoculto").value;
        // casbusq.addEventListener("keyup",function(){
        //     dep=document.getElementById("deposito").value;
        //     console.log("dep: ",dep);
        //     if(casbusq.value.length>1){
        //         document.getElementById("borrar").style="display:block";
        //         fetch("buscaprod?texto="+casbusq.value+"&dep="+dep,{method:"get"})
        //         .then(response=>response.text())
        //         .then(datos=>{
        //         document.getElementById("resultadobusq").innerHTML=datos;
        //         });
        //     }
        //     else{
        //         document.getElementById("resultadobusq").innerHTML="";
        //     }
        // });
        casbusq.addEventListener("keypress",function(event){
            if(event.key==="Enter"){
                event.preventDefault();
                dep=document.getElementById("deposito").value;
                console.log("dep: ",dep);
                if(casbusq.value.length>1){
                    document.getElementById("borrar").style="display:block";
                    fetch("buscaprod?texto="+casbusq.value+"&dep="+dep,{method:"get"})
                    .then(response=>response.text())
                    .then(datos=>{
                        console.log("datosbuscados: ",datos);
                    document.getElementById("resultadobusq").innerHTML=datos;
                    });
                }
                else{
                    document.getElementById("resultadobusq").innerHTML="";
                }
            }
            
        });
        casbusq2=document.getElementById("vendedor");
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
       obtienereservas();

       document.getElementById("exampleModalCenter").addEventListener('shown.bs.modal', () => {
            console.log("modalvisible...");
            tablaclis=document.getElementById("tablaclis");
                while(tablaclis.rows.length>0){
                    tablaclis.deleteRow(-1);
                }
            document.getElementById("buscacli").value="";
            document.getElementById("buscacli").focus();
        });

        document.getElementById("modalnuevocli").addEventListener('shown.bs.modal', () => {
            document.getElementById("nuevocli").value="";
            document.getElementById("nuevotelf").value="";
            document.getElementById("nuevonit").value="";
            document.getElementById("nuevadir").value="";
            document.getElementById("nuevocli").focus();
        });
    //    document.getElementById("formapago").value="contado";
       document.getElementById("acredito").style="display:none";
       document.getElementById("pago").value="0";
       document.getElementById("saldo").value="0";
       document.getElementById("comentario").value="";
       document.getElementById("cliente").value="";
       document.getElementById("telefono").value="";
       document.getElementById("nit").value="";
    });
    function buscar(){
        event.preventDefault();
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
    }
    function recibidocambio(){
        recibido=parseFloat(document.getElementById("recibido").value);
        total==parseFloat(document.getElementById("total").innerText);
        cambio=(recibido-total).toFixed(2);
        document.getElementById("cambio").value=cambio;
    }
    function guardaventa(){
        document.title="venta_"+document.getElementById("deposito").value+"_" + new Date().today() + new Date().timeNow();
        document.getElementById("btnguardar").disabled=true;
        tabla=document.getElementById("detalleventa");
        nrofilas=tabla.rows.length;
        
        if(nrofilas==1 || document.getElementById("cliente").value==""){
            alert("Formulario Incompleto \r\nDebe haber al menos un producto en venta y el cliente no puede estar en blanco");
            document.getElementById("btnguardar").disabled=false;
        }
        else{
            if(msgporcentaje10){
                document.getElementById("comentario").value="**Esta venta contiene uno o más productos REBAJADOS más del 10% | " + document.getElementById("comentario").value;
            }
            dataenvio=[];
            prods=[];
            for(i=1;i<nrofilas;i++){
                comix=tabla.rows[i].cells[5].querySelector("input:nth-child(2)").value;
                preciov_original=tabla.rows[i].cells[5].querySelector("input:first-child").value;
                preciofinalx=tabla.rows[i].cells[2].querySelector("input").value;
                if(preciofinalx<preciov_original){
                    dif=preciov_original - preciofinalx;
                    comix=comix-dif;
                    if(comix<0){comix=0;}
                }
                unprod={idprod:tabla.rows[i].cells[0].querySelector("input").value,preciolocal:tabla.rows[i].cells[1].querySelector("input").value,precioventa:tabla.rows[i].cells[5].querySelector("input:first-child").value,preciofinal:tabla.rows[i].cells[2].querySelector("input").value,cuantos:tabla.rows[i].cells[3].querySelector("input").value,descripcion:"",comision:comix,vendedor:document.getElementById("idvendedor").value,descripcion:tabla.rows[i].cells[1].innerText};
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
            console.log("formaspagox,xformapagos",formapagox,pagomixto);
            // if(document.getElementById("formapago").value=="credito"){
            //     pagox=document.getElementById("pago").value;
            //     saldox=parseFloat(document.getElementById("total").innerText) - parseFloat(document.getElementById("pago").value);
            //     formapagox=document.getElementById("formapago").value;
            // }
            // else{
            //     pagox=this.document.getElementById("total").innerText;
            //     saldox="0";
            //     formapagox=document.getElementById("formapago").value;
            // }
            dataenvio=[
                {
                    cliente:document.getElementById("cliente").value,
                    nit:document.getElementById("nit").value,
                    vendedor:document.getElementById("idvendedor").value,
                    detalleventa:prods,
                    total:document.getElementById("total").innerText,
                    idusr:document.getElementById("idusr").value,
                    formapago:formapagox,
                    comentario:document.getElementById("comentario").value,
                    idneg:document.getElementById("deposito").value,
                    telefono:document.getElementById("telefono").value,
                    idcliente:document.getElementById("idcliente").value,
                    pago:pagox,
                    saldo:saldox,
                    fecha:document.getElementById("fechax").value,
                    pagomixto:JSON.stringify(pagomixto)
                }
            ];
            console.log("venta a guardar: ",dataenvio);
            fetch('guardanuevaventavendedor', {
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
                window.print();
                alert("VENTA REGISTRADA");
                document.getElementById("btnguardar").disabled=false;
                tabladet=document.getElementById("detalleventa");
                document.getElementById("formuventa").reset();
                while(tabladet.rows.length>1){
                    tabladet.deleteRow(-1);
                }
                document.getElementById("idvendedor").value=document.getElementById("id_usroriginal").value;
                document.getElementById("vendedor").value=document.getElementById("nom_usroriginal").value;
                document.getElementById("total").innerText="0";
                
                document.getElementById("acredito").style="display:none";
                document.getElementById("pago").value="0";
                document.getElementById("saldo").value="0";
            });
        }
        
    }
    function elegido(id,descr,precioventa,preciolocal,comision,cantidad,idprod){
        if(cantidad<=0){
            alert("NO HAY STOCK DE ESTE PRODUCTO en el Inventario");
        }
        else{
            console.log(id,descr,idprod);
            tabla=document.getElementById("detalleventa");
            nro=tabla.rows.length;
            fila=tabla.insertRow();
            fila.title="Quedan "+cantidad+ " unidades";
            celda=fila.insertCell();
            celda.innerHTML="<span style='color:red;cursor:pointer' onclick='elimina(this)'>X</span>&nbsp" + nro+"<input type='hidden' value='"+id+"' name='id_"+nro+"' id='id_"+nro+"'><div id='stock_"+nro+"' style='display:none;'>"+cantidad+"</div>";
            celda=fila.insertCell();
            celda.innerHTML=descr + "<input type='hidden' value='"+preciolocal+"' name='pc_"+nro+"' id='pc_"+nro+"'>";
            if(parseFloat(cantidad)<=0){
                celda.style.color="red";
            }
            celda=fila.insertCell();
            celda.style.width="9em";
            celda.innerHTML="<input type='number' value='"+precioventa+"' name='pfinal_"+nro+"' id='pfinal_"+nro+"' onchange='cambiacant(this,1)'  class='form-control' style='text-align:right'>";
            celda=fila.insertCell();
            celda.style.width="7em";
            celda.innerHTML="<input type='number' value='"+(cantidad>0?'1':'0')+"' name='c_"+nro+"' id='c_"+nro+"' onchange='cambiacant(this,0)'  class='form-control' style='text-align:center'>";
            celda=fila.insertCell();
            celda.style.textAlign="right";
            celda.innerText=cantidad>0?precioventa:0;
            celda=fila.insertCell();
            celda.innerHTML="<input type='hidden' value='"+precioventa+"' name='pv_"+nro+"' id='pv_"+nro+"'><input type='hidden' value='"+comision+"' name='com_"+nro+"' id='com_"+nro+"'><input type='hidden' value='"+idprod+"'>";
            document.getElementById("resultadobusq").innerHTML="";
            document.getElementById("texto").value="";
            document.getElementById("texto").focus();
            calculatotal();
            revisareservado(idprod);

        }
    }
    function elimina(prod){
        fila=prod.parentElement.parentElement.rowIndex;
        document.getElementById("detalleventa").deleteRow(fila);
        idprody=prod.parentElement.parentElement.cells[5].querySelector("input:nth-child(3)").value;
        tbr=document.getElementById("tbreservas");
        for(k=1;k<tbr.rows.length;k++){
            idprodx=tbr.rows[k].cells[0].innerText;
            if(idprodx==idprody){
                console.log("hallado en :",k);
                tbr.rows[k].classList.remove("bordeparpadea");
            }
        }
        calculatotal();
        revisarebajas();
    }
    function vendedorelegido(id,nombre){
        document.getElementById("vendedor").value=nombre;
        document.getElementById("idvendedor").value=id;
        document.getElementById("resultadobusq2").innerHTML="";
        document.getElementById("borrarvendedor").style="display:none";
        document.getElementById("resultadobusq2").style.display="none";

    }
    msgporcentaje10=false;
    function cambiacant(input,opcion){
        stock=fila.cells[0].querySelector("div").innerText;
        console.log("stock en cambiacant: ",stock);
        if(opcion==0 && (input.value*1)>stock){
            alert("Esta cantidad sobrepasa el stock disponible de: "+stock+ " unidades");
            input.value=stock<=0?0:1;
            fila.cells[4].innerText=fila.cells[2].querySelector("input").value * fila.cells[3].querySelector("input").value ;
            calculatotal();
            revisarebajas();
        }
        else{
            celda=input.parentElement;
            fila=celda.parentElement;
            fila.cells[4].innerText=fila.cells[2].querySelector("input").value * fila.cells[3].querySelector("input").value ;
            console.log("nuevacant: ",input.value);
            calculatotal();
            revisarebajas();
        }
        
    }
    function revisarebajas(){
        msgporcentaje10=false;
        tabla=document.getElementById("detalleventa");
        nrofilas=tabla.rows.length;
        for(i=1;i<nrofilas;i++){
            preciooriginal=tabla.rows[i].cells[5].querySelectorAll("input")[0].value;
            porcentaje10=preciooriginal*0.1;
            console.log("preciooririnal,porcentje: ",preciooriginal,porcentaje10);
            preciofinal=tabla.rows[i].cells[2].querySelector("input").value;
            if(preciofinal<preciooriginal - porcentaje10){
                console.log("alertará...");
                document.getElementById("btnalerta").click();
                msgporcentaje10=true;
            }
        }
        if(msgporcentaje10){
            document.getElementById("btnalerta").click();
        }
    }
    function calculatotal(){
        total=0;
        tabla=document.getElementById("detalleventa");
        nro=tabla.rows.length;
        for(k=1;k<nro;k++){
            total=total + tabla.rows[k].cells[4].innerText*1;
        }
        document.getElementById("total").innerText=total;
        document.getElementById("efectivo").value=total;
        // document.getElementById("totalformapago").value=total;
        recalculatotalformapago();
        // cambiaformapago();
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
        document.getElementById("idvendedor").value=document.getElementById("id_usroriginal").value;
        document.getElementById("borrarvendedor").style="display:none";
        document.getElementById("resultadobusq2").innerHTML="";
    }
    function obtienereservas(){
        deposito=[{dep:document.getElementById("depoculto").value}];
        fetch('obtienereservas', {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: JSON.stringify(deposito)
            })
            .then(res => res.json())
            .then(res => {
               console.log("desdeserver: ",res);
               tbr=document.getElementById("tbreservas");
               res.forEach(unares => {
                fila=tbr.insertRow();
                celda=fila.insertCell();
                celda.innerText=unares.idprod;
                celda=fila.insertCell();
                celda.innerText=unares.cliente;
                celda=fila.insertCell();
                celda.innerText=unares.celular;
                fila.title=unares.descripcion + "\nVence: "+unares.vence+"\nComentario: "+unares.comentarios+"\nVendedor: "+unares.nombre;
               });
               
            });
    }
    function revisareservado(idprod){
        console.log("revisará: ",idprod);
        tbr=document.getElementById("tbreservas");
        for(k=1;k<tbr.rows.length;k++){
            idprodx=tbr.rows[k].cells[0].innerText;
            if(idprodx==idprod){
                console.log("hallado en :",k);
                tbr.rows[k].classList.add("bordeparpadea");
            }
        }
    }
    function actualizareservas(){
        tbr=document.getElementById("tbreservas");
        while(tbr.rows.length>1){
            tbr.deleteRow(-1);
        }
        obtienereservas();
    }
    function cambiatxt(ev,input){
        if(ev.key==="Enter"){
            console.log("textoclibuscar: ",input.value);
            if(input.value.length>0){
                quebuscar=[{texto:input.value}];
                fetch('buscacliente', {
                method: 'post',
                headers: {
                    'Accept': 'application/json, text/plain, */*',
                    'Content-Type': 'application/json',
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": document.querySelector('input[name="_token"]').value
                },
                credentials: "same-origin",
                body: JSON.stringify(quebuscar)
                })
                .then(res => res.json())
                .then(res => {
                    console.log("clientesDesdeBD: ",res);
                    tablaclis=document.getElementById("tablaclis");
                    while(tablaclis.rows.length>0){
                        tablaclis.deleteRow(-1);
                    }
                    res.forEach(uncli => {
                        filacli=tablaclis.insertRow();
                        // filacli.style="cursor:pointer;";
                        celdacli=filacli.insertCell();
                        celdacli.innerText=uncli.nombre;
                        celdacli=filacli.insertCell();
                        celdacli.innerText=uncli.telefono;
                        celdacli=filacli.insertCell();
                        celdacli.innerText=uncli.nit;
                        celdacli=filacli.insertCell();
                        celdacli.innerText=uncli.id;
                        celdacli.style="display:none;";
                        celdacli=filacli.insertCell();
                        celdacli.innerText=uncli.rubro;
                        filacli.onclick=function(){eligecli(this);};

                    });
                    
                });

            }
        }
        
    }
    function eligecli(elegido){
        console.log("clielegido: ",elegido.cells[0].innerText);
        document.getElementById("equis").click();
        document.getElementById("idcliente").value=elegido.cells[3].innerText;
        document.getElementById("cliente").value=elegido.cells[0].innerText;
        document.getElementById("telefono").value=elegido.cells[1].innerText;
        document.getElementById("nit").value=elegido.cells[2].innerText;
        document.getElementById("rubro").value=elegido.cells[4].innerText;
    }
    function guardanuevocli(){
        console.log("guardará nuevocli");
        nuevocli=document.getElementById("nuevocli").value;
        nuevotelf=document.getElementById("nuevotelf").value;
        nuevonit=document.getElementById("nuevonit").value;
        nuevadir=document.getElementById("nuevadir").value;
        nuevorubro=document.getElementById("nuevorubro").value;
        if(nuevocli!="" && nuevotelf!="" && nuevonit!="" && nuevadir!="" && nuevorubro!=""){
            nuevito=[{nombre:nuevocli,telefono:nuevotelf,nit:nuevonit,direccion:nuevadir,rubro:nuevorubro}];
            fetch('guardanuevocliente2', {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: JSON.stringify(nuevito)
            })
            .then(res => res.json())
            .then(res => {
                console.log("neuvoclidesdeBD: ",res);
                document.getElementById("equiscli").click();
                document.getElementById("idcliente").value=res.id;
                document.getElementById("cliente").value=res.nombre;
                document.getElementById("telefono").value=res.telefono;
                document.getElementById("nit").value=res.nit;
                document.getElementById("rubro").value=res.rubro;
            });
        }
        else{
            alert("Faltan datos. Todos los campos  SON REQUERIDOS");
        }
    }
    function cambiaformapago(){
        // nuevaforma=document.getElementById("formapago").value;
        // console.log("nuevaformapago: ",nuevaforma);
        // if(nuevaforma=="credito"){
        //     document.getElementById("acredito").style="display:block";
        //     document.getElementById("pago").value="0";
        //     document.getElementById("saldo").value=parseFloat(document.getElementById("total").innerText) - parseFloat(document.getElementById("pago").value);

        // }
        // else{
        //     document.getElementById("acredito").style="display:none";
        //     document.getElementById("pago").value="0";
        //     document.getElementById("saldo").value="0";
        // }
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
            document.getElementById("divformaspago").style.background="lightblue";
            document.getElementById("credito").value=0;
            document.getElementById("divcredito").style.display="none";
        }
        else{
            console.log("entra desiguales");
            document.getElementById("divformaspago").style.background="orangered";
            document.getElementById("credito").value=total-totalformaspago;
            document.getElementById("divcredito").style.display="";
        }
        xcredito=parseFloat(document.getElementById("credito").value);

    }
</script>
@endsection