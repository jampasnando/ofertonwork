<?php
// require_once "conector.php";
$lista=scandir("../public/images");
echo json_encode($lista);
?>