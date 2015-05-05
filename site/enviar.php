<?php
//--FORMULARIO PARA EL ENVIO DE UNA DETERMINADA FACTURA DE GNU

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
<div class="wrapper">
    <div class="main-body">
        <div class="container col-md-push-2 col-md-8">

            <h2 class="title center">Facturación GNU</h2>

            <div class="alert alert-custom">
                Ingrese los siguientes datos para enviar la factura seleccionada por email.
            </div>
            <form class="form-horizontal bottom" role="form" method="post" action="sent-bill.php" id="email__form">
                <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                <table width="100%">
                    <tr>
                        <td>
                            <div class="input-group space-left">
                                <span class="input-group-addon green"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="nombre" name="nombre" value=""
                                       placeholder="Enviado por">
                            </div>
                            <div class="input-group space-left top">
                                <span class="input-group-addon green"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email_enviar" name="email_enviar" value=""
                                       placeholder="Email">
                            </div>

                            <div class="input-group space-left top">
                                <span class="input-group-addon green"><i class="fa fa-comment"></i></span>
                                <textarea name="comentarios" id="comentarios" class="form-control"
                                          placeholder="Comentarios"></textarea>
                            </div>

                            <button type="submit" class="btn green right-btn top">ENVIAR FACTURA</button>
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