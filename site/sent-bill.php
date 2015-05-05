<?php
//--ENVIA LA FACTURA AL DESTINATARIO INDICADO EN EL FORMULARIO DE ENVIO DE FACTURA
include('../lib/conf.php');
include('../lib/connect.php');
$link = Connect();

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$email_enviar = $_POST['email_enviar'];
$comentarios = $_POST['comentarios'];

$fileBill = mysql_query("SELECT * FROM factura_general WHERE idFolioFactura = '$id'") or die(mysql_error());
$getFile = mysql_fetch_array($fileBill);

$file = $getFile['pathPDF'];

/*require_once("../lib/mail/class.phpmailer.php");
require_once("../lib/mail/class.smtp.php");*/

require '../lib/mail/PHPMailerAutoload.php';

if ($comentarios != "") {
    $txt = $comentarios;
} else {
    $txt = "Se adjunta la factura #" . $id;
}

$mail = new PHPMailer;
$mail->Mailer = "smtp";
$mail->isSMTP();
$mail->Host = "mail.gnu.mx";
$mail->SMTPAuth = true;
$mail->Username = 'ecs@gnu.mx';
$mail->Password = 'eC452519S';
$mail->SMTPSecure = 'tls';
$mail->Port = 25;
$mail->From = "ecs@gnu.mx";; 
$mail->FromName = "GNU";


$mail->Subject = iconv('UTF-8', 'ISO-8859-1', "Datos de facturación | Folio #" . $id);
$mail->AddAddress($email_enviar, iconv('UTF-8', 'ISO-8859-1', "GNU"));
$body = iconv('UTF-8', 'ISO-8859-1', $txt);
$mail->Body = $body;
$mail->AddAttachment($file);
$mail->IsHTML(true);

if (!$mail->Send()) {
    echo "";
} else {
    echo "<script type='text/javascript'>window.location.href = 'mensaje-enviado.php'; </script>";
}

?>