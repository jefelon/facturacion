<?php
require_once ("../../config/Cado.php");
require_once ("../transporte/cTransporte.php");
$oTransporte = new cTransporte();

if($_POST['action']=="editar"){
	$dts=$oTransporte->mostrarUno($_POST['tra_id']);
	$dt = mysql_fetch_array($dts);
		//$tip=$dt['tb_transporte_tip'];
		$razsoc=$dt['tb_transporte_razsoc'];
		$ruc=$dt['tb_transporte_ruc'];
		$dir=$dt['tb_transporte_dir'];
		//$con=$dt['tb_transporte_con'];
		$tel=$dt['tb_transporte_tel'];
		$ema=$dt['tb_transporte_ema'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	
	//$( "#radio" ).buttonset();
	
	$("#for_tra").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../transporte/transporte_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_tra").serialize(),
				beforeSend: function(){
					$('#div_transporte_form').dialog("close");
					$('#msj_transporte').html("Guardando...");
					$('#msj_transporte').show(100);
				},
				success: function(data){					
					$('#msj_transporte').html(data.tra_msj);
					<?php
					if($_POST['vista']=="cmb_tra_id")
					{
						//echo $_POST['vista'].'(data.tra_id);';?>
						actualizarDatosTransporte();	<?php
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="transporte_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			txt_tra_razsoc: {
				required: true
			},
			txt_tra_ruc: {
				required: true,
				digits: true
			},
			txt_tra_ema: {
				required: true,
				email: true				
			}
		},
		messages: {
			txt_tra_razsoc: {
				required: '*'
			},
			txt_tra_ruc: {
				required: '*'
			},
			txt_tra_ema: {
				required: "*"				
			}
		}
	});		
});
</script>
<form id="for_tra">
<input name="action_transporte" id="action_transporte" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_tra_id" id="hdd_tra_id" type="hidden" value="<?php echo $_POST['tra_id']?>">
    <table>
    	<tr>
    	  <td align="right"><label for="txt_tra_razsoc">Transporte:</label></td>
    	  <td><input name="txt_tra_razsoc" id="txt_tra_razsoc" type="text" value="<?php echo $razsoc?>" size="50"></td>
  	  </tr>
    	<tr>
            <td align="right"><label for="txt_tra_ruc">RUC:</label></td>
            <td><input name="txt_tra_ruc" id="txt_tra_ruc" type="text" value="<?php echo $ruc?>" size="15" maxlength="11"></td>
        </tr>
        <tr>
          <td align="right" valign="top"><label for="txt_tra_dir">Dirección:</label></td>
          <td><textarea name="txt_tra_dir" cols="45" rows="2" id="txt_tra_dir" ><?php echo $dir?></textarea>            
          </td>
      	</tr>
        
        <tr>
          	<td align="right"><label for="txt_tra_tel">Teléfono:</label></td>
            <td><input name="txt_tra_tel" type="text" id="txt_tra_tel" value="<?php echo $tel?>" size="15" maxlength="13"></td>
        </tr>
        <tr>
          	<td align="right"><label for="txt_tra_ema">Email:</label></td>
            <td><input name="txt_tra_ema" type="text" id="txt_tra_ema" value="<?php echo $ema?>" size="45" maxlength="100"></td>
        </tr>  
    </table>
</form>