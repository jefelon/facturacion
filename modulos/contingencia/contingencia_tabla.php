<?php
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();

require_once ("../formatos/formatos.php");
?>
<script type="text/javascript">
$(function() {	
	$('.btn_descargar').button({
		//icons: {primary: "ui-icon-pencil"},
		text: true
	});
	

	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_documento").tablesorter({
        widgets: ['zebra', 'zebraHover'],
        sortList: [[0,0]]
    });
}); 
</script>
RESUMEN DE CONTINGENCIA
        <table cellspacing="1" id="tabla_documento" class="tablesorter">
            <thead>
                <tr>
                <th>ID</th>
                <th>FECHA</th>
                <th>CODIGO</th>
                <th>FECHA REFERENCIA</th>
                <th>MOTIVO</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
		<?php
		$dts=$oVenta->listar_contingencia(fecha_mysql($_POST['txt_fil_ven_fec1']));
        $num_rows=mysql_num_rows($dts);
        if($num_rows>0){
       	while($dt = mysql_fetch_array($dts)){
        ?>
        <tbody>
            <tr class="even">
            <td><?php echo $dt['tb_contingencia_id']?></td>
            <td><?php echo mostrarFecha($dt['tb_contingencia_fec'])?></td>
            <td><?php echo $dt['tb_contingencia_cod']?></td>
            <td><?php echo $dt['tb_contingencia_fecref']?></td>
            <td>
                <?php 
                    if($dt['tb_contingencia_mot']=='1')echo "CONEXIÓN A INTERNET";
                    if($dt['tb_contingencia_mot']=='2')echo "FALLAS FLUIDO ELÉCTRICO";
                    if($dt['tb_contingencia_mot']=='3')echo "DESASTRES NATURALES";
                    if($dt['tb_contingencia_mot']=='4')echo "ROBO";
                    if($dt['tb_contingencia_mot']=='5')echo "FALLAS EN EL SISTEMA DE FACTURACIÓN";
                    if($dt['tb_contingencia_mot']=='7')echo "OTROS";
                ?>
            </td>
            <td>
                <a class="btn_descargar" href="contingencia_txt.php?con_id=<?php echo $dt['tb_contingencia_id']?>">Dercargar TXT</a>
                <a class="btn_descargar" href="contingencia_zip.php?con_id=<?php echo $dt['tb_contingencia_id']?>">Dercargar ZIP</a>
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
                  <td colspan="6"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
