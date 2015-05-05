<?php
session_start();
include('lib/connect.php');
$link = Connect();

$password = md5($_POST['password']);
$email = $_POST['email'];

//CONSULTA SI EXISTE EL RFC
$access = mysql_query("SELECT * FROM usuarios WHERE email ='$email' AND password = '$password' LIMIT 1") or die(mysql_error());

if ($row = mysql_fetch_array($access)) {
    $_SESSION['idUsuario'] = $row[id];
    $_SESSION['nombre'] = $row[nombre];
    $_SESSION['email'] = $row[email];
    $_SESSION['status'] = "in";
    $_SESSION['fecha_usuario'] = date("Y-n-j");

    echo "<script type='text/javascript'>window.location.href = 'site/index.php#home'; </script> ";

} else {
    echo "<script type='text/javascript'>window.location.href = 'index.php?access=false'; </script> ";
}

?>