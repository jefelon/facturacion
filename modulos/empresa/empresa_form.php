<?php
require_once ("../../config/Cado.php");
require_once ("cEmpresa.php");
$oEmpresa = new cEmpresa();

if($_POST['action']=="editar"){
	$dts=$oEmpresa->mostrarUno($_POST['emp_id']);
	$dt = mysql_fetch_array($dts);
		$ruc=$dt['tb_empresa_ruc'];
		$nomcom=$dt['tb_empresa_nomcom'];
		$razsoc=$dt['tb_empresa_razsoc'];
		$dir=$dt['tb_empresa_dir'];
		$dir2=$dt['tb_empresa_dir2'];
		$tel=$dt['tb_empresa_tel'];
		$ema=$dt['tb_empresa_ema'];
		$fir=$dt['tb_empresa_fir'];
		$rep=$dt['tb_empresa_rep'];	
		$logo=$dt['tb_empresa_logo'];	
	mysql_free_result($dts);
}
?>


<script type="text/javascript">
  $(function() {
     $("#file").change(function (){
         var empId = document.getElementById('hdd_emp_id').value;
         var fileInput = document.getElementById('file');
         var fileName = 'logos/'+empId+'_'+fileInput.files[0].name;
       $("#txt_emp_logo").val(fileName);
     });
  });
</script>

<script type="text/javascript">


$(function() {
	$("#for_emp").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "empresa_reg.php",
				async: true,
            	cache: false,
                contentType: false,
                processData: false,
				data: new FormData($('#for_emp')[0]),
				beforeSend: function() {
					$("#div_empresa_form" ).dialog( "close" );
					$('#msj_empresa').html("Guardando...");
					$('#msj_empresa').show(100);
				},
				success: function(html){
					$('#msj_empresa').html(html);
				},
				complete: function(){
					empresa_tabla();
				}
			});			
		},
		rules: {
			txt_emp_ruc: {
				required: true,
				digits: true,
				maxlength: 11
			},
			txt_emp_nomcom: {
				required: true
			},			
			txt_emp_razsoc: {
				required: true
			},
			txt_emp_dir: {
				required: true
			},				
			txt_emp_ema: {
				email: true				
			},
			txt_emp_rep: {
				required: false				
			}
		},
		messages: {
			txt_emp_ruc: {
				required: '*'
			},
			txt_emp_nomcom: {
				required: '*'
			},			
			txt_emp_razsoc: {
				required: '*'
			},
			txt_emp_dir: {
				required: '*'
			},
			txt_emp_rep: {
				required: '*'
			}
		}
	});		
});
</script>
<form id="for_emp" action="javascript:;" enctype="multipart/form-data" method="post">
<input name="action" id="action" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_emp_id" id="hdd_emp_id" type="hidden" value="<?php echo $_POST['emp_id']?>">
    <table>
    	<tr>
            <td align="right"><label for="txt_emp_ruc">
            RUC:</label></td>
            <td><input name="txt_emp_ruc" id="txt_emp_ruc" type="text" value="<?php echo $ruc?>" size="15" maxlength="11"></td>
        </tr>
        <tr>
            <td align="right"><label for="txt_emp_nomcom">Nombre Comercial:</label></td>
            <td><input name="txt_emp_nomcom" id="txt_emp_nomcom" type="text" value="<?php echo $nomcom?>" size="50" ></td>
        </tr>
         <tr>
            <td align="right"><label for="txt_emp_razsoc">Razón Social:</label></td>
            <td><input name="txt_emp_razsoc" id="txt_emp_razsoc" type="text" value="<?php echo $razsoc?>" size="50" ></td>
        </tr>
        <tr>
          <td align="right"><label for="txt_emp_dir">Dirección:</label></td>
          <td>
          	<input name="txt_emp_dir" type="text" id="txt_emp_dir" value="<?php echo $dir?>" size="50" maxlength="100">            
          </td>
      	</tr>
        <tr>
          	<td></td>
            <td><input name="txt_emp_dir2" type="text" id="txt_emp_dir2" value="<?php echo $dir2?>" size="50" maxlength="100"></td>
        </tr>
        <tr>
          	<td align="right"><label for="txt_emp_tel">Teléfono:</label></td>
            <td><input name="txt_emp_tel" type="text" id="txt_emp_tel" value="<?php echo $tel?>" size="15" maxlength="20"></td>
        </tr>
        <tr>
          	<td align="right"><label for="txt_emp_ema">Email:</label></td>
            <td><input name="txt_emp_ema" type="text" id="txt_emp_ema" value="<?php echo $ema?>" size="50" maxlength="100"></td>
        </tr>
        <tr>
          <td align="right"><label for="txt_emp_rep">Representante:</label></td>
          <td><input name="txt_emp_rep" id="txt_emp_rep" type="text" value="<?php echo $rep?>" size="50" ></td>
        </tr>  
        <tr>
          <td align="right"><label for="txt_emp_logo">Logo:</label></td>
          <td><input name="txt_emp_logo" id="txt_emp_logo" type="text" value="<?php echo $logo?>" size="40" ></td>
          <td><input id="file" name="file" size="12" type="file" /><input name="txt_emp_logoimg" id="txt_emp_logoimg" type="image" src="<?php echo $logo?>" width="100" height="30" alt="Logo" ></td>
        </tr> 
        <tr>
        	
        </tr>
    </table>
</form>