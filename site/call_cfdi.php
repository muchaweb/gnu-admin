<?php 
$cfdi_final = file_get_contents('_generate/cfdi_'.$idFacturacion.'.txt');

$client = new SoapClient('https://www.fiscoclic.mx/factura/WSEntityServices/timbre/TimbraWS?wsdl',
   array('features'=>SOAP_SINGLE_ELEMENT_ARRAYS, 
     'soap_version' => SOAP_1_2,
     'encoding'=>'UTF-8',
     'trace' => 1 ));

  $params = array(
    'cfdi'=> $cfdi_final,
    'user'=>'AAA111111ZZZ',
    'pass'=>'TeStInGfIsCoClIc2012Ws'
    );

  $result = $client->timbraCFDIXMLTest($params);
  $taxStamps  = $client->__getLastResponse();
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

?>