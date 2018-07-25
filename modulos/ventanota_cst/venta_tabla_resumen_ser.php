<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVentanota.php");
$oVentanota = new cVentanota();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
require_once ("../formatos/formato.php");

//seleccion de las categorias
if(isset($_POST['cmb_fil_pro_cat']) and $_POST['cmb_fil_pro_cat']>0)
{
	$cadena_categorias=$_POST['cmb_fil_pro_cat'].'';
	
	$dts2=$oCategoria->mostrar_por_idp($_POST['cmb_fil_pro_cat']);
	$num_rows2= mysql_num_rows($dts2);
	if($num_rows2>0){
		while($dt2 = mysql_fetch_array($dts2)){
			
			$cadena_categorias.=', '.$dt2['tb_categoria_id'];
			
			$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
			$num_rows3= mysql_num_rows($dts3);
			if($num_rows3>0){
				while($dt3 = mysql_fetch_array($dts3)){
					$cadena_categorias.=', '.$dt3['tb_categoria_id'];			
				}
			mysql_free_result($dts3);
			}//fin nivel 3
					
		}
	mysql_free_result($dts2);
	}//fin nivel 2

//echo $cadena_categorias;			
}

//seleccion de los atributos
$atr_array=$_POST['atr_ids'];
if(is_array($atr_array)){
	$cadena_atr = implode(',',$atr_array);
}

$estado='CANCELADA';

$dts1=$oVentanota->mostrar_resumen_servicios_ventas(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$cadena_categorias,$_POST['hdd_fil_cli_id'],$estado,$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id']);
$num_rows2= mysql_num_rows($dts1);
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
	
	$("#tabla_venta").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		headers: {
			4: { sorter: 'numerico'}
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0],[4,1],[5,1]]
		<?php }?>
    });
	
}); 
</script>
<div>
<table cellspacing="1" id="tabla_venta" class="tablesorter">
            <thead>
                <tr>
                  <th>TIPO</th>
                  <th>ARTICULO</th>
                  <th>CATEGORIA</th>
                    <th>UNI</th>
                    <th align="right">CANTIDAD</th>
                    <!--<th align="right" title="Descuento">DESC</th>-->
                    <th align="right">MONTO</th>
                </tr>
            </thead>
            <tbody>
            <?php
			if($num_rows2>0){
			?>
            
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
					$sub_total=$dt1['valven']+$dt1['igv'];
					
					if($dt1['tb_venta_est']=='CANCELADA'){
						$total_valven	+=$dt1['valven'];
						$total_igv		+=$dt1['igv'];
						
						//$total_des		+=$dt1['tb_venta_des'];
						$total_ventas	+=$sub_total;
					}
				?>
                    <tr>
                      <td><?php 
					  	if($dt1['tb_ventadetalle_tipven']==1)echo 'PRODUCTO';
						if($dt1['tb_ventadetalle_tipven']==2)echo 'SERVICIO';
					  ?></td>
                      <td><?php 
					  	if($dt1['tb_ventadetalle_tipven']==1)echo $dt1['tb_producto_nom'];
						if($dt1['tb_ventadetalle_tipven']==2)echo $dt1['tb_servicio_nom'];
					  ?></td>
                      <td><?php echo $dt1['tb_categoria_nom']?></td>
                      <td><?php 
					  	if($dt1['tb_ventadetalle_tipven']==1)echo $dt1['tb_unidad_abr'];
						if($dt1['tb_ventadetalle_tipven']==2)echo 'UN';
					  ?></td>
                      <td align="right"><?php echo $dt1['can']?></td>
                      <!--<td align="right"><?php //echo $dt1['tb_venta_des']?></td>-->
                      <td align="right"><?php echo formato_money($sub_total)?></td>
                    </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
            
            <?php
			}
		    ?>
            </tbody>
                <tr class="even">
                  <td colspan="5">TOTAL</td>
                  <!--<td align="right"><strong><?php //echo formato_money($total_des)?></strong></td>-->
                  <td align="right"><strong><?php echo formato_money($total_ventas)?></strong></td>
                </tr>
                <tr class="even">
                  <td colspan="7"><?php echo ($num_rows+$num_rows2).' registros'?></td>
                </tr>
        </table>
</div>