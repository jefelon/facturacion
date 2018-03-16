<?php
require_once ("../../config/Cado.php");
require_once ("../conductor/cConductor.php");
$oConductor = new cConductor();

if($_POST['action']=="editar"){
	$dts=$oConductor->mostrarUno($_POST['con_id']);
	$dt = mysql_fetch_array($dts);
		$tip=$dt['tb_conductor_tip'];
		$nom=$dt['tb_conductor_nom'];
		$doc=$dt['tb_conductor_doc'];
		$dir=$dt['tb_conductor_dir'];		
		$tel=$dt['tb_conductor_tel'];
		$ema=$dt['tb_conductor_ema'];
		$lic=$dt['tb_conductor_lic'];
		$cat=$dt['tb_conductor_cat'];
		$tra_id=$dt['tb_transporte_id'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">
function cmb_tra_id(idt){	
	$.ajax({
		type: "POST",
		url: "../transporte/cmb_tra_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			tra_id: idt
		}),
		beforeSend: function() {
			$('#cmb_con_tra').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_con_tra').html(html);
		}
	});
}

$(function() {
	
	cmb_tra_id('<?php echo $tra_id?>');
	
	$( "#radio" ).buttonset();
	
	$("#for_con").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../conductor/conductor_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_con").serialize(),
				beforeSend: function(){
					$('#div_conductor_form').dialog("close");
					$('#msj_conductor').html("Guardando...");
					$('#msj_conductor').show(100);
				},
				success: function(data){								
					$('#msj_conductor').html(data.con_msj);					
					<?php
					if($_POST['vista']=="cmb_con_id")
					{
						//echo $_POST['vista'].'(data.con_id);';?>
						actualizarDatosConductor();	<?php
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="conductor_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			rad_con_tip: {
				required: true
			},
			txt_con_nom: {
				required: true
			},
			txt_con_doc: {
				required: true,
				digits: true
			},
			txt_con_ema: {
				required: true,
				email: true				
			}
		},
		messages: {
			rad_con_tip: {
				required: '*'
			},
			txt_con_nom: {
				required: '*'
			},
			txt_con_doc: {
				required: '*'
			},			
			txt_con_ema: {
				required: '*'			
			}
		}
	});		
});
</script>
<form id="for_con">
<input name="action_conductor" id="action_conductor" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_con_id" id="hdd_con_id" type="hidden" value="<?php echo $_POST['con_id']?>">
    <table>
    	<tr>
            <td align="right">Empresa Transporte:</td>
            <td><select id="cmb_con_tra" name="cmb_con_tra">
            	
            </select></td>
        </tr>
    	<tr>
    	  <td align="right">Persona:</td>
    	  <td>
          	<div id="radio">
              <input name="rad_con_tip" type="radio" id="radio1" value="1" <?php if($tip==1)echo 'checked="checked"'?>/><label for="radio1">Natural</label>
              <input name="rad_con_tip" type="radio" id="radio2" value="2" <?php if($tip==2)echo 'checked="checked"'?>/><label for="radio2">Jurídica</label>
            </div>
    	  </td>
  	  </tr>
    	<tr>
    	  <td align="right"><label for="txt_con_nom">Conductor:</label></td>
    	  <td><input name="txt_con_nom" id="txt_con_nom" type="text" value="<?php echo $nom?>" size="50"></td>
  	  </tr>
    	<tr>
            <td align="right"><label for="txt_con_doc">RUC/DNI:</label></td>
            <td><input name="txt_con_doc" id="txt_con_doc" type="text" value="<?php echo $doc?>" size="15" maxlength="11"></td>
        </tr>
        <tr>
          <td align="right" valign="top"><label for="txt_con_dir">Dirección:</label></td>
          <td><textarea name="txt_con_dir" cols="45" rows="2" id="txt_con_dir" ><?php echo $dir?></textarea>            
          </td>
      	</tr>        
        <tr>
          	<td align="right"><label for="txt_con_tel">Teléfono:</label></td>
            <td><input name="txt_con_tel" type="text" id="txt_con_tel" value="<?php echo $tel?>" size="15" maxlength="13"></td>
        </tr>
        <tr>
          	<td align="right"><label for="txt_con_ema">Email:</label></td>
            <td><input name="txt_con_ema" type="text" id="txt_con_ema" value="<?php echo $ema?>" size="45" maxlength="100"></td>
        </tr>  
        
        <tr>
          <td align="right"><label for="txt_con_lic">N° de Licencia de Conducir:</label></td>
          <td><input name="txt_con_lic" id="txt_con_lic" type="text" value="<?php echo $lic?>" size="50" tabindex="1"></td>
        </tr>
        
        <tr>
          <td align="right"><label for="txt_con_cat">Categoría:</label></td>
          <td><input name="txt_con_cat" id="txt_con_cat" type="text" value="<?php echo $cat?>" size="50" tabindex="1"></td>
        </tr>
    </table>
</form>