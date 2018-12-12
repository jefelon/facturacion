<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../traspaso/cTraspaso.php");
$oTraspaso = new cTraspaso();
require_once ("../formatos/formato.php");

$dts1=$oTraspaso->mostrar_filtro(fecha_mysql($_POST['tra_fec1']),fecha_mysql($_POST['tra_fec2']),$_POST['alm_ori'],$_POST['alm_des'],$_SESSION['empresa_id']);
$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(function() {	
	
	$('.btn_agregar_tra').button({		
		text: true
	});

	$("#tabla_traspaso").tablesorter({
		widgets: ['zebra', 'zebra'] ,
		headers: {
			0: {sorter: 'shortDate' },
			4: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
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
                      <td><?php echo str_pad($dt1['tb_traspaso_cod'],4, "0", STR_PAD_LEFT)?></td>
                      <td><?php echo $dt1['almacen_ori']?></td>
                      <td><?php echo $dt1['almacen_des']?></td>                      
                      <td align="center" nowrap="nowrap">
                      	<a class="btn_agregar_tra" href="#" onClick="restablecer_session('<?php echo $dt1['tb_traspaso_id']?>')">Seleccionar</a>
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
                  <td colspan="5"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>