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
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
          Ventas
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
          <li><a class="nav-link navbar-brand" href="{{route('nuevaventavendedor')}}">Nueva Venta</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('ventas.detallev')}}">Detalle Ventas</a></li>
          <li><a class="nav-link navbar-brand" href="{{route('ventas.paracerrarcaja')}}">Cerrar Caja</a></li> 
        </ul>
      </div>
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
          Caja Chica
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
          <li><a class="nav-link navbar-brand" href="{{route('cajachica.create')}}">Nuevo registro</a></li>
        </ul>
      </div>

      <div class="salirdevendedor" style="position: absolute;right:1em">{{session("usr")->nombre}} | <a href="./" class="btn">Salir</a></div>
      {{ csrf_field() }}
      <div class="dropdown">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
          Reportes
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
          <li><a class="nav-link navbar-brand" href="{{route('cierres')}}">Historico cierres</a></li>
          {{-- <li><a class="nav-link navbar-brand" href="{{route('comisiones')}}">Comisiones Pendientes</a></li> --}}
          {{-- <li><a class="nav-link navbar-brand" href="{{route('comisionespagadas')}}">Comisiones Pagadas</a></li> --}}
        </ul>
      </div>
      <a class="nav-link navbar-brand" href="{{route('indexparavendedor')}}">Inventario</a>
      <a class="nav-link navbar-brand" href="{{route('listapreventas')}}">TiendaOnline</a>
         
          
    </nav>
    <link rel="stylesheet" href="{{asset('css/misvistas.css').'?'.microtime()}}">
    <div class="container-fluid">
      <div class="ancho">
        @yield("contenido")
      </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    @yield('js')
  </body>
</html>