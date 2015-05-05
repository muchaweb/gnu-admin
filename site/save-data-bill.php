<?php 
set_time_limit(0);
//--GUARDA TODA LA INFORMACION GENERADA DE LA FACTURACION Y SE GENERA EL PDF CORRESPONDIENTE
include('../lib/conf.php');
include('../lib/connect.php');
$link = Connect();
date_default_timezone_set("Mexico/General");

$gnuCheck = mysql_query("SELECT * FROM negocio");
$gnu = mysql_fetch_array($gnuCheck);

$rfc = $gnu['rfc_gnu'];
$mainCustomer = $gnu['nombre_gnu'];
$addressCustomer = $gnu['calle_gnu'] . " #" . $gnu['numero_gnu'] . ", Colonia " . $gnu['colonia_gnu'] . ", C.P. " . $gnu['cp_gnu'] . ", " . $gnu['municipio_gnu'] . ", " . $gnu['estado_gnu'];

$razonSocial = $_POST['razonSocial'];
$idSale = $_POST['idSale'];
$noteSale = $_POST['noteSale'];
$rfcGeneral = $_POST['rfcGeneral'];
$today = date('Y-m-d');

$getData = mysql_query("INSERT INTO factura_general (montoTotal, totalLetra, rfc, fechaFactura, notas, pathPDF) 
                                       VALUES ('', '', '$rfcGeneral', '$today', '$noteSale', '')") or die(mysql_error());

$idFacturacion = mysql_insert_id();

foreach ($idSale as $key) {
  
  $insertOp = mysql_query("INSERT INTO operacion_cliente (numeroOperacion) VALUES ('$key')")or die(mysql_error());


   $url = "http://gnuvehicular.mine.nu:8580/ventas_general.php?idventas=$key";
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_TIMEOUT, 0);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   $json_object = curl_exec($ch);
   curl_close($ch);
   $array = json_decode($json_object, true);
   $totalSales += $array['rows'][1]['subtotal'];

   $fechaVenta                 =   $array['rows'][1]['fecha']; 
   $descuento                  =   $array['rows'][1]['descuento']; 
   $vehiculo                   =   $array['rows'][1]['vehiculo'];
   $idventaServicio            =   $array['rows'][1]["idVenta"];

   $volumen_array              +=  $array['rows'][1]['volumen'];
   $precioPorUnidadConIVA      =   $array['rows'][1]['precioUnitario']; //Siempre es unico
   $subtotalIVA                +=  $array['rows'][1]['subtotal'];
    
}//End foreach

  include('operations.php');
  include('call_impress.php');
  include('call_cfdi.php'); 

  
  //--------------------------------------------NUMBER-TO-LETTER----------------------------------------------------
  include("../lib/convertidor_numero_letras/CNumeroaLetra.php");
  $numalet = new CNumeroaletra;
  $numalet->setNumero($totalSales);
  //cambia a minusculas
  $numalet->setMayusculas(1);
  //cambia moneda
  $numalet->setMoneda("Pesos");
  //cambia prefijo
  $numalet->setPrefijo("");
  //cambia sufijo
  $numalet->setSufijo("");
  //imprime numero con los cambios
  $nLetra = $numalet->letra() . " M.N.";
  //-----------------------------------------------------------------------------------------------------------------

  //--------------------------------------------SAVE GENERAL DATA----------------------------------------------------

  $saveGeneralData = mysql_query("UPDATE factura_general SET montoTotal = '$totalSales', totalLetra = '$nLetra'")or die(mysql_error());
  //-----------------------------------------------------------------------------------------------------------------

  if ($saveGeneralData = true) {

        $generalData = mysql_query("SELECT * FROM factura_general WHERE idFolioFactura = '$idFacturacion'");
        $getGeneralData = mysql_fetch_array($generalData);

        $montoTotal = $getGeneralData['montoTotal'];
        $totalLetra = $getGeneralData['totalLetra'];
        $rfc = $getGeneralData['rfc'];
        $notas = $getGeneralData['notas'];
        $fechaFactura = $getGeneralData['fechaFactura'];

    foreach ($idSale as $keyToSave) {
        $billDetail = mysql_query("INSERT INTO venta_factura (idTallerFactura, idFolioFacturaGeneral)VALUES('$keyToSave', '$idFacturacion')")or die(mysql_error());
    }

    //-------------------------------------------BEGIN PDF------------------------------------------------------------

    include('pdf.php');
    include('xml.php');
    
    //------------------------------------------UPDATE PATH-----------------------------------------------------------
    
    $customPath = 'facturas-gnu/factura_' . $idFacturacion . '.pdf';
    $namePDF = 'factura_' . $idFacturacion . '.pdf';
    $updatePath = mysql_query("UPDATE factura_general SET pathXML= '$namexml', pathPDF = '$namePDF' WHERE idFolioFactura = '$idFacturacion'") or die(mysql_error());

    //-----------------------------------------DOWNLOAD PDF-----------------------------------------------------------
  
?>
    <div class="panel-group" id="accordion">
         <div class="panel panel-default">
             <div class="panel-heading">
                 <h4 class="panel-title">
                     <a data-toggle="collapse" class="collapseLink" data-parent="#accordion"
                     href="#collapseOne">
                     <i class="fa fa-bars"></i> Información General
                 </a>
             </h4>
         </div>
         <div id="collapseOne" class="panel-collapse collapse in">
             <div class="panel-body">
                 <label class="blue strong">R.F.C.: </label><label
                 class="blue"><?php echo $rfc; ?></label><br>
                 <label class="blue strong">TITULAR: </label><label
                 class="blue"><?php echo $mainCustomer; ?></label><br>
                 <label class="blue strong">DOMICILIO: </label><label
                 class="blue"><?php echo $addressCustomer; ?></label>
             </div>
         </div>
     </div>
 </div>

<a href="download.php?f=<?php echo $customPath; ?>" class="right btn alert-custom bottom">DESCARGAR FACTURA <i class="fa fa-cloud-download"></i></a>
 <div id="target" class="bottom"> 
     <object data="<?php echo $customPath; ?>" type="application/pdf" width="100%" height="700"></object>
 </div>
<?php
  }
?>