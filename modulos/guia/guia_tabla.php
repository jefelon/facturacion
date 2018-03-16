<?php
require_once ("../../config/Cado.php");
require_once ("../guia/cGuia.php");
$oGuia = new cGuia();
require_once ("../formatos/formato.php");

$dts1=$oGuia->mostrar_filtro(fecha_mysql($_POST['gui_fec1']),fecha_mysql($_POST['gui_fec2']), $_POST['con_id'], $_POST['tra_id'], $_POST['gui_est']);
$num_rows= mysql_num_rows($dts1);
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
	
	$('.btn_anular').button({
		icons: {primary: "ui-icon-cancel"},
		text: false
	});

	$.tablesorter.defaults.widgets = ['zebra'];
	//$.tablesorter.defaults.sortList = [[0,0]];
	$("#tabla_guia").tablesorter({ 
		headers: {
			0: {sorter: 'shortDate' },
			10: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_guia" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th>REMITENTE</th>
                  <th>DESTINATARIO</th>
                  <th>PUNTO PARTIDA</th>
                  <th>PUNTO LLEGADA</th>
                  <th>NUM GUÍA</th>                                    
                    <th>OBSERVACIÓN</th>
                    <th>MARCA / PLACA VEHÍCULO</th>   
                    <th>CONDUCTOR</th>
                    <th>TRANSPORTE</th>                   
                    <th align="right">ESTADO</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){	?>
                    <tr>
                      <td><?php echo mostrarFecha($dt1['tb_guia_fec'])?></td>                      
                      <td><?php echo $dt1['tb_guia_rem']?></td> 
                      <td><?php echo $dt1['tb_guia_des']?></td> 
                      <td><?php echo $dt1['tb_guia_punpar']?></td> 
                      <td><?php echo $dt1['tb_guia_punlle']?></td>                       
                      <td><?php echo $dt1['tb_guia_num']?></td>                                    
                      <td><?php echo $dt1['tb_guia_obs']?></td>
                      <td><?php echo $dt1['tb_guia_mar']." /".$dt1['tb_guia_pla']?></td>                                         
                      <td><?php echo $dt1['tb_conductor_nom']?></td>
                      <td><?php echo $dt1['tb_transporte_razsoc']?></td>                      
                      <td><?php echo $dt1['tb_guia_est']?></td>
                      <td align="left">
                      <a class="btn_editar" href="#update" onClick="guia_form('editar','<?php echo $dt1['tb_guia_id']?>')">Editar</a> 
					  <?php if($dt1['tb_guia_est']!='ANULADA'){?>
                      <a class="btn_anular" href="#anular" onClick="guia_anular('<?php echo $dt1['tb_guia_id']?>')">Anular</a> 
                      <?php }?>
                      	<!--<a class="btn_eliminar" href="#delate" onClick="eliminar_guia('<?php //echo $dt1['tb_guia_id']?>')">Eliminarr</a>-->
                      </td>
                    </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
            </tbody>
            <?php
			}
		    ?>               
                <tr class="even">
                  <td colspan="12"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>