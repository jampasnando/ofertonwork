@if(count($resbusq))
    @foreach ($resbusq as $uno)
        <p class="border-bottom" onclick="elegido('{{$uno->id}}','{{$uno->descripcion}}','{{$uno->precioventa}}','{{$uno->preciolocal}}','{{$uno->comision}}','{{$uno->cantidad}}')">{{$uno->idprod}} [ {{$uno->cantidad}} ] [${{$uno->comision}}] {{$uno->descripcion}}</p>
    @endforeach
@endif