<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cEncarte.php");
$oEncarte = new cEncarte();
require_once ("../formatos/formato.php");
require_once ("../formatos/operaciones.php");

$dts1=$oEncarte->mostrar_todos($_POST['enc_est']);
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

	$("#tabla_encarte").tablesorter({
		widgets : ['zebra','zebraHover'],
		headers: {
			0: {sorter: 'shortDate' },
			4: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_encarte" class="tablesorter">
            <thead>
                <tr>
                  <th title="FECHA INICIO">FECHA INI</th>
                  <th title="FECHA FIN">FECHA FIN</th>
                  <th title="DESCRIPCION">DESCRIPCION</th>
                  <th align="right" title="DESCUENTO PORCENTAJE">DESCTO. %</th>
                  <th align="right">ESTADO</th>
                  <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
//					$diferencia_días=0;
//					$estilo="";
//					//dia vencimiento - dia actual
//					if(mostrarFecha($dt1['tb_encarte_fecven'])!="")$diferencia_días=restaFechas(date('d-m-Y'),mostrarFecha($dt1['tb_encarte_fecven']));
//					
//					if($diferencia_días>0 and $dt1['tb_encarte_est']=='EMITIDA')
//					{
//						$estilo='style="color:#298A08; font-weight:bold;"';
//					}
//					
//					if($diferencia_días<=0 and $dt1['tb_encarte_est']=='EMITIDA')
//					{
//						$estilo='style="color:#F00; font-weight:normal;"';
//					}
				?>
                    <tr>
                      <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_encarte_fecini'])?></td>
                      <td>
					  <span <?php echo $estilo?>>
					  <?php echo mostrarFecha($dt1['tb_encarte_fecfin'])?>
                      </span>
                      </td>
                      <td><?php echo $dt1['tb_encarte_des']?></td>
                      <td align="right"><?php echo $dt1['tb_encarte_despor']?></td>
                      <td align="right"><?php echo $dt1['tb_encarte_est']?></td>
                      <td align="left" nowrap="nowrap">
                      <a class="btn_editar" href="#update" onClick="encarte_form('editar','<?php echo $dt1['tb_encarte_id']?>')">Editar</a>
                      <?php if($dt1['tb_encarte_est']=='ACTIVO'){?>
                      <a class="btn_anular" href="#anular" onClick="encarte_anular('<?php echo $dt1['tb_encarte_id']?>')">Inactivo</a> 
                      <?php }?>
                      <!--<a class="btn_eliminar" href="#delate" onClick="eliminar_encarte('<?php //echo $dt1['tb_encarte_id']?>')">Eliminarr</a>-->
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
                  <td colspan="6">&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="6"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>