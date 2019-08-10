<?php
require_once ("../../config/Cado.php");
require_once("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

$dts1=$oPuntoventa->mostrar_puntoventa_por_usuario($_POST['usu_id'],$punven_id);
$num_rows= mysql_num_rows($dts1);

if($num_rows>0)
{
?>


<script type="text/javascript" id="js">
$(function() {
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
	$("#tabla_usuario_puntoventa").tablesorter({ 
        headers: {
			2: {sorter: false }
			},
		//sortForce: [[6,0]],
		sortList: [[0,0]] 
    });
}); 
</script>

<table cellspacing="1" id="tabla_usuario_puntoventa" class="tablesorter">
    <thead>
        <tr>
            <th>Empresa</th>
            <th>Punto de Venta</th>
            <th align="center">&nbsp;</th>
         </tr>
    </thead>
    <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){	  
        ?>
      <tr class="even">
        <td><?php echo $dt1['tb_empresa_razsoc']?></td>
        <td><?php echo $dt1['tb_puntoventa_nom']?></td>
        <td align="center"><a class="btn_eliminar" href="#" onClick="eliminar_usuario_puntoventa('<?php echo $dt1['tb_usuariopv_id']?>')">Eliminar</a></td>
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