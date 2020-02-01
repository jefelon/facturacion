<?php
require_once ("../../config/Cado.php");
require_once ("../tipocambio/cTipoCambio.php");
require_once("../formatos/formato.php");
$oTipoCambio = new cTipoCambio();

if($_POST['action']=="insertar"){
	$fec=date('d-m-Y');
}

if($_POST['action']=="editar"){
	$dts=$oTipoCambio->mostrarUno($_POST['tipcam_id']);
	$dt = mysql_fetch_array($dts);
		
		$reg=mostrarFechaHora($dt['tb_tipocambio_reg']);
		$mod=mostrarFechaHora($dt['tb_tipocambio_mod']);
		$fec=mostrarFecha($dt['tb_tipocambio_fec']);
		$dolsunv=$dt['tb_tipocambio_dolsunv'];
        $dolsunc=$dt['tb_tipocambio_dolsunc'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">
    function tipocambiosunat_filtro()
    {
        $.ajax({
            type: "POST",
            url: "tipocambiosunat_filtro.php",
            async:true,
            dataType: "html",
            //data: ({
            //compra: $('#txt_fil_pro').val()
            //}),
            beforeSend: function() {
                $('#div_tipocambiosunat_filtro').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_tipocambiosunat_filtro').html(html);
            },
            complete: function(){
                tipocambiosunat_tabla();
            }
        });
    }
    function tipocambiosunat_tabla(){
        $.ajax({
            type: "POST",
            url: "tipocambiosunat_tabla.php",
            async:true,
            dataType: "html",
            data: ({
                mesElegido:$('#cmb_fil_mes').val(),
                anioElegido:$('#cmb_fil_anio').val(),
                mes:$('#cmb_fil_mes').val(),
                anho:$('#cmb_fil_anio').val()
            }),
            beforeSend: function() {
                $('#div_tipocambiosunat_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_tipocambiosunat_tabla').html(html);
            },
            complete: function(){
                $('#div_tipocambiosunat_tabla').removeClass("ui-state-disabled");
            }
        });
    }
$( "#txt_tipcam_fec" ).datepicker({
	//minDate: "-1M", 
	maxDate:"+0D",
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
$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.000',
	vMax: '9.999'
});

$(function() {

    //tipocambiosunat_tabla();
    tipocambiosunat_filtro();
	$("#for_tipcamsunat").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../tipocambio/tipocambiosunat_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_tipcamsunat").serialize(),
				beforeSend: function(){
					$('#div_tipocambiosunat_form').dialog("close");
					$('#msj_tipocambio').html("Guardando...");
					$('#msj_tipocambio').show(100);
				},
				success: function(data){

					$('#msj_tipocambio').html(data.tipcam_msj);
					<?php
					if($_POST['vista']=="cmb_tipcam_id")
					{
						echo $_POST['vista'].'(data.tipcam_id);';
					}
					?>
				},
				complete: function(){
					<?php
					if($_POST['vista']=="tipocambio_tabla")
					{
						echo $_POST['vista'].'();';
					}
					?>
				}
			});			
		},
		rules: {
            cmb_fil_anio: {
				required: true,
				dateITA: true
			},
            cmb_fil_mes: {
				required: true
			}
		},
		messages: {
            cmb_fil_anio: {
				required: '*'
			},
            cmb_fil_mes: {
				required: '*'
			}
		}
	});
	
});
</script>
<div id="div_tipocambiosunat_filtro" class="contenido_tabla">
</div>
<div id="msj_tipocambio" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
<form id="for_tipcamsunat">
<input name="action_tipocambio" id="action_tipocambio" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_tipcam_id" id="hdd_tipcam_id" type="hidden" value="<?php echo $_POST['tipcam_id']?>">

    <div id="div_tipocambiosunat_tabla" class="contenido_tabla">
    </div>
</form>



