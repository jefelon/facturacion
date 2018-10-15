<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cClientecuenta.php");
$oClientecuenta = new cClientecuenta();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../ventanota/cVentanota.php");
$oVentanota = new cVentanota();
require_once ("../documento/cDocumento.php");
$oDocumento= new cDocumento();

require_once("../formatos/formato.php");


/*if($_POST['action']=="editar"){	
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
		$cli_nom		=$dt['tb_cliente_nom'];
		$cli_doc		=$dt['tb_cliente_doc'];
		
		$clicue_ver	=$dt['tb_clientecuenta_ver'];
		
	mysql_free_result($dts);
}*/

if($_POST['action']=="insertar_pago"){
	//datos de cuenta
    $cli_id = $_POST['cli_id'];
    $emp_id=$_SESSION['empresa_id'];

    $clicus = $oClientecuenta->mostrar_cuenta_por_cliente($cli_id, $emp_id, 3);
    $sum_ven_tot = 0;
    $doc_abr_ven_numdoc='';
    $sum_total_pagado = 0;
    $sum_cuenta_clicue_mon = 0;
    $sum_saldo_pagar = 0;
    while ($cliclu = mysql_fetch_array($clicus)) {
        if ($cliclu['tb_clientecuenta_est']==2 or $cliclu['tb_clientecuenta_est']==3){
            $total_pagado=0;
        $dts = $oClientecuenta->mostrarUno($cliclu['tb_clientecuenta_id']);
        $dt = mysql_fetch_array($dts);
        $clicue_fec = $dt['tb_clientecuenta_fec'];
        $cuenta_clicue_glo = $dt['tb_clientecuenta_glo'];
        $clicue_tip = $dt['tb_clientecuenta_tip'];//Tipo
        $cuenta_clicue_mon = $dt['tb_clientecuenta_mon'];//Monto
        $clicue_est = $dt['tb_clientecuenta_est'];//Estado

        $ventip = $dt['tb_clientecuenta_ventip'];
        $ven_id = $dt['tb_clientecuenta_ven_id'];

        $forpag_id = $dt['tb_formapago_id'];
        $modpag_id = $dt['tb_modopago_id'];

        $cuecor_id = $dt['tb_cuentacorriente_id'];
        $tar_id = $dt['tb_tarjeta_id'];

        $numope = $dt['tb_clientecuenta_numope'];
        $numdia = $dt['clientecuenta_numdia'];
        $fecven = mostrarFecha($dt['tb_clientecuenta_fecven']);

        $cli_id = $dt['tb_cliente_id'];
        $cli_nom = $dt['tb_cliente_nom'];
        $cli_doc = $dt['tb_cliente_doc'];

        $clicue_ver = $dt['tb_clientecuenta_ver'];

        mysql_free_result($dts);

        //id padre
        $clicue_idp = $cliclu['tb_clientecuenta_id'];

        //TIPO DE VENTA
        if ($ventip == 1)//venta
        {
            //datos de venta
            $dts = $oVenta->mostrarUno($ven_id);
            $dt = mysql_fetch_array($dts);
            $ven_fec = mostrarFecha($dt['tb_venta_fec']);

            $doc_id = $dt['tb_documento_id'];
            $ven_numdoc = $dt['tb_venta_numdoc'];
            //$cli_id	=$dt['tb_cliente_id'];
            //$cli_nom = $dt['tb_cliente_nom'];
            //$cli_doc = $dt['tb_cliente_doc'];
            //$cli_dir = $dt['tb_cliente_dir'];
            //$subtot	=$dt['tb_venta_subtot'];
            //$igv	=$dt['tb_venta_igv'];
            $ven_tot = $dt['tb_venta_tot'];
            //$est	=$dt['tb_venta_est'];

            //$lab1	=$dt['tb_venta_lab1'];
            mysql_free_result($dts);

            $texto_titulo = 'VENTA';
        }

        if ($ventip == 2)//nota venta
        {
            //datos de nota venta
            $dts = $oVentanota->mostrarUno($ven_id);
            $dt = mysql_fetch_array($dts);
            $ven_fec = mostrarFecha($dt['tb_venta_fec']);

            $doc_id = $dt['tb_documento_id'];
            $ven_numdoc = $dt['tb_venta_numdoc'];
            //$cli_id	=$dt['tb_cliente_id'];
            //$cli_nom = $dt['tb_cliente_nom'];
            //$cli_doc = $dt['tb_cliente_doc'];
            //$cli_dir = $dt['tb_cliente_dir'];
            //$subtot	=$dt['tb_venta_subtot'];
            //$igv	=$dt['tb_venta_igv'];
            $ven_tot = $dt['tb_venta_tot'];
            //$est	=$dt['tb_venta_est'];

            //$lab1	=$dt['tb_venta_lab1'];
            mysql_free_result($dts);

            $texto_titulo = 'NOTA VENTA';

        }

        switch ($forpag_id) {
            case 1:
                $forma_pago = 'CONTADO';
                break;
            case 2:
                $forma_pago = 'CREDITO';
                break;
        }

        switch ($modpag_id) {
            case 1:
                $modo_pago = 'EFECTIVO';
                break;
            case 2:
                $modo_pago = 'DEPOSITO';
                break;
            case 3:
                $modo_pago = 'TARJETA';
                break;
        }

        $dts = $oDocumento->mostrarUno($doc_id);
        $dt = mysql_fetch_array($dts);
        $doc_abr = $dt['tb_documento_abr'];
        mysql_free_result($dts);

        //pagos realizados
            $tipo = 2;
            $tipo_registro = 2;
            $dts = $oClientecuenta->mostrar_por_cuenta($clicue_idp, $tipo, $tipo_registro);
            while ($dt = mysql_fetch_array($dts)) {
                $total_pagado += $dt['tb_clientecuenta_mon'];
            }
            mysql_free_result($dts);


        //saldo a pagar
        $saldo_pagar = $cuenta_clicue_mon - $total_pagado;


        //datos para registro de pago
        $r_clicue_fec = date('d-m-Y');
        $r_forpag_id = 1;
        $r_modpag_id = 1;
        $r_fecven = '00-00-0000';
        $r_tar_id = 0;
        $r_numdia = 0;
        $r_numope = "";
        $r_clicue_tip = 2;//salida
        $r_clicue_glo = "PAGO $texto_titulo $doc_abr $ven_numdoc | $forma_pago $modo_pago.";
        $r_clicue_est = 0;
        $r_ver = 1;
        $r_clicue_idp = $clicue_idp;

        $doc_abr_ven_numdoc .= $doc_abr.' '.$ven_numdoc.',';
        $todo_cuenta_clicue_glo.= $cuenta_clicue_glo.', ';
        $sum_ven_tot+=$ven_tot;
        $sum_total_pagado+=$total_pagado;
        $sum_cuenta_clicue_mon+=$cuenta_clicue_mon;
        $sum_saldo_pagar+=$saldo_pagar;
        $r_monto = $sum_saldo_pagar;
        }
    }
}


?>

<script type="text/javascript">
$('.btn_imp').button({
	icons: {primary: "ui-icon-print"},
	text: false
});
$( "#txt_clicue_fec" ).datepicker({
	//minDate: "-1M", 
	maxDate:"+0D",
	yearRange: 'c-0:c+0',
	changeMonth: true,
	changeYear: false,
	dateFormat: 'dd-mm-yy',
	//altField: fecha,
	//altFormat: 'yy-mm-dd',
	showOn: "button",
	buttonImage: "../../images/calendar.gif",
	buttonImageOnly: true
});
function cmb_cuecor_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../cuentacorriente/cmb_cuecor_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			cuecor_id: ids
		}),
		beforeSend: function() {
			$('#cmb_cuecor_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_cuecor_id').html(html);
		}
	});
}
function cmb_tar_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../tarjeta/cmb_tar_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			tar_id: ids
		}),
		beforeSend: function() {
			$('#cmb_tar_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_tar_id').html(html);
		}
	});
}
	$('.moneda_monto').autoNumeric({
		aSep: ',',
		aDec: '.',
		//aSign: 'S/. ',
		//pSign: 's',
		vMin: '0.00',
		vMax: '9999.99'
		//vMax: '<?php //echo $saldo_pagar?>'
	});
	
function validar_monto()
{	
	$.ajax({
		type: "POST",
		url: "../cuentacorriente/cmb_cuecor_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			cuecor_id: ids
		}),
		beforeSend: function() {
			$('#cmb_cuecor_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_cuecor_id').html(html);
		}
	});
}
	
$(function() {
	
	cmb_cuecor_id('<?php echo $cuecor_id?>');
	cmb_tar_id('<?php echo $tar_id?>');
	<?php 
	if($_POST['action']=="insertar"){?>
	$('#txt_clicue_glo').focus();
	<?php }?>
	
	$("#cmb_forpag_id").change(function(){		
		var tipo = $("#cmb_forpag_id").val();
		
		//$('#cmb_forpag_id').val();
		
		//$('#txt_venpag_mon').val('');
		//$('#cmb_modpag_id').val('');
		$('#cmb_cuecor_id').val('');
		$('#cmb_tar_id').val('');
		$('#txt_venpag_numope').val('');

	});
	
	$("#cmb_modpag_id").change(function(){		
		var tipo = $("#cmb_modpag_id").val();
		
		$('#cmb_tar_id').val('');
		$('#cmb_cuecor_id').val('');
		$('#txt_venpag_numope').val('');
		
		//efectivo
		if(tipo == 1){
			$("#div_cuentacorriente").hide(100);			
			$("#div_tarjeta").hide(100);
			$("#div_operacion").hide(100);
		}
		//deposito
		if(tipo == 2){
			$("#div_cuentacorriente").show(100);
			$("#div_tarjeta").hide(100);
			$("#div_operacion").show(100);
		}
		//tarjeta
		if(tipo == 3){
			$("#div_cuentacorriente").hide(100);		
			$("#div_tarjeta").show(100);
			$("#div_operacion").show(100);
		}
	});

	<?php if($_POST['action']=="editar_pago"){?>
	$('#txt_clicue_fec').attr('disabled',true);
	<?php }?>

	$("#for_clicue").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../clientecuenta/clientecuenta_reg_todos.php",
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
					//verificar_actualizacion_estado_entradas();
					actualizar_estado_clientecuenta('<?php echo $_POST['clicue_id']?>','<?php echo $_POST['action']?>');
				}
			});
		},
		rules: {
			txt_clicue_glo: {
				required: true
			},
			txt_clicue_mon: {
				required: true,
				max: '<?php echo $saldo_pagar?>'
			}
		},
		messages: {
			txt_clicue_glo: {
				required: '*'
			},
			txt_clicue_mon: {
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

<input name="hdd_cli_id" id="hdd_cli_id" type="hidden" value="<?php echo $_POST['cli_id']?>">
<input name="hdd_clicue_ventip" id="hdd_clicue_ventip" type="hidden" value="<?php echo $ventip?>">
<input name="hdd_clicue_ven_id" id="hdd_clicue_ven_id" type="hidden" value="<?php echo $ven_id?>">

<input name="hdd_clicue_tip" id="hdd_clicue_tip" type="hidden" value="<?php echo $r_clicue_tip?>">
<input name="hdd_clicue_est" id="hdd_clicue_est" type="hidden" value="<?php echo $r_clicue_est?>">

<input name="hdd_clicue_numdia" id="hdd_clicue_numdia" type="hidden" value="<?php echo $r_numdia?>">
<input name="hdd_clicue_fecven" id="hdd_clicue_fecven" type="hidden" value="<?php echo $r_fecven?>">

<input name="hdd_clicue_ver" id="hdd_clicue_ver" type="hidden" value="<?php echo $r_ver?>">
<input name="hdd_clicue_idp" id="hdd_clicue_idp" type="hidden" value="<?php echo $r_clicue_idp?>">
<fieldset><legend><?php echo $texto_titulo?></legend>
    <table width="100%">
        <tr>
          <td align="right" valign="top" width="70">Cliente:</td>
          <td colspan="3"><?php echo $cli_nom?></td>
        </tr>
        <tr>
          <td align="right" valign="top">Documento:</td>
          <td colspan="3"><?php echo $cli_doc?></td>
        </tr>
       <?php //if($_POST['action2']=='pago'){?>
        <tr>
          <td align="right" valign="top">Venta Doc:</td>
          <td><?php echo $doc_abr_ven_numdoc?></td>
        </tr>
        <tr>
          <td align="right" valign="top">Total Venta:</td>
          <td colspan="3"><?php echo formato_money($sum_ven_tot)?></td>
        </tr>
      </table>
</fieldset>
<fieldset><legend>Cuenta</legend>
      <?php echo $todo_cuenta_clicue_glo?>
      <table>
        <tr>
          <td align="right" valign="top">Monto a Pagar:</td>
          <td colspan="3" align="right"><?php echo formato_money($sum_cuenta_clicue_mon)?></td>
        </tr>
        <tr>
          <td align="right" valign="top" title="<?php if($_POST['action']=="editar_pago")echo 'No incluye el monto registrado como pago en éste registro, ('.formato_money($clicue_mon).')'?>">Monto Pagado<?php if($_POST['action']=="editar_pago")echo '*'?>:</td>
          <td colspan="3" align="right"><?php echo formato_money($sum_total_pagado)?></td>
        </tr>
        <tr>
          <td align="right" valign="top">Saldo:</td>
          <td colspan="3" align="right"><?php echo formato_money($sum_saldo_pagar)?></td>
        </tr>
      </table>
        <?php //}?>
</fieldset>
<fieldset><legend>Pago</legend>
 			<table>
        <tr>
          <td align="right" valign="top"><label for="txt_clicue_fec">Fecha:</label></td>
          <td colspan="3"><input name="txt_clicue_fec" type="text" class="fecha" id="txt_clicue_fec" value="<?php echo $r_clicue_fec?>" size="10" maxlength="10" readonly></td>
        </tr>
<!--        <tr>-->
<!--            <td align="right" valign="top">Glosa:</td>-->
<!--            <td colspan="3"><textarea name="txt_clicue_glo" cols="50" rows="3" id="txt_clicue_glo">--><?php //echo $r_clicue_glo?><!--</textarea></td>-->
<!--        </tr>-->
        
        <tr>
            <td align="right" valign="top">Monto:</td>
            <td colspan="3"><input name="txt_clicue_mon" type="text" class="moneda_monto_" id="txt_clicue_mon" style="text-align:right" value="<?php echo $r_monto?>" disabled size="10" <?php //if($_POST['action']=="editar_pago")echo 'readonly'?>/></td>
        </tr>
        <?php if($_POST['action']=='insertar_pago'){?>
        <tr>
          <td colspan="4" valign="top"><table border="0" cellspacing="2" cellpadding="0">
            <tr>
              <?php /*?><td>
    <label for="txt_venpag_fec">Fecha:</label>
      <input type="text" name="txt_venpag_fec" id="txt_venpag_fec" size="10" maxlength="10" value="<?php echo $venpag_fec?>" readonly>
    </td><?php */?>
              <td valign="top">
                <label for="cmb_forpaf_id">Forma<!-- Pago-->:</label></br>
                <select name="cmb_forpag_id" id="cmb_forpag_id">
                  <option value="1" selected="selected">CONTADO</option>
                </select>
              </td>
              <td valign="top"><!--<label for="cmb_modpaf_id">Modo Pago:</label>--></br>
                <select name="cmb_modpag_id" id="cmb_modpag_id">
                  <option value="1" selected="selected">EFECTIVO</option>
                  <option value="2">DEPOSITO</option>
                  <option value="3">TARJETA</option>
              </select></td>
              <td valign="top">
                <div id="div_tarjeta" style="display:none">
                  <label for="cmb_tar_id">Tarjeta:</label></br>
                  <select name="cmb_tar_id" id="cmb_tar_id">
                  </select>
                </div>
                <div id="div_cuentacorriente" style="display:none">
                  <label for="cmb_cuecor_id">Cuenta Corriente:</label></br>
                  <select name="cmb_cuecor_id" id="cmb_cuecor_id">
                  </select>
                </div>
              </td>
              <td valign="top">
                <div id="div_operacion" style="display:none">
                  <label for="txt_venpag_numope">N° Operación:</label></br>
                  <input type="text" name="txt_venpag_numope" id="txt_venpag_numope" size="15">
                </div>
              </td>
            </tr>
</table></td>
        </tr>
        <?php }?>
        <?php if($_POST['action']=='editar_pago'){?>
        <tr>
          <td align="right" valign="top">Forma:</td>
          <td colspan="3"><?php echo $texto_pago?></td>
        </tr>
        <?php }?>
        <tr>
          <td align="right" valign="top">&nbsp;</td>
          <td colspan="3"><?php if($_POST['action']=="insertar_pago"){?>
        <?php }?>
        <?php
      if($_POST['action']=="editar_pago"){
	  ?>
      <a class="btn_imp" title="Imprimir" href="#imprimir" onClick="recibo_impresion('<?php echo $_POST['clicue_id']?>')">Imprimir</a>
      <?php }?>
        </td>
        </tr>
       
        <?php /*?><tr>
            <td align="right" valign="top">Estado:</td>
            <td>
            	<select id="cbo_clicue_est" name="cbo_clicue_est">
                	<option value="-1" selected="selected">-</option>                	
	                <option value="2" <?php if($clicue_est==2){echo "selected";}?>>SIN CANCELAR</option>
                	<option value="1" <?php if($clicue_est==1){echo "selected";}?>>CANCELADA</option> 
                    <option value="4" <?php if($clicue_est==4){echo "selected";}?>>ABONADO</option>                    
                </select>
            </td>
        </tr><?php */?>
    </table>
</fieldset>
</form>