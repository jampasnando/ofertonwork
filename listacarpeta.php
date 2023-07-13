<?php
// require_once "conector.php";
$lista=scandir("../ferreteria/public/images");
echo json_encode($lista);
?>