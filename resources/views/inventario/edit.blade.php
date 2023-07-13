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
    <h1 class="card-header">Editar Producto</h1> <br>   
    <form action="{{route("actualizaprod",["id"=>$unprod->id])}}" method="post">
        <input type="hidden" name="idprodoriginal" value="{{$unprod->idprod}}">
        @csrf
        @method("PATCH")
        <div class="col-12" style="text-align: center">
            <a href="{{route('inventario.index')}}" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" type="submit">Modificar</button>
            </div>
        <div class="mb-3">
            <label for="idprod" class="form-label">Id del producto</label>
            <input type="text" class="form-control" id="idprod" name="idprod" value="{{$unprod->idprod}}">
        </div>
        <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{$unprod->descripcion}}</textarea>
        </div>
        <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" value="{{$unprod->marca}}">
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{$unprod->cantidad}}">
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoria</label>
            <input type="text" class="form-control" id="categoria" name="categoria" value="{{$unprod->categoria}}">
        </div>
        <div class="mb-3">
            <label for="unidad" class="form-label">Unidad</label>
            <input type="text" class="form-control" id="unidad" name="unidad" value="{{$unprod->unidad}}">
        </div>
        <div class="mb-3">
            <label for="preciolocal" class="form-label">Precio Local</label>
            <input type="number" class="form-control" id="preciolocal" name="preciolocal" value="{{$unprod->preciolocal}}">
        </div>
        <div class="mb-3">
            <label for="precioventa" class="form-label">Precio Venta</label>
            <input type="number" class="form-control" id="precioventa" name="precioventa" value="{{$unprod->precioventa}}">
        </div>
        <div class="mb-3">
            <label for="comision" class="form-label">Comision</label>
            <input type="number" class="form-control" id="comision" name="comision" value="{{$unprod->comision}}">
        </div>
        <div class="mb-3">
            <label for="deposito" class="form-label">Depósito</label>
            <select name="deposito" id="deposito" class="form-control">
                @foreach ($depositos as $depot)
                    <option value="{{$depot->id}}" {{$depot->id==$unprod->deposito?"selected":""}}>{{$depot->nombre}}</option>
                @endforeach
            </select>
            
            <input type="checkbox" class="form-check-input" id="todos" name="todos" onchange="if(this.checked){document.getElementById('checktodos').style='background:yellow;font-weight:bold;'} else{document.getElementById('checktodos').style=''}">
            <label for="todos" class="form-label" id="checktodos">Afectar Todos los depósitos</label>
        </div>
        {{-- <div class="mb-3">
            <label for="deposito" class="form-label">Depósito</label>
            <input type="text" class="form-control" id="deposito" name="deposito" value="{{$unprod->deposito}}">
        </div> --}}
        <div class="mb-3">
            <label for="proveedor" class="form-label">Proveedor</label>
            <input type="text" class="form-control" id="proveedor" name="proveedor" value="{{$unprod->proveedor}}">
        </div>
        <div class="col-12" style="text-align: center">
        <a href="/inventario" class="btn btn-danger">Cancelar</a>
        <button class="btn btn-primary" type="submit">Modificar</button>
        </div>
    </form>
</div>

@endsection