<?php
require_once ("../../config/Cado.php");
require_once("cTelefono.php");
$oTelefono = new cTelefono();

$dts1=$oTelefono->mostrarTodos_usuario($_POST['usu_id']);
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
	$("#tabla_usuario_telefono").tablesorter({ 
        headers: {
			3: {sorter: false },
			4: { sorter: false}
			},
		//sortForce: [[6,0]],
		sortList: [[0,0]] 
    });
}); 
</script>

<table cellspacing="1" id="tabla_usuario_telefono" class="tablesorter">
    <thead>
        <tr>
            <th>Tipo</th>
            <th>Operador</th>
            <th>Número</th>
            <th align="center">&nbsp;</th>
            <th align="center">&nbsp;</th>
         </tr>
    </thead>
    <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){	  
        ?>
      <tr class="even">
        <td><?php echo $dt1['tb_telefono_tip']?></td>
        <td><?php echo $dt1['tb_telefono_ope']?></td>
        <td><?php echo $dt1['tb_telefono_num']?></td>
        <td align="center"><a class="btn_editar" href="#" onClick="usuario_telefono_form('editar','<?php echo $dt1['tb_telefono_id']?>')">Editar</a></td>
        <td align="center"><a class="btn_eliminar" href="#" onClick="eliminar_usuario_telefono('<?php echo $dt1['tb_telefono_id']?>')">Eliminar</a></td>
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