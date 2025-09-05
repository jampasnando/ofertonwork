<?php
$conexion=new mysqli("localhost","jampasna_adm1","admin123","jampasna_ferreteria");
if (mysqli_connect_errno()) {
    printf("Fallo de conexion: %s\n", mysqli_connect_error());
    exit();
}

?>