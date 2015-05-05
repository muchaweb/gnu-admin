<?php 
$concepto = $concepto_original;

$volumen                    =   $volumen_array; //Sumando
$precioPorUnidad      		=   number_format(($precioPorUnidadConIVA/1.16),4);
$subtotal 		      		=   number_format(($precioPorUnidad * $volumen),2);
$subtotal_final 			= 	$subtotalIVA; //Sumado

$total                		=   number_format($subtotal_final, 2);
//$total                	=   number_format(($subtotal * 1.16),2);
$importe 			  		=   number_format($total - $subtotal,2);

?>