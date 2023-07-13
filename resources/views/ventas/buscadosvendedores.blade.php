@if(count($resbusq))
    @foreach ($resbusq as $uno)
        <p class="border-bottom" onclick="vendedorelegido('{{$uno->id}}','{{$uno->nombre}}')">{{$uno->nombre}}</p>
    @endforeach
@endif