<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('usuarios.formuingreso');
});

Route::resource("articulos","App\Http\Controllers\ArticuloController");
Route::resource("salas","App\Http\Controllers\ASalaController");
Route::resource("categorias","App\Http\Controllers\ACategoriaController");
Route::resource("marcas","App\Http\Controllers\AMarcaController");
Route::resource("lideres","App\Http\Controllers\ALidereController");
Route::resource("lecturas","App\Http\Controllers\ALecturaController");
Route::resource("reportes","App\Http\Controllers\AReporte");
Route::resource("inventario","App\Http\Controllers\InventarioController");
Route::resource("vendedore","App\Http\Controllers\VendedoreController");
Route::resource("clientes","App\Http\Controllers\ClienteController");
Route::resource("proveedores","App\Http\Controllers\ProveedoreController");
Route::resource("marcas","App\Http\Controllers\MarcaController");
Route::resource("ventas","App\Http\Controllers\VentaController");
Route::resource("compras","App\Http\Controllers\CompraController");
Route::resource("reportesx","App\Http\Controllers\ReportexController");
Route::resource("hist_traspasos","App\Http\Controllers\HistTraspasoController");
Route::resource("cajachica","App\Http\Controllers\CajachicaController");
Route::resource("aperturacajachica","App\Http\Controllers\AperturacajachicaController");
Route::resource("preventas","App\Http\Controllers\PreventaController");
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('ferexport',"App\Http\Controllers\ASalaController@exportar")->name("salas.export");
Route::get("expcats","App\Http\Controllers\ACategoriaController@exportar")->name("cats.export");
Route::get("expmarcas","App\Http\Controllers\AMarcaController@exportar")->name("marca.export");
Route::get("expusuarios","App\Http\Controllers\ALidereController@exportar")->name("usr.export");
Route::get("explecturas","App\Http\Controllers\ALecturaController@exportar")->name("lec.export");
Route::get("reporte1","App\Http\Controllers\AReporte@reporteA")->name("rep.primero");
Route::post("ferformu","App\Http\Controllers\AReporte@recibeformu")->name("rep.recibef");

Route::get("nuevoventas","App\Http\Controllers\InventarioController@create")->name("nuevoprod");
Route::post("guardanuevoprod","App\Http\Controllers\InventarioController@store")->name("guardanuevoprod");
Route::delete("/eliminaprod/{id}","App\Http\Controllers\InventarioController@destroy")->name("eliminaprod");
Route::get("/editaprod/{id}","App\Http\Controllers\InventarioController@edit")->name("editaprod");
Route::get("/mover/{id}","App\Http\Controllers\InventarioController@mover")->name("mover");
Route::get("moverenmasa","App\Http\Controllers\InventarioController@moverenmasa")->name("moverenmasa");
Route::patch("/actualizaprod/{id}","App\Http\Controllers\InventarioController@update")->name("actualizaprod");
// Route::patch("/registramover/{id}","App\Http\Controllers\InventarioController@registramover")->name("registramover");
Route::post("registramover","App\Http\Controllers\InventarioController@registramover")->name("registramover");
Route::post("registramoverenmasa","App\Http\Controllers\InventarioController@registramoverenmasa")->name("registramoverenmasa");
Route::post("obtieneimagenesmarca","App\Http\Controllers\InventarioController@obtieneimagenesmarca")->name("obtieneimagenesmarca");
Route::post("subeimagen","App\Http\Controllers\InventarioController@subeimagen")->name("subeimagen");
Route::get("imagenesadmin","App\Http\Controllers\InventarioController@imagenesadmin")->name("imagenesadmin");
Route::get("datatableprod","App\Http\Controllers\DatatableController@inventarioz")->name("datatablecontr");
Route::post("filtradopordepot","App\Http\Controllers\DatatableController@filtradopordepot")->name("filtradopordepot");
Route::post("buscaprodkardex","App\Http\Controllers\InventarioController@buscaprodkardex")->name("buscaprodkardex");
Route::post("obtienekardexprod","App\Http\Controllers\InventarioController@obtienekardexprod")->name("obtienekardexprod");


Route::get("nuevovendedor","App\Http\Controllers\VendedoreController@create")->name("nuevovendedor");
Route::get("nuevovendedor","App\Http\Controllers\VendedoreController@create")->name("nuevovendedor");
Route::post("guardanuevovendedor","App\Http\Controllers\VendedoreController@store")->name("guardanuevovendedor");
Route::delete("/eliminavendedor/{id}","App\Http\Controllers\VendedoreController@destroy")->name("eliminavendedor");
Route::get("/editavendedor/{id}","App\Http\Controllers\VendedoreController@edit")->name("editavendedor");
Route::patch("/actualizavendedor/{id}","App\Http\Controllers\VendedoreController@update")->name("actualizavendedor");

Route::get("nuevoprov","App\Http\Controllers\ProveedoreController@create")->name("nuevoprov");
Route::post("guardanuevoprov","App\Http\Controllers\ProveedoreController@store")->name("guardanuevoprov");
Route::delete("/eliminaprov/{id}","App\Http\Controllers\ProveedoreController@destroy")->name("eliminaprov");
Route::get("/editaprov/{id}","App\Http\Controllers\ProveedoreController@edit")->name("editaprov");
Route::patch("/actualizaprov/{id}","App\Http\Controllers\ProveedoreController@update")->name("actualizaprov");

Route::get("nuevamarca","App\Http\Controllers\MarcaController@create")->name("nuevamarca");
Route::post("guardanuevamarca","App\Http\Controllers\MarcaController@store")->name("guardanuevamarca");
Route::delete("/eliminamarca/{id}","App\Http\Controllers\MarcaController@destroy")->name("eliminamarca");
Route::get("/editamarca/{id}","App\Http\Controllers\MarcaController@edit")->name("editamarca");
Route::patch("/actualizamarca/{id}","App\Http\Controllers\MarcaController@update")->name("actualizamarca");

Route::get("nuevodepot","App\Http\Controllers\DepositoController@create")->name("nuevodepot");
Route::post("guardanuevodepot","App\Http\Controllers\DepositoController@store")->name("guardanuevodepot");
Route::delete("/eliminadepto/{id}","App\Http\Controllers\DepositoController@destroy")->name("eliminadepto");
Route::get("/editadepto/{id}","App\Http\Controllers\DepositoController@edit")->name("editadepto");
Route::patch("/actualizadepto/{id}","App\Http\Controllers\DepositoController@update")->name("actualizadepto");

Route::get("nuevaventa","App\Http\Controllers\VentaController@create")->name("nuevaventa");
Route::get("nuevaventavendedor","App\Http\Controllers\VentaController@createventavendedor")->name("nuevaventavendedor");
// Route::get("solosaldos","App\Http\Controllers\VentaController@createsolosaldos")->name("solosaldos");
Route::post("guardanuevaventa","App\Http\Controllers\VentaController@store")->name("guardanuevaventa");
Route::post("actualizaventa","App\Http\Controllers\VentaController@actualizaventa")->name("actualizaventa");
Route::post("guardanuevaventavendedor","App\Http\Controllers\VentaController@storeventavendedor")->name("guardanuevaventavendedor");
// Route::delete("/eliminaventa/{id}","App\Http\Controllers\VentaController@destroy")->name("eliminaventa");
// Route::get("/editaventa/{id}","App\Http\Controllers\VentaController@edit")->name("editaventa");
Route::patch("/actualizaventa/{id}","App\Http\Controllers\VentaController@update")->name("actualizaventa");
Route::get("datatableventas","App\Http\Controllers\DatatableController@ventasz")->name("datatablecontrventas");
Route::get("buscaprod","App\Http\Controllers\VentaController@buscaprod")->name("buscaprod");
Route::get("buscaprodxamover","App\Http\Controllers\VentaController@buscaprodxamover")->name("buscaprodxamover");
Route::get("buscaprodsolosaldos","App\Http\Controllers\VentaController@buscaprodsolosaldos")->name("buscaprodsolosaldos");
Route::get("buscavendedor","App\Http\Controllers\VentaController@buscavendedor")->name("buscavendedor");
Route::get("ventassinvendedor","App\Http\Controllers\VentaController@ventassinvendedor")->name("ventassinvendedor");
Route::get("exportarventas","App\Http\Controllers\VentaController@exportarventas")->name("exportarventas");
Route::post("exportarporfechas","App\Http\Controllers\VentaController@exportarporfechas")->name("exportarporfechas");




Route::get("reportecomisiones","App\Http\Controllers\ReportexController@comisiones")->name("comisiones");
Route::get("reportecomisionespagadas","App\Http\Controllers\ReportexController@comisionespagadas")->name("comisionespagadas");
Route::get("pagacomision","App\Http\Controllers\ReportexController@pagacomision")->name("pagacomision");
Route::get("detallecompagada","App\Http\Controllers\ReportexController@detallecompagada")->name("detallecompagada");
Route::get("detallecompagada","App\Http\Controllers\ReportexController@detallecompagada")->name("detallecompagada");
Route::post("guardapagocomision","App\Http\Controllers\ReportexController@guardapagocomision")->name("guardapagocomision");

Route::get("detallev","App\Http\Controllers\VentaController@detallev")->name("ventas.detallev");
Route::post("editaventa","App\Http\Controllers\VentaController@edit")->name("ventas.editaventa");
Route::get("detalleunaventa","App\Http\Controllers\VentaController@detalleunaventa")->name("ventas.detalleunaventa");
Route::get("paracerrarcaja","App\Http\Controllers\VentaController@paracerrarcaja")->name("ventas.paracerrarcaja");
// Route::get("histcierres","App\Http\Controllers\CierreController@index")->name("cierres");
Route::get("histcierres","App\Http\Controllers\CierreController@index")->name("cierres");
Route::post("histcierres","App\Http\Controllers\CierreController@listacierres")->name("listacierres");
Route::get("detallecierres","App\Http\Controllers\CierreController@detallecierres")->name("cierres.detcierres");
Route::post("guardacierredecaja","App\Http\Controllers\VentaController@guardacierredecaja")->name("guardacierredecaja");
// Route::get("respaldoscierre","App\Http\Controllers\CierreController@respaldos")->name("cierre.respaldos");
Route::post("suberespaldos","App\Http\Controllers\CierreController@suberespaldos")->name("cierre.suberespaldos");
Route::post("eliminaventa","App\Http\Controllers\VentaController@eliminaventa")->name("eliminaventa");
// Route::post( "inventario","App\Http\Controllers\ReportexController@guardapagocomision")->name("guardapagocomision");
Route::get("historialqueries","App\Http\Controllers\VentaController@indexhistorialqueries")->name("historialqueries");
Route::post("historialqueries","App\Http\Controllers\VentaController@historialqueries")->name("historialqueries");

Route::get("plantillaexcel","App\Http\Controllers\InventarioController@plantillaexcel")->name("inventario.plantillaexcel");
Route::get("plantillaActInv","App\Http\Controllers\InventarioController@plantillaActInv")->name("inventario.plantillaActInv");
Route::get("importar","App\Http\Controllers\InventarioController@importar")->name("inventario.importar");
Route::get("exportarinv","App\Http\Controllers\InventarioController@exportarinv")->name("inventario.exportar");
Route::post("guardaimportarinv","App\Http\Controllers\InventarioController@guardaimportarinv")->name("inventario.guardaimportarinv");
Route::post("guardaimportarinvmas","App\Http\Controllers\InventarioController@guardaimportarinvmas")->name("inventario.guardaimportarinvmas");
Route::post("guardaimportaractualizacion","App\Http\Controllers\InventarioController@guardaimportaractualizacion")->name("inventario.guardaimportaractualizacion");
Route::get("kardexprod","App\Http\Controllers\InventarioController@kardexprod")->name("inventario.kardexprod");
Route::get("inventario2","App\Http\Controllers\InventarioController@inventario2")->name("inventario.inventario2");
// Route::get("inventario2","App\Http\Controllers\InventarioController@inventario2")->name("inventario.inventario2");

Route::post("validausr","App\Http\Controllers\UsuarioController@validausr")->name("validausr");

Route::get("nuevacompra","App\Http\Controllers\CompraController@create")->name("nuevacompra");
Route::post("guardanuevacompra","App\Http\Controllers\CompraController@store")->name("guardanuevacompra");
Route::get("/exportardetallecierre/{fechacierre}","App\Http\Controllers\CierreController@exportardetallecierre")->name("exportardetallecierre");
Route::get("datatablecompras","App\Http\Controllers\DatatableController@compras")->name("datatablecontrcompras");
Route::get("detalleunacompra","App\Http\Controllers\CompraController@detalleunacompra")->name("compras.detalleunacompra");
Route::post("registrapago","App\Http\Controllers\CompraController@registrapago")->name("compras.registrapago");
Route::post("ventasdetalladovendedor","App\Http\Controllers\VentaController@ventasdetalladovendedor")->name("ventas.ventasdetalladovendedor");
Route::get("comprasdetdeudas","App\Http\Controllers\CompraController@comprasdetdeudas")->name("compras.detdeudas");
Route::get("indexcreditos","App\Http\Controllers\CompraController@indexcreditos")->name("compras.indexcreditos");

Route::get("ventasxprod","App\Http\Controllers\ReportexController@ventasxprod")->name("ventasxprod");

Route::get("cajachica.create","App\Http\Controllers\CajachicaController@create")->name("cajachica.create");
Route::post("guardaapertura","App\Http\Controllers\AperturacajachicaController@update")->name("guardaapertura");
Route::post("guardacajachica","App\Http\Controllers\CajachicaController@storecajachica")->name("guardacajachica");
Route::get("detallecajachicaxfecha","App\Http\Controllers\CajachicaController@detallecajachicaxfecha")->name("detallecajachicaxfecha");
Route::post("detallecajachicaxfecha2","App\Http\Controllers\CajachicaController@detallecajachicaxfecha2")->name("detallecajachicaxfecha2");
Route::post("aperturacajachica2","App\Http\Controllers\AperturacajachicaController@aperturacajachica2")->name("aperturacajachica2");
Route::post("eliminadecajachica","App\Http\Controllers\CajachicaController@eliminadecajachica")->name("eliminadecajachica");

Route::post("obtienereservas","App\Http\Controllers\PreventaController@obtienereservas")->name("obtienereservas");

Route::post("buscacliente","App\Http\Controllers\ClienteController@buscacliente")->name("buscacliente");
Route::post("guardanuevocliente2","App\Http\Controllers\ClienteController@guardanuevocliente2")->name("guardanuevocliente2");

Route::get("servicios","App\Http\Controllers\ServicioController@index")->name("servicios");
Route::post("guardanuevoservicio","App\Http\Controllers\ServicioController@store")->name("guardanuevoservicio");
Route::delete("/eliminaservicio/{id}","App\Http\Controllers\ServicioController@destroy")->name("eliminaservicio");
Route::patch("/actualizaservicio/{id}","App\Http\Controllers\ServicioController@update")->name("actualizaservicio");

Route::post("guardanuevocliente","App\Http\Controllers\ClienteController@store")->name("guardanuevocliente");
Route::delete("/eliminacliente/{id}","App\Http\Controllers\ClienteController@destroy")->name("eliminacliente");
Route::patch("/actualizacliente/{id}","App\Http\Controllers\ClienteController@update")->name("actualizacliente");
Route::get("cargaclientes","App\Http\Controllers\ClienteController@cargaclientes")->name("cargaclientes");

Route::get("exportarusuarios","App\Http\Controllers\VendedoreController@exportarusuarios")->name("exportarusuarios");
Route::get("exportarproveedores","App\Http\Controllers\ProveedoreController@exportarproveedores")->name("exportarproveedores");
Route::get("exportarclientes","App\Http\Controllers\ClienteController@exportarclientes")->name("exportarclientes");

Route::post("verkardex","App\Http\Controllers\VentaController@verkardex")->name("verkardex");

Route::get("tienda","App\Http\Controllers\MarketController@index")->name("tienda");
Route::post("obtieneproductos","App\Http\Controllers\MarketController@obtieneprodsajax")->name("obtieneproductos");