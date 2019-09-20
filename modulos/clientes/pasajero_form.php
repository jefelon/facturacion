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
        $est=$dt['tb_cliente_est'];
        $cliente_retiene=$dt['tb_cliente_retiene'];
        $precio_id=$dt['tb_precio_id'];
        $cui=$dt['tb_cliente_cui'];


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
        if (($('input[name="rad_cli_tip"]:checked').val()==1 && $('#txt_cli_doc').val().length==8)||($('input[name="rad_cli_tip"]:checked').val()==2 && $('#txt_cli_doc').val().length==11) ||($('input[name="rad_cli_tip"]:checked').val()==3 && $('#txt_cli_doc').val().length>1)){
            return true;
        }else{
            return false;
        }
    }, "Número de digitos incorrecto");


    function buscar() {
        if($("input[id=radio1]").is(":checked")){
            var dni = $('#txt_cli_doc').val();
            var url = '../../libreriasphp/consultadni/consulta_reniec.php';
            $.ajax({
                type:'POST',
                url:url,
                data:'dni='+dni,
                success: function(datos_dni){
                    var datos = eval(datos_dni);
                    // $('#mostrar_dni').text(datos[0]);
                    // $('#paterno').text(datos[1]);
                    // $('#materno').text(datos[2]);
                    // $('#nombres').text(datos[3]);
                    if(datos[1]!="" && datos[2]!="" && datos[3]!="") {
                        $('#txt_cli_nom').val(datos[1] + " " + datos[2] + " " + datos[3]);
                    }else {
                        $('#txt_cli_nom').val("Datos no encontrados o menor de edad. Editar manualmente los datos.");
                    }
                }
            });
        }else {
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
                function (data, textStatus) {
                    if (data == null) {
                        alert('Intente nuevamente...Sunat');
                    }
                    if (data.length == 1) {
                        alert(data[0]);
                        $('#msj_busqueda_sunat_2').hide();
                    } else {
                        $('#txt_cli_nom').val(data['RazonSocial']);
                        $('#txt_cli_dir').val(data['Direccion']);
                        if (typeof data['Contacto'] != 'undefined') {
                            $('#txt_cli_con').val(data['Contacto']);
                        } else {
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
                }, "json");
        }
    }


    function cmb_precio_id(ids)
    {
        $.ajax({
            type: "POST",
            url: "../listaprecio/cmb_precio_id.php",
            async:true,
            dataType: "html",
            data: ({
                precio_id: ids
            }),
            beforeSend: function() {
                $('#cmb_precio_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_precio_id').html(html);
            }
        });

    }

    function cmb_dir_id(ids)
    {
        $.ajax({
            type: "POST",
            url: "../clientes/cmb_cli_dir.php",
            async:true,
            dataType: "html",
            data: ({
                cli_id: ids
            }),
            beforeSend: function() {
                $('#cmb_cli_suc').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_cli_suc').html(html);
            }
        });
    }

$('#validar_ruc_rem').button({
    text: true
  });

$(function() {
    cmb_precio_id(<?php echo $precio_id ?>);
	$("input[id=radio1]").change(function(){
		if($("input[id=radio1]").is(":checked")){
			$('#lbl_cli_doc').html("DNI:");
			$( "#txt_cli_doc" ).attr('maxlength','8');
		}
	});
	if($("input[id=radio1]").is(":checked")){
		$('#lbl_cli_doc').html("DNI:");
		$( "#txt_cli_doc" ).attr('maxlength','8');
        $( "#validar_ruc_rem span").html("Valida DNI");
        $( "#validar_ruc_rem").show(200);
	}
	$("input[id=radio2]").change(function(){
        if($("input[id=radio2]").is(":checked")){
            $('#lbl_cli_doc').html("RUC:");
            $( "#txt_cli_doc" ).attr('maxlength','11');
            $( "#validar_ruc_rem span").html("Valida RUC");
            $( "#validar_ruc_rem").show(200);
        }
    });
    $("input[id=radio3]").change(function(){
        if($("input[id=radio3]").is(":checked")){
            $('#lbl_cli_doc').html("DOC:");
            $( "#txt_cli_doc").attr('maxlength','11');
            $( "#validar_ruc_rem").hide(200);
        }
    });

    if($( "#hdd_cli_id" ).val()>0){
        cmb_dir_id($( "#hdd_cli_id" ).val());
    }

	$( "#txt_cli_doc" ).focus();

    $('#btn_agregar2').button({
        icons: {primary: "ui-icon-plus"},
        text: true
    });
	$('#txt_cli_nom, #txt_cli_dir, #txt_cli_con').change(function(){
		$(this).val($(this).val().toUpperCase());
	});

    // if($("#radio1").is(":checked")){
    //     $("#lbl_cli_doc").html('DNI');
    // }
    // if($("#radio2").is(":checked")){
    //     $("#lbl_cli_doc").html('RUC');
    // }
    // if($("#radio3").is(":checked")) {
    //     alert('hola');
    // }

    $( "#btn_agregar2" ).click(function( event ) {

        var id_cliente=$( "#hdd_cli_id" ).val();
        direccion_form('insertar',id_cliente);
    });

        $("#for_pas").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../clientes/cliente_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_pas").serialize(),
				beforeSend: function(){
                    $('#div_pasajero_form').dialog("close");
					$('#msj_cliente').html("Guardando...");
					$('#msj_cliente').show(100);
                    $('#div_pasajero_form').html('');
				},
				success: function(data){
					$('#msj_cliente').html(data.cli_msj);

					<?php
					if($_POST['vista']=="cmb_cli_id")
					{
						echo $_POST['vista'].'(data.cli_id);';?>
						<?php
					}
                    if($_POST['vista']=="hdd_pas_id")
                    {
                        echo 'pasajero_cargar_datos(data.cli_id);';
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
<form id="for_pas">
<input name="action_cliente" id="action_cliente" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_cli_id" id="hdd_cli_id" type="hidden" value="<?php echo $_POST['cli_id']?>">
    <table>
    	<tr>
    	  <td align="right">Documento:</td>
    	  <td>
          	<div id="radio">
              <input name="rad_cli_tip" type="radio" id="radio1" value="1" <?php if($tip==1)echo 'checked="checked"'?>/><label for="radio1">DNI</label>
              <input name="rad_cli_tip" type="radio" id="radio2" value="2" <?php if($tip==2)echo 'checked="checked"'?>/><label for="radio2">RUC</label>
              <input name="rad_cli_tip" type="radio" id="radio3" value="3" <?php if($tip==3)echo 'checked="checked"'?>/><label for="radio3">OTROS</label>
            </div>
    	  </td>
  	  </tr>
    	<tr>
            <td align="right"><label for="txt_cli_doc"  id="lbl_cli_doc">DNI:</label></td>
            <td><input name="txt_cli_doc" id="txt_cli_doc" type="text" value="<?php echo $doc?>" size="15" maxlength="11">
            <a id="validar_ruc_rem" href="#validar" onClick="buscar()">Validar Ruc</a>
            <input name="txt_cli_cui" id="txt_cli_cui" type="hidden" value="<?php echo $cui?>" size="8">
            <div id="msj_busqueda_sunat_2" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px;display: none"></div>
            </td>
        </tr>
        <tr>
    	  <td align="right" valign="top"><label for="txt_cli_nom">Cliente:</label></td>
    	  <td><textarea name="txt_cli_nom" cols="50" rows="2" id="txt_cli_nom"><?php echo $nom?></textarea></td>
  	  </tr>
        <tr>
          <td align="right" valign="top"><label for="txt_cli_dir">Dirección:</label></td>
          <td><textarea name="txt_cli_dir" cols="50" rows="3" id="txt_cli_dir" ><?php echo $dir?></textarea>            
          </td>
      	</tr>
        <tr>
        <?php if($_POST['dir']=="ok") { ?>
        <tr>
          <td align="right" valign="top"><label for="txt_cli_suc">Sucursales:</label></td>
          <td>
                <select name="cmb_cli_suc" id="cmb_cli_suc">

                </select>
                <a id="btn_agregar2" href="#">Agregar Direccion</a>
          </td>
        </tr>
        <?php } ?>
          <td align="right"><label for="txt_cli_con">Contacto:</label></td>
          <td><input name="txt_cli_con" id="txt_cli_con" type="text" value="<?php echo $con?>" size="50" tabindex="1"></td>
        </tr>
        <tr>
          	<td align="right"><label for="txt_cli_tel">Teléfono:</label></td>
            <td><input name="txt_cli_tel" type="text" id="txt_cli_tel" value="<?php echo $tel?>" size="45" maxlength="100"></td>
        </tr>
        <tr>
          	<td align="right"><label for="txt_cli_ema">Email:</label></td>
            <td><input name="txt_cli_ema" type="text" id="txt_cli_ema" value="<?php echo $ema?>" size="45" maxlength="100"></td>
        </tr>
        <tr>
          	<td align="right"><label for="txt_cli_est">Estado:</label></td>
            <td><input name="txt_cli_est" type="text" id="txt_cli_est" value="<?php echo $est?>" size="45" readonly></td>
        </tr>
        <tr>
            <td align="right"><label for="cmb_cli_retiene">Retiene:</label></td>
            <td><select name="cmb_cli_retiene" id="cmb_cli_retiene">
                <option value="">-</option>
                <option value="1" <?php if($cliente_retiene=='1')echo 'selected'?>>RETIENE</option>
                <option value="2" <?php if($cliente_retiene=='2')echo 'selected'?>>NO RETIENE</option>
            </select>
                <label for="cmb_precio_id">Lista Precios:</label>
                <select name="cmb_precio_id" id="cmb_precio_id">
                </select>
                <div id="div_precio_form">
                </div>
            </td>
        </tr>

    </table>
</form>