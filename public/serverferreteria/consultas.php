<?php
header("Access-Control-Allow-Origin: *");
require_once "conector.php";
date_default_timezone_set("America/La_Paz");
$acentos=$conexion->query("SET NAMES 'utf8'");

function image_resize($file_name, $width, $height,$nombrepeq, $crop=FALSE) {
   list($wid, $ht) = getimagesize($file_name);
   $r = $wid / $ht;
   if ($crop) {
      if ($wid > $ht) {
         $wid = ceil($wid-($width*abs($r-$width/$height)));
      } else {
         $ht = ceil($ht-($ht*abs($r-$w/$h)));
      }
      $new_width = $width;
      $new_height = $height;
   } else {
      if ($width/$height > $r) {
         $new_width = $height*$r;
         $new_height = $height;
      } else {
         $new_height = $width/$r;
         $new_width = $width;
      }
   }
   $source = imagecreatefromjpeg($file_name);
   $dst = imagecreatetruecolor($new_width, $new_height);
   imagecopyresampled($dst, $source, 0, 0, 0, 0, $new_width, $new_height, $wid, $ht);
   imagejpeg($dst, "imagenes/".$nombrepeq);
   return $dst;
}
function sendFCM($tokens,$region,$sala,$comentario) {
$titulo=$region." - ".$sala;
$cuerpo=$comentario;
$estructura=array (
  'notification' => 
  array (
    'title' => $titulo,
    'body' => $cuerpo,
  ),
  'registration_ids' => $tokens
);
    $fields = json_encode ( $estructura);
$url="https://fcm.googleapis.com/fcm/send";
    $headers = array (
            'Authorization: key=' . "AAAA_2IKHXo:APA91bFo4BIO8PfmLyABh4hfLYS6arSC6JFn3dpfzKUwIUTXDPMRR19NWsD13qWAqs37TShx2BXuRg3nn0oANz0yf_FV37zujQYoL73MZsGG_rvDEmMZfqdiIOXFAeBCKm649sVZVMJc",
            'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    //echo json_encode($result);
    curl_close ( $ch );
}
$consulta=$_REQUEST["consulta"];
switch ($consulta){
	case "subefotocam":
		$nombrearch=$_FILES["fotocam"]["name"];
		$subir=$_FILES["fotocam"]["tmp_name"];
		$micro=round(microtime(true));
		$aux = explode(".", $nombrearch);
		$nuevonombre ="camara_".$micro.'.'.end($aux);
			if(move_uploaded_file($subir,"adjuntos/".basename($nuevonombre))){
			
				echo json_encode($nuevonombre);
			}
			else { echo json_encode("errorsubiendo");}
		break;
	case "recibearch":
		$archs=$_FILES["arch"]["name"];
		$nroarchs=count($archs);
		$micro=round(microtime(true));
		$listarchs=[];
		for($k=0;$k<$nroarchs;$k++){
			$nombrearch=$_FILES["arch"]["name"][$k];
			$aux = explode(".", $nombrearch);
			$nuevonombre ="galeria_".$micro.'.'.end($aux);
			$subir=$_FILES["arch"]["tmp_name"][$k];
			if(move_uploaded_file($subir,"adjuntos/".basename($nuevonombre))){
				$listarchs[]=basename($nuevonombre);
				//echo "subido";
			}
			else { echo json_encode("errorsubiendo");}
		}
		$xxx=implode(":",$listarchs);
		echo json_encode($xxx);
		break;
	case "obtieneusuario":
		$login=$_REQUEST["login"];
		$pass=$_REQUEST["password"];
		$sql="select * from vendedores where email='$login' and password='$pass' and estado='Activo'";	
		$res=$conexion->query($sql);
		$filas=[];
        	while($unreg=$res->fetch_assoc()){
            		$filas[]=$unreg;
        	}
        	echo json_encode($filas);

		break;
   case "obtienedepositos":
      $sql="select * from depositos where id in (1,2,3,4)";	
      $res=$conexion->query($sql);
      $filas=[];
            while($unreg=$res->fetch_assoc()){
                  $filas[]=$unreg;
            }
            echo json_encode($filas);

      break;
   case "obtieneproductos":
         $dep=$_REQUEST["deposito"];
         $texto=$_REQUEST["texto"];
         $sql="select * from inventarios where deposito='$dep' and (descripcion like '%$texto%' or idprod like '$texto%') limit 10";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "obtienecomisionesporcobrar":
         $idusr=$_REQUEST["idusr"];
         $sql="select tb2.*,depositos.nombre from (select tb1.*,ventas.fecha,ventas.idneg,ventas.cliente,ventas.telefono from (select * from detalleventas where pagocomision is null and vendedor='$idusr') as tb1 inner join ventas on tb1.idventa=ventas.idventa) as tb2 inner join depositos on tb2.idneg=depositos.id";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "obtienecomisionescobradas":
         $idusr=$_REQUEST["idusr"];
         $sql="select tb2.*,depositos.nombre from (select tb1.*,date(ventas.fecha) as fecha,ventas.idneg,ventas.cliente,ventas.telefono from (select * from detalleventas where not(pagocomision is null) and vendedor='$idusr') as tb1 inner join ventas on tb1.idventa=ventas.idventa) as tb2 inner join depositos on tb2.idneg=depositos.id order by pagocomision desc";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "obtieneventassinvendedor":
         $sql="select tb3.*,descripcion,precioventa,preciofinal,cuantos,comision from (select tb2.*,depositos.nombre as deposito from (select ventas.idventa,ventas.idneg,cliente,telefono,fecha,tb1.* from ventas inner join (SELECT id as idv,nombre FROM `vendedores` where nombre='PENDIENTE DE VENTA' or rol='Enc. Tienda y caja' and estado='activo') as tb1 on ventas.vendedor=tb1.idv) as tb2 inner join depositos on tb2.idneg=depositos.id) as tb3 inner join detalleventas on tb3.idventa=detalleventas.idventa where comision>0 order by fecha desc,idventa";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "listacarpeta":
         $fotos=scandir("../public/images");
         // $res=$conexion->query("select id,idprod,descripcion from inventarios");
         echo json_encode($fotos);
      break;
      case "buscaenotrosdep":
         $idprod=$_REQUEST["idprod"];
         $sql="select tb1.*,depositos.nombre as nomdep from (select * from inventarios where idprod='$idprod' and cantidad>'0') as tb1 inner join depositos on tb1.deposito=depositos.id where depositos.id in (1,2,3,4,7)";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "registrapreventa":
         $unprod=json_decode($_REQUEST["unprod"]);
         $deposito=$unprod->deposito;
         $desc=$unprod->descripcion;
         $vendedor=$_REQUEST["vendedor"];
         $idprod=$unprod->idprod;
         $tiempo=$_REQUEST["tiempo"];
         $cliente=$_REQUEST["cliente"];
         $celular=$_REQUEST["celular"];
         $comentarios=$_REQUEST["comentarios"];
         $fechareg=date("Y-m-d H:i:s");
         $sql="insert into preventas values('','$idprod','$deposito','$desc','$cliente','$celular','$tiempo','$fechareg','$comentarios','$vendedor')";
         if($conexion->query($sql)){
            echo json_encode("registrado");
         }
         else{
            echo json_encode("noregistrado");
         }
      break;
      case "obtienereservas":
         $vendedor=$_REQUEST["vendedor"];
         $sql="select *,date_format(fechareg,'%d-%m-%Y %H:%m') as fecharegx,datediff(date_add(fechareg, interval tiempo day),now()) as faltan,date_format(date_add(fechareg, interval tiempo day),'%d-%m-%Y %H:%m') as vence from preventas where vendedor='$vendedor' order by fechareg desc
         ";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "eliminareserva":
         $idres=$_REQUEST["idres"];
         $sql="delete from preventas where id='$idres'";
         if($conexion->query($sql)){
            echo json_encode("eliminao");
         }
         else{
            echo json_encode("noeliminado");
         }
      break;
      case "obtieneclientes":
         $vendedor=$_REQUEST["vendedor"];
         $sql="select cliente,celular,date_format(max(fechareg),'%d-%m-%Y') as ultfecha,count(*) as nrores from preventas where vendedor='$vendedor' group by celular order by cliente";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "obtienemarcas":
         $sql="SELECT marca,count(*) as cant FROM `inventarios` where cantidad>0 and comision>0 group by marca";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "obtienelistaunamarca":
         $marca=$_REQUEST["marca"];
         $sql="select tb1.*,depositos.nombre from (SELECT idprod,descripcion,cantidad,precioventa,comision,deposito,imagenes,id from inventarios where marca='$marca' and cantidad>0 and comision>0) as tb1 inner join depositos on tb1.deposito=depositos.id order by descripcion";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "registrarventa":
         $datosventa=json_decode($_REQUEST["datosventa"]);
         $venta=$datosventa[0]->venta;
         $deposito=$datosventa[0]->deposito;
         $detalle=$datosventa[0]->detalle;
         $usuario=$datosventa[0]->usuario;
         $idcliente=$venta->idcliente;
         $pago=$venta->pago;
         $saldo=$venta->saldo;
         if($venta->formapago=="credito"){
            $formapago=$venta->formapagoacredito;
         }
         else{
            $formapago=$venta->formapago;
            $pago=$venta->total;
            $saldo=0;
         }
         $uuid=uniqid();
         $hoy=date("Y-m-d H:i:s");
         $sql1="insert into ventas values('','$deposito','$uuid','".$venta->total."','".$venta->cliente."','".$venta->telefono."','".$venta->nit."','".$formapago."','$hoy','".$venta->comentario."','".$venta->idvendedor."','$usuario','$idcliente','$pago','$saldo')";
         if($conexion->query($sql1)){
            foreach ($detalle as $undetalle) {
              $sql2="insert into detalleventas values('','$uuid','".$undetalle->id."','".$undetalle->preciolocal."','".$undetalle->precioventa."','".$undetalle->preciofinal."','".$undetalle->cuantos."','".$undetalle->descripcion."','".$venta->idvendedor."','".$undetalle->comision."',null,null,null)";
              $conexion->query($sql2);
              $sql3="update inventarios set cantidad=cantidad - ".$undetalle->cuantos." where id='".$undetalle->id."'";
              $conexion->query($sql3);
            }
         }
         // echo json_encode($venta->cliente);
         echo json_encode("registrado");
      break;
      case "buscarvendedores":
         $textov=$_REQUEST["textov"];
         $sql="SELECT id,nombre from vendedores where nombre like '$textov%' limit 10";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "buscarclientes":
         $textov=$_REQUEST["textov"];
         $sql="select * from clientes where nombre like '$textov%' limit 30";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "listaimagenes":
         $lista=scandir("../public/images/");
         echo json_encode($lista);
      break;
      case "registrarimagen";
         $clave=$_REQUEST["clave"];
         if($clave=="soyeditor"){
            $idprod=$_REQUEST["idprod"];
            $imagen=$_REQUEST["imagen"];
            $sql="update inventarios set imagenes='$imagen' where idprod='$idprod'";
            if($conexion->query($sql)){
               echo json_encode("registrado");
            }
            else{
               echo json_encode("noregistrado");
            }
         }
      break;
      case "subeimagen":
         $clave=$_REQUEST["clave"];
         if($clave=="soyeditor"){
            $micro=round(microtime(true));
               $tmpFilePath = $_FILES['file']['tmp_name'];
               if ($tmpFilePath != ""){
                     $temp = explode(".", $_FILES["file"]["name"]);
                     $nuevonombre ="tmp_".$micro.'.'.end($temp);
                     $nombrepeq =$micro.'.'.end($temp);
                     if(move_uploaded_file($tmpFilePath,  "../public/images/".$nombrepeq)) {
                        $nuevoarch=$nombrepeq;
                     }
               }
            echo json_encode($nombrepeq);
         }
	   break;
      case "guardanuevocliente":
         $nombre=$_REQUEST["nombre"];
         $telefono=$_REQUEST["telefono"];
         $nit=$_REQUEST["nit"];
         $sql="insert into clientes values ('','$nombre','$telefono','$nit','')";
         if($conexion->query($sql)){
            $idcliente=$conexion->insert_id;
            echo json_encode($idcliente);
         }
         else{
            echo json_encode("noregistrado");
         }
      break;
      case "actualizacliente":
         $nombre=$_REQUEST["nombre"];
         $telefono=$_REQUEST["telefono"];
         $nit=$_REQUEST["nit"];
         $idcli=$_REQUEST["idcli"];
         $sql="update clientes set nombre='$nombre',telefono='$telefono',nit='$nit' where id='$idcli'";
         if($conexion->query($sql)){
            echo json_encode("registrado");
         }
         else{
            echo json_encode("noregistrado");
         }
      break;
      case "registracobro":
         $idcliente=$_REQUEST["idcliente"];
         $idusr=$_REQUEST["idusr"];
         $pago=$_REQUEST["pago"];
         $formapago=$_REQUEST["formapago"];
         $comentario=$_REQUEST["comentario"];
         $hoy=date("Y-m-d H:i:s");
         $sql="insert into cobros values('','$idcliente','$pago','$formapago','$comentario','$hoy','$idusr')";
         if($conexion->query($sql)){
            echo json_encode("registrado");
         }
         else{
            echo json_encode("noregistrado");
         }
      break;
      case "kardexcliente":
         $idcliente=$_REQUEST["idcliente"];
         $sql="select * from ( select 'venta' as concepto,date_format(fecha,'%d-%m-%y %H:%i') as fecha,total,pago,saldo,id from ventas where idcliente='$idcliente' UNION select 'pago' as concepto,date_format(fechareg,'%d-%m-%y %H:%i') as fecha,'0' as total,monto as pago,'0' as saldo,id from cobros where cliente='$idcliente') as tb1 where saldo>0 or concepto='pago' order by fecha";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "obtieneventadetalle":
         $id=$_REQUEST["id"];
         $sql1="select * from ventas where id='$id'";
         $resp1=$conexion->query($sql1);
         $unaventa=$resp1->fetch_assoc();
         $idventa=$unaventa["idventa"];
         $sql2="select * from detalleventas where idventa='$idventa'";
         $filas=[];
         $resp2=$conexion->query($sql2);
         while($unreg=$resp2->fetch_assoc()){
               $filas[]=$unreg;
         }
         $datos=["venta"=>$unaventa,"detalle"=>$filas];
         echo json_encode($datos);
      break;
      case "obtieneunpago":
         $id=$_REQUEST["id"];
         $sql="select * from cobros where id='$id'";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "registracupon":
         $hoy=date("Y-m-d H:i:s");
         $size = 6;
         $cupon = strtoupper(substr(md5(time().rand(10000,99999)), 0, $size));
         $descuento=$_REQUEST['descuento'];
         $producto=$_REQUEST['producto'];
         $vendedor=$_REQUEST['vendedor'];
         $tipo=$_REQUEST['tipo'];
         $duracion=$_REQUEST['duracion'];
         $fechacreacion=$hoy;
         $sql="insert into cupons values('','$cupon','$descuento','$producto','$vendedor','$tipo','$duracion','$fechacreacion',true)";
         if($conexion->query($sql)){
            echo json_encode($cupon);
         }
         else{
            echo json_encode("noregistrado");
         }
      break;
      case "obtienecupones":
         $id=$_REQUEST["idvendedor"];
         $sql="select * from (select *,id as idcupon from cupons where vendedor='$id') as tb1 inner join inventarios where tb1.producto=inventarios.id;";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "eliminacupon":
         $id=$_REQUEST["id"];
         $sql="delete from cupons where id='$id'";
         if($conexion->query($sql)){
            echo json_encode("eliminado");
         }
         else{
            echo json_encode("noeliminado");
         }
      break;
      case "obtieneprodstienda":
         $deposito=$_REQUEST["deposito"];
         $sql="select * from inventarios where imagenes<>'' and deposito='$deposito' and cantidad>0 limit 0,10";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         $sql2="select marca,count(*) as cant from inventarios where deposito='$deposito' and imagenes<>''  and cantidad>0 group by marca having cant>0";
         $res2=$conexion->query($sql2);
         $filas2=[];
         while($unreg2=$res2->fetch_assoc()){
               $filas2[]=$unreg2;
         }
         echo json_encode(["productos"=>$filas,"marcas"=>$filas2]);

         // echo json_encode($filas);
      break;
      case "buscaprodstienda":
         $txtbuscar=$_REQUEST['txtbuscar'];
         $marca=$_REQUEST["marca"];
         $deposito=$_REQUEST["deposito"];
         if($marca!="" && $marca!="Marca"){
            $sql="select * from inventarios where deposito='$deposito' and imagenes<>'' and marca='$marca'  and cantidad>0 and (descripcion like '%$txtbuscar%' or idprod like '$txtbuscar%') limit 0,10";
         }
         else{
            $sql="select * from inventarios where deposito='$deposito' and imagenes<>''  and cantidad>0 and (descripcion like '%$txtbuscar%' or idprod like '$txtbuscar%') limit 0,10";
         }
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "verificacupon":
         $cupon=$_REQUEST["cupon"];
         $sql="select * from cupons where cupon='$cupon'";
         $res=$conexion->query($sql);
         $unreg=$res->fetch_assoc();
         echo json_encode($unreg);
      break;
      case "obtieneconfig":
         $sql="select * from configapp";
         $res=$conexion->query($sql);
         $unreg=$res->fetch_assoc();
         echo json_encode($unreg);
      break;
      case "guardatiendapreventa":
         $datos=$_REQUEST["datos"];
         $datosx=json_decode($datos)[0];
         $hoy=date("Y-m-d H:i:s");
         $sql="insert into tiendapreventas values('','".$datosx->cliente."','".$datosx->celular."','".$datosx->metodopago."','".$datosx->deposito."','$datos','$hoy')";
         if($conexion->query($sql)){
            echo json_encode(["id"=>$conexion->insert_id,"fechareg"=>$hoy]);
         }
         else{
            echo json_encode("noregistrado");
         }
      break;
      case "buscamarcatienda":
         $marca=$_REQUEST['marca'];
         $deposito=$_REQUEST["deposito"];
         $sql="select * from inventarios where deposito='$deposito' and imagenes<>'' and marca='$marca'  and cantidad>0 limit 0,10";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);
      break;
      case "obtienemiscompras":
         $celular=$_REQUEST["celular"];
         $sql="select * from tiendapreventas where celular='$celular' order by fecha_creacion desc";
         $res=$conexion->query($sql);
         $filas=[];
         while($unreg=$res->fetch_assoc()){
               $filas[]=$unreg;
         }
         echo json_encode($filas);

      break;
      case "obtieneundeposito":
         $deposito=$_REQUEST["deposito"];
         $sql="select * from depositos where id='$deposito'";	
         $res=$conexion->query($sql);
         $unreg=$res->fetch_assoc();
         echo json_encode($unreg);
      break;
}
mysqli_close($conexion);
?>    