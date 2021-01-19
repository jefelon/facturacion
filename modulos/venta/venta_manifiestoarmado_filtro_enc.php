<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
//require_once ("../formatos/formatos.php");
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	
	$fec1="$d-$m-$y";
	
	//$d=ultimoDia($m,$y);
	$fec2="$d-$m-$y";
	//$fec2="$d-$m-$y";
	
	//$punven_id=$_SESSION['puntoventa_id'];
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

$pvs=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv = mysql_fetch_array($pvs);
	
?>
<script type="text/javascript">
	$('#btn_filtrar2').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_resfil2').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
    $('#btn_agregar_horario').button({
        icons: {primary: "ui-icon-plus"},
        text: false
    });
    $('#btn_editar_horario').button({
        icons: {primary: "ui-icon-pencil"},
        text: false
    });

function cmb_fil_cli_id()
{	
	$.ajax({
		type: "POST",
		url: "../clientes/cmb_cli_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			//cli_id: "<?php //echo $cli_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_cli_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_fil_cli_id').html(html);
		}
	});
}

function cmb_fil_ven_ven()
{	
	$.ajax({
		type: "POST",
		url: "../usuarios/cmb_use_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			usugru_id: '2,3'
		}),
		beforeSend: function() {
			$('#cmb_fil_ven_ven').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_ven_ven').html(html);
		}
	});
}
function cmb_punven_id(idf)
{	
	$.ajax({
		type: "POST",
		url: "../puntoventa/cmb_punven_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			punven_id: idf
		}),
		beforeSend: function() {
			$('#cmb_fil_ven_punven').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_ven_punven').html(html);
		},
		complete: function(){
			//venta_tabla();
		}
	});
}
function cmb_ven_doc()
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	'2',
			doc_id: '<?php echo $doc_id?>',
			vista:	'<?php echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_fil_ven_doc').html('<option value="">Cargando...</option>');
        },
		success: function(html){			
			$('#cmb_fil_ven_doc').html(html);
		}
	});
}

    function cmb_lugar()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_lug_id.php",
            async:true,
            dataType: "html",
            data: ({
                lug_id: <?php echo $pv['tb_lugar_id']?>
            }),
            beforeSend: function() {
                $('#cmb_salida_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_salida_id').html(html);
                $('#cmb_salida_id').find('option').not(':selected').remove();
            },
            complete: function(){

            }
        });
    }

    function cmb_lugar_parada()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_lug_id.php",
            async:true,
            dataType: "html",
            beforeSend: function() {
                $('#cmb_parada_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_parada_id').html(html);
                $("#cmb_parada_id").find("option[value='<?php echo $pv['tb_lugar_id']?>']").remove();
            },
            complete: function(){

            }
        });
    }
    function cmb_lugar_destino()
    {
        $.ajax({
            type: "POST",
            url: "../lugar/cmb_lug_id.php",
            async:true,
            dataType: "html",
            beforeSend: function() {
                $('#cmb_llegada_id').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_llegada_id').html(html);
                $("#cmb_llegada_id").find("option[value='<?php echo $pv['tb_lugar_id']?>']").remove();
            },
            complete: function(){

            }
        });
    }
$(function() {
    cmb_lugar();
    cmb_lugar_destino();
    cmb_lugar_parada();
    $('#txt_fil_ven_numdoc2').prop("disabled", true).addClass("ui-state-disabled");

	var dates = $( "#txt_fil_ven_fec1, #txt_fil_ven_fec2" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_ven_fec1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	
	//cmb_fil_cli_id();
	cmb_fil_ven_ven();
	
	$( "#txt_fil_cli" ).autocomplete({
   		minLength: 1,
   		source: "../clientes/cliente_complete_nom.php",
		select: function(event, ui){
			$("#hdd_fil_cli_id").val(ui.item.id);														
		}
    });
	
	$("#txt_fil_cli").change(function(){
		var cli=$("#txt_fil_cli").val();
		if(cli=="")$("#hdd_fil_cli_id").val('');
	});

    $( "#txt_fil_ven_numdoc2" ).autocomplete({
        minLength: 1,
        source: "../venta/venta_complete_numdoc.php",
        select: function(event, ui){
            $("#hdd_fil_ven_numdoc2").val(ui.item.label);
            venta_tabla_manifiesto_armado();
        }
    });

    $("#txt_fil_ven_numdoc2").change(function(){
        var numdoc=$("#txt_fil_ven_numdoc2").val();
        if(numdoc=="")$("#hdd_fil_ven_numdoc2").val('');
        venta_tabla_manifiesto_armado();
    });
	
	$('#cmb_fil_ven_doc').change(function(e) {
        venta_tabla_manifiesto_armado();
    });
	$('#cmb_fil_ven_ven').change(function(e) {
        venta_tabla_manifiesto_armado();
    });
	
	$('#chk_ven_anu').change( function() {
        venta_tabla_manifiesto_armado();
	});

    $('#cmb_horario').change(function(){
        $('#txt_fil_ven_numdoc2').removeAttr("disabled");
        $('#txt_fil_ven_numdoc2').removeClass("ui-state-disabled");

        cmb_horario_vehiculo();
        venta_tabla_manifiesto_armado();
    });

    $('#cmb_fech_sal').change(function(){
        cmb_fecha_horario();
        $('#txt_placa_vehiculo').val('');
        $('#txt_modelo_vehiculo').val('');
        $('#txt_asientos_vehiculo').val('');
        $('#bus').html('');
        $('#hdd_vi_ho').val('');
    });

    $('#cmb_parada_id').prop("disabled", true).addClass("ui-state-disabled");
    $('#cmb_llegada_id').change(function(){
        $('#cmb_horario').val('');
        cmb_fecha();
        $('#txt_placa_vehiculo').val('');
        $('#txt_modelo_vehiculo').val('');
        $('#txt_asientos_vehiculo').val('');
        $('#bus').html('');
        $('#hdd_vi_ho').val('');
        $('#cmb_parada_id').prop("disabled", false);
        $('#cmb_parada_id').removeClass("ui-state-disabled");

    });
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_ven2" id="for_fil_ven2" target="_blank" action="" method="post">
<input name="hdd_modo2" id="hdd_modo2" type="hidden" value="venta_manifiestoarmado_tabla_enc.php">
 <input type="hidden" id="hdd_vi_ho" name="hdd_vi_ho">
    <input type="hidden" id="hdd_vehiculo" name="hdd_vehiculo">
<fieldset><legend>Filtro de Manifiesto</legend>
        <table border="0" cellspacing="2" cellpadding="0" width="100%">
            <tr>
                <td valign="top">
                    <label for="cmb_salida_id">Origen</label><br>
                    <select name="cmb_salida_id" id="cmb_salida_id" style="width: 150px">
                        <option value=""></option>
                    </select>
                </td>
                <td valign="top">
                    <label for="cmb_parada_id">Parada</label><br>
                    <select name="cmb_parada_id" id="cmb_parada_id" style="width: 150px">
                    </select>
                </td>
                <td valign="top"><label for="cmb_llegada_id">Destino:</label><br>
                    <select name="cmb_llegada_id" id="cmb_llegada_id" style="width: 150px">
                    </select>
                </td>
                <td align="left" valign="middle">
                    <label for="cmb_fech_sal">Agregar/Editar</label><br>
                    <a id="btn_agregar_horario" title="Agregar Horarios de salida de bus" href="#" onClick="venta_horario_form()">Agregar Horario</a>

                    <a id="btn_editar_horario" title="Editar Horario de salida de bus" href="#" onClick="venta_vh_vehiculo_form()">Editar Horario</a>
                    <div id="msj_horario" class="ui-state-highlight ui-corner-all" style="width: 195px;display: none;position: relative;top: 8%;right: 3%;"></div>
                </td>
            </tr>

            <tr>
                <td valign="top">
                    <label for="cmb_fech_sal">F. Salida</label><br>
                    <select name="cmb_fech_sal" id="cmb_fech_sal">
                    </select>
                </td>
                <td align="center" valign="top"><label for="cmb_horario">Hora Salida:</label><br>
                    <select name="cmb_horario" id="cmb_horario" style="width: 100%">
                    </select>
                </td>
            </tr>
        </table>

    <input type="hidden" id="hdd_fil_cho_id2" name="hdd_fil_cho_id2" />
    <input type="hidden" id="hdd_fil_cli_id2" name="hdd_fil_cli_id2" />

    <label for="txt_fil_cli2">Num. Doc:</label>
    <input type="text" id="txt_fil_ven_numdoc2" name="txt_fil_ven_numdoc2" size="7"/>
    <input type="hidden" id="hdd_fil_ven_numdoc2" name="hdd_fil_ven_numdoc2">

    <label for="txt_fil_cli2">Cliente:</label>
    <input type="text" id="txt_fil_cli2" name="txt_fil_cli2" size="40" />

      	<a href="#" onClick="venta_tabla_manifiesto_armado()" id="btn_filtrar2">Filtrar</a>
    <a href="#" onClick="venta_filtro_armado()" id="btn_resfil2">Restablecer</a>
</fieldset>
</form>