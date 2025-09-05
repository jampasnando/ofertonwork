@extends('layouts.plantillabase')
@section('contenido')
        @if (session("avisito"))
        <div class="alert alert-success">{{session("avisito")}}</div>
        @endif
        <div>Configuración:</div>
        <form action="actualizaconfig" method="POST">
            @csrf
            <table class="table">
                <tr>
                    <th>Whatsapp</th>
                    <th>Nrocuenta y CI</th>
                    <th>Banco</th>
                    <th>Titular cuenta</th>
                    <th></th>
                </tr>
                <tr>
                    <td><input style="width:100%;" type="text" value="{{$config[0]->whatsapp}}" name="whatsapp" id="whatsapp"></td>
                    <td><input style="width:100%;" type="text" value="{{$config[0]->nrocuenta}}" name="nrocuenta" id="nrocuenta"></td>
                    <td><input style="width:100%;" type="text" value="{{$config[0]->banco}}" name="banco" id="banco"></td>
                    <td><input style="width:100%;" type="text" value="{{$config[0]->titularcuenta}}" name="titularcuenta" id="titularcuenta"></td>
                    <td><button type="submit" class="btn btn-warning">Guardar</button></td>
                </tr>
            </table>
        </form>
        <h5>Carrusel promos por depósito</h5>
        <table class="table">
            <tr>
                <th>Depósito</th>
                <th>Productos</th>
                <th></th>
            </tr>
            @foreach ($promos as $unapromo)
            <tr>
                <td>{{$unapromo["nombre"]}}</td>
                <td><button  class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalbuscaprod" onclick='cambiadep("{{$unapromo["iddep"]}}","{{$unapromo["nombre"]}}")'>+</button></td>
                <td>
                    <table>
                        <tr>
                            @foreach ($unapromo["promos"] as $unprod)
                                @if ($unprod->producto !=null)
                                    <td>
                                        <div style="position: relative;">
                                            <button class="btn btn-danger btn-sm" style="position: absolute;top:-10px;right:3px;" onclick="quitar('{{$unprod->producto}}')">X</button>
                                            <img src="{{url('images').'/'.$unprod->imagenes}}" alt="" style="width:12em;">
                                        </div>

                                        <div>{{$unprod->producto}}</div>
                                        <div>{{$unprod->fechareg}}</div>
                                        <div>Cant: {{$unprod->cantidad}}</div>
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            @endforeach
                        </tr>
                    </table>
                   
                </td>
                
            </tr>

            @endforeach
        </table>
        <form action="quitarprodpromo" id="formquitar" method="post">
            @csrf
            <input type="hidden" name="idquitar" id="idquitar">
        </form>
        {{-- ////////////////////////////////////////////////////////////// MODAL BUSCA PROD /////////////////////////////////////////////////////////////////////// --}}
        {{-- <button data-bs-toggle="modal" data-bs-target="modalbuscaprod" style="display: none" id="btnabrebuscador"></button> --}}
<div class="modal fade " id="modalbuscaprod" tabindex="-1" role="dialog" aria-labelledby="modalBuscaProd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <div>Buscar en Inventario de <span id="ciudad" style="font-weight: bold"></span></div>
            {{-- <input type="text" class="form-control" id="buscacli" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" onkeypress="cambiatxt(event,this)" placeholder="Buscar cliente..."> --}}
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="equis">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table class="table table-light">
                    <tr>
                        <td>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Buscar producto" id="texto" autofocus>
                                <a href="" class="btn btn-secondary" id="borrar" style="display:none" onclick="borrar(event)">X</a>
                                {{-- <span class="input-group-text" id="basic-addon2">Buscar</span> --}}
                                <button class="btn border" onclick="buscar()">Buscar</button>
                                <div class="resultadobusq" id="resultadobusq"></div>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <form action="guardaprodenpromo" method="post">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="deposito" id="deposito">
                            
                                <div style="text-align: center">
                                    <img src="" alt="" id="imgpromo" style="width:15em;">
                                </div>
                                <button type="submit" class="btn btn-info">Añadir a la promoción</button>
                            </form>
                        </td>
                    </tr>
            </table>
            
    
        </div>
        
      </div>
    </div>
  </div>
{{-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

    <script>
        dep="";
        function cambiadep(depx,ciudad){
            console.log("nuevodep: ",depx);
            dep=depx;
            document.getElementById("ciudad").innerText=ciudad;
        }
        function borrar(e){
            e.preventDefault();
            document.getElementById("texto").value="";
            document.getElementById("borrar").style="display:none";
            document.getElementById("resultadobusq").innerHTML="";
        }
        function buscar(){
                event.preventDefault();
                // dep=document.getElementById("deposito").value;
                casbusq=document.getElementById("texto");
                console.log("dep: ",dep);
                if(casbusq.value.length>1){
                    document.getElementById("borrar").style="display:block";
                    fetch("buscaprodxapromo?texto="+casbusq.value+"&dep="+dep,{method:"get"})
                    .then(response=>response.text())
                    .then(datos=>{
                    document.getElementById("resultadobusq").innerHTML=datos;
                    });
                }
                else{
                    document.getElementById("resultadobusq").innerHTML="";
                }
        }
        function elegido(id,descr,precioventa,preciolocal,comision,cantidad,idprod,imagenes){
            console.log(id,descr,precioventa,preciolocal,comision,cantidad,idprod,imagenes);
            document.getElementById("imgpromo").src="https://ferreteriaoferton.com/public/images/"+imagenes;
            document.getElementById("id").value=id;
            document.getElementById("deposito").value=dep;
        }
        function quitar(id){
            document.getElementById("idquitar").value=id;
            document.getElementById("formquitar").submit();
        }
    </script>
@endsection
