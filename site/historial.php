<?php
set_time_limit(0);
//--HISTORIAL DE TODAS LAS FACTURAS REALIZADAS POR PARTE DE GNU
include('../lib/conf.php');
session_start();
$idUsuario = $_SESSION['idUsuario'];
$nombre = $_SESSION['nombre'];

if (!$_SESSION['status']) {
    header("Location: ../");
    exit;
}

$time = 1800; //segundos
if(isset($_SESSION["status"])){ 
  if(isset($_SESSION["expire"]) && time() > $_SESSION["expire"] + $time){ 
    unset($_SESSION["expire"]); 
    session_destroy();
    echo "<script type='text/javascript'>window.location.href = '../'; </script>";
  }else{ 
    $_SESSION["expire"] = time(); 
  } 
} 

include('../lib/connect.php');
$link = Connect();

//---LAST CHANGE 01-10-2014
$folio = $_POST['folio'];
$fecha_inicio_calendario = $_POST['fecha_inicio'];
$fecha_fin_calendario = $_POST['fecha_fin'];

if($fecha_inicio_calendario != ""){
    $newDateBegin = explode("-", $fecha_inicio_calendario);
    $fecha_inicio = $newDateBegin['2']."-".$newDateBegin['1']."-".$newDateBegin['0'];
}else{
    $fecha_inicio_calendario = "";
}

if($fecha_fin_calendario != ""){
    $newDateEnd = explode("-", $fecha_fin_calendario);
    $fecha_fin = $newDateEnd['2']."-".$newDateEnd['1']."-".$newDateEnd['0'];
}else{
    $fecha_fin_calendario = "";
}

//---LAST CHANGE 01-10-2014
$monto = $_POST['monto'];

include('query-search.php');
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
    <link rel="stylesheet" href="../lib/fancybox/source/jquery.fancybox.css" type="text/css" media="screen"/>


    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="wrapper">

    <header>
        <h1 class="logo center">
            <img src="../img/logo.png" width="150" alt="">
        </h1>
    </header>

    <div class="header-divisor"></div>

    <div class="main-body">
        <div class="container col-md-push-2 col-md-8">
            <br>
            <p class="normal small right">Bienvenido <strong><?php echo $nombre." a "; echo date('d-m-Y'); ?></strong></p>
            <br>
            <h2 class="title center">Facturación GNU</h2>
        
            <ul class="nav nav-tabs bottom" role="tablist">
                <li><a href="index.php" class="size-menu"> <i class="fa fa-calculator"></i> Ventas Sin Facturar</a></li>
                <li class="active"><a href="#" class="size-menu"><i class="fa fa-folder-open"></i> Historial</a></li>
                <li><a href="ventas-facturadas.php" class="size-menu"> <i class="fa fa-check-square-o"></i> Ventas Facturadas</a></li>
                <li style="float:right;"><a href="logout.php" class="size-menu"><i class="fa fa-sign-out"></i> Salir</a>
                </li>
            </ul>

            <div class="alert alert-custom">
                Historial de las facturas generadas. Optimice su búsqueda mediante el uso de los siguientes filtros.
            </div>


            <form class="form-horizontal bottom" method="post" action="" role="form">
                <table width="100%">
                    <tr>
                        <td>
                            <div class="input-group">
                                <span class="input-group-addon green"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha inicio">
                            </div>
                        </td>
                        <td>
                            <div class="input-group space-left">
                                <span class="input-group-addon green"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control" id="fecha_fin" name="fecha_fin" placeholder="Fecha fin">
                            </div>
                        </td>
                        <td>
                            <div class="input-group space-left">
                                <span class="input-group-addon green"><i class="fa fa-dollar"></i></span>
                                <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto">
                            </div>
                        </td>

                        <td>
                            <div class="input-group space-left">
                                <span class="input-group-addon green"><i class="fa fa-paperclip"></i></span>
                                <input type="text" class="form-control" id="folio" name="folio" placeholder="Folio">
                            </div>
                        </td>

                        <td>
                            <button type="submit" class="btn green space-left"><i class="fa fa-search"></i></button>
                        </td>
                    </tr>
                </table>
            </form>

            <div>
                <table class="table table-bordered" id="">
                    <thead>
                    <th><label for="" class="blue strong">FOLIO</label></th>
                    <th><label for="" class="blue strong">MONTO</label></th>
                    <th><label for="" class="blue strong">FECHA</label></th>
                    <th><label for="" class="blue strong">OPCIONES</label></th>
                    </thead>
                    <tbody>
                    <?php
                    while ($data = mysql_fetch_array($allBills)) {
                        $id = $data['idFolioFactura'];
                        $montoTotal = $data['montoTotal'];
                        $rfc = $data['rfc'];
                        $fechaFactura = $data['fechaFactura'];
                        $pathPDF = $data['pathPDF'];
                        $pathXML = $data['pathXML'];
                        ?>
                        <tr class="note">
                            <td>
                                <?php echo $id; ?>
                            </td>
                            <td>
                                $<?php echo $montoTotal; ?> MXN
                            </td>
                            <td>
                                <?php echo $fechaFactura; ?>
                            </td>
                            <td>
                                <a href="download.php?f=<?php echo $pathPDF; ?>" class="option-tooltip"
                                   data-toggle="tooltip" data-placement="top" title="Descargar PDF factura">
                                    <i class="space-right border space-left normal fa fa-cloud-download"></i>
                                </a>
                                <a href="download-xml.php?f=<?php echo $pathXML; ?>" class="option-tooltip"
                                   data-toggle="tooltip" data-placement="top" title="Descargar XML factura">
                                    <i class="space-right border space-left normal fa fa-code"></i>
                                </a>
                                <a href="<?php echo $pathPDF; ?>" class="fancybox fancybox.iframe option-tooltip"
                                   data-toggle="tooltip" data-placement="top" title="Vista previa de factura">
                                    <i class="space-right border space-left normal fa fa-eye"></i>
                                </a>
                                <a href="enviar.php?id=<?php echo $id; ?>"
                                   class="fancybox fancybox.iframe option-tooltip" data-toggle="tooltip"
                                   data-placement="top" title="Enviar factura">
                                    <i class="space-right border space-left normal fa fa-envelope"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" language="javascript" src="../lib/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="../lib/datatables/DT_bootstrap.js"></script>

<script src="../lib/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script src="../assets/bootstrap/js/tooltip.js"></script>
<script src="../js/main.js"></script>
</body>
</html>