<?php
include('../lib/conf.php');
//--FORMULARIO PARA EL ENVIO DE UNA DETERMINADA FACTURA DE GNU
include('../lib/connect.php');
$link = Connect();
date_default_timezone_set("Mexico/General");

$gnuCheck = mysql_query("SELECT * FROM negocio")or die(mysql_error());
$gnu = mysql_fetch_array($gnuCheck);
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
    <div class="wrapper">
        <div class="main-body">
            <div class="container col-md-push-2 col-md-8">

                <h2 class="title center">Facturación GNU</h2>

                <div class="alert alert-custom">
                    Edite la información general de GNU.
                </div>
                <form class="form-horizontal bottom" role="form" method="post" action="save-gnu.php" id="">
                    <table width="100%">
                        <tr>
                            <td>
                                <div class="col-sm-6 col-xs-6" style="padding:0">
                                    <div class="input-group">
                                        <span class="input-group-addon green">Negocio</span>
                                        <input type="text" class="form-control" id="nombre_gnu" name="nombre_gnu" value="<?php echo $gnu['nombre_gnu']; ?>"
                                        placeholder="Nombre del negocio">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-xs-6" style="padding-right:0">
                                    <div class="input-group">
                                        <span class="input-group-addon green"> R.F.C.</span>
                                        <input type="text" class="form-control" id="rfc_gnu" name="rfc_gnu" value="<?php echo $gnu['rfc_gnu']; ?>"
                                        placeholder="R.F.C.">
                                    </div>
                                </div>

                                <div class="col-sm-4 col-xs-4 " style="padding:0">
                                    <div class="input-group top">
                                        <span class="input-group-addon green"> Calle</span>
                                        <input type="text" class="form-control" id="calle_gnu" name="calle_gnu" value="<?php echo $gnu['calle_gnu']; ?>"
                                        placeholder="Calle">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-4">
                                    <div class="input-group top">
                                        <span class="input-group-addon green">#</span>
                                        <input type="text" class="form-control" id="numero_gnu" name="numero_gnu" value="<?php echo $gnu['numero_gnu']; ?>"placeholder="Número">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-4" style="padding:0">
                                    <div class="input-group top">
                                        <span class="input-group-addon green"> Colonia</span>
                                        <input type="text" class="form-control" id="colonia_gnu" name="colonia_gnu" value="<?php echo $gnu['colonia_gnu']; ?>" placeholder="Colonia">
                                    </div>
                                </div>

                                <div class="col-sm-4 col-xs-4" style="padding:0">
                                    <div class="input-group top">
                                        <span class="input-group-addon green">C.P.</span>
                                        <input type="text" class="form-control" id="cp_gnu" name="cp_gnu" value="<?php echo $gnu['cp_gnu']; ?>"placeholder="C.P.">
                                    </div>
                                </div>

                                <div class="col-sm-4 col-xs-4">
                                    <div class="input-group top">
                                        <span class="input-group-addon green">Municipio</span>
                                        <input type="text" class="form-control" id="municipio_gnu" name="municipio_gnu" value="<?php echo $gnu['municipio_gnu']; ?>"placeholder="Municipio">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-4" style="padding:0">
                                    <div class="input-group top">
                                        <span class="input-group-addon green">Estado</span>
                                        <input type="text" class="form-control" id="estado_gnu" name="estado_gnu" value="<?php echo $gnu['estado_gnu']; ?>"placeholder="Estado">
                                    </div>
                                </div>


                                <button type="submit" class="btn green right-btn top">GUARDAR INFORMACIÓN</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
</body>
</html>