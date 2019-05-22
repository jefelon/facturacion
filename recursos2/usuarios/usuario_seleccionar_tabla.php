<?php
require_once ("../../config/Cado.php");
require_once("cUsuario.php");
$oUsuario = new cUsuario();

require_once ("../formatos/formatos.php");

$usugru=$_POST['usugru'];
$dato=$_POST['dato_busqueda'];

if($dato!="")
{
	$dts1=$oUsuario->filtro1($usugru, $dato);
	$num_rows= mysql_num_rows($dts1);
}
?>

<script type="text/javascript">
$(function() {	
	$('.btn_seleccionar').button({
		icons: {primary: "ui-icon-check"},
		text: false
	});
});
</script>

<script type="text/javascript" id="js">
$(document).ready(function() {
	$.tablesorter.defaults.widgets = ['zebra'];
	//$.tablesorter.defaults.sortList = [[0,0]];
	$("#tabla_usuario").tablesorter({ 
        headers: {
			3: {sorter: false }
			},
		//sortForce: [[6,0]],
		sortList: [[0,0],[1,0]] 
    });
}); 
</script>
<div>
<?php 
if($num_rows==1)echo $num_rows.' resultado';
if($num_rows>1)echo $num_rows.' resultados'
?>
</div>
<table cellspacing="1" id="tabla_usuario" class="tablesorter" align="center">
    <thead>
        <tr>
            <th>Apellidos</th>
            <th>Nombres</th>
            <th>DNI</th>
            <th align="center">&nbsp;</th>
         </tr>
    </thead>
    <tbody>
        <?php
        if($num_rows>0)
        {
        while($dt1 = mysql_fetch_array($dts1)){	  
        ?>
      <tr>
        <td><?php echo $dt1['tb_usuario_apepat']." ".$dt1['tb_usuario_apemat']?></td>
        <td><?php echo $dt1['tb_usuario_nom']?></td>
        <td><?php echo $dt1['tb_usuario_dni']?></td>
        <td align="center"><a class="btn_seleccionar" href="#" onClick="cargar_datos_usuario_seleccionado('<?php echo $dt1['tb_usuario_id']?>')">Seleccionar</a></td>
      </tr>
         <?php
         }
         mysql_free_result($dts1);
         }
         ?>
    </tbody>
</table>