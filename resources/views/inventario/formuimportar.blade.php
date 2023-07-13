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
        <br>
        <div class="row">
            <div class="col">
                <h4 class="card-header">A) Importar inventario eliminando todo lo anterior</h4> <br> 
                <form action="{{route("inventario.guardaimportarinv")}}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="arch" class="form-label">Elija su excel</label>
                        <input type="file" class="form-control" id="arch" name="arch" required>
                    </div>
                    <div class="col-12" style="text-align: center">
                        {{-- <a href="{{route('vendedore.index')}}" class="btn btn-danger">Cancelar</a> --}}
                        <button class="btn btn-danger" type="submit" disabled>Enviar archivo</button>
                    </div>
                </form>
                <br>
                <a href="{{route("inventario.plantillaexcel")}}" class="btn btn-success">Descargar el Archivo excel BASE</a>  
            </div>
            <div class="col">
                <h4 class="card-header">B) Importar inventario añadiendo a lo que ya existe</h4> <br>  
                <form action="{{route("inventario.guardaimportarinvmas")}}" method="post" enctype="multipart/form-data">
                    
                    @csrf
                    
                    <div class="mb-3">
                        <label for="arch" class="form-label">Elija su excel</label>
                        <input type="file" class="form-control" id="arch" name="arch" required>
                    </div>
                    <div class="col-12" style="text-align: center">
                        {{-- <a href="{{route('vendedore.index')}}" class="btn btn-danger">Cancelar</a> --}}
                        <button class="btn btn-warning" type="submit">Enviar archivo</button>
                    </div>
                </form>
            </div>
            <div class="col">
                <h4 class="card-header">C) Importar para ACTUALIZAR inventario</h4> <br>  
                <form action="{{route("inventario.guardaimportaractualizacion")}}" method="post" enctype="multipart/form-data">
                    
                    @csrf
                    
                    <div class="mb-3">
                        <label for="arch" class="form-label">Elija su excel</label>
                        <input type="file" class="form-control" id="arch" name="arch" required>
                    </div>
                    <div class="col-12" style="text-align: center">
                        <button class="btn btn-info" type="submit">Enviar archivo</button>
                    </div>
                </form>
                <br>
                <a href="{{route("inventario.plantillaActInv")}}" class="btn btn-success">Descargar el Archivo excel BASE</a> 
            </div>
        </div>

    <br><br><hr>
   
</div>

@endsection