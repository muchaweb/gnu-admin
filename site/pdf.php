<?php 
//--ES EL ARMADO DEL PDF CON LA INFORMACION DE LA FACTURA REALIZADA

$billPDF = '
<div class="row" style="padding-bottom: 0px;">

    <div class="col-xs-5">
        <img src="../img/logo3gas.jpg" width="150" alt=""/><br>
        <span class="">3EGASV S DE RL DE CV</span><br>
        <span class="">EGA100902M13</span><br>
        <span class="small palid-text">Periférico Paseo de la República No. 7875. 14 de Febrero</span><br>
        <span class="small palid-text">C.P.58147, Morelia, Michoacán</span><br>
    </div>

    <div class="col-xs-6">
            <table align="right">
                <tr> 
                    <td align="right"><span class="palid-text text-right" style="font-size:25px;">FACTURA</span></td> 
                </tr>
                <tr>
                    <td align="right">
                        <span class="palid-text text-right strong">Folio</span>
                        <br>
                         <span class="palid-text text-right">'.$idFacturacion.'</span>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <span class="palid-text text-right strong">Folio fiscal</span><br>
                        <span class="palid-text text-right">'.$uuid[1].'</span>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <span class="palid-text text-right strong">Lugar de expedición</span><br>
                        <span class="palid-text text-right">Morelia, Michoacán de Ocampo</span>
                    </td>
                </tr>

                <tr>
                    <td align="right">
                        <span class="palid-text text-right strong">Fecha de expedición</span><br>
                        <span class="palid-text text-right">'.$date.'</span>
                    </td>
                </tr>
            </table>
    </div>
</div>

<div class="row">
    <div class="col-xs-5">
        <span style="font-size:17px;">DATOS DEL CLIENTE</span>
        <div style="padding:10px 10px 10px 0; height:109px; font-size:14px;">
        '.$razonSocial.'<br>
        R.F.C.: XAXX010101000<br>
        </div>
    </div>

    <div class="col-xs-6" style="text-align:right;">
         <span style="font-size:17px;">CERTIFICADOS</span>
        <div style="height:100px; font-size:14px;" >
            <div style="padding: 5px; ">
                <strong>No.de certificado emisor</strong><br>
                <span>00001000000203345673</span> 
            </div>

            <div style="padding: 5px;">
                <strong>No. de certificado SAT</strong><br>
                <span>'.$numCertificadoSAT[1].'</span> 
            </div>

            <div style="padding: 5px;">
                <strong>Fecha de certificación</strong><br>
                <span>'.$fechaTimbrado[1].'</span>
            </div>           
      </div>
    </div>
    <div class="line"></div>
</div>

<div class="row">
    <div style="padding:10px;"> 
        <span style="font-size:17px;">DATOS DE LA FACTURA</span>
        <div class="line3"></div>
        <table style="width: 99%">
            <tr>
                <td align="" style="padding:10px; border: solid 3px white; width:110px; " class="">Cantidad</td>
                <td align="" style="padding:10px; border: solid 3px white; width:110px; " class="">U. de medida</td>
                <td align="" style="padding:10px; border: solid 3px white;" class="">Descripción</td>
                <td align="" style="padding:10px; border: solid 3px white; width:120px; " class="">P. por unidad</td>
                <td align="" style="padding:10px; border: solid 3px white; width:110px; " class="">Subtotal</td>
            </tr>';
            $billPDF .='
            <tr>
              <td align="" class="small" style="padding: 10px; border: solid 3px white; height: auto; vertical-align: top;">'.$volumen.'</td>
              <td align="" class="small" style="padding: 10px; border: solid 3px white; height: auto; vertical-align: top;">m3</td>
              <td align="" class="small" style="padding: 10px; border: solid 3px white; height: auto; vertical-align: top;">Gas Natural Comprimido</td>
              <td align="" class="small" style="padding: 10px; border: solid 3px white; height: auto; vertical-align: top;">$'.$precioPorUnidad.'</td>
              <td align="" class="small" style="padding: 10px; border: solid 3px white; height: auto; vertical-align: top;">$'.$subtotal.'</td>
            </tr>';
        $billPDF .= '
        </table>
    </div>
</div>

<div class="row">
    <div style="padding-left:13px;">    
        <table style="width: 99%">
            <tr>
                <td align="right" style="padding:5px; border: solid 3px white; width:100px;" class="">
                    <span style="text-align:left;">I.V.A.</span> $' . $importe . '</td>
            </tr>
            <tr>
                <td align="right" style="padding:5px; border: solid 3px white; width:100px;" class="">
                    <span style="text-align:left;">TOTAL</span> $'.$total.'</td>
            </tr>
            <tr>
                <td align="right" style="padding:5px; border: solid 3px white; width:100px; position:fixed;" class="">'.$nLetra.'</td>
            </tr>
        </table>
    </div>
</div>

<div class="row">
    <div style="padding:13px;">
        <table style="width: 99%">
            <tr>
                <td style="width:30px; padding-bottom:10px; font-size:17px;">INFORMACIÓN DEL PAGO</td>
                <td style="padding-bottom:10px; width:30px;"></td>
                <td align="" style="text-align:right; padding-bottom:10px; rder-left: solid 30px white; width:320px; font-size:17px;">OBSERVACIONES</td>
            </tr>
            <tr>
                <td align="" style="width:30px;" class="">
                    <strong>Forma de pago</strong> <br>
                    Pago en una sola exhibición
                </td>
                <td style="padding:5px; width:30px;" class=""></td>
                <td align="" style="padding:5px; text-align:right; border-left: solid 30px white; width:290px;" class="">'.$notas.'</td>
            </tr>
            <tr>
                <td align="" style="width:30px;" class="">
                    <strong>Método de pago</strong>
                    <br> Efectivo
                </td>
                <td align="" style="padding:5px; width:30px;" class=""></td>
                <td align="" style="padding:5px; border-left: solid 30px white; width:290px;" class=""></td>
            </tr>
            <tr>
                <td align="" style="width:30px;" class="">
                    <strong>Régimen fiscal</strong> 
                    <br>Regimen general de ley de personas morales
                </td>
                <td align="" style="padding:5px; width:30px;" class=""></td>
                <td align="" style="padding:5px; border-left: solid 30px white; width:290px;" class=""></td>
            </tr>
        </table>
    </div>
    <div class="line2"></div>
    <div class="line3"></div>
</div>

<div class="row">
    <div class="col-xs-3">
        <img src="../img/qr3gas.jpg"  alt=""/>
    </div>
    <div class="col-xs-8">
        <strong class="small">Cadena Original del Complemento de Certificación Digital del SAT</strong><br>
        <span class="small">
            ||' . $tfdTimbre[1] . '|' . $uuid[1] . '|' . $fechaTimbrado[1] . '|<br>' . $selloCFD[1] . '|' . $numCertificadoSAT[1] . '||
        </span><br>

        <strong class="small">Sello Digital del Emisor</strong>
        <span class="small ">
            '.$selloCFD[1].'
        </span><br>

        <strong class="small">Sello Digital del SAT</strong>
        <span class="small">
            '.$selloSAT[1].'
        </span><br>
    </div>
</div>

<span class="small">ESTE DOCUMENTO ES UNA REPRESENTACIÓN IMPRESA DE UN CFDI</span>';

//==============================================================

//==============================================================

//==============================================================
include("../lib/pdf/mpdf.php");

$mpdf = new mPDF('c',         // mode - default ''
    'A4', // format - A4, for example, default ''
    5,    // margin_left
    5,    // margin right
    5,    // margin top
    5,    // margin bottom
    5,    // margin header
    5     // margin footer
);
$stylesheet = file_get_contents('../css/pdf.css');
$mpdf->WriteHTML($stylesheet, 1);

$mpdf->WriteHTML($billPDF, 2);
$mpdf->Output('facturas-gnu/factura_' . $idFacturacion . '.pdf', 'F');

/*

===========================================================

                            P D F

===========================================================

*/
?>