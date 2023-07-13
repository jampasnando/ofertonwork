@extends('layouts.plantillabase')
@section('contenido')
<div class="nuevoprod">
   
    @if (session("prodmodificado"))
            <div class="alert alert-success alert-dismissable"">
                {{session("prodmodificado")}}
            
            </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissable"">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
            
        </div>
    @endif
    <h1 class="card-header">Mover Producto</h1> <br>   
    <form action="{{route("registramover")}}" method="post" id="formu">
        
        @csrf
        {{-- @method("PATCH") --}}
        <table class="table table-light" id="tabla">
            <thead>
                <th>Id</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Depósito</th>
                <th>Cantidad</th>
            </thead>
            <tbody>
                <tr>
                    <td>{{$unprod->idprod}}</td>
                    <td>{{$unprod->descripcion}}</td>
                    <td>{{$unprod->marca}}</td>
                    <td>{{$unprod->nombre}}</td>
                    <td>{{$unprod->cantidad}}</td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" id="idprod" name="idprod" value="{{$unprod->idprod}}">
        <input type="hidden" id="id" name="id" value="{{$unprod->id}}">
        <input type="hidden" id="prodjason" name="prodjason" value="{{json_encode($unprod)}}">
        <input type="hidden" id="depositoorigen" name="depositoorigen" value="{{$unprod->deposito}}">
        <div class="input-group mb-3">
            <span class="input-group-text">Cantidad a mover</span>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="1">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Depósito Destino</span>
            <select name="depositodestino" id="depositodestino" class="form-control">
                <option value=""></option>
                @foreach ($depositos as $depot)
                    <option value="{{$depot->id}}">{{$depot->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Comentario</span>
            <input type="text" class="form-control" id="comentario" name="comentario">
        </div>
        <div class="col-12" style="text-align: center">
        <a href="/inventario" class="btn btn-danger">Cancelar</a>
        <a href="#" class="btn btn-primary" onclick="valida()" id="btnmover">Mover</a>
        </div>
    </form>
</div>

@endsection
<script>
    function valida(){
        document.getElementById("btnmover").disabled=true;
        cant=parseFloat(document.getElementById("tabla").rows[1].cells[4].innerText);
        mover=parseFloat(document.getElementById("cantidad").value);
        idprod=document.getElementById("idprod").value;
        origen=document.getElementById("depositoorigen").value;
        destino=document.getElementById("depositodestino").value;
        if(origen!=destino){
            if(mover>0 && mover<=cant && document.getElementById("depositodestino").value!=""){
                console.log("ok");
                console.log(cant,idprod,mover,destino);
                document.getElementById("formu").submit();  
            }
            else{
                alert("Error en la cantidad o depósito destino");
            }
        }
        else{
            alert("No puedes transferir al mismo depósito");
        }
       
        
    }
</script>