@extends('layouts.plantillabaseservicios')
@section('contenido')
        @if (session("avisito"))
        <div class="alert alert-success">{{session("avisito")}}</div>
        @endif
        <br>
        <div class="titulo">
            <h3>Servicio Técnico<span style="color:darkorange"></span><span><button style="background:lightgreen" onclick="nuevoregistro()" data-bs-toggle="modal" data-bs-target="#modalnuevoreg" >Nuevo Registro</button></span></h3>
            {{-- <input type="text" class="form-control"  id="fecharecepcion2"  autocomplete="off" readonly style="border:0;background:lemonchiffon;text-align:center"> --}}
        </div>
        <table class="table table-light table-stripped table-hover" id="tb_servicios" style="width:100%">
            <thead class="thead-light">
                <tr>
                    <th>N</th>
                    <th>FechaReg</th>
                    <th>CodProd</th>
                    <th>Estado</th>
                    <th>Marca</th>
                    <th>Lugar</th>
                    <th>Cliente</th>
                    <th>Falla</th>
                    <th>Receptor</th>
                    <th>FechaRecepcion</th>
                    <th>EstadoActual</th>
                    <th>EntregadoAcliente</th>
                    <th>FechaEntregado</th>
                    <th></th>
                    {{-- <th>Comentario</th> --}}

                </tr>
            </thead>
            <tbody>
                @foreach (($lista ?? []) as $key=>$unprod)
                    <tr>
                        {{-- <td></td> --}}
                        <td>{{$loop->iteration}} <input type="hidden" name="id_{{$loop->iteration}}" id="id_{{$loop->iteration}}" value="{{$unprod->id}}"></td>
                        <td>{{implode("-",array_reverse(explode("-",(explode(" ",$unprod->fechareg)[0]))))." ".explode(" ",$unprod->fechareg)[1]}}</td>
                        <td>{{$unprod->codigo}}</td>
                        <td>{{$unprod->estado}}</td>
                        <td>{{$unprod->marca}}</td>
                        <td>{{$unprod->ciudad}}</td>
                        <td>{{$unprod->cliente}}</td>
                        <td>{{$unprod->falla}}</td>
                        <td>{{$unprod->receptor}}</td>
                        <td>{{implode("-",array_reverse(explode("-",$unprod->fecharecepcion)))}}</td>
                        <td>{{$unprod->estadoactual}}</td>
                        <td>{{$unprod->entregadocliente}}</td>
                        <td>{{implode("-",array_reverse(explode("-",$unprod->fechaentregado)))}}</td>
                        <td>
                            <div style="display:flex;height:31px;">
                                <button onclick="editar({{$unprod}})" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalnuevoreg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </button>
                                <span>&nbsp;&nbsp;</span>
                                <form action="{{route('eliminaservicio',$unprod->id)}}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-danger"  onclick="return confirm('Está seguro de eliminar este registro ?')" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            {{-- <button onclick="editar({{$unprod}})" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalnuevoreg">Editar</button>
                            <form action="{{route('eliminaservicio',$unprod->id)}}" method="post">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Está seguro de eliminar este registro ?')" >Borrar</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- <div>{{$lista->links()}}</div> --}}
        {{-- ////////////////////////////////////////////////////////////// MODAL NUEVO REGISTRO /////////////////////////////////////////////////////////////////////// --}}
<div class="modal fade" id="modalnuevoreg" tabindex="-1" role="dialog" aria-labelledby="modalnuevoregTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="titmodal">Nuevo Registro</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="equisequis">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" id="formulario" method="post">
            @csrf
            @method("PATCH")
        <div class="modal-body">
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >*Codigo de Producto</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="codigo" name="codigo"  aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO" autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Estado</span>
                <input type="text" class="form-control" aria-label="Sizing example input"  id="estado" name="estado" aria-describedby="inputGroup-sizing-sm"   autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Marca</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="marca" name="marca"  aria-describedby="inputGroup-sizing-sm"   autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >*Lugar</span>
                <select class="form-select" aria-label="Default select example" id="ciudad" name="ciudad">
                    <option value=""></option>
                    @foreach ($depositos as $undepot)
                        <option value="{{$undepot->id}}">{{$undepot->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >*Cliente</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="cliente" name="cliente"  aria-describedby="inputGroup-sizing-sm" required title="REQUERIDO"  autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Falla</span>
                <textarea class="form-control" id="falla" name="falla" aria-describedby="inputGroup-sizing-sm"  ></textarea>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Receptor</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="receptor" name="receptor" aria-describedby="inputGroup-sizing-sm"  >
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >*Fecha Recepcion</span>
                <input type="text" class="form-control"  id="fecharecepcion" name="fecharecepcion"  readonly style="border:0;background:lemonchiffon;text-align:center" title="REQUERIDO" value="{{$hoy}}" autocomplete="off">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Estado Actual</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="estadoactual" name="estadoactual" aria-describedby="inputGroup-sizing-sm"  >
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Entregado al Cliente</span>
                <input type="text" class="form-control" aria-label="Sizing example input" id="entregadocliente" name="entregadocliente" aria-describedby="inputGroup-sizing-sm"  >
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm" >Fecha Entregado al Cliente</span>
                <input type="text" class="form-control"  id="fechaentregado" name="fechaentregado"   style="border:0;background:lemonchiffon;text-align:center" autocomplete="off">
            </div>
            {{-- <input type="hidden" id="id"> --}}
        </div>
    </form>
        <div class="modal-footer">
            <button class="btn btn-success" onclick="enviar()" id="btnmodal">Registrar</button>
        </div>
      </div>
    </div>
  </div>
{{-- ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<style>
    .modal-open .ui-datepicker{z-index: 2000!important}
</style>
<script>
    procesar="";
     $(document).ready(function() {
        mitabla= $('#tb_servicios').DataTable({
            "language":{
            "emptyTable":     "No hay datos en la Tabla",
            "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
            "infoFiltered":   "(Filtrado de _MAX_ total registros)",
            "infoPostFix":    "",
            "thousands":      ",",
            "lengthMenu":     "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando datos...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No matching records found",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Previo"
            },
            
            },
            "pageLength": 50
        });
                
    });
        
    
    window.onload=function(){
        $("#fecharecepcion").datepicker({
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
                        yearSuffix: '',
                        
        });

        $("#fechaentregado").datepicker({
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
                        yearSuffix: '',
                        clearButton:true
        });
    }
    // function nuevoregistro(){
    //     tb=document.getElementById("tb_servicios");
    //     fila=tb.insertRow(1);
    //     celda=fila.insertCell();
        
    //     for(k=1;k<=12;k++){
    //         celda=fila.insertCell();
    //         input=document.createElement("input");
    //         input.style="background:lemonchiffon";
    //         celda.appendChild(input);
    //     }
    // }
    function enviar(){
        switch (procesar) {
            case "nuevo":
                enviara("guardanuevoservicio");
                break;
            case "editar":
                guardaeditado();
                break;
            default:
                break;
        }

    }
    function enviara(destino){
        console.log("guardará reg en : ",destino);
        codigo=document.getElementById("codigo").value;
        estado=document.getElementById("estado").value;
        marca=document.getElementById("marca").value;
        ciudad=document.getElementById("ciudad").value;
        cliente=document.getElementById("cliente").value;
        falla=document.getElementById("falla").value;
        receptor=document.getElementById("receptor").value;
        fecharecepcion=document.getElementById("fecharecepcion").value;
        estadoactual=document.getElementById("estadoactual").value;
        entregadocliente=document.getElementById("entregadocliente").value;
        fechaentregado=document.getElementById("fechaentregado").value;
        id=document.getElementById("fechaentregado").value;
        if(codigo!="" && cliente!="" && ciudad!=""){
            if(destino=="guardanuevoservicio"){
                nuevito=[{codigo:codigo,estado:estado,marca:marca,ciudad:ciudad,cliente:cliente,falla:falla,receptor:receptor,fecharecepcion:fecharecepcion.split("-").reverse().join("-"),estadoactual:estadoactual,entregadocliente:entregadocliente,fechaentregado:fechaentregado.split("-").reverse().join("-")}];

            }
            else{
                nuevito=[{codigo:codigo,estado:estado,marca:marca,ciudad:ciudad,cliente:cliente,falla:falla,receptor:receptor,fecharecepcion:fecharecepcion.split("-").reverse().join("-"),estadoactual:estadoactual,entregadocliente:entregadocliente,fechaentregado:fechaentregado.split("-").reverse().join("-"),id:id}];

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
                if(res=="registrado"){
                    document.getElementById("formulario").reset();
                    console.log("neuvoclidesdeBD: ",res);
                    document.getElementById("equisequis").click();
                    location.reload();
                }
                else{
                    alert("Ocurrió un error, intente más tarde");
                }
                
                // document.getElementById("idcliente").value=res.id;
                // document.getElementById("cliente").value=res.nombre;
                // document.getElementById("telefono").value=res.telefono;
                // document.getElementById("nit").value=res.nit;
                
            });
        }
        else{
            alert("Formulario incompleto, los campos con asterisco son obligatorios");
        }
    }
    function editar(unprod){
        console.log("unprod",unprod);
        procesar="editar";
        document.getElementById("formulario").reset();
        document.getElementById("codigo").value=unprod.codigo;
        document.getElementById("estado").value=unprod.estado;
        document.getElementById("marca").value=unprod.marca;
        document.getElementById("ciudad").value=unprod.ciudad;
        document.getElementById("cliente").value=unprod.cliente;
        document.getElementById("falla").value=unprod.falla;
        document.getElementById("receptor").value=unprod.receptor;
        document.getElementById("fecharecepcion").value=unprod.fecharecepcion!=null?unprod.fecharecepcion.split("-").reverse().join("-"):"";
        document.getElementById("estadoactual").value=unprod.estadoactual;
        document.getElementById("entregadocliente").value=unprod.entregadocliente;
        document.getElementById("fechaentregado").value=unprod.fechaentregado!=null?unprod.fechaentregado.split("-").reverse().join("-"):"";
        document.getElementById("titmodal").innerText="MODIFICAR REGISTRO";
        document.getElementById("btnmodal").innerText="GUARDAR CAMBIOS";
        // document.getElementById("id").value=unprod.id;
        document.getElementById("formulario").action="actualizaservicio/"+unprod.id;
        return true;
    }
    function nuevoregistro(){
        procesar="nuevo";
        document.getElementById("formulario").reset();
        document.getElementById("titmodal").innerText="NUEVO REGISTRO";
        document.getElementById("btnmodal").innerText="REGISTRAR";
        return true;
    }
    function guardaeditado(){
        document.getElementById("fecharecepcion").value=document.getElementById("fecharecepcion").value.split("-").reverse().join("-");
        document.getElementById("fechaentregado").value=document.getElementById("fechaentregado").value!=null && document.getElementById("fechaentregado").value!=""?document.getElementById("fechaentregado").value.split("-").reverse().join("-"):"";
        document.getElementById("formulario").submit();
    
    }
    // function eliminar(id){
    //     if(confirm("Está seguro de eliminar este producto?")){
    //         document.getElementById("formeliminar").action="eliminaservicio/".id;
    //         document.getElementById("formeliminar").submit();
    //     }
    // }
</script>

