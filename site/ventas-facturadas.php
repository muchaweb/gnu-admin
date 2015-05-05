<?php
set_time_limit(0);
//--BUSCADOR Y MUESTRA DE RESULTADOS DE LAS FACTURAS A GENERAR; CONTIENE VALIDACION DE RFC
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

//GNU Negocio
$gnuCheck = mysql_query("SELECT * FROM negocio");
$gnu = mysql_fetch_array($gnuCheck);

$rfc = $gnu['rfc_gnu'];
$mainCustomer = $gnu['nombre_gnu'];
$addressCustomer = $gnu['calle_gnu'] . " #" . $gnu['numero_gnu'] . ", Colonia " . $gnu['colonia_gnu'] . ", C.P. " . $gnu['cp_gnu'] . ", " . $gnu['municipio_gnu'] . ", " . $gnu['estado_gnu'];

?>

<!doctype html>
<html lang="es">
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
            <div class="container col-md-push-2 col-md-8" id="home">
                <br>
                <p class="normal small right">Bienvenido <strong><?php echo $nombre." a "; echo date('d-m-Y'); ?></strong></p>
                <br>
                <h2 class="title center">Facturación GNU</h2>

                <ul class="nav nav-tabs bottom" role="tablist">
                    <li><a href="index.php" class="size-menu"><i class="fa fa-calculator"></i> Ventas Sin Facturar</a></li>
                    <li><a href="historial.php" class="size-menu"><i class="fa fa-folder-open"></i> Historial</a></li>
                    <li class="active"><a href="ventas-facturadas.php" class="size-menu"><i class="fa fa-check-square-o"></i> Ventas Facturadas</a></li>
                    <li style="float:right;"><a href="logout.php" class="size-menu"><i class="fa fa-sign-out"></i> Salir</a>
                    </li>
                </ul>
                <div id="getBill" class="getBill">
                <div class="alert alert-custom">
                    Listado de ventas ya facturadas. 
                </div>
                <div class="message"></div>
                <div class="content">
                    <?php 
                    //General
                    $getOperation = mysql_query("SELECT numeroOperacion FROM operacion_cliente")or die(mysql_error());
                    while ($eachOperation = mysql_fetch_array($getOperation)) {
                        $allOperations .= $eachOperation['numeroOperacion'].",";
                    }
                    $operation = substr($allOperations, 0, -1);

                    $getBillOperation = mysql_query("SELECT idTallerFactura FROM venta_factura")or die(mysql_error());
                    while ($eachBillOperation = mysql_fetch_array($getBillOperation)) {
                        $allBillOperations .= $eachBillOperation['idTallerFactura'].",";
                    }
                    $billOperation = substr($allBillOperations, 0, -1);

                        $url = "http://gnuvehicular.mine.nu:8580/ventas_3meses.php?generated=true&operation=$operation&billOperation=$billOperation";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $json_object = curl_exec($ch);
                        curl_close($ch);
                        $array = json_decode($json_object, true);


                        //---
                        //---

                    $contador = $array['rows'][0]['contador'];
                    if($contador > 0){ 
                        ?>
                        
                    <?php include('informacion-general.php'); ?>

                    <div id="null"></div>
                    <div id="loading"></div>
                    <span class="blue right strong">Ventas facturadas: <?php echo $contador; ?></span>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>
                                    <label for="" data-toggle="tooltip" data-placement="top" title="ID Taller" class="option-tooltip blue strong">OPERACIÓN</label>
                                </th>
                                <th>
                                    <label for="" data-toggle="tooltip" data-placement="top" title="Quien solicitó el servicio" class="option-tooltip blue strong">CLIENTE</label>
                                </th>
                                <th>
                                    <label for="" data-toggle="tooltip" data-placement="top" title="Fecha del servicio" class="option-tooltip blue strong">FECHA</label>
                                </th>
                                <th>
                                    <label for="" class="blue strong">MONTO</label>
                                </th>
                                <th>
                                    <label for="" class="blue strong">ESTATUS</label>
                                </th>
                         </thead>
                         <tbody>
                            <?php 
                                for ($i=1; $i <= $contador; $i++) { 

                                    $operacion = $array['rows'][$i]['operacion'];
                                    $clientes  = $array['rows'][$i]['clientes'];
                                    $fecha     = $array['rows'][$i]['fecha'];
                                    $total     = $array['rows'][$i]['total'];
                                    $id        = $array['rows'][$i]['id'];
                            ?>
                                <tr class="note">
                                    <td>
                                        <?php echo $operacion;?>
                                    </td>
                                    <td>
                                        <?php echo $clientes; ?>
                                    </td>
                                    <td>
                                         <?php echo date("d-m-Y ", strtotime($fecha)); ?>
                                    </td>
                                    <td>
                                        <?php echo "$" . $total . " MXN"; ?>
                                    </td>
                                    <td>
                                       <span class="label label-success">Facturado</span>
                                    </td>
                                </tr>
                                <?php 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php }else{ echo "<p class='top size-menu blue'>No se encuentran datos a facturar.</p>"; } ?>
            </div>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../lib/fancybox/source/jquery.fancybox.pack.js"></script>
<script src="../assets/monthpicker/jquery.monthpicker.js"></script> 
<script src="../js/main.js"></script> 
<script type="text/javascript">
        options = {
            pattern: 'mm-yyyy', // Default is 'mm/yyyy' and separator char is not mandatory
            startYear: 2014,
            finalYear: 2050,
            monthNames: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
        };
        $('#filter_date').monthpicker(options);
</script>
</body>
</html>