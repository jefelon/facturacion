<?php
require_once ("../../config/Cado.php");
require_once ("../clientes/cCliente.php");
require_once ("../formatos/formato.php");
$oCliente = new cCliente();

$tip = 0;

$dts1=$oCliente->mostrarLibrosContables();
$num_rows= mysql_num_rows($dts1);

if($_POST['action']=="editar"){
	$dts=$oCliente->mostrarUno($_POST['cli_id']);
	$dt = mysql_fetch_array($dts);
		$tip=$dt['tb_cliente_tip'];
		$nom=$dt['tb_cliente_nom'];
		$doc=$dt['tb_cliente_doc'];
		$dir=$dt['tb_cliente_dir'];
		$con=$dt['tb_cliente_con'];
        $cum=mostrarFecha($dt['tb_cliente_cumpleanos']);
		$tel=$dt['tb_cliente_tel'];
		$ema=$dt['tb_cliente_ema'];
		$est=$dt['tb_cliente_est'];
        $est=$dt['tb_cliente_est'];
        $cliente_retiene=$dt['tb_cliente_retiene'];
        $precio_id=$dt['tb_precio_id'];
        $cui=$dt['tb_cliente_cui'];
        $regimen=$dt['tb_clienteregimen_id'];
        $afp= $dt['tb_cliente_afp'];
        $planilla= $dt['tb_cliente_planilla'];
        $pdt= $dt['tb_cliente_pdt'];
        $bienfizca=$dt['tb_cliente_bienfizc'];
        $balanceanual=$dt['tb_cliente_balanceanual'];
        $clientefijo=    $dt['tb_cliente_clientefijo'];
        $foto=    $dt['tb_cliente_foto'];
        $soluser=    $dt['tb_cliente_soluser'];
        $solpass=    $dt['tb_cliente_solpass'];
        $afpuser=    $dt['tb_cliente_afpuser'];
        $afppass=    $dt['tb_cliente_afppass'];




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

$('#validar_ruc').button({
    text: true
  });
    $( "#txt_cli_cum" ).datepicker({
        minDate: "-7Y",
        maxDate:"+7Y",
        yearRange: 'c-0:c+0',
        changeMonth: true,
        changeYear: false,
        dateFormat: 'dd-mm-yy',
        //altField: fecha,
        //altFormat: 'yy-mm-dd',
        showOn: "button",
        buttonImage: "../../images/calendar.gif",
        buttonImageOnly: true
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
        $( "#validar_ruc span").html("Valida DNI");
        $( "#validar_ruc").show(200);
	}
	$("input[id=radio2]").change(function(){
        if($("input[id=radio2]").is(":checked")){
            $('#lbl_cli_doc').html("RUC:");
            $( "#txt_cli_doc" ).attr('maxlength','11');
            $( "#validar_ruc span").html("Valida RUC");
            $( "#validar_ruc").show(200);
        }
    });
    $("input[id=radio3]").change(function(){
        if($("input[id=radio3]").is(":checked")){
            $('#lbl_cli_doc').html("DOC:");
            $( "#txt_cli_doc").attr('maxlength','11');
            $( "#validar_ruc").hide(200);
        }
    });

    if($( "#hdd_cli_id" ).val()>0){
        cmb_dir_id($( "#hdd_cli_id" ).val());
    }

	$( "#txt_cli_cui" ).focus();

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
<style>
    .cuadro{
        border: 1px solid #c3c1c1;
        text-align: center;
        border-radius: 10px;
        padding: 3px;
    }
</style>
<form id="for_cli">
    <div style="width: 45%;float: left">
        <input name="action_cliente" id="action_cliente" type="hidden" value="<?php echo $_POST['action']?>">
        <input name="hdd_cli_id" id="hdd_cli_id" type="hidden" value="<?php echo $_POST['cli_id']?>">
            <fieldset style="min-width: 300px;width: 450px">
                <legend>DATOS DE LA EMPRESA</legend>
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
                        <td align="right" valign="top"><label for="txt_cli_cui">CODIGO:</label></td>
                        <td><input name="txt_cli_cui" id="txt_cli_cui" type="text" value="<?php echo $cui?>" size="8"></td>
                    </tr>
                    <tr>
                        <td align="right"><label for="txt_cli_doc" id="lbl_cli_doc">DNI:</label></td>
                        <td><input name="txt_cli_doc" id="txt_cli_doc" type="text" value="<?php echo $doc?>" size="15" maxlength="11">
                        <a id="validar_ruc" href="#validar" onClick="buscar()">Validar Ruc</a>
                        <div id="msj_busqueda_sunat_2" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px;display: none"></div>
                        </td>
                    </tr>
                    <tr>
                      <td align="right" valign="top"><label for="txt_cli_nom">RAZ. SOCIAL:</label></td>
                      <td><textarea name="txt_cli_nom" cols="50" rows="2" id="txt_cli_nom"><?php echo $nom?></textarea></td>
                  </tr>
                    <tr>
                      <td align="right" valign="top"><label for="txt_cli_dir">DIRECCIÓN:</label></td>
                      <td><textarea name="txt_cli_dir" cols="50" rows="3" id="txt_cli_dir" ><?php echo $dir?></textarea>
                      </td>
                    </tr>

                    <tr>
                        <td align="right"><label for="txt_cli_con">REP. LEGAL:</label></td>
                        <td><input name="txt_cli_con" id="txt_cli_con" type="text" value="<?php echo $con?>" size="50" tabindex="1"></td>
                    </tr>

                    <tr>
                        <td align="right"><label for="txt_emp_reg">REGIMEN:</label></td>
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
                    <tr>
                        <td align="right"><label for="txt_cli_cum">CUMPLEAÑOS:</label></td>
                        <td><input name="txt_cli_cum" type="text" id="txt_cli_cum" value="<?php echo $cum?>" size="45" maxlength="100"></td>
                    </tr>
                    <tr>
                        <td align="right"><label for="txt_cli_tel">TELÉFONO:</label></td>
                        <td><input name="txt_cli_tel" type="text" id="txt_cli_tel" value="<?php echo $tel?>" size="45" maxlength="100"></td>
                    </tr>
                    <tr>
                        <td align="right"><label for="txt_cli_ema">EMAIL:</label></td>
                        <td><input name="txt_cli_ema" type="text" id="txt_cli_ema" value="<?php echo $ema?>" size="45" maxlength="100"></td>
                    </tr>
                    <tr>
                        <td align="right"><label for="txt_cli_est">ESTADO:</label></td>
                        <td><input name="txt_cli_est" type="text" id="txt_cli_est" value="<?php echo $est?>" size="45" readonly></td>
                    </tr>


                </table>
            </fieldset>
            <fieldset style="min-width: 300px;width: 450px;display:<?php if($_POST['ver']=="todo"){ echo 'block';} { echo 'none';}?>">
                <legend>LIBROS CONTABLES QUE LLEVA</legend>

                <table class="ui-widget ui-widget-content">
                    <tbody>
                    <tr class="ui-widget-header">
                        <th title="Mostrar en Catálogo">Seleccione las opciones</th>
                    </tr>

                    <?php
                    while($dt1 = mysql_fetch_array($dts1)){?>
                    <tr>
                        <td><input name="chk_cli_libros[]" type="checkbox" value="<?php echo $dt1['tb_librocontable_id']?>"> <label for="chk_cli_<?php echo $dt1['tb_librocontable_id']?>"><?php echo $dt1['tb_librocontable_nom'].' - ' .$dt1['tb_librocontable_tipo']?></label></td>
                    </tr>
                    <?php
                    }
                    mysql_free_result($dts1);
                    ?>
                    </tbody>
                </table>
            </fieldset>

    </div>

    <div style="width: 45%;float: right;display: <?php if($_POST['ver']=="todo"){ echo 'block';} { echo 'none';}?>">
        <fieldset style="min-width: 300px;width: 450px">
            <legend>OTROS DATOS</legend>
            <table>
                <tr>
                    <td align="left" class="cuadro"><b>AFP:</b>
                        <table>
                            <tr>
                                <td>
                                    <div id="afp">
                                        <input name="rad_cli_afp" type="radio" id="si" value="1" <?php if($afp==1)echo 'checked="checked"'?>/><label for="si">SI</label>
                                        <input name="rad_cli_afp" type="radio" id="no" value="0" <?php if($afp==0)echo 'checked="checked"'?>/><label for="no">NO</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td align="right" class="cuadro"><b>PLANILLA:</b>
                        <table>
                            <tr>
                                <td>
                                    <div id="planilla">
                                        <input name="rad_cli_planilla" type="radio" id="si" value="1" <?php if($planilla==1)echo 'checked="checked"'?>/><label for="si">SI</label>
                                        <input name="rad_cli_planilla" type="radio" id="no" value="0" <?php if($planilla==0)echo 'checked="checked"'?>/><label for="no">NO</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td align="left" class="cuadro"><b>PDT:</b>
                        <table>
                            <tr>
                                <td>
                                    <div id="pdt">
                                        <input name="rad_cli_pdt" type="radio" id="si" value="1" <?php if($pdt==1)echo 'checked="checked"'?>/><label for="si">SI</label>
                                        <input name="rad_cli_pdt" type="radio" id="no" value="0" <?php if($pdt==0)echo 'checked="checked"'?>/><label for="no">NO</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td align="right" class="cuadro"><b>BIENES FIZCALIZADOS:</b>
                        <table>
                            <tr>
                                <td>
                                    <div id="bienesfizcalizados">
                                        <input name="rad_cli_bienesfizcalizados" type="radio" id="si" value="1" <?php if($bienfizca==1)echo 'checked="checked"'?>/><label for="si">SI</label>
                                        <input name="rad_cli_bienesfizcalizados" type="radio" id="no" value="0" <?php if($bienfizca==0)echo 'checked="checked"'?>/><label for="no">NO</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="cuadro"><b>BALANCE ANUAL:</b>
                        <table>
                            <tr>
                                <td>
                                    <div id="balancea">
                                        <input name="rad_cli_balancea" type="radio" id="si" value="1" <?php if($balanceanual==1)echo 'checked="checked"'?>/><label for="si">SI</label>
                                        <input name="rad_cli_balancea" type="radio" id="no" value="0" <?php if($balanceanual==0)echo 'checked="checked"'?>/><label for="no">NO</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td align="right" class="cuadro"><b>CLIENTE FIJO:</b>
                        <table>
                            <tr>
                                <td>
                                    <div id="clientefijo">
                                        <input name="rad_cli_clientefijo" type="radio" id="si" value="1" <?php if($clientefijo==1)echo 'checked="checked"'?>/><label for="si">SI</label>
                                        <input name="rad_cli_clientefijo" type="radio" id="no" value="0" <?php if($clientefijo==0)echo 'checked="checked"'?>/><label for="no">NO</label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset style="min-width: 300px;width: 450px">
            <legend>CLAVES</legend>
            <table>
                <tr>
                    <td align="right" class="cuadro"><b>CLAVE SOL:</b>
                        <table>
                            <tr>
                                <td align="right" valign="top"><label for="txt_cli_clavesolusuario">USUARIO:</label></td>
                                <td><input name="txt_cli_clavesolusuario" type="text" id="txt_cli_clavesolusuario" value="<?php echo $soluser?>" size="10" maxlength="100"></td>
                            </tr>
                            <tr>
                                <td align="right" valign="top"><label for="txt_cli_clavesolclave">CLAVE:</label></td>
                                <td><input name="txt_cli_clavesolclave" type="text" id="txt_cli_clavesolclave" value="<?php echo $solpass?>" size="10" maxlength="100"></td>
                            </tr>
                        </table>
                    </td>
                    <td align="right" class="cuadro"><b>CLAVE AFP NET:</b>
                        <table>
                            <tr>
                                <td align="right" valign="top"><label for="txt_cli_claveafpusuario">USUARIO:</label></td>
                                <td><input name="txt_cli_claveafpusuario" type="text" id="txt_cli_claveafpusuario" value="<?php echo $afpuser?>" size="10" maxlength="100"></td>
                            </tr>
                            <tr>
                                <td align="right" valign="top"><label for="txt_cli_claveafpclave">CLAVE:</label></td>
                                <td><input name="txt_cli_claveafpclave" type="text" id="txt_cli_claveafpclave" value="<?php echo $afppass?>" size="10" maxlength="100"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </fieldset>
        <fieldset style="min-width: 300px;width: 450px">
            <legend>FOTO REPRESENTATIVA EMPRESA</legend>
            <table>
                <tr>
                    <td align="right" valign="top">
                        <input name="txt_clie_foto" id="txt_clie_foto" type="hidden" value="<?php echo $foto?>" size="40" >
                    </td>
                    <td><input id="file" name="file" size="12" type="file" />
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right" valign="top"><input name="txt_clie_fotoimg" id="txt_clie_fotoimg" type="image" src="<?php echo $foto?>" width="80" height="100" alt="Foto" ></td>
                </tr>
            </table>
        </fieldset>
    </div>
</form>