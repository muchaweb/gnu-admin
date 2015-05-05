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
                    <li class="active"><a href="#" class="size-menu"> <i class="fa fa-calculator"></i> Ventas Sin Facturar</a></li>
                    <li><a href="historial.php" class="size-menu"><i class="fa fa-folder-open"></i> Historial</a></li>
                    <li><a href="ventas-facturadas.php" class="size-menu"> <i class="fa fa-check-square-o"></i> Ventas Facturadas</a></li>
                    <li style="float:right;"><a href="logout.php" class="size-menu"><i class="fa fa-sign-out"></i> Salir</a>
                    </li>
                </ul>
                <div id="getBill" class="getBill">
                <div class="alert alert-custom">
                    Seleccione del siguiente listado aquellos datos de sus clientes que no solicitaron factura.
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

                    //-- First cross domain
                        $url = "http://gnuvehicular.mine.nu:8580/ventas_3meses.php?operation=$operation&billOperation=$billOperation";
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $json_object = curl_exec($ch);
                        curl_close($ch);
                        $array = json_decode($json_object, true);
  
                    $contador = $array['rows'][0]['contador'];
                     
                    ?>
                    <ul class="nav nav-tabs bottom" role="tablist">
                        <li><a href="index.php" class="size-menu"> <i class="fa fa-calendar"></i> Ventas de 1 día</a></li>
                        <li class="active"><a href="#" class="size-menu"> <i class="fa fa-calendar"></i> Ventas de 1 semana</a></li>
                        <li><a href="ventas-1-mes.php" class="size-menu"> <i class="fa fa-calendar"></i> Ventas de 1 mes</a></li>
                        <li><a href="ventas-2-meses.php" class="size-menu"><i class="fa fa-calendar"></i> Ventas de 2 meses</a></li>
                        <li class="active"><a href="" class="size-menu"> <i class="fa fa-calendar"></i> Ventas de 3 meses</a></li>
                        </li>
                    </ul>
                    <?php if($contador > 0){ ?>
                    <?php include('informacion-general.php'); ?>

                    <div id="null"></div>
                    <div id="loading"></div>
                    
                    

                    <span class="right blue strong">Total de ventas: <?php echo $contador; ?></span> 
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>
                                    <label for="" data-toggle="tooltip" data-placement="top" title="ID Taller" class="option-tooltip blue strong">OPERACIÓN</label>
                                </th>
                                <th>
                                    <label for="" data-toggle="tooltip" data-placement="top" title="Quien solicitó el servicio" class="option-tooltip blue strong">CLIENTE</label>
                                </th>
                                <th width="12%">
                                    <label for="" data-toggle="tooltip" data-placement="top" title="Fecha del servicio" class="option-tooltip blue strong">FECHA</label>
                                </th>
                                <th width="15%">
                                    <label for="" class="blue strong">MONTO</label>
                                </th>
                                <th>
                                    <label for="" class="blue strong">ESTATUS</label>
                                </th>
                                <th width="8%">
                                    <label for="" class=" blue strong">
                                        <a id="checkAll" data-toggle="tooltip" data-placement="top" title="Seleccionar Todos" class="option-tooltip blue strong" href="javascript:void(0);">
                                            <i class="fa fa-check-square"></i> 
                                        </a>
                                        | 
                                        <a id="uncheckAll" data-toggle="tooltip" data-placement="top" title="Deseleccionar Todos" class="option-tooltip blue strong" href="javascript:void(0);">
                                         <i class="fa fa-square"></i> 
                                     </a>
                                 </label>
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
                                        <span class="label label-danger">No Facturado</span>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="checkbox1" name="idSale[]" id="idSale" value="<?php echo $id; ?>" title="<?php echo $id; ?>">
                                    </td>
                                </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                    <!--Hidden-->
                    <input type="hidden" name="rfcGeneral" id="rfcGeneral" value="<?php echo $rfc; ?>">
                    <label for="">Razón social</label>   
                    <select name="razonSocial" id="razonSocial" class="form-control">
                        <option value="VENTA AL PUBLICO EN GENERAL">Venta Al Publico En General</option>
                        <option value="PUBLICO EN GENERAL PAGO CON TERMINAL">Publico En General Pago Con Terminal</option>
                    </select>
                    
                    <br>
                    <label for="">Notas</label>
                    <textarea name="noteSale" id="noteSale" class="form-control" placeholder="OBSERVACIONES"></textarea>
                    <button type="submit" class="btn bottom-space green right-btn top" onclick="return getSale()">GENERAR FACTURA</button>
                    <div id="loading2"></div>
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
<script src="../js/main.js"></script> 

<script type="text/javascript">
  $('#checkAll').click(function(){
    $("input:checkbox").prop('checked', true);
});
  $('#uncheckAll').click(function(){
    $("input:checkbox").prop('checked', false);
});
</script>
<script type="text/javascript">
    function validateRFC() {
        var rfc = document.getElementById("rfc_cliente").value;
        var expreg = new RegExp("^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))");

        if (expreg.test(rfc)) {
            console.log("Success");
        } else {
            $('.message').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>El dato ingresado no corresponde a un R.F.C., intente nuevamente.</div>');
            return false;
        }
    }
</script>
<script>
    function getSale() {
        var idSale = new Array();
        $('input[name="idSale[]"]:checked').each(function () {
            idSale.push($(this).val());
        });

        var noteSale = $('#noteSale').val();
        var razonSocial = $('#razonSocial').val();
        var rfcGeneral = $('#rfcGeneral').val();

        if (idSale == '') {       //Revisa campos nulos
            $('#null').html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Seleccione al menos un dato a facturar.');
            $('#null').addClass('alert alert-danger');   //Si hay campo vacio muestra un error
            return;
        } else {
            $('#null').remove();
            $('#loading').html('<img src="../img/loading.gif" />'); //Pendiente
            $('#loading2').html('<img src="../img/loading.gif" style="float: right; padding: 2em;"/>'); //Pendiente

            $.ajax({
                type: 'POST',
                url: 'save-data-bill.php', //Define en donde se enviara la informacion
                data: {
                    "idSale": idSale,//Se pasaran dichos valores
                    "noteSale": noteSale,
                    "razonSocial": razonSocial,
                    "rfcGeneral": rfcGeneral,
                },
                success: function (data) {
                    window.setTimeout(function () {
                        $('#loading').html('');
                        $('#loading2').html('');
                        $('#getBill').css("display", "block");
                        $('#getBill').html(data);
                    }, 2000);
                }
            });
        }
    }
</script>
</body>
</html>