<?php
require_once ("../../config/Cado.php");
require_once ("cForm.php");
$oForm = new cForm();

if($_POST['action']=="editar"){
	$dts=$oForm->mostrarUno($_POST['for_id']);
	$dt = mysql_fetch_array($dts);
		$ele=$dt['tb_form_ele'];
		$cat=$dt['tb_form_cat'];
		$des=$dt['tb_form_des'];
		$ord=$dt['tb_form_ord'];		
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

$(function() {
	
	$( "#radio" ).buttonset();
	
	$("#for_for").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "form_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_for").serialize(),
				beforeSend: function(){
					$('#div_form_form').dialog("close");
					$('#msj_form').html("Guardando...");
					$('#msj_form').show(100);
				},
				success: function(data){					
					$('#msj_form').html(data.for_msj);
					<?php
					if($_POST['vista']=="cmb_for_id")
					{
						echo $_POST['vista'].'(data.for_id);';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="form_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {			
			txt_for_ele: {
				required: true
			},
			txt_for_cat: {
				required: true				
			},
			txt_for_des: {
				required: true				
			},
			txt_for_ord: {
				required: true				
			}
		},
		messages: {			
			txt_for_ele: {
				required: '*'
			},
			txt_for_cat: {
				required: '*'
			},
			txt_for_des: {
				required: '*'
			},
			txt_for_ord: {
				required: '*'				
			}
		}
	});		
});
</script>
<form id="for_for">
<input name="action_form" id="action_form" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_for_id" id="hdd_for_id" type="hidden" value="<?php echo $_POST['for_id']?>">
    <table>    	
    	<tr>
    	  <td align="right"><label for="txt_for_ele">Elemento:</label></td>
    	  <td><input name="txt_for_ele" id="txt_for_ele" type="text" value="<?php echo $ele?>" size="50"></td>
  	  </tr>
    	<tr>
            <td align="right"><label for="txt_for_cat">Categoría:</label></td>
            <td><input name="txt_for_cat" id="txt_for_cat" type="text" value="<?php echo $cat?>" size="50"></td>
        </tr>
        <tr>
          <td align="right"><label for="txt_for_des">Descripción:</label></td>
          <td>
          <textarea name="txt_for_des" cols="50" rows="2" id="txt_for_des" ><?php echo $des?></textarea>
          </td>
        </tr>
        <tr>
          <td align="right" valign="top"><label for="txt_for_ord">Orden:</label></td>
          <td><input name="txt_for_ord" id="txt_for_ord" type="text" value="<?php echo $ord?>" size="15" tabindex="1">            
          </td>
      	</tr>
                
    </table>
</form>