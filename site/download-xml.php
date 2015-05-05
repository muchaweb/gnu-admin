<?php
//--ARCHIVO PARA REALIZAR LA DESCARGA DE FICHEROS, EN ESTE CASO PDF
$extensiones = array("xml");
$f = $_GET["f"];

$ftmp = explode(".", $f);
$fExt = strtolower($ftmp[count($ftmp) - 1]);

if (!in_array($fExt, $extensiones)) {
    die("");
}
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"$f\"\n");
$fp = fopen("$f", "r");
fpassthru($fp);
?>