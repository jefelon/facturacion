<?php
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();

require_once ("../formatos/formatos.php");
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
	$("#tabla_documento").tablesorter({
        widgets: ['zebra', 'zebraHover'],
        sortList: [[0,0]]
    });
}); 
</script>
COMUNICACIONES DE BAJA
        <table cellspacing="1" id="tabla_documento" class="tablesorter">
            <thead>
                <tr>
                <th>ID</th>
                <th>FECHA</th>
                <th>CODIGO</th>
                <th>FECHA REF</th>
                <th>DETALLE</th>
                <th>ESTADO SUNAT</th>
                <th>FECHA ENVIO SUNAT</th>
                <th>TICKET</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
		<?php
		$dts=$oVenta->listar_combaja(fecha_mysql($_POST['txt_fil_ven_fec1']));
        $num_rows=mysql_num_rows($dts);
        if($num_rows>0){
       	while($dt = mysql_fetch_array($dts)){
        ?>
        <tbody>
            <tr class="even">
            <td><?php echo $dt['tb_combaja_id']?></td>
            <td><?php echo $dt['tb_combaja_fec']?></td>
            <td><?php echo $dt['tb_combaja_cod']?></td>
            <td><?php echo $dt['tb_combaja_fecref']?></td>
            <td>
            <?php
                $dts1=$oVenta->listar_combaja_detalle($dt['tb_combaja_id']);
                $item=0;
                while($dt1 = mysql_fetch_array($dts1))
                {
                    $item++;
                    echo "$item) ".$dt1['tb_combajadetalle_ser'].'-'.$dt1['tb_combajadetalle_numdoc'].' ('.$dt1['tb_combajadetalle_mot'].')<br/>'; 
                }
            ?>
            </td>
            <td>
            <?php
                if($dt['tb_combaja_estsun']=='1')
                {
                  echo 'ACEPTADO';
                }
                else
                {
                  if($dt['tb_combaja_estsun']=='2')
                  {
                    echo 'RECHAZADO';
                  }else{
                    echo 'PENDIENTE ENVIO';
                    $mostrar_envio_sunat=1;
                  }
                }
            ?>
            </td>
            <td><?php echo mostrarFechaHora($dt['tb_combaja_fecenvsun'])?></td>
            <td><?php echo $dt['tb_combaja_tic']?></td>
            <td align="center">
                <?php if($mostrar_envio_sunat==1):?>
                      <a class="btn_sunat" href="#sunat" onClick="enviar_sunat('<?php echo $dt['tb_combaja_id']?>')">E. Sunat</a>
                <?php endif;?>
            </td>
            </tr>
		<?php
			}
            mysql_free_result($dts);?>
            </tbody>
        <?php
            }
		?>
        
                <tr class="even">
                  <td colspan="9"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>