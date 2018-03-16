<?php
require_once ("../../config/Cado.php");
require_once ("cHorario.php");
$oHorario = new cHorario();
require_once("../formatos/formato.php");

$dts=$oHorario->mostrar_todos();
$num_rows= mysql_num_rows($dts);

?>
<script type="text/javascript">
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
	$("#tabla_horario").tablesorter({ 
		headers: {
			7: { sorter: false}
		},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_horario" class="tablesorter">
            <thead>
                <tr>
                <th> HORARIO</th>
                <th>FECHA INICIO</th>
                <th>FECHA FIN</th>
                <th>DIAS</th>
                <th>TURNO 1</th>
                <th>TURNO 2</th>
                <th>ESTADO</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
        <?php
        if($num_rows>=1){
		?>  
            <tbody>
			<?php
           	while($dt = mysql_fetch_array($dts)){
            ?>
                <tr>
                <td><?php echo $dt['tb_horario_nom']?></td>
                <td><?php echo mostrarFecha($dt['tb_horario_fecini'])?></td>
                <td><?php echo mostrarFecha($dt['tb_horario_fecfin'])?></td>
                <td>
				<?php echo 
				mostrar_siigual($dt['tb_horario_lun'],1,'LUN').
				mostrar_siigual($dt['tb_horario_mar'],1,'-MAR').
				mostrar_siigual($dt['tb_horario_mie'],1,'-MIE').
				mostrar_siigual($dt['tb_horario_jue'],1,'-JUE').
				mostrar_siigual($dt['tb_horario_vie'],1,'-VIE').
				mostrar_siigual($dt['tb_horario_sab'],1,'-SAB').
				mostrar_siigual($dt['tb_horario_dom'],1,'-DOM')
				?>
                </td>
                <td><?php echo mostrarHora($dt['tb_horario_horini1']).' - '.mostrarHora($dt['tb_horario_horfin1'])?></td>
                <td><?php echo mostrarHora($dt['tb_horario_horini2']).' - '.mostrarHora($dt['tb_horario_horfin2'])?></td>
                <td><?php echo $dt['tb_horario_est']?></td>
                <td align="center"><a class="btn_editar" href="#" onClick="horario_form('editar','<?php echo $dt['tb_horario_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_horario('<?php echo $dt['tb_horario_id']?>')">Eliminar</a></td>
                </tr>
			<?php
				}
				mysql_free_result($dts);
            ?>
            </tbody>
     	<?php
        }
		?>
                <tr class="even">
                  <td colspan="8"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>