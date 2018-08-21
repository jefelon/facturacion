<?php
require_once ("../../config/Cado.php");
require_once ("cProducto.php");
$oProducto = new cProducto();

require_once ("cPresentacion.php");
$oPresentacion = new cPresentacion();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");

if(isset($_POST['pro_cat']) and $_POST['pro_cat']>0)
{
	$dc=$_POST['pro_cat'].'';
	
	$dts2=$oCategoria->mostrar_por_idp($_POST['pro_cat']);
	$num_rows2= mysql_num_rows($dts2);
	if($num_rows2>0){
		while($dt2 = mysql_fetch_array($dts2)){
			
			$dc.=', '.$dt2['tb_categoria_id'];
			
			$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
			$num_rows3= mysql_num_rows($dts3);
			if($num_rows3>0){
				while($dt3 = mysql_fetch_array($dts3)){
					$dc.=', '.$dt3['tb_categoria_id'];			
				}
			mysql_free_result($dts3);
			}//fin nivel 3
					
		}
	mysql_free_result($dts2);
	}//fin nivel 2

//echo $dc;			
}

$dts1=$oProducto->mostrar_filtro($_POST['pro_nom'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_POST['limit'],$_POST['ordby']);
$num_rows= mysql_num_rows($dts1);

//orden
if($_POST['ordby']=='tb_producto_mod DESC')$sort='[5,1]';
if($_POST['ordby']=='tb_producto_nom')$sort='[0,0]';
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.btn_presentacion').button({
		icons: {primary: "ui-icon-clipboard"},
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
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_producto").tablesorter({ 
		headers: {
			4: {sorter: 'shortDate' },
			7: {sorter: false }, 
			8: { sorter: false}
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [<?php echo $sort?>]
		<?php }?>
    });
}); 
</script>

        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th>DESCRIPCION</th>
                    <th>MARCA</th>
                    <th>CATEGORIA</th>
                    <th>TIPO AFECT.</th>
                    <th>MODIFICACION</th>
                    <th>ESTADO</th>
                    <th align="center" title="N° PRESENTACIONES">PRES</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){?>
                        <tr>
                            <td><?php echo $dt1['tb_presentacion_cod']?></td>
                            <td><?php echo $dt1['tb_producto_nom']?></td>
                            <td><?php echo $dt1['tb_producto_des']?></td>
                            <td><?php echo $dt1['tb_marca_nom']?></td>
                            <td><?php echo $dt1['tb_categoria_nom']?></td>
                            <td><?php if ($dt1['tb_afectacion_id']=='1') echo 'Gravado'; if ($dt1['tb_afectacion_id']=='9') echo 'Exonerado'; if ($dt1['tb_afectacion_id']=='11') echo 'Inafecto'?></td>
                            <td><?php echo mostrarFechaHora($dt1['tb_producto_mod'])?></td>
                            <td><?php echo $dt1['tb_producto_est']?></td>
                            <td align="center"><?php
							$dts2=$oPresentacion->mostrar_por_producto($dt1['tb_producto_id']);
							echo mysql_num_rows($dts2);
							mysql_free_result($dts2);
							?></td>
                            <td align="center" nowrap><a class="btn_editar" href="#editar" onClick="producto_form('editar','<?php echo $dt1['tb_producto_id']?>')">Editar</a><a class="btn_eliminar" href="#eliminar" onClick="eliminar_producto('<?php echo $dt1['tb_producto_id']?>')"> Eliminar</a></td>
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
                  <td colspan="8"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
