<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>FERRETERIA</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      {{-- <a class="nav-link active navbar-brand" aria-current="page" href="{{route('inventario.index')}}">Inventario</a> --}}
      <div class="salirdevendedor" style="position: absolute;right:1em">{{session("usr")->nombre}} | <a href="./" class="btn">Salir</a></div>
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
          Inventario
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
          <li><a class="nav-link navbar-brand" href="{{route('inventario.index')}}">Ver Inventario</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('nuevoprod')}}">Nuevo Producto</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('moverenmasa')}}" target="_blank">Traspasos en masa</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('inventario.importar')}}">Importar excel</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('inventario.kardexprod')}}">Kardex Producto</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('imagenesadmin')}}" target="_blank">Imágenes Productos</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('servicios')}}" target="_blank">Servicio Técnico</a></li>
          
        </ul>
      </div>
      <a class="nav-link navbar-brand" href="{{route('vendedore.index')}}">Usuarios</a>
      <a class="nav-link navbar-brand" href="{{route('clientes.index')}}">Clientes</a>
      <a class="nav-link navbar-brand" href="{{route('proveedores.index')}}">Proveedores</a>
      <a class="nav-link navbar-brand" href="{{route('marcas.index')}}">Marcas</a>
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
          Ventas
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
          <li><a class="nav-link navbar-brand" href="{{route('nuevaventa')}}">Nueva Venta</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('ventas.index')}}">Resumen Ventas</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('ventas.detallev')}}">Detalle Ventas</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('ventas.paracerrarcaja')}}">Cerrar Caja</a></li>
        </ul>
      </div>
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
          Compras
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
          <li><a class="nav-link navbar-brand" href="{{route('nuevacompra')}}">Nueva Compra</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('compras.index')}}">Resumen Compras</a></li>
          <li style="background: lightyellow;"><a class="nav-link navbar-brand" href="{{route('compras.indexcreditos')}}">Resumen Deudas</a></li>
          {{-- <li><a class="nav-link navbar-brand" href="{{route('ventas.detallev')}}">Detalle Ventas</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('ventas.paracerrarcaja')}}">Cerrar Caja</a></li> --}}
        </ul>
      </div>
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
          Caja chica
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
          <li><a class="nav-link navbar-brand" href="{{route('aperturacajachica.index')}}">Aperturas/Cierres</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('detallecajachicaxfecha')}}">Detalle por fecha</a></li>
          {{-- <li style="background: lightyellow;"><a class="nav-link navbar-brand" href="{{route('compras.indexcreditos')}}">Resumen Deudas</a></li> --}}
          {{-- <li><a class="nav-link navbar-brand" href="{{route('ventas.detallev')}}">Detalle Ventas</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('ventas.paracerrarcaja')}}">Cerrar Caja</a></li> --}}
        </ul>
      </div>
      {{ csrf_field() }}
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
          Reportes
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
          {{-- <li><a class="nav-link navbar-brand" href="{{route('cierres')}}">Historico cierres</a></li> --}}
          <li><a class="nav-link navbar-brand" href="{{route('cierres')}}">Historico cierres</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('comisiones')}}">Comisiones Pendientes</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('comisionespagadas')}}">Comisiones Pagadas</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('hist_traspasos.index')}}">Historial Traspasos</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('ventasxprod')}}">Ventas X producto</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('historialqueries')}}">Historial Cambios</a></li>
        </ul>
      </div>
    </nav>
    <link rel="stylesheet" href="{{asset('css/misvistas.css').'?'.time()}}">
    <div class="container-fluid">
      <div class="ancho">
        @yield("contenido")
      </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    @yield('js')
  </body>
</html>