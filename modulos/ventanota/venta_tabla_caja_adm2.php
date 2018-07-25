<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVentanota.php");
$oVentanota = new cVentanota();

require_once ("../formatos/formato.php");

require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

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
<div id="tabla_resumen_venta" class="ui-widget">
<span>CONSULTA DE PAGOS EN VENTAS</span>
<table class="ui-widget ui-widget-content">
	<tr class="ui-widget-header">
    <th>DETALLE</th>
    <th>MONTO</th>
    <th>REGISTRO</th>
    </tr>
<?php
$dts1=$oVentanota->mostrar_filtro_detalle_adm(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],'',$cat_ids,$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id']);
$num_rows= mysql_num_rows($dts1);

while($dt1 = mysql_fetch_array($dts1))
{
	$sub_total=$dt1['tb_ventadetalle_valven']+$dt1['tb_ventadetalle_igv'];
					
	if($dt1['tb_venta_est']=='CANCELADA'){
		$total_valven	+=$dt1['tb_ventadetalle_valven'];
		$total_igv		+=$dt1['tb_ventadetalle_igv'];
		
		//$total_des		+=$dt1['tb_venta_des'];
		$total_ventas	+=$sub_total;
	}
	$ref_id=1;
}
mysql_free_result($dts1);

$glosa="VENTAS EFECTIVO | NOTAS DE VENTA";
?>
  <tr>
    <td align="left"><?php echo $glosa?></td>
    <td align="right"><?php echo formato_money($total_ventas)?></td>
    <td align="center">
    <?php 
	if($_POST['cmb_fil_ven_est']=='CANCELADA')
	{
	?>
    <a id="btn_agregar" title="Agregar" href="#reging" style="color:#039" onClick="ingreso_form('insertar','','caja_nv','<?php echo $glosa?>','<?php echo $total_ventas?>','<?php echo $ref_id?>','<?php echo $entfin_id?>')">Ingreso</a>
    <?php 
	}
	else
	{
		echo '<span title="Seleccione CANCELADA para registrar.">?</span>';	
	}
	?>
    </td>
  </tr>
</table>
</div>
</br>
<span style="text-align:left">REGISTRO DE INGRESOS - NOTAS DE VENTA</span>
<div id="div_ingreso_tabla" class="contenido_tabla">
</div>