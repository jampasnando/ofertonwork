@if(count($resbusq))
    @foreach ($resbusq as $uno)
        @php
            if($uno->imagenes !=""){$img=" - IMG";}
            else{$img="";}
        @endphp
        <p class="border-bottom" onclick="elegido('{{$uno->id}}','{{$uno->descripcion}}','{{$uno->precioventa}}','{{$uno->preciolocal}}','{{$uno->comision}}','{{$uno->cantidad}}','{{$uno->idprod}}','{{$uno->imagenes}}')">{{$uno->idprod}} [{{$uno->cantidad}}] {{$uno->descripcion}} {{$img}}</p>
    @endforeach
@endif