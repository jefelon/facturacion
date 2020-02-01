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
        $regimen=$dt['tb_empresa_regimen'];
        $cel=$dt['tb_empresa_cel'];
        $cer=$dt['tb_empresa_certificado'];
        $clacer=$dt['tb_empresa_clave_certificado'];
        $ususun=$dt['tb_empresa_usuario_sunat'];
        $clasun=$dt['tb_empresa_clave_sunat'];
        $iddis=$dt['tb_empresa_iddistrito'];
        $sub=$dt['tb_empresa_subdivision'];
        $dep=$dt['tb_empresa_departamento'];
        $pro=$dt['tb_empresa_provincia'];
        $dis=$dt['tb_empresa_distrito'];
        $webser=$dt['tb_empresa_webser'];
        $texto_impresion=$dt['tb_empresa_teximp'];
	mysql_free_result($dts);
}
?>


<script type="text/javascript">
  $(function() {
     $("#file").change(function (){

         if(checkFile())
         {
             var empId = document.getElementById('hdd_emp_id').value;
             var fileInput = document.getElementById('file');
             var fileName = 'logos/'+empId+'_'+fileInput.files[0].name;
             $("#txt_emp_logo").val(fileName);
         }
         else {
             $("#file").val("");
         }

     });

     $("#file_cer").change(function (){

          if(checkFileCert())
          {
              var empId = document.getElementById('hdd_emp_id').value;
              var fileInput = document.getElementById('file_cer');
              var fileName = empId+'_'+fileInput.files[0].name;
              $("#txt_cer").val(fileName);
          }
          else {
              $("#file_cer").val("");
          }

      });
  });

  function checkFile() {
      var fileElement = document.getElementById("file");
      var fileExtension = "";
      if (fileElement.value.lastIndexOf(".") > 0) {
          fileExtension = fileElement.value.substring(fileElement.value.lastIndexOf(".") + 1, fileElement.value.length);
      }
      if (fileExtension.toLowerCase() == "jpg") {
          return true;
      }
      else if (fileExtension.toLowerCase() == "jpeg") {
          return true;
      }
      else if (fileExtension.toLowerCase() == "png") {
          return true;
      }
      else {
          alert("Solo puede subir imágenes en .png .jpg . jpeg");
          return false;
      }
  }
  function checkFileCert() {
      var fileElement = document.getElementById("file_cer");
      var fileExtension = "";
      if (fileElement.value.lastIndexOf(".") > 0) {
          fileExtension = fileElement.value.substring(fileElement.value.lastIndexOf(".") + 1, fileElement.value.length);
      }
      if (fileExtension.toLowerCase() == "pfx") {
          return true;
      }
      else {
          alert("Solo puede subir un certificado digital en .pfx ");
          return false;
      }
  }
</script>
<script>
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
    <table style="width:50%;float: left">
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
            <td><input name="txt_emp_tel" type="text" id="txt_emp_tel" value="<?php echo $tel?>" size="20" maxlength="20">
            <label for="txt_cel">Celular:</label>
            <input name="txt_cel" type="text" id="txt_cel" value="<?php echo $cel?>" size="20" maxlength="20"></td>
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
          <td>
              <input name="txt_emp_logo" id="txt_emp_logo" type="text" value="<?php echo $logo?>" size="40" ><br>
              <input id="file" name="file" size="12" type="file" /><br><input name="txt_emp_logoimg" id="txt_emp_logoimg" type="image" src="<?php echo $logo?>" width="100" alt="Logo" >
          </td>
        </tr>
        <tr>
            <td align="right"><label for="txt_emp_rep">Regimen:</label></td>
            <td>
                <select name="cmb_regimen_id" id="cmb_regimen_id">
                    <option value="">-</option>
                    <option value="1" <?php if($regimen=='1')echo 'selected'?>>REGIMEN GENERAL</option>
                    <option value="2" <?php if($regimen=='2')echo 'selected'?>>REGIMEN MYPE TRIBUTARIO</option>
                    <option value="3"<?php if($regimen=='3')echo 'selected'?>>REGIMEN ESPECIAL</option>
                    <option value="4"<?php if($regimen=='4')echo 'selected'?>>NUEVO RUS</option>
                </select>
            </td>
        </tr>
    </table>
    <table style="width: 40%;float: right">
        <tr>
            <td align="right"><label for="txt_emp_cer">Certificado Digital .pfx:</label></td>
            <td>
                <input name="txt_cer" id="txt_cer" type="text" value="<?php echo $cer?>" size="30" ><br>
                <input id="file_cer" name="file_cer" type="file" size="10" style="width: 228px" placeholder="hola"/>
            </td>
        </tr>
        <tr>
            <td align="right"><label for="txt_clacer">Clave Certificado:</label></td>
            <td><input name="txt_clacer" id="txt_clacer" type="password" value="<?php echo $clacer?>" size="30" ></td>
        </tr>
        <tr>
            <td align="right"><label for="txt_ususun">Usuario Sec. Sunat:</label></td>
            <td><input name="txt_ususun" id="txt_ususun" type="text" value="<?php echo $ususun?>" size="30" ></td>
        </tr>
        <tr>
            <td align="right"><label for="txt_clasun">Clave Sec. Sunat:</label></td>
            <td><input name="txt_clasun" id="txt_clasun" type="password" value="<?php echo $clasun?>" size="30" ></td>
        </tr><tr>
            <td align="right"><label for="txt_iddis">Ubigeo:</label></td>
            <td><input name="txt_iddis" id="txt_iddis" type="text" value="<?php echo $iddis?>" size="30" ></td>
        </tr><tr>
            <td align="right"><label for="txt_sub">Subdivisión:</label></td>
            <td><input name="txt_sub" id="txt_sub" type="text" value="<?php echo $sub?>" size="30" ></td>
        </tr>
        <tr>
            <td align="right"><label for="txt_dep">Departamento:</label></td>
            <td><input name="txt_dep" id="txt_dep" type="text" value="<?php echo $dep?>" size="30" ></td>
        </tr>
        <tr>
            <td align="right"><label for="txt_pro">Provincia:</label></td>
            <td><input name="txt_pro" id="txt_pro" type="text" value="<?php echo $pro?>" size="30" ></td>
        </tr>
        <tr>
            <td align="right"><label for="txt_dis">Distrito:</label></td>
            <td><input name="txt_dis" id="txt_dis" type="text" value="<?php echo $dis?>" size="30" ></td>
        </tr>
        <tr>
            <td align="right"><label for="txt_webser">Web Service Sunat:</label></td>
            <td>
                <select name="txt_webser" id="txt_webser">
                    <option value="">-</option>
                    <option value="beta" <?php if($webser=='beta')echo 'selected'?>>BETA</option>
                    <option value="produccion" <?php if($webser=='produccion')echo 'selected'?>>PRODUCCION</option>
                </select>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td align="right" style="display: inline-block;width: 84px;text-align: right"><label for="txt_texto_impresion">Texto Rubro: </label></td>
            <td>
                <input style="float: right" name="txt_texto_impresion" id="txt_texto_impresion" type="text" value="<?php echo $texto_impresion?>" size="102" >
            </td>
        </tr>
    </table>
</form>