<?php
require_once ("../../config/Cado.php");
require_once ("cFormula.php");
$oFormula = new cFormula();

if($_POST['action']=="editar"){
	$dts=$oFormula->mostrarUno($_POST['for_id']);
	$dt = mysql_fetch_array($dts);
		$ele=$dt['tb_formula_ele'];
		$ide=$dt['tb_formula_ide'];
		$dat=$dt['tb_formula_dat'];
		$des=$dt['tb_formula_des'];		
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
				url: "formula_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_for").serialize(),
				beforeSend: function(){
					$('#div_formula_form').dialog("close");
					$('#msj_formula').html("Guardando...");
					$('#msj_formula').show(100);
				},
				success: function(data){
					$('#msj_formula').html(data.for_msj);
					<?php
					if($_POST['vista']=="cmb_for_id")
					{
						echo $_POST['vista'].'(data.for_id);';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="formula_tabla")
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
			txt_for_ide: {
				required: true				
			},
			txt_for_dat: {
				required: true				
			},
			txt_for_des: {
				required: true				
			}
		},
		messages: {			
			txt_for_ele: {
				required: '*'
			},
			txt_for_ide: {
				required: '*'
			},
			txt_for_dat: {
				required: '*'
			},
			txt_for_des: {
				required: '*'				
			}
		}
	});		
});
</script>
<form id="for_for">
<input name="action_formula" id="action_formula" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_for_id" id="hdd_for_id" type="hidden" value="<?php echo $_POST['for_id']?>">
    <table>    	
    	<tr>
    	  <td align="right"><label for="txt_for_ele">Elemento:</label></td>
    	  <td><input name="txt_for_ele" id="txt_for_ele" type="text" value="<?php echo $ele?>" size="50"></td>
  	  </tr>
    	<tr>
            <td align="right"><label for="txt_for_ide">Identificador:</label></td>
            <td><input name="txt_for_ide" id="txt_for_ide" type="text" value="<?php echo $ide?>" size="50"></td>
        </tr>
        <tr>
          <td align="right" valign="top"><label for="txt_for_dat">Dato:</label></td>
          <td><input name="txt_for_dat" id="txt_for_dat" type="text" value="<?php echo $dat?>" size="15" tabindex="1">            
          </td>
      	</tr>
        <tr>
          <td align="right" valign="top"><label for="txt_for_des">Descripción:</label></td>
          <td>
          <textarea name="txt_for_des" cols="50" rows="4" id="txt_for_des" ><?php echo $des?></textarea>
          </td>
        </tr>        
    </table>
</form>