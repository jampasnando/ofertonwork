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
    <h1 class="card-header">Nuevo Producto</h1> <br>   
    <form action="guardanuevoprod" method="post">
        
        @csrf
        <div class="col-12" style="text-align: center">
            <a href="/inventario" class="btn btn-danger">Cancelar</a>
            <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
        <div class="mb-3">
            <label for="idprod" class="form-label">Id del producto</label>
            <input type="text" class="form-control" id="idprod" name="idprod">
        </div>
        <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>
            <select name="marca" id="marca" class="form-control">
                @foreach ($marcas as $unamarca)
                    <option value="{{$unamarca->nombre}}">{{$unamarca->nombre}}</option>
                @endforeach
            </select>
            {{-- <input type="text" class="form-control" id="marca" name="marca"> --}}
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="0">
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoria</label>
            <select name="categoria" id="categoria" class="form-control">
                <option value="HERRAMIENTA">HERRAMIENTA</option>
                <option value="EQUIPO HOGAR">EQUIPO HOGAR</option>
                <option value="EQUIPO SEGURIDAD">EQUIPO SEGURIDAD</option>
        </select>
            {{-- <input type="text" class="form-control" id="categoria" name="categoria"> --}}
        </div>
        {{-- <div class="mb-3">
            <label for="subcategoria" class="form-label">Subcategoria</label>
            <input type="text" class="form-control" id="subcategoria" name="subcategoria">
        </div> --}}
        <div class="mb-3">
            <label for="unidad" class="form-label">Unidad</label>
            <input type="text" class="form-control" id="unidad" name="unidad">
        </div>
        <div class="mb-3">
            <label for="preciolocal" class="form-label">Precio Local</label>
            <input type="number" class="form-control" id="preciolocal" name="preciolocal" value="0">
        </div>
        <div class="mb-3">
            <label for="precioventa" class="form-label">Precio Venta</label>
            <input type="number" class="form-control" id="precioventa" name="precioventa" value="0">
        </div>
        <div class="mb-3">
            <label for="comision" class="form-label">Comision</label>
            <input type="number" class="form-control" id="comision" name="comision" value="0">
        </div>
        <div class="mb-3" id="divdepnuevoprod">
            <label for="deposito" class="form-label">Depósito</label>
            <select name="deposito[]" id="deposito" class="form-control" multiple>
                @foreach ($depositos as $depot)
                    <option value="{{$depot->id}}">{{$depot->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3" >
            <label for="proveedor" class="form-label">Proveedor</label>
            {{-- <input type="text" class="form-control" id="proveedor" name="proveedor"> --}}
            <select name="proveedor" id="proveedor" class="form-control" >
                @foreach ($proveedores as $unprov)
                    <option value="{{$unprov->nombre}}">{{$unprov->nombre}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12" style="text-align: center">
        <a href="{{route('inventario.index')}}" class="btn btn-danger">Cancelar</a>
        <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
        <input type="hidden" class="form-control" id="imagenes" name="imagenes">
    </form>
</div>

@endsection