@extends('layouts.plantillaarte')
@section('contenido')
<div class="input-group mb-3">
    <span class="input-group-text" id="inputGroup-sizing-sm">Marcas</span>
    <select class="form-select" aria-label="Default select example" id="marca" style="background: aliceblue" onchange="eligemarca()" placeholder="Elija Marca">
        @foreach ($marcas as $unamarca)
            <option value="{{$unamarca->nombre}}">{{$unamarca->nombre}}</option>
        @endforeach
    </select>
</div>
<table id="tb_img">

</table>
<div class="modal fade" id="modalsubir" tabindex="-1" role="dialog" aria-labelledby="modalsubirTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Elija una imagen</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="equisequis">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{-- <form action="{{route("inventario.subeimagen")}}" method="post" enctype="multipart/form-data" style="float:right"> --}}
                {{-- <div class="mb-3"> --}}
                    {{-- @csrf --}}
                    <div style="display: flex">
                        <input class="form-control" type="file" id="imagen" onchange="document.getElementById('btnsubir').style='display:block;'">
                        <input type="hidden" name="idprod" id="idprod">
                        <button class="btn btn-info" onclick="subirarchivo()" style="display:none;" id="btnsubir">Subir</button>
                    </div>
                    
                  {{-- </div> --}}
            {{-- </form> --}}
        </div>
        
        
      </div>
    </div>
  </div>

<script>
    window.addEventListener("load",function(){

    });
    function guardaventa(){

        
    }
    function subirarchivo(){
        document.getElementById("btnsubir").disabled=true;
        var input = document.getElementById("imagen");
        var data = new FormData();
        data.append('file', input.files[0]);
        data.append('idprod', document.getElementById("idprod").value);
        fetch('subeimagen', {
            method: 'post',
            headers: {
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: data
            })
            .then(res => res.json())
            .then(res => {
               console.log("desdeserver: ",res);
                if(imagenx!=null){
                    imagenx.src="{{asset('images')}}/"+res.nombre;
                    hrefx.href="{{asset('images')}}/"+res.nombre;
                }
                else{
                    a=document.createElement("a");
                    a.href="{{asset('images')}}/"+res.nombre;
                    a.target="_blank";
                    img=document.createElement("img");
                    img.src="{{asset('images')}}/"+res.nombre;
                    img.style="width:150px;";
                    a.appendChild(img);
                    cardx.prepend(a);
                }
               
                document.getElementById("equisequis").click();
                document.getElementById("imagen").value="";
                document.getElementById("btnsubir").style="display:none";
                document.getElementById("btnsubir").disabled=false;
               
            });
    }
    function eligemarca(){
        acera();
        marca=[{idmarca:document.getElementById("marca").value}];
        fetch('obtieneimagenesmarca', {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: JSON.stringify(marca)
            })
            .then(res => res.json())
            .then(res => {
               console.log("desdeserver: ",res);
                cont=0;
                tb=document.getElementById("tb_img");
                fila=tb.insertRow();
                res.forEach(unaimg => {
                    console.log(unaimg.imagenes);
                    if(cont<5){
                        celda=fila.insertCell();
                        celda.style="width:20%;padding:5px 10px;background:#f7f7f7;"
                        card=document.createElement("div");
                        card.classList.add("card");
                        
                        if(unaimg.imagenes!="" && unaimg.imagenes!=null){
                            a=document.createElement("a");
                            a.href="{{asset('images')}}/"+unaimg.imagenes;
                            a.target="_blank";
                            img=document.createElement("img");
                            img.src="{{asset('images')}}/"+unaimg.imagenes;
                            img.style="width:150px;";
                            a.appendChild(img);
                            card.appendChild(a);
                        }
                       
                    }
                    else{
                        cont=0;
                        fila=tb.insertRow();
                        celda=fila.insertCell();
                        celda.style="width:20%;padding:5px 10px;background:#f7f7f7;"
                        card=document.createElement("div");
                        card.classList.add("card");
                        
                        if(unaimg.imagenes!="" && unaimg.imagenes!=null){
                            a=document.createElement("a");
                            a.href="{{asset('images')}}/"+unaimg.imagenes;
                            a.target="_blank";
                            img=document.createElement("img");
                            img.src="{{asset('images')}}/"+unaimg.imagenes;
                            img.style="width:150px;";
                            a.appendChild(img);
                            card.appendChild(a);
                        }
                       
                    }
                    descripcion=document.createElement("div");
                    descripcion.innerText=unaimg.idprod +" | "+ unaimg.descripcion;
                    descripcion.style="font-size:0.8em";
                    card.appendChild(descripcion);
                    celda.appendChild(card);
                    cont++;
                    divbtn=document.createElement("div");
                    divbtn.innerHTML="<button style='font-weight:bold;opacity:0.7;background:gold;border: 1px solid orange;' data-bs-toggle='modal' data-bs-target='#modalsubir' onclick='elige(this)'>&#8743;</button>";
                    divbtn.style="position:absolute;top:0px;left:0px;";
                    card.appendChild(divbtn);
                    card.style="align-items:center;";
                    idprod=document.createElement("input");
                    idprod.type="hidden";
                    idprod.value=unaimg.idprod;
                    celda.appendChild(idprod);
                
                });
               
            });

    }
    document.getElementById("modalsubir").addEventListener('shown.bs.modal', () => {
           
    });
    function elige(celda){
        console.log("elegida: ",celda);
        cell=celda.parentElement.parentElement.parentElement;
        document.getElementById("idprod").value=cell.querySelector("input").value;
        cardx=celda.parentElement.parentElement;
        imagenx=celda.parentElement.parentElement.querySelector("img");
        hrefx=celda.parentElement.parentElement.querySelector("a");
    }
    function acera(){
        tb=document.getElementById("tb_img");
        while(tb.rows.length>0){
            tb.deleteRow(-1);
        }
    }

  
</script>
@endsection