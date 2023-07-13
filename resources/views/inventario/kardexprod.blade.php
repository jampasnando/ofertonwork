@extends(session("usr")->rol=="Enc. Tienda y caja"?"layouts.plantillavendedor":'layouts.plantillabase') 
@section('css')
    <style>
        .compra td{
                background:aliceblue !important;
        }
    </style>
    
@endsection
@section('contenido')
        @if (session("proveliminado"))
        <div class="alert alert-success">{{session("proveliminado")}}</div>
        @endif
        <br>
        <div style="display: flex;justify-content:space-between">
            <div class="titulo">
                <h3>Kardex de</h3>&nbsp;&nbsp;
                <div>
                    <input type="text" class="form-control" aria-label="Sizing example input" id="idprod" aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO" data-bs-toggle="modal" data-bs-target="#modalprod" readonly>
                </div>
                
            </div>
            <div>
                <div class="row row-cols-auto" style="background: lemonchiffon;">
                    <div class="col" id='xdep' style="background: silver;" title="Deposito"></div><div class="col" id='xidprod'></div><div class="col" id='xdesc'></div><div class="col" id='xcant' style="background: lightgreen;" title="Cantidad en stock"></div>
                </div>
            </div>
        </div>

        {{-- <div class="totalesventadeldia">
            <div id="totaltotal">Total: <span></span></div>
            <div id="contado">Contado: <span></span></div>
            <div id="tarjeta">Tarjeta: <span></span></div>
            <div id="cheque">Cheque: <span></span></div>
            <div id="deposito">Depósito: <span></span></div>
            <div id="transferencia">Transferencia: <span></span></div>
            <div id="credito">Crédito: <span></span></div>
        </div>   --}}

        <table class="table table-light " id="tb_kardex">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>Fecha</th>
                    <th>Cuantos</th>
                    <th>PrecioV</th>
                    <th>Cliente</th>
                    <th>Registrador</th>
                    <th>Fecha</th>
                    <th>Cuantos</th>
                    <th>PrecioC</th>
                    <th>Proveedor</th>
                    <th>Registrador</th>
                </tr>
            </thead>
        </table>
        <form action="{{route("ventas.detallev")}}" method="get" id="formufecha">
            @csrf
                <input type="hidden" name="fecha" id="fecha" class="form-control">
        </form>
        <form action="{{route("ventas.editaventa")}}" method="post" id="formuedit">
            @csrf
                <input type="hidden" name="idventa" id="idventa" class="form-control">
        </form>
 {{-- ////////////////////////////////////////////////////////////// MODAL BUSCA PRODUCTO /////////////////////////////////////////////////////////////////////// --}}
<div class="modal fade" id="modalprod" tabindex="-1" role="dialog" aria-labelledby="modalprodTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <input type="text" class="form-control" id="buscaprod" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" onkeyup="cambiatxt(this)" placeholder="Buscar producto...">
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="equis">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table id="tablaprods">
            <thead class="thead-light" style="display:none" id="titbusq">
                <tr>
                    <th style="color:navy;font-weight:bolder;background:silver">DEP</th>
                    <th>CODIGO</th>
                    <th>DESCRIPCIÓN</th>
                </tr>
            </thead>
          </table>
        </div>
        
      </div>
    </div>
  </div>
{{-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}       
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<script>
    window.onload=function(){
        document.getElementById("modalprod").addEventListener('shown.bs.modal', () => {
            console.log("modalvisible...");
            tablaprods=document.getElementById("tablaprods");
                while(tablaprods.rows.length>1){
                    tablaprods.deleteRow(-1);
                }
            document.getElementById("buscaprod").value="";
            document.getElementById("buscaprod").focus();
        });
    }
    function cambiatxt(input){
        console.log("textoclibuscar: ",input.value);
        if(input.value.length>2){
            quebuscar=[{texto:input.value}];
            fetch('buscaprodkardex', {
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
                console.log("productosDesdeBD: ",res);
                tablaprods=document.getElementById("tablaprods");
                if(res.length>0){document.getElementById("titbusq").style="display:block";} else{document.getElementById("titbusq").style="display:none";}
                while(tablaprods.rows.length>1){
                    tablaprods.deleteRow(-1);
                }
                res.forEach(unprod => {
                    filaprod=tablaprods.insertRow();
                    filaprod.style="cursor:pointer;";
                    celdaprod=filaprod.insertCell();
                    celdaprod.innerText=unprod.deposito;
                    celdaprod.style="color:navy;font-weight:bold;background:silver;border:1px solid white;";
                    celdaprod=filaprod.insertCell();
                    celdaprod.innerText=unprod.idprod;
                    celdaprod=filaprod.insertCell();
                    celdaprod.innerText=unprod.descripcion;
                    celdaprod=filaprod.insertCell();
                    celdaprod.innerText=unprod.id;
                    celdaprod.style="display:none;";
                    celdaprod=filaprod.insertCell();
                    celdaprod.innerText=unprod.cantidad;
                    celdaprod.style="display:none;";
                    filaprod.onclick=function(){eligeprod(this);};

                });
                
            });

        }
    }
    function eligeprod(elegido){
        console.log("prodelegido: ",elegido.cells[3].innerText);
        document.getElementById("equis").click();
        document.getElementById("titbusq").style="display:none";
        document.getElementById("xdep").innerText=elegido.cells[0].innerText;
        document.getElementById("xidprod").innerText=elegido.cells[1].innerText;
        document.getElementById("xdesc").innerText=elegido.cells[2].innerText;
        document.getElementById("xcant").innerText=elegido.cells[4].innerText;
        datos=[{id:elegido.cells[3].innerText}];
        fetch('obtienekardexprod', {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: JSON.stringify(datos)
            })
            .then(res => res.json())
            .then(res => {
                console.log("kardexunprod desde BD: ",res);
                tablaregs=document.getElementById("tb_kardex");
                while(tablaregs.rows.length>1){
                    tablaregs.deleteRow(-1);
                }
                cont=1;
                res.forEach(unreg => {
                    filareg=tablaregs.insertRow();
                    filareg.style="cursor:pointer;font-size:0.8em;";
                    celdareg=filareg.insertCell();
                    celdareg.innerText=cont;
                    cont++;
                    if(unreg.tipo=="compra"){
                        filareg.classList.add("compra");
                        for(k=1;k<=5;k++){
                            celdareg=filareg.insertCell();
                        }
                    }
                    celdareg=filareg.insertCell();
                    celdareg.innerText=unreg.fechax;
                    celdareg=filareg.insertCell();
                    celdareg.innerText=unreg.cuantos;
                    celdareg=filareg.insertCell();
                    celdareg.innerText=unreg.preciofinal;
                    celdareg=filareg.insertCell();
                    celdareg.innerText=unreg.cliente;
                    celdareg=filareg.insertCell();
                    if(unreg.email!="huarachichambialicia35@gmail.com"){celdareg.innerText=unreg.email;} else {celdareg.innerText="Administrador";}
                    
                    if(unreg.tipo=="venta"){
                        for(k=1;k<=5;k++){
                            celdareg=filareg.insertCell();
                        }
                    }
                });
                
            });
    }
</script>
@endsection