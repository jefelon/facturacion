<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("./cCatalogo.php");
$oCatalogo = new cCatalogo();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once("../producto/cPrecio.php");
$oPrecio = new cPrecio();

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

//seleccion de los atributos
$atr_array=$_POST['atr_ids'];
if(is_array($atr_array)){
	$cadena_atr = implode(',',$atr_array);
}

if($_POST['alm_id']>0)
{
	$dts1=$oCatalogo->catalogo_filtro_stock($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$cadena_atr,$_POST['verven'],$_POST['vercom'],$_POST['unibas']);
$num_rows= mysql_num_rows($dts1);
}
else
{
	$num_rows=0;
}
?>
<script type="text/javascript">

$('.cantidad').autoNumeric({
	aSep: '',
	aDec: '.',
	vMin: '0',
	vMax: '99999'
});

$('.moneda_cp').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.9999'
});
$('.porcentaje').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99.99'
});

$(document).ready(function() {
	
	$('.btn_guardar').button({
		icons: {primary: "ui-icon-disk"},
		text: false
	});
	
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			//4: {sorter: 'shortDate' }
		},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[2,0],[1,0],[0,0]]
		<?php }?>
    });


}); 
</script>
        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <th>NOMBRE</th>
                    <th>MARCA</th>
                    <th>CATEGORIA</th>
                    <th title="UNIDAD">UN</th>
                    <th align="right" nowrap title="PRECIO DE VENTA">P.  VENTA S/.</th>
                    <th align="right" nowrap title="PRECIO MINIMO"> P.  MIN. S/.</th>
                    <th align="right" nowrap title="PRECIO MAYORISTA">P. MAY. S/.</th>
                    <th align="right">&nbsp;</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
					
					//PRECIOS
					$precio=1;
							$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt1['tb_catalogo_id']);
							$rw = mysql_fetch_array($rws);
							$predet_id1=$rw['tb_preciodetalle_id'];
							$predet_val1=$rw['tb_preciodetalle_val'];
							mysql_free_result($rws);
							
					$precio=2;
							$rws = $oPrecio->consultar_precio_por_catalogo($precio,$dt1['tb_catalogo_id']);
							$rw = mysql_fetch_array($rws);
							$predet_id2=$rw['tb_preciodetalle_id'];
							$predet_val2=$rw['tb_preciodetalle_val'];
							mysql_free_result($rws);
					?>
                        <tr>
                          <td>
                            <span style="">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                            </td>
                            <td><?php echo $dt1['tb_marca_nom']?></td>
                            <td><?php echo $dt1['tb_categoria_nom']?></td>
                            <td title="<?php echo $dt1['tb_unidad_nom']?>">
							<span style="">
							<?php echo $dt1['tb_unidad_abr']?>
                            </span>
                            </td>
                            <td align="right" nowrap="nowrap"><?php if($dt1['tb_catalogo_preven']!=0)echo formato_money($dt1['tb_catalogo_preven'])?></td>
                            <td align="right" nowrap><?php if($predet_val1!=0)echo formato_money($predet_val1)?></td>
                            <td align="right" nowrap><?php if($predet_val2!=0)echo formato_money($predet_val2)?></td>
                            <td align="right" nowrap>
                            <label id="lbl_sto_<?php echo $dt1['tb_catalogo_id']?>" style="display:none"></label>
                            <?php //if($dt1['tb_catalogo_unibas']==1 and $action_stock=='insertar')
							//{
							?>
                            <!--<a class="btn_guardar" href="#editar" onClick="actualizar_precio('<?php //echo $dt1['tb_catalogo_id']?>')">Guardar</a>-->
                            <?php //}?>
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
                  <td colspan="8"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
