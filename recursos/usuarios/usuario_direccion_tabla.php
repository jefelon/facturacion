<?php
require_once ("../../config/Cado.php");
require_once("cDireccion.php");
$oDireccion = new cDireccion();
require_once("../ubigeo/cUbigeo.php");
$oUbigeo = new cUbigeo();

$dts1=$oDireccion->mostrarTodos_usuario($_POST['usu_id']);
$num_rows= mysql_num_rows($dts1);

if($num_rows>0)
{
?>

<script type="text/javascript" id="js">
$(document).ready(function() {
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
	$.tablesorter.defaults.widgets = ['zebra'];
	//$.tablesorter.defaults.sortList = [[0,0]];
	$("#tabla_usuario_direccion").tablesorter({ 
        headers: {
			2: {sorter: false },
			3: { sorter: false}
			},
		//sortForce: [[6,0]],
		sortList: [[0,0]] 
    });
}); 
</script>
<table cellspacing="1" id="tabla_usuario_direccion" class="tablesorter">
    <thead>
        <tr>
            <th>Ubigeo</th>
            <th>Dirección</th>
            <th align="center">&nbsp;</th>
            <th align="center">&nbsp;</th>
         </tr>
    </thead>
    <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){	  
        ?>
      <tr class="even">
        <td>
		<?php
		$dts2=$oUbigeo->mostrarUbigeo($dt1['tb_ubigeo_cod']);
			$dt2=mysql_fetch_array($dts2);
			echo $dt2['Departamento'].' - '.$dt2['Provincia'].' - '.$dt2['Distrito'];
		mysql_free_result($dts2);
		?>
        </td>
        <td><?php echo $dt1['tb_direccion_dir']?></td>
        <td align="center"><a class="btn_editar" href="#" onClick="usuario_direccion_form('editar','<?php echo $dt1['tb_direccion_id']?>')">Editar</a></td>
        <td align="center"><a class="btn_eliminar" href="#" onClick="eliminar_usuario_direccion('<?php echo $dt1['tb_direccion_id']?>')">Eliminar</a></td>
      </tr>
         <?php
         }
         mysql_free_result($dts1);
         ?>
    </tbody>
</table>
<?php
}
?>