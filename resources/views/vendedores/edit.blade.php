@extends('layouts.plantillabase')
@section('contenido')
<div class="nuevoprod">
   
    @if (session("vendedormodificado"))
            <div class="alert alert-success">{{session("vendedormodificado")}}</div>
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
    <h1 class="card-header">Editar Usuario</h1> <br>   
    <form action="{{route("actualizavendedor",$unvendedor->id)}}" method="post">
        
        @csrf  
        @method("PATCH") 
        <div class="col-12" style="text-align: center">
            <a href="{{route('vendedore.index')}}" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" type="submit">Modificar</button>
            </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{$unvendedor->nombre}}">
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Direccion</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="{{$unvendedor->direccion}}">
        </div>
        <div class="mb-3">
            <label for="carnet" class="form-label">Carnet</label>
            <input type="text" class="form-control" id="carnet" name="carnet" value="{{$unvendedor->carnet}}">
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Telefono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="{{$unvendedor->telefono}}">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="{{$unvendedor->email}}">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="text" class="form-control" id="password" name="password" value="{{$unvendedor->password}}">
        </div>
        <div class="mb-3">
            <label for="ciudad" class="form-label">Ciudad</label>
            <select class="form-select" aria-label="Default select example" id="ciudad" name="ciudad" style="background: aliceblue">
                @foreach ($depositos as $undepot)
                    <option value="{{$undepot->id}}" @if($undepot->id==$unvendedor->ciudad) selected @endif>{{$undepot->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select  class="form-select" aria-label="Default select example" name="rol" id="rol">
                <option value="Enc. Tienda y caja" @if($unvendedor->rol=="Enc. Tienda y caja") selected @endif>Enc. Tienda y caja</option>
                <option value="Vendedores" @if($unvendedor->rol=="Vendedores") selected @endif>Vendedores</option>
                <option value="Administradores" @if($unvendedor->rol=="Administradores") selected @endif>Administradores</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select  class="form-select" aria-label="Default select example" name="estado" id="estado" >
                <option value="activo" @if($unvendedor->estado=="activo") selected @endif>Activo</option>
                <option value="inactivo" @if($unvendedor->estado=="inactivo") selected @endif>Inactivo</option>
            </select>
            {{-- <input type="text" class="form-control" id="estado" name="estado" value="{{$unvendedor->estado}}"> --}}
        </div>
        
        <div class="col-12" style="text-align: center">
        <a href="{{route('vendedore.index')}}" class="btn btn-danger">Cancelar</a>
        <button class="btn btn-primary" type="submit">Modificar</button>
        </div>
    </form>
</div>

@endsection