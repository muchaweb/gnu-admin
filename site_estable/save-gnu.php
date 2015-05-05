<?php
//--MENSAJE SUCCESS DE QUE LOS DATOS DE GNU HAN SIDO GUARDADOS
include('../lib/conf.php');
include('../lib/connect.php');
$link = Connect();
date_default_timezone_set("Mexico/General");

$nombre_gnu = $_POST['nombre_gnu'];
$rfc_gnu = $_POST['rfc_gnu'];
$calle_gnu = $_POST['calle_gnu'];
$numero_gnu = $_POST['numero_gnu'];
$colonia_gnu = $_POST['colonia_gnu'];
$cp_gnu = $_POST['cp_gnu'];
$municipio_gnu = $_POST['municipio_gnu'];
$estado_gnu = $_POST['estado_gnu'];

$updateGNU = mysql_query("UPDATE negocio SET nombre_gnu = '$nombre_gnu', rfc_gnu = '$rfc_gnu', calle_gnu = '$calle_gnu', numero_gnu = '$numero_gnu', colonia_gnu = '$colonia_gnu', cp_gnu = '$cp_gnu', municipio_gnu = '$municipio_gnu', estado_gnu = '$estado_gnu'")or die(mysql_error());
if($updateGNU == true){
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GNU | Facturación - Intranet</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->

    <!-- bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="wrapper container col-md-push-2 col-md-8">

    <header>
        <h1 class="logo center">
            <img src="../img/logo.png" width="150" alt="">
        </h1>
    </header>
    <div class="header-divisor"></div>
    <div class="main-body">
        <div class="bottom">
            <h2 class="title center">Los datos han sido actualizados</h2>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</body>
</html>
<?php }else{ echo "no"; } ?>