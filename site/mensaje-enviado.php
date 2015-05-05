<?php
include('../lib/conf.php');
//--MENSAJE SUCCESS DE QUE EL CORREO CON LA FACTURA HA SIDO ENVIADO
$id = $_GET['id'];
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
            <h2 class="title center">El correo ha sido enviado satisfactoriamente.</h2>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</body>
</html>