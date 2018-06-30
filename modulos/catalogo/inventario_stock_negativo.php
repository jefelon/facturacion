<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("./cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once("../producto/cStock.php");
$oStock = new cStock();

require_once ("../formatos/formato.php");
require_once ("../catalogo/cst_producto.php");


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

//fecha inventario

$fecini='01-01-2013';
$fecfin=$_POST['inv_fec'];


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


$(document).ready(function() {
	
	$('.btn_guardar').button({
		icons: {primary: "ui-icon-disk"},
		text: true
	});
	
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			//4: {sorter: 'shortDate' }
		},
		//sortForce: [[0,0]],
    });


}); 
</script>
        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $num_rows = 0;
					while($dt1 = mysql_fetch_array($dts1)){

						//almacen 1
						$rws = $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],'1');
						$num_filas1=mysql_num_rows($rws);
						mysql_free_result($rws);

						$stock=stock_kardex($dt1['tb_catalogo_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);

					?>
                        <?php if ($stock<0){
                            $num_rows+=1;
                            ?>
                        <tr>
                            <td>
                                <span style="">
                                <?php echo $dt1['tb_producto_nom'] ?>
                                </span>
                            </td>
                            <td align="right" nowrap><?php echo $stock ?></td>
                        </tr>
                        <?php }?>
                <?php
                	}
                mysql_free_result($dts1);
                ?>
                </tbody>
            <tr class="even">
                <td colspan="2"><?php echo $num_rows.' registros'?></td>
            </tr>
        </table>
