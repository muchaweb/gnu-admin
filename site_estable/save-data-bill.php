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


$idSale = $_POST['idSale'];
$noteSale = $_POST['noteSale'];
$rfcGeneral = $_POST['rfcGeneral'];
//---LAST CHANGE 01-10-2014
$today = date('Y-m-j');
//---LAST CHANGE 01-10-2014

//------------------------------------Digital Bill--------------------------------------------------------------
$client = new SoapClient('https://www.fiscoclic.mx/factura/WSEntityServices/timbre/TimbraWS?wsdl',
    array('features' => SOAP_SINGLE_ELEMENT_ARRAYS,
        'soap_version' => SOAP_1_2,
        'encoding' => 'UTF-8',
        'trace' => 1
    ));

$params = array(
    'cfdi' => '<?xml version="1.0" encoding="UTF-8"?><cfdi:Comprobante version="3.2" serie="SERIE" folio="0001" fecha="2013-08-15T16:09:05" sello="pLyCnKE2OyDBOy/gRDyAlRrNwxXRPFLMRIxLm6SnfcjCZZdqgO2pUiOhGCf4I3i5J3zlMNpPyFE4nOF0NjgQrUebk3ZoSQJlZnzC7lM3NtxeFx5kfcIC0V88kYKsDuBGB2P9pt/gGo2ByCJ7ejb+rMMBusFbtaQutlhYlo5+9hU=" formaDePago="FormaPago" noCertificado="00001000000201703011" certificado="MIIEtzCCA5+gAwIBAgIUMDAwMDEwMDAwMDAyMDE3MDMwMTEwDQYJKoZIhvcNAQEFBQAwggGVMTgwNgYDVQQDDC9BLkMuIGRlbCBTZXJ2aWNpbyBkZSBBZG1pbmlzdHJhY2nDs24gVHJpYnV0YXJpYTEvMC0GA1UECgwmU2VydmljaW8gZGUgQWRtaW5pc3RyYWNpw7NuIFRyaWJ1dGFyaWExODA2BgNVBAsML0FkbWluaXN0cmFjacOzbiBkZSBTZWd1cmlkYWQgZGUgbGEgSW5mb3JtYWNpw7NuMSEwHwYJKoZIhvcNAQkBFhJhc2lzbmV0QHNhdC5nb2IubXgxJjAkBgNVBAkMHUF2LiBIaWRhbGdvIDc3LCBDb2wuIEd1ZXJyZXJvMQ4wDAYDVQQRDAUwNjMwMDELMAkGA1UEBhMCTVgxGTAXBgNVBAgMEERpc3RyaXRvIEZlZGVyYWwxFDASBgNVBAcMC0N1YXVodMOpbW9jMRUwEwYDVQQtEwxTQVQ5NzA3MDFOTjMxPjA8BgkqhkiG9w0BCQIML1Jlc3BvbnNhYmxlOiBDZWNpbGlhIEd1aWxsZXJtaW5hIEdhcmPDrWEgR3VlcnJhMB4XDTEyMDgwNjIzNTE0NloXDTE2MDgwNjIzNTE0NlowgfgxNDAyBgNVBAMTKzNTSVQgSU5URUdSQUNJT04gWSBTT0xVQ0lPTkVTIFMgREUgUkwgREUgQ1YxNDAyBgNVBCkTKzNTSVQgSU5URUdSQUNJT04gWSBTT0xVQ0lPTkVTIFMgREUgUkwgREUgQ1YxNDAyBgNVBAoTKzNTSVQgSU5URUdSQUNJT04gWSBTT0xVQ0lPTkVTIFMgREUgUkwgREUgQ1YxJTAjBgNVBC0THFNJUzA5MTIxOEFaNCAvIFNBRVI4ODEwMDZVRzkxHjAcBgNVBAUTFSAvIFNBRVI4ODEwMDZIREZOU0wwMTENMAsGA1UECxMEM1NJVDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAxb5ud40vDZlCNZ1xjEQ+TzRtJz0LLJcashH/G2GJbSK8x1EyjpzABn4zRV0lnKE1qby7TDtB/Fq/VyA/DzrrXWsYwtxW8xOiZ1XkviPb5SrYWeAIXhRMOG6PZYWLSTIkMEnLq+LthWJRzO+qDQKBRhnS0P6nkGe2T2QCq+/J03cCAwEAAaMdMBswDAYDVR0TAQH/BAIwADALBgNVHQ8EBAMCBsAwDQYJKoZIhvcNAQEFBQADggEBAEvtuhguTOQTKkn3tfKf5V9JtxZdkC+BqHCeUKlKcSC/THOB8TUIre13sNT6rn1YPD7+cIdYbdlSbNguuY1byClZjRobGYaQKBFCqZMmzmkbn3QPTab1bjgx5YoZbUZZdmhfz3RgO0bt/BE8aP8pqH1dhKJ6nDoVBVoVjnEqaqGJrrzH7NgbVW9Rs0y5xl4elEi5U0oYozuIg74HGWPqU6lm1kR21emxGkcPdDP5bkjDRs1kb1GYARBIGXcN1laH8vszKfHr9Yt1i3hDC0qg9qykYgUjiNax41qaFqkchg3IiZtNZs7NtxIyqJreKrypU3xI9EX2TMm/Cc8XLiplLhA=" condicionesDePago="CondicionesDePago" subTotal="1.00" TipoCambio="10.2" Moneda="USD" total="1.00" tipoDeComprobante="ingreso" metodoDePago="metodopago" LugarExpedicion="lugarExpedicion" NumCtaPago="numctapago" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd http://www.sat.gob.mx/leyendasFiscales http://www.sat.gob.mx/sitio_internet/cfd/leyendasFiscales/leyendasFisc.xsd" xmlns:leyendasFisc="http://www.sat.gob.mx/leyendasFiscales" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><cfdi:Emisor rfc="SIS091218AZ4" nombre="Emisor"><cfdi:DomicilioFiscal calle="calleemisor" codigoPostal="05220" estado="estadoemisor" municipio="municipioemisor" pais="paisemisor" colonia="coloniaemisor" noExterior="extemisor" noInterior="intemisor"/><cfdi:RegimenFiscal Regimen="Persona Moral"/></cfdi:Emisor><cfdi:Receptor nombre="Receptor" rfc="SIS091218AZ4"><cfdi:Domicilio calle="callereceptor" codigoPostal="05454" colonia="colreceptor" estado="estadoreceptor" municipio="municipioreceptor" noExterior="extreceptor" noInterior="intreceptor" pais="paisreceptor"/></cfdi:Receptor><cfdi:Conceptos><cfdi:Concepto cantidad="1.00" descripcion="Producto" importe="1.00" valorUnitario="1.00" unidad="Unidad" noIdentificacion="ID"/></cfdi:Conceptos><cfdi:Impuestos totalImpuestosRetenidos="1.00"><cfdi:Traslados><cfdi:Traslado importe="1.00" impuesto="IVA" tasa="1.00"/></cfdi:Traslados></cfdi:Impuestos><cfdi:Complemento><leyendasFisc:LeyendasFiscales version="1.0"><leyendasFisc:Leyenda disposicionFiscal="setDisposicionFiscal" norma="setNorma" textoLeyenda="setTextoLeyenda"/></leyendasFisc:LeyendasFiscales></cfdi:Complemento></cfdi:Comprobante>',
    'user' => 'AAA111111ZZZ',
    'pass' => 'TeStInGfIsCoClIc2012Ws'
);

$result = $client->timbraCFDIXMLTest($params);
$taxStamps = $client->__getLastResponse();
$var = explode(" ", $taxStamps);

$tfdTimbre_pre = "<tfd:TimbreFiscalDigital " . $var[3];//version xml que inicie con <tfd:TimbreFiscalDigital
$uuid_pre = $var[4]; //UUID
$fechaTimbrado_pre = $var[5]; //FechaTimbrado
$selloCFD_pre = $var[6]; //Sello CFD
$numCertificadoSAT_pre = $var[7]; //Num certificado SAT
$selloSAT_pre = $var[8];//Sello SAT
$schemaLocation_pre = $var[9] . " " . $var[10]; //schemaLocation
$xmlnsTFD_pre = $var[11]; //xmlns:tfd
$xmlnsXSI_pre = $var[12]; //xmlns:xsi

//This extract content from double quotes " "
$sat0 = preg_match('/"([^"]+)"/', $tfdTimbre_pre, $tfdTimbre);
$sat1 = preg_match('/"([^"]+)"/', $uuid_pre, $uuid);
$sat2 = preg_match('/"([^"]+)"/', $fechaTimbrado_pre, $fechaTimbrado);
$sat3 = preg_match('/"([^"]+)"/', $selloCFD_pre, $selloCFD);
$sat4 = preg_match('/"([^"]+)"/', $numCertificadoSAT_pre, $numCertificadoSAT);
$sat5 = preg_match('/"([^"]+)"/', $selloSAT_pre, $selloSAT);
$sat6 = preg_match('/"([^"]+)"/', $schemaLocation_pre, $schemaLocation);
$sat7 = preg_match('/"([^"]+)"/', $xmlnsTFD_pre, $xmlnsTFD);
$sat8 = preg_match('/"([^"]+)"/', $xmlnsXSI_pre, $xmlnsXSI);
//----------------------------------------------------------------------------------------------------------------

//--------------------------------GET VALUES FROM SALES ACCORDING TO ID-------------------------------------------
foreach ($idSale as $key) {
    /*$getTotal = mysql_query("SELECT Total FROM ventas WHERE idventas='$key'");
    $result = mysql_fetch_array($getTotal);*/

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
    
}
//----------------------------------------------------------------------------------------------------------------

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
$saveGeneralData = mysql_query("INSERT INTO factura_general (montoTotal, totalLetra, rfc, fechaFactura, notas, pathPDF) 
                                       VALUES ('$totalSales', '$nLetra', '$rfcGeneral', '$today', '$noteSale', '')") or die(mysql_error());
//-----------------------------------------------------------------------------------------------------------------


//---------------------------------------MAKE PDF------------------------------------------------------------------
if ($saveGeneralData = true) {

    $idFolioFactura = mysql_insert_id();

    $generalData = mysql_query("SELECT * FROM factura_general WHERE idFolioFactura = '$idFolioFactura'");
    $getGeneralData = mysql_fetch_array($generalData);

    $montoTotal = $getGeneralData['montoTotal'];
    $totalLetra = $getGeneralData['totalLetra'];
    $rfc = $getGeneralData['rfc'];
    $notas = $getGeneralData['notas'];
    $fechaFactura = $getGeneralData['fechaFactura'];

    foreach ($idSale as $keyToSave) {
    //Save detail of sales
    $billDetail = mysql_query("INSERT INTO venta_factura (idTallerFactura, idFolioFacturaGeneral)VALUES('$keyToSave', '$idFolioFactura')")or die(mysql_error());
}
//-------------------------------------------BEGIN PDF------------------------------------------------------------

    include('pdf.php');
//------------------------------------------UPDATE PATH-----------------------------------------------------------
    $customPath = 'facturas-gnu/factura_' . $idFolioFactura . '.pdf';
    $updatePath = mysql_query("UPDATE factura_general SET pathPDF = '$customPath' WHERE idFolioFactura = '$idFolioFactura'") or die(mysql_error());

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
    
<?
//----------------------------------------------------------------------------------------------------------------
}
//-----------------------------------------------------------------------------------------------------------------
?>