<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
require_once ("../formatos/formato.php");

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
	
}); 
</script>
<style>
	div#tabla_resumen_venta { margin: 5px 230px; }
	div#tabla_resumen_venta table { border-collapse: collapse; width: 500px;}
	div#tabla_resumen_venta table td, div#tabla_resumen_venta table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#tabla_resumen_venta table th { height:19px }
</style>
<div id="tabla_resumen_venta" class="ui-widget">
<span>RESUMEN DE VENTAS</span>
<table class="ui-widget ui-widget-content">
	<tr class="ui-widget-header">
    <td>CATEGORIA</td>
    <td>CANTIDAD</td>
    <td>MONTO</td>
  </tr>
<?php 
$categoria[]=1;
$tipo[]='p';
$categoria[]=40;
$tipo[]='p';
$categoria[]=12;
$tipo[]='p';

$categoria[]=20;
$tipo[]='s';
$categoria[]=57;
$tipo[]='s';
$categoria[]=75;
$tipo[]='s';
$categoria[]=74;
$tipo[]='s';

foreach($categoria as $indice=>$cat_id){
//prepara consulta categoria

//$cat_id=40;

	if($cat_id>0)
	{
		$rws=$oCategoria->mostrarUno($cat_id);
		$rw = mysql_fetch_array($rws);
			$cat_nom=$rw['tb_categoria_nom'];
		mysql_free_result($rws);
		
		$cat_ids=$cat_id.'';
		
		$dts2=$oCategoria->mostrar_por_idp($cat_id);
		$num_rows2= mysql_num_rows($dts2);
		if($num_rows2>0){
			while($dt2 = mysql_fetch_array($dts2)){
				
				$cat_ids.=', '.$dt2['tb_categoria_id'];
				
				$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
				$num_rows3= mysql_num_rows($dts3);
				if($num_rows3>0){
					while($dt3 = mysql_fetch_array($dts3)){
						$cat_ids.=', '.$dt3['tb_categoria_id'];			
					}
				mysql_free_result($dts3);
				}//fin nivel 3
						
			}
		mysql_free_result($dts2);
		}//fin nivel 2
	
	//echo $cat_ids;			
	}
	$dts1=$oVenta->mostrar_filtro_detalle(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$tipo[$indice],$cat_ids,$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_SESSION['usuario_id'],$_SESSION['puntoventa_id']);
$num_rows= mysql_num_rows($dts1);

$res_can=0;
$res_sub_total=0;
$res_total_ventas=0;

if($num_rows>0){
	while($dt1 = mysql_fetch_array($dts1)){

		if($dt1['tb_venta_est']=='CANCELADA'){
			$res_can+=$dt1['tb_ventadetalle_can'];
			$res_sub_total=$dt1['tb_ventadetalle_valven']+$dt1['tb_ventadetalle_igv'];
			$res_total_ventas	+=$res_sub_total;
		}
	
	}
	mysql_free_result($dts1);
?>
  <tr>
    <td align="left"><?php echo $cat_nom;?></td>
    <td align="right"><?php if($tipo[$indice]!='s')echo $res_can?></td>
    <td align="right"><?php echo formato_money($res_total_ventas)?></td>
  </tr>
  <?php
	
}

}//fin foreach
?>
</table>
