<?php
require_once ("../../config/Cado.php");
require_once ("cCompra.php");
$oCompra = new cCompra();

require_once ("../formatos/formato.php");

	$dts= $oCompra->mostrarUno($_POST['com_id']);
	$dt = mysql_fetch_array($dts);
		$fec	=mostrarFecha($dt['tb_compra_fec']);
		
		$doc_id	=$dt['tb_documento_id'];
		$numdoc	=$dt['tb_compra_numdoc'];
		
		$mon	=$dt['tb_compra_mon'];
		$tipcam	=$dt['tb_compra_tipcam'];
		$tipcam2	=$dt['tb_compra_tipcam2'];
		
		$pro_id	=$dt['tb_proveedor_id'];
		$subtot	=$dt['tb_compra_subtot'];
		$des	=$dt['tb_compra_des'];
		$descal	=$dt['tb_compra_descal'];
		$fle	=$dt['tb_compra_fle'];
		$tipfle	=$dt['tb_compra_tipfle'];
		$ajupos	=$dt['tb_compra_ajupos'];
		$ajuneg	=$dt['tb_compra_ajuneg'];
		$valven	=$dt['tb_compra_valven'];
		$igv	=$dt['tb_compra_igv'];
		$tot	=$dt['tb_compra_tot'];
		$alm_id	=$dt['tb_almacen_id'];
		$est	=$dt['tb_compra_est'];
	mysql_free_result($dts);

$dts1=$oCompra->mostrar_compra_detalle($_POST['com_id']);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">
function compra_editar()
{    
		$.ajax({
			type: "POST",
			url: "compra_editar.php",
			async:true,
			dataType: "html",
			data: ({
				action: "cambio2",
				com_id:		'<?php echo $_POST['com_id']?>',
				tipcam2:	$('#txt_com_tipcam2').val()
			}),
			beforeSend: function() {
				//$('#msj_compra').html("Cargando...");
				//$('#msj_compra').show(100);
			},
			success: function(html){
				//$('#msj_compra').html(html);
				//$('#msj_compra').show();
			},
			complete: function(){
				compra_detalle_tabla();
				gasto_tabla();
				compra_obs();
			}
		});
}
$(function() {
	
	$('#txt_com_tipcam2').change( function(){
		compra_editar();
	});
	
	$('#txt_com_des,#txt_com_descal,#txt_com_fle,#cmb_com_tipfle,#txt_com_subtot,#txt_com_ajupos,#txt_com_ajuneg,#txt_com_valven,#txt_com_igv,#txt_com_tot').attr('disabled', 'disabled');
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_compra_detalle").tablesorter({ 
		headers: {
			//4: {sorter: 'shortDate' },
			//8: { sorter: false}
			},
		//sortForce: [[0,0]],
		//sortList: [[2,0]]
    });

}); 
</script>
<div>
<fieldset><legend>Detalle</legend>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <?php /*?><td valign="top">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="80"><label for="txt_com_des">DSCTO %</label></td>
        <td><input name="txt_com_des" type="text" id="txt_com_des" style="text-align:right" value="<?php echo formato_money($des)?>" size="10" maxlength="5" class="porcentaje2"></td>
      </tr>
      <tr>
        <td><label for="txt_com_fle">FLETE S/.</label></td>
        <td nowrap="nowrap"><input name="txt_com_fle" type="text" id="txt_com_fle" style="text-align:right" value="<?php echo formato_money($fle)?>" size="10" maxlength="8" class="moneda2">
          <label for="cmb_com_tipfle"></label>
          <select name="cmb_com_tipfle" id="cmb_com_tipfle">
            <option value="1"<?php if($tipfle==1)echo 'selected'?>>Con IGV</option>
            <option value="2"<?php if($tipfle==2)echo 'selected'?>>Sin IGV</option>
            <option value="3"<?php if($tipfle==3)echo 'selected'?>>Con IGV afecta Compra</option>
            <option value="4"<?php if($tipfle==4)echo 'selected'?>>Sin IGV afecta Compra</option>
          </select>
		</td>
      </tr>
    </table>
    </td>
    <td valign="top">
    <div style="margin-left:20px; float:right">
    <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td width="110"><label for="txt_com_subtot">SUB TOTAL</label></td>
        <td width="190"><input name="txt_com_subtot" type="text" id="txt_com_subtot" value="<?php echo formato_money($subtot)?>" readonly style="text-align:right"></td>
      </tr>
      <tr>
        <td><label for="txt_com_descal">DESCUENTO</label></td>
        <td><input type="text" name="txt_com_descal" id="txt_com_descal" value="<?php echo formato_money($descal)?>" readonly style="text-align:right"></td>
      </tr>
      <tr>
        <td title="AJUSTE APLICADO AL VALOR VENTA">AJUSTE*</td>
        <td>
        <label for="txt_com_ajupos">+</label><input name="txt_com_ajupos" type="text" id="txt_com_ajupos" style="text-align:right" value="<?php echo $ajupos?>" size="6" maxlength="6" class="moneda2">
|        
<label for="txt_com_ajuneg">-</label><input name="txt_com_ajuneg" type="text" id="txt_com_ajuneg" style="text-align:right" value="<?php echo $ajuneg?>" size="6" maxlength="6" class="moneda2">
        </td>
      </tr>
    </table>
    </div>
    </td>
<?php */?>    <td valign="top">
    	<div <?php /*?>style="margin-right:50px; float:right"<?php */?>>
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="110">VALOR VENTA</td>
    <td width="140" align="right"><input type="text" name="txt_com_valven" id="txt_com_valven" value="<?php echo formato_money($valven)?>" readonly style="text-align:right"></td>
  </tr>
  <tr>
    <td><label for="txt_com_igv">IGV</label></td>
    <td align="right"><input type="text" name="txt_com_igv" id="txt_com_igv" value="<?php echo formato_money($igv)?>" readonly style="text-align:right"></td>
  </tr>
  <tr>
    <td><label for="txt_com_tot"><strong>TOTAL</strong></label></td>
    <td align="right"><input type="text" name="txt_com_tot" id="txt_com_tot" value="<?php echo formato_money($tot)?>" readonly style="text-align:right"></td>
  </tr>
</table>
</div>
    </td>
    <td valign="top">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td><label for="txt_com_tipcam2">Cambio Pago:</label></td>
        <td><input name="txt_com_tipcam2" type="text" value="<?php echo $tipcam2?>" id="txt_com_tipcam2" size="5" maxlength="5" style="text-align:right" <?php if($mon==1)echo 'readonly'?>></td>
      </tr>
      <tr>
        <td><label for="txt_com_tot_sol"><strong>TOTAL S/.</strong></label></td>
        <td><input type="text" name="txt_com_tot_sol" id="txt_com_tot_sol" value="<?php echo formato_money($tot*$tipcam2)?>" readonly style="text-align:right"></td>
      </tr>
  </table>
    </td>
  </tr>
</table>
</fieldset>
</div>