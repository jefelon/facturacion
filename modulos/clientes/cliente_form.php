<?php
require_once ("../../config/Cado.php");
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();

$tip = 1;

if($_POST['action']=="editar"){
	$dts=$oCliente->mostrarUno($_POST['cli_id']);
	$dt = mysql_fetch_array($dts);
		$tip=$dt['tb_cliente_tip'];
		$nom=$dt['tb_cliente_nom'];
		$doc=$dt['tb_cliente_doc'];
		$dir=$dt['tb_cliente_dir'];
		$con=$dt['tb_cliente_con'];
		$tel=$dt['tb_cliente_tel'];
		$ema=$dt['tb_cliente_ema'];
		$est=$dt['tb_cliente_est'];
	mysql_free_result($dts);
}

if($_POST['action']=="editarSunat"){
	$dts=$oCliente->mostrarUno($_POST['cli_id']);
	$dt = mysql_fetch_array($dts);
		$tip=$dt['tb_cliente_tip'];
		$doc=$dt['tb_cliente_doc'];
		$ema=$dt['tb_cliente_ema'];
	mysql_free_result($dts);
	$nom=$_POST['cli_nom'];
	$dir=$_POST['cli_dir'];
	if($_POST['cli_con']!=""){
		$con=$_POST['cli_con'];
	}else{
		$con=$_POST['cli_nom'];
	}
	$tel=$_POST['cli_tel'];
	$est=$_POST['cli_est'];
}

?>

<script type="text/javascript">
    jQuery.validator.addMethod("tip_doc", function(value, element, parameter) {
        if (($('input[name="rad_cli_tip"]:checked').val()==1 && $('#txt_cli_doc').val().length==8)||($('input[name="rad_cli_tip"]:checked').val()==2 && $('#txt_cli_doc').val().length==11)){
            return true;
        }else{
            return false;
        }
    }, "Número de digitos incorrecto");


    function buscar() {
	/*if($("#txt_cli_doc").val().substr(0,2)=='20'){
		$('#radio2').prop( "checked", true );
	}else if($("#txt_cli_doc").val().substr(0,2)=='10'){
		$('#radio1').prop( "checked", true );
	}*/
	$('#msj_busqueda_sunat_2').html("Buscando en Sunat...");
	$('#msj_busqueda_sunat_2').show(100);
	$.post('../../libreriasphp/consultaruc/index.php', {
		vruc: $('#txt_cli_doc').val(),
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
			$('#txt_cli_nom').val(data['RazonSocial']);
			$('#txt_cli_dir').val(data['Direccion']);
			if( typeof data['Contacto'] != 'undefined'){
				$('#txt_cli_con').val(data['Contacto']);
			}else{
				$('#txt_cli_con').val(data['RazonSocial']);
			}
			
			// var telefono = data['Telefonos'];
			// telefono = telefono.replace(/ \/ /g, "/");
			// telefono = telefono.replace("/ ", "");
			// telefono = telefono.replace(/\//g, " / ");
			// $('#txt_cli_tel').val(telefono);
			$('#txt_cli_est').val(data['Estado']);
			$('#msj_busqueda_sunat_2').hide();
		}
	},"json");
}

    function buscar_cliente(){
        $.ajax({
            type: "POST",
            url: "cliente_buscar.php",
            async:false,
            dataType: "json",
            data: ({
                txt_cli_cod: $('#txt_cli_cod').val()
            }),
            beforeSend: function() {

            },
            success: function(data){
                if(data.msj!="")
                {
                    $('#hdd_cli_id').val(data.cli_id);
                    $('#txt_cli_doc').val(data.cli_doc);
                    if(data.cli_tip==1){

                        $("#radio1").prop("checked", true);
                    }
                    else{
                        $("#radio2").prop("checked", true);
                        $('#lbl_cli_doc').html('RUC');
                    }

                    $('#txt_cli_nom').html(data.cli_nombre);
                    $('#txt_cli_dir').html(data.cli_dir);

                    $(data).each(function () {
                        var option = $(document.createElement('option'));

                        option.val(data.cli_id);
                        option.text(data.cli_nombre);

                        $("#cmb_cli_suc").append(option);
                    });

                    $('#msj_cliente').html(data.msj);
                }
                else
                {
                    //$('#msj_venta_form').hide();
                }
            }
        });
    }


$('#validar_ruc').button({
    text: true
  });

$(function() {

	// $("input[id=radio1]").change(function(){
	// 	if($("input[id=radio1]").is(":checked")){
	// 		$('#lbl_cli_doc').html("DNI:");
	// 		$( "#txt_cli_doc" ).attr('maxlength','8');
	// 	}
	// });
	// if($("input[id=radio1]").is(":checked")){
	// 	$('#lbl_cli_doc').html("DNI:");
	// 	$( "#txt_cli_doc" ).attr('maxlength','8');
	// }
	// $("input[id=radio2]").change(function(){
	// 	if($("input[id=radio2]").is(":checked")){
	// 		$('#lbl_cli_doc').html("RUC:");
	// 		$( "#txt_cli_doc" ).attr('maxlength','11');
	// 	}
	// });
	// if($("input[id=radio2]").is(":checked")){
	// 	$('#lbl_cli_doc').html("RUC:");
	// 	$( "#txt_cli_doc" ).attr('maxlength','11');
	// }

	// $( "#txt_cli_doc" ).focus();
    $( "#txt_cli_cod" ).focus();

    $('#btn_agregar').button({
        icons: {primary: "ui-icon-plus"},
        text: true
    });

	$('#txt_cli_nom, #txt_cli_dir, #txt_cli_con').change(function(){
		$(this).val($(this).val().toUpperCase());
	});


    $( "#txt_cli_cod" ).keydown(function( event ) {
        if ( event.which == 13 ) {

            buscar_cliente();
        }


    });

    $( "#btn_agregar" ).click(function( event ) {

        var id_cliente=$( "#hdd_cli_id" ).val();
        direccion_form('insertar',id_cliente);
    });


	$("#for_cli").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../clientes/cliente_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_cli").serialize(),
				beforeSend: function(){
					$('#div_cliente_form').dialog("close");
					$('#msj_cliente').html("Guardando...");
					$('#msj_cliente').show(100);
				},
				success: function(data){
					$('#msj_cliente').html(data.cli_msj);
					<?php
					if($_POST['vista']=="cmb_cli_id")
					{
						echo $_POST['vista'].'(data.cli_id);';?>
						<?php
					}
					if($_POST['vista']=="hdd_cli_id")
					{
						echo 'cliente_cargar_datos(data.cli_id);';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="cliente_tabla")
					{
						echo $_POST['vista'].'();';
					}
					if($_POST['vista']=="venta_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
			rad_cli_tip: {
				required: true
			},
			txt_cli_nom: {
				required: true,
				maxlength: 100
			},
			txt_cli_doc: {
				required: true,
				digits: true,
                tip_doc: true
			},
			txt_cli_dir: {
				maxlength: 150
			},
			txt_cli_ema: {
				email: true				
			}
		},
		messages: {
			rad_cli_tip: {
				required: '*'
			},
			txt_cli_nom: {
				required: '*'
			},
			txt_cli_doc: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_cli">
<input name="action_cliente" id="action_cliente" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_cli_id" id="hdd_cli_id" type="hidden" value="<?php echo $_POST['cli_id']?>">
    <table>
        <tr>
            <td align="right">Código:</td>
            <td><input name="txt_cli_cod" id="txt_cli_cod" type="text" value="<?php echo $cod?>" size="15" maxlength="11">
            </td>
        </tr>
    	<tr>
    	  <td align="right">Documento:</td>
    	  <td>
          	<div id="radio">
              <input name="rad_cli_tip" type="radio" id="radio1" value="1" <?php if($tip==1)echo 'checked="checked"'?>/><label for="radio1">DNI</label>
              <input name="rad_cli_tip" type="radio" id="radio2" value="2" <?php if($tip==2)echo 'checked="checked"'?>/><label for="radio2">RUC</label>
            </div>
    	  </td>
  	  </tr>
    	<tr>
            <td align="right"><label for="txt_cli_doc" id="lbl_cli_doc">DNI:</label></td>
            <td><input name="txt_cli_doc" id="txt_cli_doc" type="text" value="<?php echo $doc?>" size="15" maxlength="11">
<!--            <a id="validar_ruc" href="#validar" onClick="buscar()">Validar Ruc</a>-->
            <div id="msj_busqueda_sunat_2" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px;display: none"></div>
            </td>
        </tr>
        <tr>
    	  <td align="right" valign="top"><label for="txt_cli_nom">Cliente:</label></td>
    	  <td><textarea name="txt_cli_nom" cols="50" rows="2" id="txt_cli_nom"><?php echo $nom?></textarea></td>
  	  </tr>
        <tr>
          <td align="right" valign="top"><label for="txt_cli_dir">Dirección:</label></td>
          <td>
              <textarea name="txt_cli_dir" cols="50" rows="3" id="txt_cli_dir" ><?php echo $dir?></textarea>

          </td>
      	</tr>
        <tr>
            <td align="right" valign="top"><label for="txt_cli_suc">Sucursales:</label></td>
            <td>
                <select name="cmb_cli_suc" id="cmb_cli_suc">

                </select>
                <a id="btn_agregar" href="#">Agregar Direccion</a>
            </td>
        </tr>
<!--        <tr>-->
<!--          <td align="right"><label for="txt_cli_con">Contacto:</label></td>-->
<!--          <td><input name="txt_cli_con" id="txt_cli_con" type="text" value="--><?php //echo $con?><!--" size="50" tabindex="1"></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--          	<td align="right"><label for="txt_cli_tel">Teléfono:</label></td>-->
<!--            <td><input name="txt_cli_tel" type="text" id="txt_cli_tel" value="--><?php //echo $tel?><!--" size="45" maxlength="100"></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--          	<td align="right"><label for="txt_cli_ema">Email:</label></td>-->
<!--            <td><input name="txt_cli_ema" type="text" id="txt_cli_ema" value="--><?php //echo $ema?><!--" size="45" maxlength="100"></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--          	<td align="right"><label for="txt_cli_est">Estado:</label></td>-->
<!--            <td><input name="txt_cli_est" type="text" id="txt_cli_est" value="--><?php //echo $est?><!--" size="45" readonly></td>-->
<!--        </tr>-->
    </table>
</form>