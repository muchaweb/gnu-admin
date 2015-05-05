<?php 
function dropAccents($incoming_string){        
  $tofind = "ÀÁÂÄÅàáâäÒÓÔÖòóôöÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿ";
  $replac = "AAAAAaaaaOOOOooooEEEEeeeeCcIIIIiiiiUUUUuuuuy";
  return utf8_encode(strtr(utf8_decode($incoming_string), utf8_decode($tofind), $replac));
}

$date = date("Y-m-d").'T'.date("H:i:s");

//Paso 1 generar cadena
$name = 'cfdi_1_'.$idFacturacion.'.xml';
$pathXMLCFDI = '_generate/'.$name;
$fp = fopen($pathXMLCFDI, 'w+');

$xml_sin_sello = '<?xml version="1.0" encoding="UTF-8"?><cfdi:Comprobante version="3.2" folio="'.$idFacturacion.'" fecha="'.$date.'" formaDePago="PAGO EN UNA SOLA EXHIBICION" noCertificado="00001000000303280009" certificado="MIIEaTCCA1GgAwIBAgIUMDAwMDEwMDAwMDAzMDMyODAwMDkwDQYJKoZIhvcNAQEFBQAwggGKMTgwNgYDVQQDDC9BLkMuIGRlbCBTZXJ2aWNpbyBkZSBBZG1pbmlzdHJhY2nDs24gVHJpYnV0YXJpYTEvMC0GA1UECgwmU2VydmljaW8gZGUgQWRtaW5pc3RyYWNpw7NuIFRyaWJ1dGFyaWExODA2BgNVBAsML0FkbWluaXN0cmFjacOzbiBkZSBTZWd1cmlkYWQgZGUgbGEgSW5mb3JtYWNpw7NuMR8wHQYJKoZIhvcNAQkBFhBhY29kc0BzYXQuZ29iLm14MSYwJAYDVQQJDB1Bdi4gSGlkYWxnbyA3NywgQ29sLiBHdWVycmVybzEOMAwGA1UEEQwFMDYzMDAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBEaXN0cml0byBGZWRlcmFsMRQwEgYDVQQHDAtDdWF1aHTDqW1vYzEVMBMGA1UELRMMU0FUOTcwNzAxTk4zMTUwMwYJKoZIhvcNAQkCDCZSZXNwb25zYWJsZTogQ2xhdWRpYSBDb3ZhcnJ1YmlhcyBPY2hvYTAeFw0xNDAzMTExODU1MjJaFw0xODAzMTExODU1MjJaMIG1MR0wGwYDVQQDExQzRUdBU1YgUyBERSBSTCBERSBDVjEdMBsGA1UEKRMUM0VHQVNWIFMgREUgUkwgREUgQ1YxHTAbBgNVBAoTFDNFR0FTViBTIERFIFJMIERFIENWMSUwIwYDVQQtExxFR0ExMDA5MDJNMTMgLyBNQUFFNzgwNTEzQjE0MR4wHAYDVQQFExUgLyBNQUFFNzgwNTEzSE1OR0xEMDkxDzANBgNVBAsTBlVOSURBRDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3H41Z+wNaZJQRxhgoWBsYed8JFRL69sTcYg852j3db7k6AcsSu+MzygurtHJK0drrqgZ4k6hm4hkKK0vRUckwXCvUWNsGUtlGe79Y1wN2025FXE+OOOeU9DhBynS8m7JJTbIXcMfWGJ0G/7TJXIJEJcV/kzmDYNElgd0Z8BxeQsCAwEAAaMdMBswDAYDVR0TAQH/BAIwADALBgNVHQ8EBAMCBsAwDQYJKoZIhvcNAQEFBQADggEBANMWDXgtg1G+XAhWz+Xu5GWJ1PleFz3MlSW+rksRbYznXD1KVJfAUJDg1Z6nRB0R++IGIjiWt4dXwJx1GE8zLWpCxJyYY54BBTNJjgnynNYIbbtyCwVNi1FZyNQg8ocFizMJCFYm9/QYgSJ5zYx4yJME8WGvAgwAOTvDCslPDnctPYjztqQwbvdnIefypolsbH9fd4Xr7f2Fvy0vgdytJIIU7Le+6eb5UE1Mp9jp2G+PKftv6MqntN8kFBu4Ps2yEexiXwlcdGaCqHhFsL9ESkYqP4N53rAr7xS154hzjVqjDEJMefo+A5u/AiFPSRaYciGrUCDOpPHMFsMeURmUqpg=" subTotal="'.$subtotal.'" TipoCambio="1.0" Moneda="MXN" total="'.$total.'" tipoDeComprobante="ingreso" metodoDePago="DESCONOCIDO" LugarExpedicion="MORELIA, MICHOACAN" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd http://www.sat.gob.mx/leyendasFiscales http://www.sat.gob.mx/sitio_internet/cfd/leyendasFiscales/leyendasFisc.xsd" xmlns:leyendasFisc="http://www.sat.gob.mx/leyendasFiscales" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><cfdi:Emisor rfc="EGA100902M13" nombre="3EGASV S DE RL DE CV"><cfdi:DomicilioFiscal calle="PERIFERICO PASEO DE LA REPUBLICA" codigoPostal="58147" estado="MICHOACAN" municipio="MORELIA" pais="MEXICO" colonia="14 DE FEBRERO" noExterior="7875" noInterior="0"/><cfdi:RegimenFiscal Regimen="REGIMEN GENERAL DE LEY PERSONAS MORALES"/></cfdi:Emisor><cfdi:Receptor nombre="'.strtoupper($razonSocial).'" rfc="XAXX010101000"><cfdi:Domicilio calle="DESCONOCIDO" codigoPostal="0" colonia="DESCONOCIDO" estado="DESCONOCIDO" municipio="DESCONOCIDO" noExterior="0" noInterior="0" pais="DESCONOCIDO"/></cfdi:Receptor><cfdi:Conceptos><cfdi:Concepto cantidad="'.$volumen.'" descripcion="GAS NATURAL COMPRIMIDO" importe="'.$importe.'" valorUnitario="'.$precioPorUnidad.'" unidad="M3" noIdentificacion="'.$idventaServicio.'"/></cfdi:Conceptos><cfdi:Impuestos totalImpuestosRetenidos="0"><cfdi:Traslados><cfdi:Traslado importe="'.$importe.'" impuesto="IVA" tasa="0"/></cfdi:Traslados></cfdi:Impuestos><cfdi:Complemento><leyendasFisc:LeyendasFiscales version="1.0"><leyendasFisc:Leyenda disposicionFiscal="setDisposicionFiscal" norma="setNorma" textoLeyenda="setTextoLeyenda"/></leyendasFisc:LeyendasFiscales></cfdi:Complemento></cfdi:Comprobante>';
$xml_original = dropAccents($xml_sin_sello);

fwrite($fp, $xml_original);
fclose($fp); 

//Paso 2 generar la cadena
$data = shell_exec('xsltproc _generate/cadenaoriginal_3_2.xslt '.$pathXMLCFDI.' --output _generate/file_'.$idFacturacion.'.txt');

//Paso 3 generar archivo .pem
$key_pem = shell_exec('openssl pkcs8 -inform DET -in _generate/ega100902m13_1403110953s.key -passin pass:MahM7373 -out _generate/key.pem');

//Paso 4 firmar la cadena
$sign = shell_exec('openssl dgst -sha1 -out _generate/sign_'.$idFacturacion.'.bin -sign _generate/key.pem _generate/file_'.$idFacturacion.'.txt');

//Paso 5 encriptar sello
$final_sign = shell_exec('openssl enc -in _generate/sign_'.$idFacturacion.'.bin -a -A -out _generate/signB64_'.$idFacturacion.'.txt');

//Paso 6 leer sello
$sello_final = file_get_contents('_generate/signB64_'.$idFacturacion.'.txt');

//Paso 7 integrar sello
$pathcfdi = '_generate/cfdi_'.$idFacturacion.'.txt';
$fp2 = fopen($pathcfdi, 'w+');

$xml_con_sello = '<?xml version="1.0" encoding="UTF-8"?><cfdi:Comprobante version="3.2" folio="'.$idFacturacion.'" fecha="'.$date.'" sello="'.$sello_final.'" formaDePago="PAGO EN UNA SOLA EXHIBICION" noCertificado="00001000000303280009" certificado="MIIEaTCCA1GgAwIBAgIUMDAwMDEwMDAwMDAzMDMyODAwMDkwDQYJKoZIhvcNAQEFBQAwggGKMTgwNgYDVQQDDC9BLkMuIGRlbCBTZXJ2aWNpbyBkZSBBZG1pbmlzdHJhY2nDs24gVHJpYnV0YXJpYTEvMC0GA1UECgwmU2VydmljaW8gZGUgQWRtaW5pc3RyYWNpw7NuIFRyaWJ1dGFyaWExODA2BgNVBAsML0FkbWluaXN0cmFjacOzbiBkZSBTZWd1cmlkYWQgZGUgbGEgSW5mb3JtYWNpw7NuMR8wHQYJKoZIhvcNAQkBFhBhY29kc0BzYXQuZ29iLm14MSYwJAYDVQQJDB1Bdi4gSGlkYWxnbyA3NywgQ29sLiBHdWVycmVybzEOMAwGA1UEEQwFMDYzMDAxCzAJBgNVBAYTAk1YMRkwFwYDVQQIDBBEaXN0cml0byBGZWRlcmFsMRQwEgYDVQQHDAtDdWF1aHTDqW1vYzEVMBMGA1UELRMMU0FUOTcwNzAxTk4zMTUwMwYJKoZIhvcNAQkCDCZSZXNwb25zYWJsZTogQ2xhdWRpYSBDb3ZhcnJ1YmlhcyBPY2hvYTAeFw0xNDAzMTExODU1MjJaFw0xODAzMTExODU1MjJaMIG1MR0wGwYDVQQDExQzRUdBU1YgUyBERSBSTCBERSBDVjEdMBsGA1UEKRMUM0VHQVNWIFMgREUgUkwgREUgQ1YxHTAbBgNVBAoTFDNFR0FTViBTIERFIFJMIERFIENWMSUwIwYDVQQtExxFR0ExMDA5MDJNMTMgLyBNQUFFNzgwNTEzQjE0MR4wHAYDVQQFExUgLyBNQUFFNzgwNTEzSE1OR0xEMDkxDzANBgNVBAsTBlVOSURBRDCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEA3H41Z+wNaZJQRxhgoWBsYed8JFRL69sTcYg852j3db7k6AcsSu+MzygurtHJK0drrqgZ4k6hm4hkKK0vRUckwXCvUWNsGUtlGe79Y1wN2025FXE+OOOeU9DhBynS8m7JJTbIXcMfWGJ0G/7TJXIJEJcV/kzmDYNElgd0Z8BxeQsCAwEAAaMdMBswDAYDVR0TAQH/BAIwADALBgNVHQ8EBAMCBsAwDQYJKoZIhvcNAQEFBQADggEBANMWDXgtg1G+XAhWz+Xu5GWJ1PleFz3MlSW+rksRbYznXD1KVJfAUJDg1Z6nRB0R++IGIjiWt4dXwJx1GE8zLWpCxJyYY54BBTNJjgnynNYIbbtyCwVNi1FZyNQg8ocFizMJCFYm9/QYgSJ5zYx4yJME8WGvAgwAOTvDCslPDnctPYjztqQwbvdnIefypolsbH9fd4Xr7f2Fvy0vgdytJIIU7Le+6eb5UE1Mp9jp2G+PKftv6MqntN8kFBu4Ps2yEexiXwlcdGaCqHhFsL9ESkYqP4N53rAr7xS154hzjVqjDEJMefo+A5u/AiFPSRaYciGrUCDOpPHMFsMeURmUqpg=" subTotal="'.$subtotal.'" TipoCambio="1.0" Moneda="MXN" total="'.$total.'" tipoDeComprobante="ingreso" metodoDePago="DESCONOCIDO" LugarExpedicion="MORELIA, MICHOACAN" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd http://www.sat.gob.mx/leyendasFiscales http://www.sat.gob.mx/sitio_internet/cfd/leyendasFiscales/leyendasFisc.xsd" xmlns:leyendasFisc="http://www.sat.gob.mx/leyendasFiscales" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><cfdi:Emisor rfc="EGA100902M13" nombre="3EGASV S DE RL DE CV"><cfdi:DomicilioFiscal calle="PERIFERICO PASEO DE LA REPUBLICA" codigoPostal="58147" estado="MICHOACAN" municipio="MORELIA" pais="MEXICO" colonia="14 DE FEBRERO" noExterior="7875" noInterior="0"/><cfdi:RegimenFiscal Regimen="REGIMEN GENERAL DE LEY PERSONAS MORALES"/></cfdi:Emisor><cfdi:Receptor nombre="'.strtoupper($razonSocial).'" rfc="XAXX010101000"><cfdi:Domicilio calle="DESCONOCIDO" codigoPostal="0" colonia="DESCONOCIDO" estado="DESCONOCIDO" municipio="DESCONOCIDO" noExterior="0" noInterior="0" pais="DESCONOCIDO"/></cfdi:Receptor><cfdi:Conceptos><cfdi:Concepto cantidad="'.$volumen.'" descripcion="GAS NATURAL COMPRIMIDO" importe="'.$importe.'" valorUnitario="'.$precioPorUnidad.'" unidad="M3" noIdentificacion="'.$idventaServicio.'"/></cfdi:Conceptos><cfdi:Impuestos totalImpuestosRetenidos="0"><cfdi:Traslados><cfdi:Traslado importe="'.$importe.'" impuesto="IVA" tasa="0"/></cfdi:Traslados></cfdi:Impuestos><cfdi:Complemento><leyendasFisc:LeyendasFiscales version="1.0"><leyendasFisc:Leyenda disposicionFiscal="setDisposicionFiscal" norma="setNorma" textoLeyenda="setTextoLeyenda"/></leyendasFisc:LeyendasFiscales></cfdi:Complemento></cfdi:Comprobante>';

fwrite($fp2, $xml_con_sello);
fclose($fp2); 
?>