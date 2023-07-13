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
    <h1 class="card-header">Nueva Marca</h1> <br>   
    <form action="guardanuevamarca" method="post">
        
        @csrf
        <div class="col-12" style="text-align: center">
            <a href="{{route('proveedores.index')}}" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
      
        <div class="col-12" style="text-align: center">
        <a href="{{route('marcas.index')}}" class="btn btn-danger">Cancelar</a>
        <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
    </form>
</div>

@endsection