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
      <div class="salirdevendedor" style="position: relative;left:1em">
        @if ($nomvendedor=="")
        <input type="number" name="carnet" id="carnet"><button class="btn btn-info" onclick="irareporte()">-></button> |
        @else
          <a href="{{route("ventassinvendedor",["nomvendedor"=>$nomvendedor,"carnet"=>$carnet])}}" class="btn btn-warning btn-sm" target="_blank">Ventas Sin Vendedor Asignado</a>
        @endif
         
      </div>
      <div class="salirdevendedor" style="position: absolute;right:1em"><span class="nomvendedor">{{$nomvendedor}}</span>
        @if ($nomvendedor=="")
        | <a href="./" class="btn">Salir</a>
        @endif
        
      </div>

      <form action="{{route('ventas.ventasdetalladovendedor')}}" method="post" id="formcarnet">
        @csrf
        <input type="hidden" name="elcarnet" id="elcarnet" value="{{$carnet}}">
        <input type="hidden" name="fecha" id="fecha" class="form-control">
      </form>

      {{ csrf_field() }}
    </nav>
    <br>
    <link rel="stylesheet" href="{{asset('css/misvistas.css').'?'.microtime()}}">
    <div class="container-fluid">
      <div class="anchosaldos">
        @yield("contenido")
      </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    @yield('js')
  </body>
</html>