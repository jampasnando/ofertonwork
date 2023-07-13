@extends('layouts.plantillabase')
@section('contenido')
<div class="nuevoprod">
   
    @if (session("provmodificado"))
            <div class="alert alert-success">{{session("provmodificado")}}</div>
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
    <h1 class="card-header">Edita Proveedor</h1> <br>   
    <form action="{{route("actualizaprov",$unprov->id)}}" method="post">
        
        @csrf
        @method("PATCH")
        <div class="col-12" style="text-align: center">
            <a href="/proveedores" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{$unprov->nombre}}">
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Direccion</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{$unprov->direccion}}">
        </div>
        <div class="mb-3">
            <label for="ciudad" class="form-label">Ciudad</label>
            <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{$unprov->ciudad}}">
        </div>
        <div class="mb-3">
            <label for="contacto" class="form-label">Contacto</label>
            <input type="text" class="form-control" id="contacto" name="contacto" value="{{$unprov->contacto}}">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{$unprov->telefono}}">
        </div>        
        <div class="col-12" style="text-align: center">
        <a href="{{route('proveedores.index')}}" class="btn btn-danger">Cancelar</a>
        <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
    </form>
</div>

@endsection