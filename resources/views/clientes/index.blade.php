@extends('layouts.plantillabase')
@section('contenido')
        @if (session("avisito"))
        <div class="alert alert-success">{{session("avisito")}}</div>
        @endif
        <br>
        <div class="titulo">
            <h3>Clientes<span style="color:darkorange"></span><span><button class="btn btn-success" onclick="nuevoregistro()" data-bs-toggle="modal" data-bs-target="#modalnuevoreg" >Nuevo Cliente</button></span><a href="{{route("exportarclientes")}}" class="btn btn-secondary">Exportar a Excel</a></h3>
            {{-- <input type="text" class="form-control"  id="fecharecepcion2"  autocomplete="off" readonly style="border:0;background:lemonchiffon;text-align:center"> --}}
        </div>
        <table class="table table-light  table-hover" id="tb_clientes" style="width:100%">
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Nit</th>
                    <th>Rubro</th>
                    <th>Direccion</th>
                    <th>#Compras</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <form action="" method="POST" id="formeliminar">
            @csrf
            @method("DELETE")
        </form>
        {{-- <div>{{$lista->links()}}</div> --}}
        {{-- ////////////////////////////////////////////////////////////// MODAL NUEVO REGISTRO /////////////////////////////////////////////////////////////////////// --}}
<div class="modal fade" id="modalnuevoreg" tabindex="-1" role="dialog" aria-labelledby="modalnuevoregTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="titmodal">Nuevo Cliente</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="equisequis">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" id="formulario" method="post">
            @csrf
            @method("PATCH")
        <div class="modal-body">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >*Nombre</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="nombre" name="nombre"  aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO" autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Telefono</span>
                <input type="text" class="form-control" aria-label="Sizing example input"  id="telefono" name="telefono" aria-describedby="inputGroup-sizing-sm"   autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >NIT</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="nit" name="nit"  aria-describedby="inputGroup-sizing-sm"   autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Rubro</span>
                <select class="form-select" aria-label="Default select example" id="rubro" name="rubro" style="background: aliceblue">
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
                <input type="text" class="form-control" aria-label="Sizing example input" id="direccion" name="direccion"  aria-describedby="inputGroup-sizing-sm"   autocomplete="off">
            </div>
        </div>
    </form>
        <div class="modal-footer">
            <button class="btn btn-success" onclick="enviar()" id="btnmodal">Registrar</button>
        </div>
      </div>
    </div>
  </div>
{{-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
  <form action="{{route("verkardex")}}" method="post" id="formukardex" target="_blank">
    @csrf
    <input type="hidden" name="idcli" id="idcli">
  </form>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<style>
    #tb_clientes tr td:nth-child(7){
        text-align: right;
    }
    #tb_clientes tr td:nth-child(n+3):nth-child(-n+6){
        text-align: center;
        border-right: 1px solid silver;
    }
    #tb_clientes tr th:nth-child(n+3):nth-child(-n+6){
        text-align: center;
    }

</style>
<script>
    procesar="";
     $(document).ready(function() {
        mitabla= $('#tb_clientes').DataTable({
            // processing: true,
            serverSide: true,
              ajax: {
                  url: "{{url('cargaclientes')}}",
                //   method:'POST',
                  
                    // data: {
                    // '_token': '{{ csrf_token() }}',
                    // },
                //   data: function (data) {
                //       data.params = {
                //           sac: "helo"
                //       }
                //   }
              },
              columns: [
                  {data: "id"},
                  {data: "nombre"},
                  {data: "telefono"},
                  {data: "nit"},
                  {data: "rubro"},
                  {data: "direccion"},
                  {data: "cant"},
                  {data: 'action', name: 'action', orderable: false, searchable: false}
              ],
            language:{
            emptyTable:     "No hay datos en la Tabla",
            info:           "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty:      "Mostrando 0 a 0 de 0 registros",
            infoFiltered:   "(Filtrado de _MAX_ total registros)",
            infoPostFix:    "",
            thousands:      ",",
            lengthMenu:     "Mostrar _MENU_ registros",
            loadingRecords: "Cargando datos...",
            processing:     "Procesando...",
            search:         "Buscar:",
            zeroRecords:    "No matching records found",
            paginate: {
                first:      "Primero",
                last:       "Ultimo",
                next:       "Siguiente",
                previous:   "Previo"
            },
            
            },
            order: [[ 7, "desc" ]],
            pageLength: 50
        });
                
    });
        
    
    window.onload=function(){

    }
    function enviar(){
        switch (procesar) {
            case "nuevo":
                enviara("guardanuevocliente2");
                break;
            case "editar":
                guardaeditado();
                break;
            default:
                break;
        }

    }
    function enviara(destino){
        nombre=document.getElementById("nombre").value;
        telefono=document.getElementById("telefono").value;
        nit=document.getElementById("nit").value;
        direccion=document.getElementById("direccion").value;
        rubro=document.getElementById("rubro").value;
        if(nombre!=""){
            if(destino=="guardanuevocliente2"){
                nuevito=[{nombre:nombre,telefono:telefono,nit:nit,direccion:direccion,rubro:rubro}];

            }
            else{
                nuevito=[{nombre:nombre,telefono:telefono,nit:nit,direccion:direccion,rubro:rubro}];

            }

            fetch(destino, {
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
                console.log("llega res luego de res.json(): ",res);
                if(res){
                    document.getElementById("formulario").reset();
                    console.log("neuvoclidesdeBD: ",res);
                    document.getElementById("equisequis").click();
                    location.reload();
                }
                else{
                    alert("Ocurrió un error, intente más tarde");
                }
                
                
            });
        }
        else{
            alert("Formulario incompleto, los campos con asterisco son obligatorios");
        }
    }
    function editar(btneditar,idcli){
        procesar="editar";
        document.getElementById("formulario").reset();
        filacli=btneditar.parentElement.parentElement;
        console.log("id y btneditar: ",filacli,btneditar);
        document.getElementById("nombre").value=filacli.cells[1].innerText;
        document.getElementById("telefono").value=filacli.cells[2].innerText;
        document.getElementById("nit").value=filacli.cells[3].innerText;
        document.getElementById("rubro").value=filacli.cells[4].innerText;
        document.getElementById("direccion").value=filacli.cells[5].innerText;
        document.getElementById("titmodal").innerText="MODIFICAR CLIENTE";
        document.getElementById("btnmodal").innerText="GUARDAR CAMBIOS";
        // document.getElementById("id").value=unprod.id;
        document.getElementById("formulario").action="actualizacliente/"+idcli;
        return true;
    }
    function nuevoregistro(){
        procesar="nuevo";
        document.getElementById("formulario").reset();
        document.getElementById("titmodal").innerText="NUEVO Cliente";
        document.getElementById("btnmodal").innerText="REGISTRAR";
        return true;
    }
    function guardaeditado(){
        document.getElementById("formulario").submit();
    
    }

    function eliminar(id){
        if(confirm("Está seguro de eliminar este cliente?")){
            document.getElementById("formeliminar").action='eliminacliente/'+id;
            document.getElementById("formeliminar").submit();
        }
    }
    function verkardex(btn,idcli){
        document.getElementById("idcli").value=idcli;
        document.getElementById("formukardex").submit();
    }
</script>

