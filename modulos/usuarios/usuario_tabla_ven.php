<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cUsuario.php");
$oUsuario = new cUsuario();
require_once("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();


require_once ("../formatos/formatos.php");

$dts1=$oUsuario->mostrar_vendedor('Vendedor',$_POST['bus'],$_POST['punven_id'],$_SESSION['empresa_id']);
$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(function() {	
	$('.btn_pas').button({
		icons: {primary: "ui-icon-key"},
		text: false
	});
	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
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
			8: { sorter: false}
			},
		//sortForce: [[6,0]],
		<?php if($num_rows>0){ ?>
		sortList: [[0,0],[1,0]]
		<?php }?> 
    });
}); 
</script>
<table cellspacing="1" id="tabla_usuario" class="tablesorter">
    <thead>
        <tr>
            <th>APELLIDOS</th>
            <th>NOMBRE</th>
            <th>USUARIO</th>
            <th>CORREO</th>
            <th>PUNTO DE VENTA</th>
            <th>HORARIO</th>
            <th>BLOQ</th>
            <th>ULTIMA VISITA</th>
            <th align="center">&nbsp;</th>
         </tr>
    </thead>
    <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){	  
        ?>
      <tr>
        <td><?php echo $dt1['tb_usuario_apepat']." ".$dt1['tb_usuario_apemat']?></td>
        <td><?php echo $dt1['tb_usuario_nom']?></td>
        <td><?php echo $dt1['tb_usuario_use']?></td>
        <td><?php echo $dt1['tb_usuario_ema']?></td>
        <td><?php echo $dt1['tb_puntoventa_nom']?></td>
        <td><?php echo $dt1['tb_horario_nom']?></td>
        <td><?php echo mostrar_siigual($dt1['tb_usuario_blo'],1,'SI')?></td>
        <td><?php echo mostrarFechaHora($dt1['tb_usuario_ultvis'])?></td>
        <td align="center" nowrap="nowrap"><a class="btn_editar" href="#" onClick="editar_usuario('<?php echo $dt1['tb_usuario_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_usuario('<?php echo $dt1['tb_usuario_id']?>')">Eliminar</a></td>
      </tr>
         <?php
         }
         mysql_free_result($dts1);
         ?>
    </tbody>
</table>