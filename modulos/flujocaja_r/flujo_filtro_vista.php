<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once("../flujocaja - Copia/Cado.php");

require_once ("../flujocaja - Copia/Libreria/contenido.php");
$oContenido = new cContenido();

require_once ("../flujocaja - Copia/Clases/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../flujocaja - Copia/Clases/cGasto.php");
$oGasto = new cGasto();
require_once ("../flujocaja - Copia/Clases/cEntfinanciera.php");
$oEntfinanciera = new cEntfinanciera();

//empresa 
$emp=$_SESSION['empresa'];

//año
$anio=date('Y');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Flujo de Gastos</title>
<link href="../flujocaja - Copia/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<link href="../flujocaja - Copia/Estilo/miestilo_cuadre.css" rel="stylesheet" type="text/css">
<link href="../flujocaja - Copia/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="../flujocaja - Copia/cluetip/jquery.cluetip.css" type="text/css" />

<link rel="stylesheet" href="../flujocaja - Copia/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
<script src="../flujocaja - Copia/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
<script src="../flujocaja - Copia/jquery-ui/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
<script src="../flujocaja - Copia/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="../flujocaja - Copia/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="../flujocaja - Copia/jquery-ui/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="../flujocaja - Copia/jquery-ui/development-bundle/ui/jquery.ui.button.js"></script>
<script src="../flujocaja - Copia/jquery-ui/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="../flujocaja - Copia/jquery-ui/development-bundle/ui/jquery.ui.position.js"></script>
<script src="../flujocaja - Copia/jquery-ui/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="../flujocaja - Copia/jquery-ui/development-bundle/ui/jquery.ui.dialog.js"></script>


<script src="../flujocaja - Copia/cluetip/lib/jquery.hoverIntent.js"></script>
<script src="../flujocaja - Copia/cluetip/jquery.cluetip.min.js"></script>

<link rel="stylesheet" href="../flujocaja - Copia/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../flujocaja - Copia/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript">
function cargar_tabla_flujo()
{	
	$.ajax({
		type: "POST",
		url: "flujo_filtro_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			emp: 	'<?php echo $emp?>',
			anio: 	$('#cmb_fil_flu_ani').val(),
			entfin:	$('#cmb_fil_flu_entfin').val()
		}),
		beforeSend: function() {
			$('#div_flujo_tabla').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_flujo_tabla').html(html);
		}/*,
		complete: function(){	
			$( "#i_loader" ).dialog( "close" );
		}*/
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
        <td class="caption_cont">FLUJO DE GASTOS</td>
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

$num1=mysql_num_rows($oIngreso->aniosIngreso());
$num2=mysql_num_rows($oGasto->aniosGasto());
if($num1>=$num2){
	$dts=$oIngreso->aniosIngreso();
}
else{
	$dts=$oGasto->aniosGasto();
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
              <td><label for="cmb_fil_flu_entfin">Banco: </label>
                <select name="cmb_fil_flu_entfin" id="cmb_fil_flu_entfin">
                  <option value="00">-</option>
                  <?php
$dts=$oEntfinanciera->mostrarTodos();
while($dt = mysql_fetch_array($dts))
{
?>
                  <option value="<?php echo $dt['tb_entfinanciera_id']?>"><?php echo $dt['tb_entfinanciera_nom']?></option>
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
        <div id="div_ingresos_detalle_tabla"></div>
        <div id="div_gastos_detalle_tabla"></div>
        <div id="div_flujo_tabla"><!-- div de la tabla-->        	
        </div>
        </div>
  	</div>
	<footer>
    	<?php echo $oContenido->print_footer()?>
  	</footer>
</div>

</body>
</html>