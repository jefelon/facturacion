<?php
/*$handle = printer_open();
printer_start_doc($handle, "Mi Documento");
printer_start_page($handle);
$font = printer_create_font("Arial",55,30,400,false,false, false,0);
printer_select_font($handle, $font);
$mostrar="ESTOY TRATANDO DE HACER FUNCIONAR ESTA COSA...";
$mostrar2= "Sigo intentando, pero en la otra linea";
printer_draw_text($handle,$mostrar,50,400);
printer_draw_text($handle,$mostrar2,50,900);
printer_delete_font($font);
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);*/
/*header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=nombre_archivo.doc");
header("Pragma: no-cache");
header("Expires: 0");*/
?>
<?php ?>
<HTML>
<HEAD>
<SCRIPT language="javascript"> 
function imprimir()
{ if ((navigator.appName == "Netscape")) { window.print() ; 
} 
else
{ var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>'; 
document.body.insertAdjacentHTML('beforeEnd', WebBrowser); WebBrowser1.ExecWB(6, -1); WebBrowser1.outerHTML = "";
}
}
</SCRIPT> 
</HEAD><!--onload="imprimir();"-->
<BODY>
Aqui estaria todo tu contenido a imprimir
<table border="0" cellspacing="0" cellpadding="0" style="width:180mm; font-family:'Courier New'; font-size:9pt">
  <tr>
    <td>hola</td>
    <td>ESTO ES UNA PRUEBA</td>
    <td>912342343224.99</td>
    <td>4354354354312890000</td>
  </tr>
  <tr>
    <td>HOLA DE NUEVO</td>
    <td>AAAAAAA</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" style="width:180mm; font-family:Arial; font-size:10px">
  <tr>
    <td>hola</td>
    <td>ESTO ES UNA PRUEBA</td>
    <td>912342343224.99</td>
    <td>4354354354312890000</td>
  </tr>
  <tr>
    <td>HOLA DE NUEVO</td>
    <td>AAAAAAA</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" style="width:180mm; font-family:Arial; font-size:10pt">
  <tr>
    <td>hola</td>
    <td>ESTO ES UNA PRUEBA</td>
    <td>912342343224.99</td>
    <td>4354354354312890000</td>
  </tr>
  <tr>
    <td>HOLA DE NUEVO</td>
    <td>AAAAAAA</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</BODY>
</HTML>
 <?php ?>