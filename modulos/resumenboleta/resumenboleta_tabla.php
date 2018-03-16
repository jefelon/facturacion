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
RESUMEN DIARIO
        <table cellspacing="1" id="tabla_documento" class="tablesorter">
            <thead>
                <tr>
                <th>ID</th>
                <th>FECHA</th>
                <th>CÓDIGO</th>
                <th>FECHA REFERENCIA</th>
                <th>DETALLE</th>
                <th>ESTADO SUNAT</th>
                <th>FECHA ENVÍO SUNAT</th>
                <th>TICKET</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
		<?php
		$dts=$oVenta->listar_resumenboleta(fecha_mysql($_POST['txt_fil_ven_fec1']));
        $num_rows=mysql_num_rows($dts);
        if($num_rows>0){
       	while($dt = mysql_fetch_array($dts)){
        ?>
        <tbody>
            <tr class="even">
            <td><?php echo $dt['tb_resumenboleta_id']?></td>
            <td><?php echo $dt['tb_resumenboleta_fec']?></td>
            <td><?php echo $dt['tb_resumenboleta_cod']?></td>
            <td><?php echo $dt['tb_resumenboleta_fecref']?></td>
            <td>
            <?php
                $filas=0;
                $dts1=$oVenta->listar_resumenboleta_detalle($dt['tb_resumenboleta_id']);
                while($dt1 = mysql_fetch_array($dts1))
                {
                    $filas++;
                    //echo $dt1['tb_resumenboletadetalle_ser'].'-'.$dt1['tb_resumenboletadetalle_cor'].' .........  TOTAL= '.$dt1['tb_resumenboletadetalle_imptot'].'<br>';
                }
                echo "$filas COMPROBANTES"; 
            ?>
            </td>
            <td>
            <?php 
            if($dt['tb_resumenboleta_estsun']=='1')
                {
                  echo 'ACEPTADO';
                }
                else
                {
                  if($dt['tb_resumenboleta_estsun']=='2')
                  {
                    echo 'RECHAZADO';
                  }else{
                    echo 'PENDIENTE ENVIO';
                    $mostrar_envio_sunat=1;
                  }
                }
            ?>
            </td>
            <td><?php echo mostrarFechaHora($dt['tb_resumenboleta_fecenvsun'])?></td>
            <td><?php echo $dt['tb_resumenboleta_tic']?></td>
            <td align="center">
                <?php if($mostrar_envio_sunat==1):?>
                      <a class="btn_sunat" href="#sunat" onClick="enviar_sunat('<?php echo $dt['tb_resumenboleta_id']?>')">E. Sunat</a>
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
