<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../ventanota/cVentanotapago.php");
$oVentanotapago = new cVentanotapago();

require_once ("../clientecuenta/cClientecuenta.php");
$oClientecuenta = new cClientecuenta();

require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

require_once ("../formatos/formato.php");


//$cue_id=22;
	
//if($_SESSION['empresa_id']==1)$subcue_id=157;
//if($_SESSION['empresa_id']==2)$subcue_id=158;
$cue_id=23;
	
if($_SESSION['empresa_id']==1)$subcue_id=159;
if($_SESSION['empresa_id']==2)$subcue_id=160;

//caja
if($_POST['cmb_fil_ven_punven']>0)
{
	$dts=$oPuntoventa->mostrarUno($_POST['cmb_fil_ven_punven']);
	$dt = mysql_fetch_array($dts);
		$caj_id		=$dt['tb_caja_id'];
	mysql_free_result($dts);
}

?>

<script type="text/javascript">
function ingreso_form(act,idf,act2,glosa,monto,ref,entfin){
	if($('#txt_fil_ven_fec1').val()==$('#txt_fil_ven_fec2').val())
	{
		if($('#cmb_fil_ven_punven').val()>0)
		{
			$.ajax({
				type: "POST",
				url: "../ingreso/ingreso_form.php",
				async:true,
				dataType: "html",                      
				data: ({
					action: act,
					action2: act2,
					ing_id:	idf,
					ven_fec1:	$('#txt_fil_ven_fec1').val(),
					punven_id:	$('#cmb_fil_ven_punven').val(),
					ing_des: glosa,
					ing_mon: monto,
					ref_id: ref,
					caj_id: '<?php echo $caj_id?>',
					entfin_id: entfin,
					vista: 'ingreso_tabla'
				}),
				beforeSend: function() {
					$('#msj_ingreso').hide();
					$('#div_ingreso_form').dialog("open");
					$('#div_ingreso_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
				},
				success: function(html){
					$('#div_ingreso_form').html(html);				
				}
			});
		}
		else
		{
			alert('Por favor seleccione un Punto de Venta.');
		}
	}
	else
	{
		if(confirm('Por favor seleccione la misma fecha. Seleccionar y cargar?')){
			$('#txt_fil_ven_fec2').val($('#txt_fil_ven_fec1').val());
			venta_tabla();	
		}
	}
}

function ingreso_tabla()
{
	if($('#txt_fil_ven_fec1').val()==$('#txt_fil_ven_fec2').val())
	{
		$.ajax({
			type: "POST",
			url: "../ingreso/ingreso_tabla_ventacaja.php",
			async:true,
			dataType: "html",                      
			data: ({
				txt_fil_ing_fec1:	$('#txt_fil_ven_fec1').val(),
				txt_fil_ing_fec2:	$('#txt_fil_ven_fec2').val(),
				cmb_fil_cue_id:		'<?php echo $cue_id?>',
				cmb_fil_subcue_id:		'<?php echo $subcue_id?>',
				cmb_fil_caj_id:	'<?php echo $caj_id?>'
			}),
			beforeSend: function() {
				$('#div_ingreso_tabla').addClass("ui-state-disabled");
			},
			success: function(html){
				$('#div_ingreso_tabla').html(html);
			},
			complete: function(){			
				$('#div_ingreso_tabla').removeClass("ui-state-disabled");
			}
		});
	}
	else
	{
		$('#div_ingreso_tabla').html('Seleccione la misma fecha para mostrar los registros de ingresos.');	
	}
}
function ingreso_eliminar(id)
{      
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "../ingreso/ingreso_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				ing_id:		id
			}),
			beforeSend: function() {
				$('#msj_ingreso').html("Cargando...");
				$('#msj_ingreso').show(100);
			},
			success: function(html){
				$('#msj_ingreso').html(html);
				$('#msj_ingreso').show();
			},
			complete: function(){
				ingreso_tabla();
			}
		});
	}
}

$(function() {	
	ingreso_tabla();
	
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
			//10: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0],[1,0]]
    });
	
	$( "#div_ingreso_form" ).dialog({
		title:'Información de Ingreso',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 800,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Guardar: function() {
				$("#for_ing").submit();
			},
			Cancelar: function() {
				$('#for_ing').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
	
}); 
</script>
<style>
	div#tabla_resumen_venta { margin: 5px 230px; }
	div#tabla_resumen_venta table { border-collapse: collapse; width: 500px;}
	div#tabla_resumen_venta table td, div#tabla_resumen_venta table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#tabla_resumen_venta table th { height:22px }
</style>
<div id="div_ingreso_form">
</div>
<div id="msj_ingreso" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
<div id="div_enlace" style="text-align:right">
<a href="../flujocaja/caja_vista.php" title="Consultar Caja" target="_blank">Consultar Caja</a>
</div>
<div id="tabla_resumen_venta" class="ui-widget">
<span>CONSULTA DE PAGOS EN VENTAS</span>
<table class="ui-widget ui-widget-content">
	<tr class="ui-widget-header">
    <th>FORMA PAGO</th>
    <th>CUENTA CTE. | TARJETA</th>
    <th>BANCO</th>
    <th>MONTO</th>
    <th>REGISTRO</th>
    </tr>
<?php
$dts1=$oVentanotapago->caja_filtro_adm(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id'],0,0,0,0);

$num_rows= mysql_num_rows($dts1);

while($dt1 = mysql_fetch_array($dts1))
{
	$total+=$dt1['total'];
	
	$glosa="NOTA VENTAS ".$dt1['tb_formapago_nom'].' '.$dt1['tb_modopago_nom'].' '.$dt1['tb_cuentacorriente_nom'].$dt1['tb_tarjeta_nom'];
	
	if($dt1['banco_cuecor_id']>0)$entfin_id=$dt1['banco_cuecor_id'];
	if($dt1['banco_tar_id']>0)$entfin_id=$dt1['banco_tar_id'];
	
	if($dt1['tb_modopago_id']==1)$ref_id=1; //caja
	if($dt1['tb_modopago_id']==2 or $dt1['tb_modopago_id']==3)$ref_id=2; // banco
?>
  <tr>
    <td align="left"><?php echo $dt1['tb_formapago_nom'].' '.$dt1['tb_modopago_nom']?></td>
    <td align="left"><?php echo $dt1['tb_cuentacorriente_nom'].$dt1['tb_tarjeta_nom']?></td>
    <td align="left"><?php echo $dt1['banco_cuecor'].$dt1['banco_tar']?></td>
    <td align="right"><?php echo formato_money($dt1['total'])?></td>
    <td align="center">
    <?php 
	if($_POST['cmb_fil_ven_est']=='CANCELADA')
	{
		if($dt1['tb_formapago_nom']!='CREDITO')
		{
	?>
    <a id="btn_agregar" title="Agregar" href="#reging" style="color:#039" onClick="ingreso_form('insertar','','caja_nv','<?php echo $glosa?>','<?php echo $dt1['total']?>','<?php echo $ref_id?>','<?php echo $entfin_id?>')">Ingreso</a>
    <?php 
		}
	}
	else
	{
		echo '<span title="Seleccione CANCELADA para registrar.">?</span>';	
	}
	?>
    </td>
  </tr>
 <?php
}
mysql_free_result($dts1);
?>
  <tr style="font-weight:bold; height:25px">
    <td colspan="3" align="left">TOTAL</td>
    <td align="right"><?php echo formato_money($total)?></td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
</div>
</br>
<div id="tabla_resumen_venta" class="ui-widget">
<span>CONSULTA DE PAGOS EN CUENTAS CLIENTES</span>
<table class="ui-widget ui-widget-content">
	<tr class="ui-widget-header">
    <th>FORMA PAGO</th>
    <th>CUENTA CTE. | TARJETA</th>
    <th>BANCO</th>
    <th>MONTO</th>
    <th>REGISTRO</th>
    </tr>
<?php
$dts1=$oClientecuenta->caja_ventanota_filtro_adm(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id'],0,0,0,0,2,2);

$num_rows= mysql_num_rows($dts1);
;
while($dt1 = mysql_fetch_array($dts1))
{
	$total2+=$dt1['total'];
	
	$glosa="NOTA VENTAS CREDITO | PAGO: ".$dt1['tb_formapago_nom'].' '.$dt1['tb_modopago_nom'].' '.$dt1['tb_cuentacorriente_nom'].$dt1['tb_tarjeta_nom'];
	
	$entfin_id=0;
	if($dt1['banco_cuecor_id']>0)$entfin_id=$dt1['banco_cuecor_id'];
	if($dt1['banco_tar_id']>0)$entfin_id=$dt1['banco_tar_id'];
	
	$ref_id=0;
	if($dt1['tb_modopago_id']==1)$ref_id=1; //caja
	if($dt1['tb_modopago_id']==2 or $dt1['tb_modopago_id']==3)$ref_id=2; // banco
?>
  <tr>
    <td align="left"><?php echo $dt1['tb_formapago_nom'].' '.$dt1['tb_modopago_nom']?></td>
    <td align="left"><?php echo $dt1['tb_cuentacorriente_nom'].$dt1['tb_tarjeta_nom']?></td>
    <td align="left"><?php echo $dt1['banco_cuecor'].$dt1['banco_tar']?></td>
    <td align="right"><?php echo formato_money($dt1['total'])?></td>
    <td align="center">
    <?php 
	if($_POST['cmb_fil_ven_est']=='CANCELADA')
	{
		if($dt1['tb_formapago_nom']=='CONTADO')
		{
	?>
    <a id="btn_agregar" title="Agregar" href="#reging" style="color:#039" onClick="ingreso_form('insertar','','caja_nv','<?php echo $glosa?>','<?php echo $dt1['total']?>','<?php echo $ref_id?>','<?php echo $entfin_id?>')">Ingreso</a>
    <?php 
		}
	}
	else
	{
		echo '<span title="Seleccione CANCELADA para registrar.">?</span>';	
	}
	?>
    </td>
  </tr>
 <?php
}
mysql_free_result($dts1);
?>
  <tr style="font-weight:bold; height:25px">
    <td colspan="3" align="left">TOTAL</td>
    <td align="right"><?php echo formato_money($total2)?></td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
</div>
</br>
<span style="text-align:left">REGISTRO DE INGRESOS - VENTAS</span>
<div id="div_ingreso_tabla" class="contenido_tabla">
</div>