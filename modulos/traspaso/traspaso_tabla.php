<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cTraspaso.php");
$oTraspaso = new cTraspaso();
require_once ("../formatos/formato.php");

$activo=1;

$dts1=$oTraspaso->mostrar_filtro(fecha_mysql($_POST['txt_fil_tra_fec1']),fecha_mysql($_POST['txt_fil_tra_fec2']),$_POST['cmb_fil_tra_alm_ori'],$_POST['cmb_fil_tra_alm_des'],$_SESSION['empresa_id'],$activo);

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

	$("#tabla_traspaso").tablesorter({
		widgets: ['zebra', 'zebra'] ,
		headers: {
			0: {sorter: 'shortDate' },
			5: { sorter: false}
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0],[1,0]]
		<?php }?>
    });
	
}); 
</script>
        <table cellspacing="1" id="tabla_traspaso" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th>CODIGO</th>
                  <th>ALMACEN ORIGEN</th>
                    <th>ALMACEN DESTINO</th>
                    <th>REFERENCIA</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
				?>
                    <tr>
                      <td><?php echo mostrarFecha($dt1['tb_traspaso_fec'])?></td>
                      <td><?php echo $dt1['tb_traspaso_cod']?></td>
                      <td><?php echo $dt1['almacen_ori']?></td>
                      <td><?php echo $dt1['almacen_des']?></td>
                      <td><?php echo $dt1['tb_traspaso_ref']?></td>
                      <td align="center"><a class="btn_editar" href="#update" onClick="traspaso_form('editar','<?php echo $dt1['tb_traspaso_id']?>')">Editar</a>
                      <?php /*?><a class="btn_eliminar" href="#delete" onClick="eliminar_traspaso('<?php echo $dt1['tb_traspaso_id']?>')">Eliminarr</a><?php */?>
                      <?php if($dt1['tb_traspaso_est']!='0' and $_POST['chk_tra_anu']==1){?>
                      <a class="btn_anular" href="#anular" onClick="traspaso_anular('<?php echo $dt1['tb_traspaso_id']?>','<?php echo $dt1['tb_traspaso_cod']?>')">Anular</a> 
                      <?php }?>
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