<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

require_once ("../compra/cCompra.php");
$oCompra = new cCompra();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();

//empresa 
$emp=$_SESSION['empresa'];

//año
$anio=date('Y');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Flujo Compras - Ventas</title>
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<!--<link href="Estilo/miestilo_cuadre.css" rel="stylesheet" type="text/css">-->
<link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../../js/cluetip/jquery.cluetip.css" type="text/css" />

<link rel="stylesheet" href="../../js/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
<script src="../../js/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.button.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.position.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.dialog.js"></script>


<script src="../../js/cluetip/lib/jquery.hoverIntent.js"></script>
<script src="../../js/cluetip/jquery.cluetip.min.js"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
function cargar_tabla_flujo()
{	
	$.ajax({
		type: "POST",
		url: "flujo_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			emp: 	'<?php echo $emp?>',
			anio: 	$('#cmb_fil_flu_ani').val()
		}),
		beforeSend: function() {
			$('#div_flujo_tabla').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_flujo_tabla').html(html);
		}
	});       
}
//
$(function() {
	cargar_tabla_flujo();
	
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: true
	});
});

</script>
<style type="text/css">
.btn_verdetalle {
	font-size: 11px;
	font-weight: bold;
	color: #06C;
}
</style>
</head>

<body>
<div class="container">
	<header>
    	<?php echo $oContenido->print_header()?>
  </header>
    <div class="content">
    	<div class="contenido">
		<div>
            <div class="contenido_des">
			<table  align="center" class="tabla_cont">
      <tr>
        <td class="caption_cont">FLUJO COMPRAS - VENTAS</td>
      </tr>
      <tr>
        <td align="right" class="cont_emp"><span title="Está Visualizando la Información de:"><?php echo $_SESSION['empresa_nombre']?></span></td>
      </tr>
      <tr>
        <td><table class="tabla_busqueda">
          <form id="for_flu" name="for_flu" method="post" action="">
            <tr>
              <td><label for="cmb_fil_flu_ani">Año:</label>
                <select name="cmb_fil_flu_ani" id="cmb_fil_flu_ani">
                  <?php

$num1=mysql_num_rows($oCompra->aniosCompra());
$num2=mysql_num_rows($oVenta->aniosVenta());
if($num1>=$num2){
	$dts=$oCompra->aniosCompra();
}
else{
	$dts=$oVenta->aniosVenta();
}
while($dt = mysql_fetch_array($dts))
{
?>
                  <option value="<?php echo $dt['anio']?>" <?php if($dt['anio']==$anio)echo 'selected'?>><?php echo $dt['anio']?></option>
                  <?php 
}
mysql_free_result($dts);

?>
                </select></td>
              <td><a href="#" onClick="cargar_tabla_flujo()" id="btn_filtrar">Filtrar</a></td>
              </tr>
            </form>
          </table></td>
      </tr>
  </table>
			</div>
   		</div>
        <div id="div_compras_detalle_tabla"></div>
        <div id="div_ventas_detalle_tabla"></div>
        <div id="div_flujo_tabla"><!-- div de la tabla-->        	
        </div>
        </div>
  	</div>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>