<?php
//--CONSULTAS SQL PARA EL FILTRO DE INFORMACION EN EL HISTORIAL

if ($fecha_inicio != '' && $fecha_fin != '' && $monto == '' && $folio == '') {
    $allBills = mysql_query("SELECT * FROM factura_general WHERE fechaFactura BETWEEN '$fecha_inicio' AND '$fecha_fin'") or die(mysql_error());

}else if ($fecha_inicio != '' && $fecha_fin == '' && $monto == '' && $folio == '') {
    $allBills = mysql_query("SELECT * FROM factura_general WHERE fechaFactura >= '$fecha_inicio'") or die(mysql_error());

}else if ($fecha_inicio != '' && $fecha_fin == '' && $monto != '' && $folio == '') {
    $allBills = mysql_query("SELECT * FROM factura_general WHERE fechaFactura >= '$fecha_inicio' AND montoTotal = '$monto'") or die(mysql_error());

}else if ($fecha_inicio == '' && $fecha_fin != '' && $monto == '' && $folio == '') {
    $allBills = mysql_query("SELECT * FROM factura_general WHERE fechaFactura <= '$fecha_fin'") or die(mysql_error());

}else if ($fecha_inicio == '' && $fecha_fin != '' && $monto == '' && $folio == '') {
    $allBills = mysql_query("SELECT * FROM factura_general WHERE fechaFactura <= '$fecha_fin' AND montoTotal = '$monto'") or die(mysql_error());

}else if ($fecha_inicio != '' && $fecha_fin != '' && $monto != '' && $folio == '') {
    $allBills = mysql_query("SELECT * FROM factura_general WHERE (fechaFactura BETWEEN '$fecha_inicio' AND '$fecha_fin') AND montoTotal = '$monto'") or die(mysql_error());

}else if ($fecha_inicio == '' && $fecha_fin == '' && $monto != '' && $folio == '') {
    $allBills = mysql_query("SELECT * FROM factura_general WHERE montoTotal = '$monto'") or die(mysql_error());

}else if ($fecha_inicio == '' && $fecha_fin == '' && $monto == '' && $folio == '') {
    $allBills = mysql_query("SELECT * FROM factura_general") or die(mysql_error());
}else if ($fecha_inicio == '' && $fecha_fin == '' && $monto == '' && $folio != '') {
    $allBills = mysql_query("SELECT * FROM factura_general WHERE idFolioFactura = '$folio'") or die(mysql_error());
}
?>