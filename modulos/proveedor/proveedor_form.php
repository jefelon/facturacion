<?php
require_once ("../../config/Cado.php");
require_once ("cProveedor.php");
$oProveedor = new cProveedor();

if($_POST['action']=="editar"){
	$dts=$oProveedor->mostrarUno($_POST['pro_id']);
	$dt = mysql_fetch_array($dts);
		$tip=$dt['tb_proveedor_tip'];
		$nom=$dt['tb_proveedor_nom'];
		$doc=$dt['tb_proveedor_doc'];
		$dir=$dt['tb_proveedor_dir'];
		$con=$dt['tb_proveedor_con'];
		$tel=$dt['tb_proveedor_tel'];
		$ema=$dt['tb_proveedor_ema'];
        $pais_id=$dt['cs_codigopais_id'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">
    function buscar() {
        /*if($("#txt_cli_doc").val().substr(0,2)=='20'){
            $('#radio2').prop( "checked", true );
        }else if($("#txt_cli_doc").val().substr(0,2)=='10'){
            $('#radio1').prop( "checked", true );
        }*/
        $('#msj_busqueda_sunat_2').html("Buscando en Sunat...");
        $('#msj_busqueda_sunat_2').show(100);
        $.post('../../libreriasphp/consultaruc/index.php', {
                vruc: $('#txt_pro_doc').val(),
                vtipod: 6
            },
            function(data, textStatus){
                if(data == null){
                    alert('Intente nuevamente...Sunat');
                }
                if(data.length==1){
                    alert(data[0]);
                    $('#msj_busqueda_sunat_2').hide();
                }else{
                    $('#txt_pro_nom').val(data['RazonSocial']);
                    $('#txt_pro_dir').val(data['Direccion']);
                    if( typeof data['Contacto'] != 'undefined'){
                        $('#txt_pro_con').val(data['Contacto']);
                    }else{
                        $('#txt_pro_con').val(data['RazonSocial']);
                    }

                    var telefono = data['Telefonos'];
                    telefono = telefono.replace(/ \/ /g, "/");
                    telefono = telefono.replace("/ ", "");
                    telefono = telefono.replace(/\//g, " / ");
                    $('#txt_pro_tel').val(telefono);
                    $('#txt_pro_est').val(data['Estado']);
                    $('#msj_busqueda_sunat_2').hide();
                }
            },"json");
    }
    function cmb_pais_id(ids)
    {
        $.ajax({
            type: "POST",
            url: "../proveedor/cmb_pais_id.php",
            async:true,
            dataType: "html",
            data: ({
                pais_id: ids
            }),
            beforeSend: function() {
                $('#cmb_pais_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_pais_id').html(html);
            }
        });

    }
    $('#validar_ruc').button({
        text: true
    });

$(function() {
	
	$( "#radio" ).buttonset();
	
	$('#txt_pro_nom, #txt_pro_dir, #txt_pro_con').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});
    cmb_pais_id(<?php echo $pais_id?>);
	$("#for_pro").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../proveedor/proveedor_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_pro").serialize(),
				beforeSend: function(){
					$('#div_proveedor_form').dialog("close");
					$('#msj_proveedor').html("Guardando...");
					$('#msj_proveedor').show(100);
				},
				success: function(data){
					$('#msj_proveedor').html(data.pro_msj);
					<?php
					if($_POST['vista']=="cmb_pro_id")
					{
						echo $_POST['vista'].'(data.pro_id);';
					}
					if($_POST['vista']=="hdd_pro_id")
					{
						echo 'proveedor_cargar_datos(data.pro_id);';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="proveedor_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			rad_pro_tip: {
				required: true
			},
			txt_pro_nom: {
				required: true,
				maxlength: 100
			},
			txt_pro_doc: {
				required: true,
				digits: true
			},
			txt_pro_dir: {
				maxlength: 100
			},
			txt_pro_ema: {
				email: true				
			}
		},
		messages: {
			rad_pro_tip: {
				required: '*'
			},
			txt_pro_nom: {
				required: '*'
			},
			txt_pro_doc: {
				required: '*'
			}
		}
	});		
});
</script>
<form id="for_pro">
<input name="action_proveedor" id="action_proveedor" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_pro_id" id="hdd_pro_id" type="hidden" value="<?php echo $_POST['pro_id']?>">
    <table>
        <tr>
            <td align="right">Persona:</td>
            <td>
                <div id="radio">
                    <input name="rad_pro_tip" type="radio" id="radio1" value="1" <?php if($tip==1)echo 'checked="checked"'?>/><label for="radio1">Natural</label>
                    <input name="rad_pro_tip" type="radio" id="radio2" value="2" <?php if($tip==2)echo 'checked="checked"'?>/><label for="radio2">Jurídica</label>
                    <input name="rad_pro_tip" type="radio" id="radio3" value="3" <?php if($tip==3)echo 'checked="checked"'?>/><label for="radio3">OTROS</label>
                </div>
            </td>
        </tr>
        <tr>
            <td align="right"><label for="txt_pro_doc">DNI:</label></td>
            <td><input name="txt_pro_doc" id="txt_pro_doc" type="text" value="<?php echo $doc?>" size="15" maxlength="11">
                <a id="validar_ruc" href="#validar" onClick="buscar()">Validar DNI</a>
                <div id="msj_busqueda_sunat_2" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px;display: none"></div>
            </td>

        </tr>




    	<tr>
    	  <td align="right" valign="top"><label for="txt_pro_nom">Proveedor:</label></td>
    	  <td><textarea name="txt_pro_nom" cols="50" rows="2" id="txt_pro_nom"><?php echo $nom?></textarea></td>
  	  </tr>
        <tr>
          <td align="right" valign="top"><label for="txt_pro_dir">Dirección:</label></td>
          <td><textarea name="txt_pro_dir" cols="50" rows="2" id="txt_pro_dir" ><?php echo $dir?></textarea>            
          </td>
      	</tr>
        <tr>
          <td align="right"><label for="txt_pro_con">Contacto:</label></td>
          <td><input name="txt_pro_con" id="txt_pro_con" type="text" value="<?php echo $con?>" size="50" tabindex="1"></td>
        </tr>
        <tr>
          	<td align="right"><label for="txt_pro_tel">Teléfono:</label></td>
            <td><input name="txt_pro_tel" type="text" id="txt_pro_tel" value="<?php echo $tel?>" size="15" maxlength="13"></td>
        </tr>
        <tr>
          	<td align="right"><label for="txt_pro_ema">Email:</label></td>
            <td><input name="txt_pro_ema" type="text" id="txt_pro_ema" value="<?php echo $ema?>" size="45" maxlength="100"></td>
        </tr>
        <tr>
            <td align="right"><label for="txt_pro_ema">PAIS:</label></td>
            <td width="34">
                <select name="cmb_pais_id" id="cmb_pais_id">
                </select>
            </td>
        </tr>
    </table>
</form>