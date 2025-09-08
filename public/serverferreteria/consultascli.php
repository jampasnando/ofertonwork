<?php
header("Access-Control-Allow-Origin: *");
require_once "conector.php";
date_default_timezone_set("America/La_Paz");
$acentos=$conexion->query("SET NAMES 'utf8'");
$consulta=$_REQUEST["consulta"];
function sendGCM($token,$cliente,$mensaje,$titulo,$negtoken) {
$cuerpo=$mensaje;
$estructura=array (
  'notification' => 
  array (
    'title' => $titulo,
    'body' => $cuerpo,
  ),
  'to' => $token,
);
    $fields = json_encode ( $estructura);
$url="https://fcm.googleapis.com/fcm/send";
    $headers = array (
            
            'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
    $result = curl_exec ( $ch );

	$estructura=array (
  		'notification' => 
  		array (
    		'title' => "NUEVO PEDIDO!",
    		'body' => $cliente,
  		),
  		'to' => $negtoken,
	);
     $headers = array (
            'Authorization: key=' . "AAAANZDDjKI:APA91bGPcEZJ84ewDNhxXujbe41ycT6YeMR1e1GvhaBZb5KsvWwyoi73fgtNsLa21-QXCkapNgYBwIYVQyX2P73xP_PRBHGtANnYwX-WaSer4ZEINVxkbdkF_LWaNYozVjWUQKoygROF",
            'Content-Type: application/json'
    );
    
    $fields = json_encode ( $estructura);
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
 	$result = curl_exec ( $ch );
    curl_close ( $ch );
}
switch ($consulta){
	case "obtienenegocios":
		$ahora=date("H:i:s");
		//$sql="select *,time_to_sec(TIMEDIFF('$ahora',horaini)) as h1,time_to_sec(TIMEDIFF(horafin,'$ahora')) as h2 from negocios where estado='activo' or estado='cerrado'";
		$sql="select tb1.*,tb2.* from (select negocios.*,time_to_sec(TIMEDIFF('$ahora',horaini)) as h1,time_to_sec(TIMEDIFF(horafin,'$ahora')) as h2 from negocios where estado='activo' or estado='cerrado') as tb1 left join (SELECT idneg,nombrecli,sum(velocidad) as sumv,COUNT(velocidad) as contv,sum(comida) as sumc,COUNT(comida) as contc,sum(servicio) as sums,COUNT(servicio) as conts,comentario FROM `calificaciones` GROUP by idneg) as tb2 on tb1.id=tb2.idneg";
		$res=$conexion->query($sql);
		$filas=[];
		while($unreg=$res->fetch_assoc()){
		$aux1=explode(":",$unreg["horaini"]);
		unset($aux1[count($aux1)-1]);
		$unreg["horaini"]=implode(":",$aux1);
		$aux2=explode(":",$unreg["horafin"]);
		unset($aux2[count($aux2)-1]);
		$unreg["horafin"]=implode(":",$aux2);	
		$filas[]=$unreg;
		}
		echo json_encode($filas);
		break;
	case "obtieneprods":
		$idneg=$_REQUEST["idneg"];
		$sql="select * from productos where idneg='$idneg' order by tipo,orden";	
		$res=$conexion->query($sql);
		$filas=[];
        	while($unreg=$res->fetch_assoc()){
            	$filas[]=$unreg;
        	}
        	echo json_encode($filas);

		break;
	case "registrapedido":
		$fechareg=date("Y-m-d H:i:s");
		$identificador=uniqid();
		$datos=$_REQUEST["datos"];
		$jsonobj=json_decode($datos);
		$idneg=$jsonobj->pedido->idneg;
		$idcelu=$jsonobj->pedido->idcelu;
		$nombrecli=$jsonobj->pedido->cliente;
		$nit=$jsonobj->pedido->nit;
		$telf=$jsonobj->pedido->telf;
		$celular=$jsonobj->pedido->celular;
		$direccion=$jsonobj->pedido->direccion;
		$lat=$jsonobj->pedido->lat;
		$lng=$jsonobj->pedido->lng;
		$costocarrera=$jsonobj->pedido->costocarrera;
		$detalles=$jsonobj->detalles;
		$instrucciones=$jsonobj->pedido->instrucciones;
		$token=$_REQUEST["token"];
		$sql1="insert into pedidos values('','$idneg','$fechareg','$identificador','$idcelu','$nombrecli','$nit','$telf','$celular','$direccion','0','$costocarrera','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','','$lat','$lng','0','$instrucciones','$token')";
		if($conexion->query($sql1)){
			$total=0;
			for($k=0;$k<count($detalles);$k++){
				$idprod=$detalles[$k]->id;
				$preciou=$detalles[$k]->costo;
				$cantidad=$detalles[$k]->cantidad;
				$total=$total+$preciou*$cantidad;
				$sql2="insert into detalle values('','$identificador','$idprod','$preciou','$cantidad')";
				$conexion->query($sql2);
			}
			$sqlaux="update pedidos set total='$total' where identificador='$identificador'";
			$conexion->query($sqlaux);
				$aux="select token from negocios where id='$idneg'";
				$res=$conexion->query($aux);
				$unafila=$res->fetch_assoc();
				$negtoken=$unafila['token'];
				$titulo=$nombrecli." Tu pedido fue recibido";
				$msg="Te avisaremos su estado aquí";
				sendGCM($token,$nombrecli,$msg,$titulo,$negtoken);


		}
		echo json_encode('registrado');
		break;
	case "pedidoscliente":
		$idcelu=$_REQUEST["idcelu"];
		$sql="select tb1.*,negocios.nombre,negocios.direccion,negocios.celular from (select idneg,fechareg,despachado,entregado,color,identificador from pedidos where idcelu='$idcelu') as tb1 inner join negocios on tb1.idneg=negocios.id order by tb1.fechareg desc";
		$res=$conexion->query($sql);
		$filas=[];
		while($unreg=$res->fetch_assoc()){
			$aux=$unreg["fechareg"];
			$aux=explode(" ",$aux);
			$volcar=implode("-",array_reverse(explode("-",$aux[0])))." ".$aux[1];
			$unreg["fechareg"]=$volcar;
			$filas[]=$unreg;
		}
		echo json_encode($filas);
		break;
	case "unpedidocliente":
		$idpedido=$_REQUEST["idpedido"];
		$sql="select tb2.*,productos.nombre from (select tb1.nombrecli,tb1.nit,tb1.celular,tb1.direccion,tb1.costocarrera,tb1.lat,tb1.lng,detalle.idprod as idprod, detalle.preciou,detalle.cantidad from (select * from pedidos where identificador='$idpedido') as tb1 inner join detalle on tb1.identificador=detalle.idpedido) as tb2 inner join productos on tb2.idprod=productos.id";
		$res=$conexion->query($sql);
		$filas=[];
		while($unreg=$res->fetch_assoc()){
			$filas[]=$unreg;
		}
		echo json_encode($filas);
		break;	
	case "obtienedatosunneg":
		$idneg=$_REQUEST["idneg"];
		$sql="select * from negocios where id='$idneg'";
		$res=$conexion->query($sql);
		$unreg=$res->fetch_assoc();
		echo json_encode($unreg);
		break;	
	case "obtieneanuncios":
		$sql="select * from anuncios where estado='activo' and CURRENT_DATE() between fechaini and fechafin";
		$res=$conexion->query($sql);
		$filas=[];
		while($unreg=$res->fetch_assoc()){
			$filas[]=$unreg;
		}
		echo json_encode($filas);
		break;
	case "obtieneconfigregion":
		$sql="select * from region";
		$res=$conexion->query($sql);
		$unreg=$res->fetch_assoc();
		echo json_encode($unreg);
		break;
	case "busca":
		$semilla=$_REQUEST["semilla"];
		$ahora=date("H:i:s");
		$sql="SELECT tb1.* from (select *,time_to_sec(TIMEDIFF('$ahora',horaini)) as h1,time_to_sec(TIMEDIFF(horafin,'$ahora')) as h2 from negocios where estado='activo' or estado='cerrado') as tb1 inner join (select distinct idneg from productos where nombre like '%$semilla%') as tb2 on tb1.id=tb2.idneg";
		$res=$conexion->query($sql);
		$filas=[];
		while($unreg=$res->fetch_assoc()){
		$aux1=explode(":",$unreg["horaini"]);
		unset($aux1[count($aux1)-1]);
		$unreg["horaini"]=implode(":",$aux1);
		$aux2=explode(":",$unreg["horafin"]);
		unset($aux2[count($aux2)-1]);
		$unreg["horafin"]=implode(":",$aux2);	
		$filas[]=$unreg;
		}
		echo json_encode($filas);
		break;	
	case "registracalif":
		$celu=$_REQUEST["celu"];
		$token=$_REQUEST["token"];
		$fechareg=date("Y-m-d H:i:s");
		$idneg=$_REQUEST["idneg"];
		$cliente=$_REQUEST["cliente"];
		$cv=$_REQUEST["cv"];
		$cp=$_REQUEST["cp"];
		$cs=$_REQUEST["cs"];
		$comentario=$_REQUEST["comentario"];
		$sql="insert into calificaciones values('','$idneg','$celu','$cliente','$cv','$cp','$cs','$comentario','$fechareg','$token')";
		if($conexion->query($sql)){
			echo json_encode("registrado");
		}
		else{
			echo json_encode("noregistrado");
		}
		break;
	
}
mysqli_close($conexion);
?>
