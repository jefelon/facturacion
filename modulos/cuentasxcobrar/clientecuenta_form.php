<?php
require_once ("../../config/Cado.php");
require_once ("cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../documento/cDocumento.php");
$oDocumento= new cDocumento();

require_once("../formatos/formato.php");



if($_POST['action']=="editar"){	
	$dts=$oClientecuenta->mostrarUno($_POST['clicue_id']);
	$dt = mysql_fetch_array($dts);
		$clicue_fec	=$dt['tb_clientecuenta_fec'];
		$clicue_glo	=$dt['tb_clientecuenta_glo'];
		$clicue_tip	=$dt['tb_clientecuenta_tip'];//Tipo
		$clicue_mon	=$dt['tb_clientecuenta_mon'];//Monto
		$clicue_est	=$dt['tb_clientecuenta_est'];//Estado
		$ven_id		=$dt['tb_venta_id'];
		
		$forpag_id	=$dt['tb_formapago_id'];
		$modpag_id	=$dt['tb_modopago_id'];
		$tar_id		=$dt['tb_tarjeta_id'];
		$numope		=$dt['tb_clientecuenta_numope'];
		$numdia		=$dt['clientecuenta_numdia'];
		$fecven		=$dt['tb_clientecuenta_fecven'];		
		
		$cli_id		=$dt['tb_cliente_id'];
		
		$clicue_ver	=$dt['tb_clientecuenta_ver'];
		
	mysql_free_result($dts);
}

if($_POST['action2']=="pago"){
	$dts=$oClientecuenta->mostrarUno($_POST['clicue_id']);
	$dt = mysql_fetch_array($dts);
		$clicue_fec	=$dt['tb_clientecuenta_fec'];
		$clicue_glo	=$dt['tb_clientecuenta_glo'];
		$clicue_tip	=$dt['tb_clientecuenta_tip'];//Tipo
		$clicue_mon	=$dt['tb_clientecuenta_mon'];//Monto
		$clicue_est	=$dt['tb_clientecuenta_est'];//Estado
		$ven_id		=$dt['tb_venta_id'];
		
		$forpag_id	=$dt['tb_formapago_id'];
		$modpag_id	=$dt['tb_modopago_id'];
		$tar_id		=$dt['tb_tarjeta_id'];
		$numope		=$dt['tb_clientecuenta_numope'];
		$numdia		=$dt['clientecuenta_numdia'];
		$fecven		=$dt['tb_clientecuenta_fecven'];		
		
		$cli_id		=$dt['tb_cliente_id'];
		
		$clicue_ver	=$dt['tb_clientecuenta_ver'];
		
	mysql_free_result($dts);
	
	$dts= $oVenta->mostrarUno($ven_id);
	$dt = mysql_fetch_array($dts);
		//$fec	=mostrarFecha($dt['tb_venta_fec']);
		
		$doc_id	=$dt['tb_documento_id'];
		$numdoc	=$dt['tb_venta_numdoc'];
		//$cli_id	=$dt['tb_cliente_id'];
		//$cli_nom = $dt['tb_cliente_nom'];
		//$cli_doc = $dt['tb_cliente_doc'];
		//$cli_dir = $dt['tb_cliente_dir'];
		//$subtot	=$dt['tb_venta_subtot'];
		//$igv	=$dt['tb_venta_igv'];
		//$tot	=$dt['tb_venta_tot'];
		//$est	=$dt['tb_venta_est'];
		
		//$lab1	=$dt['tb_venta_lab1'];
	mysql_free_result($dts);
	
	switch ($forpag_id) {
		case 1:
			$forma_pago='CONTADO';
			break;
		case 2:
			$forma_pago='CREDITO';
			break;
	}
	
	switch ($modpag_id) {
		case 1:
			$modo_pago='EFECTIVO';
			break;
		case 2:
			$modo_pago='DEPOSITO';
			break;
		case 3:
			$modo_pago='TARJETA';
			break;
	}
	
		$dts= $oDocumento->mostrarUno($doc_id);
		$dt = mysql_fetch_array($dts);
	$documento=$dt['tb_documento_abr'];
		mysql_free_result($dts);
				
	$clicue_glo="PAGO $forma_pago $modo_pago | $documento $numdoc";
}
?>

<script type="text/javascript">

$(function() {
	$('.moneda').autoNumeric({
		aSep: ',',
		aDec: '.',
		//aSign: 'S/. ',
		//pSign: 's',
		vMin: '0.00',
		vMax: '9999.99'
	});
	<?php 
	if($_POST['action']=="insertar")
	{
	?>
	$('#txt_clicue_glo').focus();
	<?php }?>

	$("#for_clicue").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../clientecuenta/clientecuenta_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_clicue").serialize(),
				beforeSend: function() {
					$("#div_clientecuenta_form" ).dialog( "close" );
					$('#msj_clientecuenta').html("Guardando...");
					$('#msj_clientecuenta').show(100);
				},
				success: function(data){						
					$('#msj_clientecuenta').html(data.clicue_msj);					
					seleccionar_cliente($('#hdd_fil_cli_id').val());
				},
				complete: function(){
					verificar_actualizacion_estado_entradas();
				}
			});
		},
		rules: {
			txt_clicue_glo: {
				required: true
			},
			cbo_clicue_tip: {
				required: true
			}
		},
		messages: {
			txt_clicue_glo: {
				required: '*'
			},
			cbo_clicue_tip: {
				required: '*'
			}
		}
	});
	
	$("#cbo_clicue_tip").change(function(){
		var tip = $("#cbo_clicue_tip").val();
		if(tip == 2){
			$("#cbo_clicue_est").val('4');
		}
		
		if(tip == 1){
			$("#cbo_clicue_est").val('2');
		}		
	});
});
</script>
<form id="for_clicue">
<input name="action_clientecuenta" id="action_clientecuenta" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_clicue_id" id="hdd_clicue_id" type="hidden" value="<?php echo $_POST['clicue_id']?>">
<input name="hdd_cli_id" id="hdd_cli_id" type="hidden" />
<input name="hdd_ven_id" id="hdd_ven_id" type="hidden" value="<?php echo 5?>">
    <table>
        <tr>
            <td align="right" valign="top">Glosa:</td>
            <td><textarea name="txt_clicue_glo" cols="50" rows="3" id="txt_clicue_glo"><?php echo $clicue_glo?></textarea></td>
        </tr>
        
        <tr>
            <td align="right" valign="top">Tipo:</td>
            <td>
            	<select id="cbo_clicue_tip" name="cbo_clicue_tip">
                	<option value="-1" selected="selected">-</option>
                	<option value="1" <?php if($clicue_tip==1){echo "selected";}?>>ENTRADA</option>
                    <option value="2" <?php if($clicue_tip==2){echo "selected";}?>>SALIDA</option>
                </select>
            </td>
        </tr>
        
        <tr>
            <td align="right" valign="top">Monto:</td>
            <td><input name="txt_clicue_mon" type="text" class="moneda" id="txt_clicue_mon" value="<?php echo formato_money($clicue_mon);?>" size="10" style="text-align:right" /></td>
        </tr>
        
        <tr>
            <td align="right" valign="top">Estado:</td>
            <td>
            	<select id="cbo_clicue_est" name="cbo_clicue_est">
                	<option value="-1" selected="selected">-</option>                	
	                <option value="2" <?php if($clicue_est==2){echo "selected";}?>>SIN CANCELAR</option>
                	<option value="1" <?php if($clicue_est==1){echo "selected";}?>>CANCELADA</option> 
                    <option value="4" <?php if($clicue_est==4){echo "selected";}?>>ABONADO</option>                    
                </select>
            </td>
        </tr>
    </table>
</form>