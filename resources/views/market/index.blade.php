@extends("layouts.plantillamarket")
@section("contenido")
<script src="{{asset('js/tiendaonline.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<style>
  @keyframes glow {
    from {
      box-shadow: 0 0 10px -10px #aef4af;
    }
    to {
      box-shadow: 0 0 10px 10px #aef4af;
    }
  }
  .carritobrilla{
    animation: glow 1s infinite alternate;
    border-radius: 10px 10px;
  }
</style>
<div class="row">
  <!-- col -->
  <div class="col-12">
    <!-- cta -->
    <div
      class="bg-light d-lg-flex justify-content-between align-items-center py-6 py-lg-3 px-8 text-center text-lg-start rounded">
      <!-- img -->
      <div class="d-lg-flex align-items-center">
        {{-- <img src="../assets/images/about/about-icons-1.svg" alt="" class="img-fluid"> --}}
        <!-- text -->

        <div class="ms-lg-4">
          <h1 class="fs-2 mb-1">Bienvenido a Ferreterías Ofertón</h1>
          <span>Le invitamos a instalar en su celular nuestra APP <span class="text-primary">OFERTÓN</span>
            para IOs o Android.</span>

        </div>

      </div>
      <div class="mt-3 mt-lg-0 app">
        <!-- btn -->
        <a href="#" class="btn btn-dark"><img src="{{url('/imagenes/appstore-btn.svg')}}" alt=""></a>
        <a href="#" class="btn btn-dark"><img src="{{url('/imagenes/googleplay-btn.svg')}}" alt=""></a>
      </div>
    </div>
  </div>

</div>
<div class="espacio"></div>
<div class="ancho">



</div>

<section>
  <div>
    <!-- row -->
    <div class="row">
      <div class="col-12 mb-6">
        <!-- heading -->
        @php
            $unprodx=isset($unprod)?json_encode($unprod):'';
            $unvendedorx=isset($vendedor)?json_encode($vendedor):'';
        @endphp
          <div style="display: none;">
            <input type="text" value="{{$unprodx}}" id="unprodcliente">
            <input type="text" value="{{$unvendedorx}}" id="unvendedor">
            <button data-bs-toggle="modal" data-bs-target="#detalleUnProd" id="btnoculto">xxx</button>
          </div>
       
        <h3 class="mb-1" id="titulocategoria">Todas las Categorías</h3>
        <p class="mb-0" id="titulomarca">Todas las Marcas</p>

      </div>
    </div>
    @php
    $contfilas=0;
    $contcols=0;
    $nroprods=count($prods);
    $nrofilas=(int)$nroprods/5;
    $residuo=$nroprods % 5;
    @endphp
    <div id="productos">
    <div class="row">
      @foreach ($prods as $unprod)
      @if ($contcols<5) <div class="col">
        <div class="item">
          <div class="card card-product" style="height: 100%">
            <div class="card-body">
              <div class="text-center position-relative ">
                <a href="#!"> <img src="{{url('/images/'.$unprod->imagenes)}}" alt="Ferreterías Ofertón"
                    class="mb-3 img-fluid" data-bs-toggle="modal" data-bs-target="#detalleUnProd"
                    onclick="llenamodalini({{json_encode($unprod)}})">
                </a>
              </div>
              <div class="text-small mb-1"><a href="#!"
                  class="text-decoration-none text-muted"><small>{{$unprod->descripcion}}</small></a></div>
              <h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">{{$unprod->marca}}</a>
              </h2>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <div><span class="text-dark" style="font-weight: bold">Bs.{{$unprod->precioventa}}</span> <span
                    class="text-decoration-line-through text-muted">Bs.{{($unprod->precioventa +
                    (int)$unprod->precioventa*0.1)}}</span>
                </div>
                <div><a href="#!" class="btn btn-sm" style="background:limegreen;color:white;" onclick="llenamodalini({{json_encode($unprod)}})" data-bs-toggle="modal" data-bs-target="#detalleUnProd">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="feather feather-plus">
                      <line x1="12" y1="5" x2="12" y2="19"></line>
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg> Añadir</a></div>
              </div>
            </div>
          </div>
        </div>
        <!-- item -->
    </div>
    @php
    $contcols++;
    @endphp
    @else
  </div>
  <div class="espacio"></div>
  <div class="row">
    <div class="col">
      <div class="item">
        <div class="card card-product" style="height: 100%;">
          <div class="card-body">
            <div class="text-center position-relative ">
              <a href="#!"> <img src="{{url('/images/'.$unprod->imagenes)}}" alt="Ferreterías Ofertón"
                class="mb-3 img-fluid" data-bs-toggle="modal" data-bs-target="#detalleUnProd"
                onclick="llenamodalini({{json_encode($unprod)}})">
            </a>
            </div>
            <div class="text-small mb-1"><a href="#!"
                class="text-decoration-none text-muted"><small>{{$unprod->descripcion}}</small></a></div>
            <h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">{{$unprod->marca}}</a>
            </h2>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <div><span class="text-dark" style="font-weight: bold">Bs.{{$unprod->precioventa}}</span> <span
                  class="text-decoration-line-through text-muted">Bs.{{$unprod->precioventa +
                  (int)$unprod->precioventa*0.1}}</span>
              </div>
              <div><a href="#!" class="btn btn-sm" style="background:limegreen;color:white;" onclick="llenamodalini({{json_encode($unprod)}})" data-bs-toggle="modal" data-bs-target="#detalleUnProd">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-plus">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg> Añadir</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- item -->
    </div>
    @php
    $contcols=1;
    @endphp
    @endif

    @endforeach
    @while ($residuo<5 && $residuo>0)
    <div class="col"></div>
    @php
    $residuo++;
    @endphp
    @endwhile
    
  </div>
  </div>
    <div class="mas" style="width: 100%;text-align:right;margin:1em 0;">
      <button class="btn btn-success border" onclick="mas()">MAS...</button>
    </div>
  </div>

  {{-- ////////////////////////////////////MODAL DETALLE UN PROD ////////////////////////// --}}
  <div class="modal fade" id="detalleUnProd" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-8" style="background: #fff6b740;" id="botonesprod">
          <div class="position-absolute top-0 end-0 me-3 mt-3 z-3" style="display: flex;">
            <div style="background:lightgoldenrodyellow;border-radius: 8px;">
              <a href="javascript:void(0)" class="btn btn-outline-success fw-bold" onclick="chatvendedor()">
                <img src="{{url('/imagenes/logowhats.png')}}" alt="" style="height: 1.2em;">&nbsp;&nbsp; Consultas
              </a>
            </div>
            <div style="border: 2px solid red;display: flex;align-items: center;margin-left: 1em;border-radius: 8px;background: lightgoldenrodyellow;">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalprod"></button>
            </div>
          </div>
          
          <div class="row">
            <div class="col-lg-6">
              <!-- img slide -->
              <div class="tns-outer" id="productModal-ow">
                {{-- <div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide <span
                    class="current">1</span> of 4
                </div> --}}
                <div id="productModal-mw" class="tns-ovh">
                  <div class="tns-inner" id="productModal-iw">
                    <div class="product productModal  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal"
                      id="productModal" style="transition-duration: 0s; transform: translate3d(0%, 0px, 0px);">
                      <div class="zoom tns-item tns-slide-active" onmousemove="zoom(event)"
                        style="background-position: 99.0494% 42.7848%;"
                        id="productModal-item0">
                        <!-- img -->
                        <img src="" alt="" style="width: 100%;height:100%;">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="ps-lg-8 mt-6 mt-lg-0">
                <a href="#!" class="mb-4 d-block" id="modal_marca" style="text-decoration: none;color:forestgreen;font-weight:bold"></a>
                <h4 class="mb-1 h4" id="modal_descripcion"></h4>
                <div class="mb-4">
                  <small class="text-warning">
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-fill"></i>
                    <i class="bi bi-star-half"></i></small><a href="#" class="ms-2"></a>
                </div>
                <div class="fs-4">
                  <span class="fw-bold text-dark" id="modal_precio"></span>
                  <span class="text-decoration-line-through text-muted" id="modal_precioantes"></span><span><small
                      class="fs-6 ms-2 text-danger" id="modal_descuento"></small></span>
                </div>
                <hr class="my-6">
                <div>
                  <div class="input-group input-spinner  ">
                    <input type="button" value="-" class="button-minus  btn  btn-sm btncuantos" data-field="quantity" onclick="document.getElementById('cuantos').value>1?document.getElementById('cuantos').value--:true;">
                    <input type="number" step="1" value="1" name="quantity" class="quantity-field form-control-sm form-input" style="width: 4em;" id="cuantos">
                    <input type="button" value="+" class="button-plus btn btn-sm btncuantos" data-field="quantity" onclick="document.getElementById('cuantos').value++;">
                  </div>
                </div>
                <div class="mt-3 row justify-content-start g-2 align-items-center" >

                  <div class="col-lg-4 col-md-5 col-6 d-grid">
                    <button type="button" class="btn" style="background: limegreen;color:white;" id="btnanadiralcarrito" data-bs-dismiss="modal">
                      <i class="feather-icon icon-shopping-bag me-2"></i>Añadir al Carrito
                    </button>
                  </div>
                  <div class="col-md-4 col-5">
                    <button type="button" class="btn" style="background: limegreen;color:white;" id="btnpagarahora" data-bs-dismiss="modal">
                      <i class="feather-icon icon-shopping-bag me-2"></i>Pagar ahora
                    </button>
                    {{-- <select class="form-select" style="background: gold;font-weight:bold" onchange="comprar(this)">
                      <option selected="selected" value=''>Pagar Ahora</option>
                      <option value='qr'>Pagar con QR</option>
                      <option value='tarjeta'>Pagar con Tarjeta</option>
                      <option value='transferencia'>Pagar con Transferencia</option>
                    </select> --}}
                  </div>
                </div>
                <hr class="my-6">
                <div>
                  <table class="table table-borderless">
                    <tbody>
                      <tr>
                        <td>Código de Producto:</td>
                        <td id="modal_codprod"></td>
                      </tr>
                      <tr style="display:none;">
                        <td>Disponibles:</td>
                        <td id="modal_stock"></td>
                      </tr>
                      <tr>
                        <td>Categoría:</td>
                        <td id="modal_categoria"></td>
                      </tr>
                      <tr>
                        <td>Sucursal:</td>
                        <td ><span id="modal_sucursal" style="background: bisque;padding: 3px 8px;border-radius: 12px;"></span></td>
                      </tr>
                      <tr>
                        <td>Entregas:</td>
                        <td>
                          <small>Por Delivery ó recojo en Ferretería.<span class="text-muted">( * )</span></small>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- //////////////////////////////////////////////////////////////////////////////////// --}}

          {{-- //////////////////////////////////// MODAL CIUDADES--}}
          <div class="modal fade" id="modalCiudades" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
              <div class="modal-content">
                 <div class="modal-body p-6">
                    <div class="d-flex justify-content-between align-items-start ">
                       <div>
                          <h5 class="mb-1" id="locationModalLabel">SUCURSALES</h5>
                          <p class="mb-0 small">Si tu producto está en otra sucursal, te la hacemos llegar sin costo de traslado. </p>
                       </div>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div>
                       <div data-simplebar >
                          <div class="list-group list-group-flush">
                             {{-- <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" id="suc_1" onclick="eligesucursal(1,'Cochabamba')" data-bs-dismiss="modal"><span>Cochabamba</span></a> --}}
                             <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" id="suc_2" onclick="eligesucursal(2,'Santa Cruz')" data-bs-dismiss="modal"><span>Santa Cruz</span></a>
                             <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" id="suc_3" onclick="eligesucursal(3,'Oruro')" data-bs-dismiss="modal"><span>Oruro</span></a>
                             {{-- <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" id="suc_7" onclick="eligesucursal(7,'El Alto')" data-bs-dismiss="modal"><span>El Alto</span></a> --}}
                             <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" id="suc_4" onclick="eligesucursal(4,'La Paz')" data-bs-dismiss="modal"><span>La Paz</span></a>
                             <a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action" id="suc_0" onclick="eligesucursal(0,'Todas las Sucursales')" data-bs-dismiss="modal"><span>Todas las Sucursales</span></a>
                          </div>
                       </div>
                    </div>
                 </div>
              </div>
           </div>
          </div>
          {{-- ///////////////////////////////////// --}}


    {{-- ////////////////////////////////////MODAL CARRITO ////////////////////////// --}}
  <div class="modal fade" id="modalCarrito" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body p-8" style="background: #fff6b740;">
          <div class="position-absolute top-0 end-0 me-3 mt-3 z-3" style="border: 2px solid red;">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btncerrarcarrito"></button>
          </div>
          <div class="row">
            <h4 class="mb-1 h4" id="modal_descripcion" style="background:gold">Contenido de tu Carrito en : <span id="depcarrito"></span></h4>
            <div class="col-lg-7" >
              <div id="itemscarrito"></div>
              <div class="cupon" style="margin-top:1em;">
                Cupón de descuento:<br>
                <input type="text" style="width: 9em;border:2px solid limegreen;" id="cupon">
                <a href="javascript:void(0)" class="btn btn-outline-success" onclick='aplicarcupon()'>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                  Aplicar cupón
                </a>
                <button class="btn btn-warning" type="button" disabled id="btnloading" style="display: none;">
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Verificando cupón...
                </button>
                <hr>
                <div style="font-size:1.5em;text-align:right;display:none;">Total con descuento: <span style="color:limegreen; font-weight:bold;">7777</span></div>
              </div>
            </div>
            
            <div class="col-lg-5">
              <div class="ps-lg-8 mt-6 mt-lg-0" style="background:cornsilk;padding:1em;">
                <h5 style="color:limegreen;font-size:1.6em;text-align:right;" id="pagar"></h5>
                {{-- <div class="mb-4">
                  <a href="#" class="ms-2"></a>
                </div> --}}
                {{-- <div class="fs-4">
                  <span class="fw-bold text-dark" id="modal_precio"></span>
                  <span class="text-decoration-line-through text-muted" id="modal_precioantes"></span><span><small
                      class="fs-6 ms-2 text-danger" id="modal_descuento"></small></span>
                </div> --}}
                {{-- <hr class="my-6"> --}}
                
                <div class="mt-1 row justify-content-start g-2 align-items-center">
                  <div class="col-md-12 col-12">
                    <div>
                      <input type="text" name="nombrecli" id="nombrecli" placeholder="Tu nombre" style="width:11em;border: 1px solid limegreen;
                      background: lightyellow;">
                      <input type="number" name="celularcli" id="celularcli" placeholder="celular" style="width:6em;border: 1px solid limegreen;
                      background: lightyellow;">
                    </div>
                    <div style="color:forestgreen;font-weight:bold;">Pagar con...</div>
                    <div style="display: flex;justify-content:space-between;font-weight:bold;">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="qr" onchange="comprar(this)">
                        <label class="form-check-label" for="inlineRadio1">QR</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="transferencia" onchange="comprar(this)">
                        <label class="form-check-label" for="inlineRadio2">Transferencia</label>
                      </div>
                    </div>
                   
                    {{-- <select class="form-select" style="background: gold;font-weight:bold" onchange="comprar(this)">
                      <option selected="selected" value=''>Elija...</option>
                      <option value='qr'>Pagar con QR</option>
                      <option value='tarjeta'>Pagar con Tarjeta</option>
                      <option value='transferencia'>Pagar con Transferencia</option>
                    </select> --}}
                    <img src="{{url('/imagenes/qr.jpg')}}" alt="" id="imgqr" style="display:none;width:15em;">
                    <div class="transferencia" style="display: none;padding: 10px;border: 1px solid silver;margin-bottom: 10px;" id="transferencia">
                      Número de cuenta: {{$config[0]->nrocuenta}}
                      <div>{{$config[0]->banco}}</div>
                      <div>A nombre de: {{$config[0]->titularcuenta}}</div>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-outline-success" onclick="comprobarpago()" id='comprobarpago' style="display:none;font-weight:bold">Comprobar mi pago</a>
                  </div>
                  
                </div>
                <hr class="my-6">
                <div>
                  <table class="table table-borderless">
                    <tbody>
                      <tr>
                        {{-- <td>Entregas:</td>
                        <td>
                          <small>Por Delivery ó recojo en Ferretería.<span class="text-muted">( Delivery gratis hoy )</span></small>
                        </td> --}}
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- //////////////////////////////////////////////////////////////////////////////////// --}}   
  
    {{-- ////////////////////////////////////MODAL COMPROBAR COMPRA ////////////////////////// --}}
    
    <div class="modal fade" id="modalComprobarcompra" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-body p-8" style="background: #fff6b740;">
            <div class="position-absolute top-0 end-0 me-3 mt-3 z-3" style="border: 2px solid red;">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="row">
              <div class="col-lg-5">
                <div class="ps-lg-8 mt-6 mt-lg-0" style="background:cornsilk;padding:1em;">
                  <div class="mt-3 row justify-content-start g-2 align-items-center">
  
                    <div>
                      <img src="{{url('/imagenes/qr.jpg')}}" alt="" id="imgqr2" style="display:none;width:15em;margin:auto">
                      <div class="transferencia" style="display: none;padding: 10px;border: 1px solid silver;margin-bottom: 10px;" id="transferencia2">
                        Número de cuenta: {{$config[0]->nrocuenta}}
                        <div>{{$config[0]->banco}}</div>
                        <div>A nombre de: {{$config[0]->titularcuenta}}</div>
                      </div>
                    </div>
                    
                  </div>
                  
                  <div class="comprobante" style="display:none;" id="comprobante">
                    <div >Tu token de compra es: <span id="token" style="color:orange;overflow-wrap: anywhere;"></span></div>
                    <hr>
                    Toca el siguiente botón y Envíanos tu comprobante &nbsp;<br>
                    <a href="javascript:void(0)" class="btn btn-outline-success" onclick="enviacomprobante()">
                      <img src="{{url('/imagenes/logowhats.png')}}" alt="" style="height: 1.2em;">&nbsp;&nbsp;77939732
                    </a>
                  </div>
                  <hr class="my-6">
                  <div>
                    <table class="table table-borderless">
                      <tbody>
                        <tr>
                          <td>Entregas:</td>
                          <td>
                            <small>Por Delivery ó recojo en Ferretería.<span class="text-muted">( Delivery gratis hoy )</span></small>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{-- //////////////////////////////////////////////////////////////////////////////////// --}}   
   
      {{-- ////////////////////////////////////           MODAL CARRUSEL                 ////////////////////////// --}}
      <button style="display:none;" id="btncarrusel" data-bs-toggle="modal" data-bs-target="#modalcarrusel"></button>
      <div class="modal fade" id="modalcarrusel" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body p-8" style="background: #fff6b740;">
              <div class="position-absolute top-0 end-0 me-3 mt-3 z-3" style="border: 2px solid red;top: -1.5em !important;border: 2px solid red;right: -1.5em !important;background: white;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              
                <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" slides-per-view="2.5" space-between="30" free-mode="true" autoplay-delay="2500" autoplay-disable-on-interaction="false" id="slidecontenedor" loop="true">
                </swiper-container>
                {{-- <swiper-container class="mySwiper" pagination="true" effect="coverflow" grab-cursor="true" centered-slides="true" slides-per-view="3" coverflow-effect-rotate="50" coverflow-effect-stretch="0" coverflow-effect-depth="100" id="slidecontenedor" loop="true" autoplay-disable-on-interaction="false">
                </swiper-container> --}}
            </div>
          </div>
        </div>
      </div>
      {{-- //////////////////////////////////////////////////////////////////////////////////// --}}   

      <swiper-slide style="display: none" class="mislide" style="position: relative">
        <div class="item">
          <div class="card card-product" style="height: 100%">
            <div class="card-body" >
              <div class="text-center position-relative ">
                {{-- <a href="#!"> --}}
                   <img alt="Ferreterías Ofertón" class="mb-3 img-fluid">
                   
                {{-- </a> --}}
              </div>
            </div>
          </div>
        </div>
      </swiper-slide>
  
          @csrf
</section>

@endsection
<script>
  marca="Todas";
  sucursal=0;
  sucursalcarrito=0;
  categoria="Todas";
  unprod=null;
  buscar="";
  limite=0;
  aumentahtml=false;
  carrito=[];
  cuponserver="";
  unvendedor="";
  nombressuc=['Todas las Sucursales','Cochabamba','Santa Cruz','Oruro','La Paz','','','El Alto'];
  unprodactual=null;
  window.onload=function(e){
    saludar();
    
    if(document.getElementById("unprodcliente").value!=""){
      llegaprod=JSON.parse(document.getElementById("unprodcliente").value)[0];
      if(document.getElementById("unvendedor").value!=''){
        console.log("carrito y vendedor:",carrito,JSON.parse(document.getElementById("unvendedor").value));
        unvendedor=JSON.parse(document.getElementById("unvendedor").value)[0];
      }
      else{
        unvendedor="";
      }
      console.log(llegaprod);
      document.getElementById("btnoculto").click();
      llenamodalini(llegaprod);
      document.getElementById("suc_"+llegaprod.deposito).click();
      sucursal=llegaprod.deposito;
      sucursalcarrito=llegaprod.deposito;
      document.getElementById("depcarrito").innerText=nombressuc[sucursalcarrito];
      console.log("elem suc: ",document.getElementById("suc_"+llegaprod.deposito));
      // sucursales=document.getElementById("sucursal");
      // sucursales.value=llegaprod.deposito;
      // nombresucursal=sucursales.options[sucursales.selectedIndex].text;
      // console.log("sucursal prod y nombmre: ",sucursales.value,nombresucursal);
    }
    else{
      // document.getElementById("btncarrusel").click();
      document.getElementById("btnmodalciudades").click();
      console.log("no existe input unprodcliente");
    }
    // var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    // var toastList = toastElList.map(function (toastEl) {
    //   return new bootstrap.Toast(toastEl);
    // })
  }
  function eligesucursal(nrosuc,nombre){
    sucursal=nrosuc;
    buscar='';
    document.getElementById('sucursal').innerText=nombre;
    porajax();
    document.getElementById("slidecontenedor").innerHTML="";
    llenamodalpromo();
  }
  function llenamodalpromo(){
    dataenvio={suc:sucursal};
      console.log("enviara carrito: ",dataenvio);
        fetch("{{ route('obtienepromosdesuc')}}", {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: JSON.stringify(dataenvio)
            })
            .then(res =>res.json())
            .then(res => {
              console.log("desde server: ",res);
              if(res.length>0){
                res.forEach(unprodprom => {
                nuevoslide=document.querySelector(".mislide").cloneNode(true);
                nuevoslide.style.display="block";
                imagen=nuevoslide.querySelector("img");
                imagen.src="https://ferreteriaoferton.com/images/" + unprodprom.imagenes;
                imagen.style.width="15em;";
                botonanadir=document.createElement("button");
                botonanadir.style="position:absolute;bottom:5px;right:5px;";
                botonanadir.className="btn btn-success btn-sm";
                botonanadir.innerText="Añadir";
                botonanadir.onclick=function(){
                  console.log("anadirá: ",unprodprom);
                  llenamodalini(unprodprom);
                  document.getElementById("btnoculto").click();
                };
                document.getElementById("slidecontenedor").appendChild(nuevoslide);
                nuevoslide.appendChild(botonanadir);
              });
              document.getElementById("btncarrusel").click();
              }
              
            });

  }
  function zoom(f){var t=f.currentTarget;offsetX=f.offsetX||f.touches[0].pageX,f.offsetY?offsetY=f.offsetY:offsetX=f.touches[0].pageX,x=offsetX/t.offsetWidth*100,y=offsetY/t.offsetHeight*100,t.style.backgroundPosition=x+"% "+y+"%"}

    function llenamodalini(unprod){
      unprodactual=unprod;
      if(carrito.length==0 || unprod.deposito==sucursalcarrito){
          sucursalcarrito=unprod.deposito;
          document.getElementById("depcarrito").innerText=nombressuc[sucursalcarrito];
          console.log("llenamodalini: ",unprod);
          elobj=document.getElementById("productModal-item0");
          elobj.style.backgroundImage="url('https://ferreteriaoferton.com/public/images/"+unprod.imagenes+"')";
          imgobj=elobj.querySelector("img");
          imgobj.src="https://ferreteriaoferton.com/public/images/"+unprod.imagenes;
          document.getElementById("modal_marca").innerText=unprod.marca;
          document.getElementById("modal_descripcion").innerText=unprod.descripcion;
          document.getElementById("modal_precio").innerText="Bs."+unprod.precioventa;
          document.getElementById("modal_precioantes").innerText=unprod.precioventa + Math.trunc(unprod.precioventa*0.1);
          document.getElementById("modal_descuento").innerText="10% descuento";
          document.getElementById("modal_codprod").innerText=unprod.idprod;
          document.getElementById("modal_stock").innerText=unprod.cantidad;
          document.getElementById('cuantos').value=1;
          document.getElementById("modal_categoria").innerText=unprod.categoria;
          document.getElementById("btnanadiralcarrito").onclick=function(){
            if(carrito.find(unprodx=>unprodx.id==unprod.id)==undefined){
              console.log("anadirá: ",unprod);
              unprod.cuantos=document.getElementById('cuantos').value;
              unprod.preciofinal=unprod.precioventa;
              carrito.push(unprod);
              document.getElementById("divcarrito").style.display='';
              document.getElementById("nroitemscarrito").innerText=carrito.length;
              if(carrito.length>0){document.getElementById("nroitemscarrito").style.display="block";}
            }
            else{
              alert("YA EXISTE en tu carrito");
            }
            
          };
          document.getElementById("btnpagarahora").onclick=function(){
            
            if(carrito.find(unprodx=>unprodx.id==unprod.id)==undefined){
              console.log("anadirá: ",unprod);
              unprod.cuantos=document.getElementById('cuantos').value;
              unprod.preciofinal=unprod.precioventa;
              carrito.push(unprod);
              document.getElementById("divcarrito").style.display='';
              document.getElementById("nroitemscarrito").innerText=carrito.length;
              if(carrito.length>0){document.getElementById("nroitemscarrito").style.display="block";}
              document.getElementById("divcarrito").click();
            }
            else{
              document.getElementById("divcarrito").click();
            }

          };
          document.getElementById("modal_sucursal").innerText=nombressuc[unprod.deposito];
      }
      else{
        document.getElementById("botonesprod").style.display="none";
        alert("En tu carrito de compras ya existen productos de otra sucursal. Todos tus productos elegidos DEBEN pertenecer a la misma sucursal/ciudad");
        setTimeout(() => {
          document.getElementById("modalprod").click();
          document.getElementById("botonesprod").style.display="block";
        }, 500);
      }
    }
    function llenamodal(indice){
          unprod=listaprods[indice];
          unprodactual=unprod;
      if(carrito.length==0 || unprod.deposito==sucursalcarrito){
          console.log("sucursal y unprod.deposito: ",sucursal,unprod.deposito);
          sucursalcarrito=unprod.deposito;
          document.getElementById("depcarrito").innerText=nombressuc[sucursalcarrito];
          console.log("indice: ", indice);
          console.log("unprod en llamamodal: ",unprod);
          elobj=document.getElementById("productModal-item0");
          elobj.style.backgroundImage="url('https://ferreteriaoferton.com/public/images/"+unprod.imagenes+"')";
          imgobj=elobj.querySelector("img");
          imgobj.src="https://ferreteriaoferton.com/public/images/"+unprod.imagenes;
          document.getElementById("modal_marca").innerText=unprod.marca;
          document.getElementById("modal_descripcion").innerText=unprod.descripcion;
          document.getElementById("modal_precio").innerText="Bs."+unprod.precioventa;
          document.getElementById("modal_precioantes").innerText=unprod.precioventa + Math.trunc(unprod.precioventa*0.1);
          document.getElementById("modal_descuento").innerText="10% descuento";
          document.getElementById("modal_codprod").innerText=unprod.idprod;
          document.getElementById("modal_stock").innerText=unprod.cantidad;
          document.getElementById('cuantos').value=1;
          unprod.cuantos=1;
          document.getElementById("modal_categoria").innerText=unprod.categoria;
          document.getElementById("btnanadiralcarrito").onclick=function(){
            if(carrito.find(unprodx=>unprodx.id==unprod.id)==undefined){
              console.log("anadirá: ",unprod);
              unprod.cuantos=document.getElementById('cuantos').value;
              unprod.preciofinal=unprod.precioventa;
              carrito.push(unprod);
              document.getElementById("divcarrito").style.display='';
              document.getElementById("nroitemscarrito").innerText=carrito.length;
              if(carrito.length>0){document.getElementById("nroitemscarrito").style.display="block";}
            }
            else{
              alert("YA EXISTE en tu carrito");
            }

          };
          document.getElementById("btnpagarahora").onclick=function(){
            if(carrito.find(unprodx=>unprodx.id==unprod.id)==undefined){
              console.log("anadirá: ",unprod);
              unprod.cuantos=document.getElementById('cuantos').value;
              unprod.preciofinal=unprod.precioventa;
              carrito.push(unprod);
              document.getElementById("divcarrito").style.display='';
              document.getElementById("nroitemscarrito").innerText=carrito.length;
              if(carrito.length>0){document.getElementById("nroitemscarrito").style.display="block";}
              document.getElementById("divcarrito").click();
            }
            else{
              document.getElementById("divcarrito").click();
            }

          };
          document.getElementById("modal_sucursal").innerText=nombressuc[unprod.deposito];
      
      }
      else{
        document.getElementById("botonesprod").style.display="none";
        alert("En tu carrito de compras ya existen productos de otra sucursal. Todos tus productos elegidos DEBEN pertenecer a la misma sucursal/ciudad");
        setTimeout(() => {
          document.getElementById("modalprod").click();
          document.getElementById("botonesprod").style.display="block";
        }, 500);
      }

    }
    function porajax(){

      dataenvio=[{marca:marca,sucursal:sucursal,categoria:'Todas',buscar:buscar,limite:limite}];
      console.log("dataenvio: ",dataenvio);
      fetch("{{ route('obtieneproductos')}}", {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: JSON.stringify(dataenvio)
            })
            .then(res => res.json())
            .then(res => {
                document.getElementById("titulomarca").innerText=marca;
                // document.getElementById("titulocategoria").innerText=document.getElementById("categoria").options[document.getElementById("categoria").selectedIndex].text;
                console.log("desdeBD: ",res);
                contfilas=0;
                contcols=0;
                nroprods=res.length;
                nrofilas=Math.trunc(nroprods/5);
                residuo=nroprods % 5;
                listaprods=[];
                contador=0;
                html='<div class="espacio"></div><div class="row">';
                res.forEach(unprod => {
                  // console.log("unprod: ",unprod);
                  listaprods.push(unprod);
                  if (contcols<5){
                    html+='<div class="col">';
                    html+='<div class="item"><div class="card card-product" style="height: 100%"><div class="card-body"><div class="text-center position-relative ">';
                    html+='<a href="#!"> <img src="/public/images/'+unprod.imagenes+'" alt="" class="mb-3 img-fluid" data-bs-toggle="modal" data-bs-target="#detalleUnProd" onclick="llenamodal('+contador+');"></a>';
                    html+='</div>';
                    html+='<div class="text-small mb-1"><a href="#!" class="text-decoration-none text-muted"><small>'+unprod.descripcion+'</small></a></div>';
                    html+='<h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">'+unprod.marca+'</a>';
                    html+='</h2>';
                    html+='<div class="d-flex justify-content-between align-items-center mt-3">';
                    html+='<div><span class="text-dark" style="font-weight: bold">Bs.'+unprod.precioventa+'</span> <span class="text-decoration-line-through text-muted">Bs.'+(unprod.precioventa*1 + Math.trunc(unprod.precioventa*0.1)*1)+'</span>';
                    html+='</div>';
                    html+='<div><a href="#!" class="btn btn-sm" style="background:limegreen;color:white;" onclick="llenamodal('+contador+');" data-bs-toggle="modal" data-bs-target="#detalleUnProd">';
                    html+='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">';
                    html+='<line x1="12" y1="5" x2="12" y2="19"></line>';
                    html+='<line x1="5" y1="12" x2="19" y2="12"></line>';
                    html+='</svg> Añadir</a></div>';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    contcols++;
                  } 
                  else{
                    html+='</div>';
                    html+='<div class="espacio"></div>';
                    html+='<div class="row">';
                    html+='<div class="col">';
                    html+='<div class="item">';
                    html+='<div class="card card-product" style="height: 100%;">';
                    html+='<div class="card-body">';
                    html+='<div class="text-center position-relative ">';
                    html+='<a href="#!"> <img src="/public/images/'+unprod.imagenes+'" alt="Ferreterías Ofertón" class="mb-3 img-fluid" data-bs-toggle="modal" data-bs-target="#detalleUnProd" onclick="llenamodal('+contador+');">';
                    html+='</a>';
                    html+='</div>';
                    html+=' <div class="text-small mb-1"><a href="#!" class="text-decoration-none text-muted"><small>'+unprod.descripcion+'</small></a></div>';
                    html+='<h2 class="fs-6"><a href="#!" class="text-inherit text-decoration-none">'+unprod.marca+'</a>';
                    html+='</h2>';
                    html+='<div class="d-flex justify-content-between align-items-center mt-3">';
                    html+=' <div><span class="text-dark" style="font-weight: bold">Bs.'+unprod.precioventa+'</span> <span class="text-decoration-line-through text-muted">Bs'+(unprod.precioventa*1 + Math.trunc(unprod.precioventa*0.1)*1)+'</span>';
                    html+='</div>';
                    html+='<div><a href="#!" class="btn btn-sm" style="background:limegreen;color:white;" onclick="llenamodal('+contador+');" data-bs-toggle="modal" data-bs-target="#detalleUnProd">';
                    html+='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">';
                    html+='<line x1="12" y1="5" x2="12" y2="19"></line>';
                    html+='<line x1="5" y1="12" x2="19" y2="12"></line>';
                    html+='</svg> Añadir</a></div>';
                    html+='</div>';
                    html+='</div>';
                    html+='</div>';
                    html+=' </div>';
                    html+='</div>';
                    contcols=1;
                  }
                  contador++;
                });
                while(residuo>0 && residuo<5){
                    html+='<div class="col"></div>';
                    residuo++;
                }
                  if(!aumentahtml){
                    document.getElementById("productos").innerHTML="";
                    document.getElementById("productos").innerHTML=html;
                  }
                  else{
                    document.getElementById("productos").innerHTML+=html;
                    aumentahtml=false;
                  }
            });
          
    }
    function buscador(){
      document.getElementById('marca').innerText='Todas las marcas';
      marca="Todas";
      categoria="Todas";
      // document.getElementById('categoria').value='Todas';
      console.log("buscará: ",document.getElementById("buscar").value);
      buscar=document.getElementById("buscar").value;
      document.getElementById("buscar").value="";
      porajax();
    }
    function mas(){
      limite+=15;
      aumentahtml=true;
      porajax();
    }
    function anadealcarrito(){

    }
    function vecarrito(){
      console.log("carrito: ",carrito);
      totaliza=0;
      html='<div class="list-group list-group-flush">';
      
      carrito.forEach((unprod,key) => {
        if(unprod.cupon!==undefined){
          imgcupon=`
            <div style="position:absolute;right:0;top:0;color:limegreen;">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
            </div>
          `;
        }
        else{
          imgcupon="";
        }
        subtotal=unprod.preciofinal * unprod.cuantos
        totaliza+=subtotal;
        html+='<div style="display:flex;"><div class="xitemcarrito" onclick="xitemcarrito('+key+')">x</div><a href="#" class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 list-group-item-action"> <span>'+unprod.descripcion+'</span></a>';
        html+=`<div class='cantcarrito'>` +imgcupon+ `

                  <div class="input-group input-spinner" style="flex-wrap:nowrap !important;">
                    <input type="button" value="-" class="button-minus  btn  btn-sm " data-field="quantity" onclick="disminuyeitem(this,`+key+`)">
                    <input type="number" step="1" max="10" value="`+unprod.cuantos+`" name="quantity" class="quantity-field form-control-sm form-input" style="width: 4.2em;" readonly>
                    <input type="button" value="+" class="button-plus btn btn-sm " data-field="quantity" onclick="aumentaitem(this,`+key+`)">
                  </div>
                  <div class="input-group input-spinner" style="flex-wrap:nowrap !important;">
                    
                    <span style="font-size:1.2em; width:100%;text-align:right;margin-right:5px" class="subtotal">Bs.`+subtotal+`</span>
                  </div>
               </div>
              </div>`;
       
      });
      html+=`<div style="text-align:right;font-weight:bold;color:limegreen;font-size:1.2em;"><span id="totaliza">Total Bs.`+totaliza+`</span></div>`;
      html+='</div>';
      document.getElementById("itemscarrito").innerHTML=html;
      document.getElementById("pagar").innerText="Bs."+totaliza;
    }
    function xitemcarrito(key){
      delete carrito[key].cupon;
      carrito.splice(key,1);
      document.getElementById("nroitemscarrito").innerText=carrito.length;
      if(carrito.length<=0){document.getElementById("nroitemscarrito").style.display="none";}
      vecarrito();
    }
    function aumentaitem(objeto,key){
      lacant=objeto.parentElement.querySelector("input[type=number]");
      lacant.value++;
      carrito[key].cuantos=lacant.value;
      subtotal=carrito[key].preciofinal * carrito[key].cuantos;
      objeto.parentElement.parentElement.querySelector("div:nth-child(2) span").innerText="Bs."+subtotal;
      totalizador();
    }
    function disminuyeitem(objeto,key){
      lacant=objeto.parentElement.querySelector("input[type=number]");
      if(lacant.value>1) {lacant.value--;}
      carrito[key].cuantos=lacant.value;
      subtotal=carrito[key].preciofinal * carrito[key].cuantos;
      objeto.parentElement.parentElement.querySelector("div:nth-child(2) span").innerText="Bs."+subtotal;
      totalizador();
    }
    function totalizador(){
      totaliza=0;
      carrito.forEach(unprod => {
        totaliza+=unprod.preciofinal * unprod.cuantos;
        document.getElementById("totaliza").innerText="Total Bs."+totaliza;
      });
      document.getElementById("pagar").innerText="Bs."+totaliza;
    }
    function comprar(metodo){
      
      if(metodo.value=="qr"){
        metodopago="qr";
        document.getElementById("imgqr").style.display="block";
        document.getElementById("imgqr2").style.display="block";
        document.getElementById("transferencia").style.display="none";
        document.getElementById("transferencia2").style.display="none";
      }
      else{
        metodopago="transferencia";
        document.getElementById("imgqr").style.display="none";
        document.getElementById("imgqr2").style.display="none";
        document.getElementById("transferencia").style.display="block";
        document.getElementById("transferencia2").style.display="block";
      }
      document.getElementById("comprobarpago").style.display="block";
    }
    function comprobarpago(){
      console.log("guardará compra online? ");
      console.log("unvendedor input: ", document.getElementById("unvendedor").value);
      // if(document.getElementById("unvendedor").value!=''){
      //   console.log("carrito y vendedor:",carrito,JSON.parse(document.getElementById("unvendedor").value));
      //   unvendedor=JSON.parse(document.getElementById("unvendedor").value)[0];
      // }
      // else{
      //   unvendedor="";
      // }
      if(carrito.length>0){document.getElementById("comprobante").style.display="block";}
      
      guardarpreventa();
    }
    function guardarpreventa(){
      console.log("guardarpreventa");
      nombrecli=document.getElementById("nombrecli").value;
      celularcli=document.getElementById("celularcli").value;
      if(nombrecli.length>3 && celularcli.length>3){
        dataenvio=[{carrito:carrito,unvendedor:unvendedor,cupon:cuponserver,cliente:nombrecli,celular:celularcli,metodopago:metodopago,deposito:sucursalcarrito,origen:"web"}];
        console.log("enviara carrito: ",dataenvio);
          fetch("{{ route('guardacarritoprev')}}", {
              method: 'post',
              headers: {
                  'Accept': 'application/json, text/plain, */*',
                  'Content-Type': 'application/json',
                  "X-Requested-With": "XMLHttpRequest",
                  "X-CSRF-Token": document.querySelector('input[name="_token"]').value
              },
              credentials: "same-origin",
              body: JSON.stringify(dataenvio)
              })
              .then(res =>res.json())
              .then(res => {
                console.log("desde server: ",res);
                carrito=[];
                vecarrito();   
                preventa={id:res.id,fecha:res.fecha_creacion};
                datapreventa=window.btoa(JSON.stringify(preventa));
                document.getElementById("token").innerText=datapreventa;
                document.getElementById("nroitemscarrito").style.display="none";
                document.getElementById("imgqr").style.display="none";
                document.getElementById("comprobarpago").style.display="none";
                document.getElementById("btncerrarcarrito").click();
                setTimeout(() => {
                  document.getElementById("btncomprobarcompra").click();
                }, 500);
                //  document.getElementById("btncomprobarcompra").click();
                //  document.getElementById("comprobarpago").disabled=true;
              });
      }
      else{
        alert("Falta tu NOMBRE Y CELULAR");
      }

    }
    function enviacomprobante(){
      // data=window.btoa(JSON.stringify({carrito:carrito,vendedor:unvendedor}));
      
      console.log("datapreventa: ",datapreventa);
      window.location='https://api.whatsapp.com/send?phone=59177939732&text=Mi código de compra es:  '+datapreventa;
    }
    function chatvendedor(){
      console.log("vendedor y llegaprod: ",unvendedor,llegaprod);
      window.location='https://api.whatsapp.com/send?phone=591'+unvendedor.telefono+'&text=Mi consulta sobre el producto '+unprodactual.id;
    }
    function aplicarcupon(){
      cupon=document.getElementById("cupon").value;
      if(cupon!==""){
        document.getElementById("btnloading").style.display="block";
        dataenvio=[{cupon:document.getElementById("cupon").value,unvendedor:unvendedor}];
        fetch("{{ route('verificacupon')}}", {
            method: 'post',
            headers: {
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-Token": document.querySelector('input[name="_token"]').value
            },
            credentials: "same-origin",
            body: JSON.stringify(dataenvio)
            })
            .then(res => res.json())
            .then(res => {
              console.log("cupon:",res);
              document.getElementById("btnloading").style.display="none";
              cuponserver=res;
              if(cuponserver.length>0 && cuponserver[0].vigente==1){
                carrito=carrito.map(unprod=>{
                  if(unprod.id==res[0].producto && !unprod.cupon){
                    unprod.preciofinal=unprod.preciofinal - cuponserver[0].descuento;
                    unprod.comision=unprod - cuponserver[0].descuento;
                    unprod.cupon=cuponserver[0];
                    if(unvendedor==""){
                      unvendedor={id:cuponserver.idvendedor,nombre:cuponserver.nombre,telefono:cuponserver.telefono};
                    }
                    // toast.show();
                  }
                  else{
                    alert("Ya fue aplicado este cupón");
                  }
                  return unprod;
                
                });
                console.log("carrito con cupon: ",carrito);
                vecarrito(); 
              }
              else{
                alert("Cupón no válido o ya usado");
              }
                        
            });
      }
      
    }
</script>