<?php
date_default_timezone_set("Mexico/General");  
function Connect()
{
    if (!($link=mysql_connect("localhost","root",""))) {
        echo "Error conectando a la base de datos.";
        exit();
    }

    if (!mysql_select_db("gnu_v4",$link)){
        echo "Error seleccionando la base de datos.";
        exit();
    }
    return $link;
}

$link = Connect();
mysql_close($link);
?>