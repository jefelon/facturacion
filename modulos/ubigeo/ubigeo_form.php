<?php
require_once ("../../config/Cado.php");
require_once ("cUbigeo.php");
$oUbigeo = new cUbigeo();

if($_POST['action']=="editar")
{
	$dts=$oUbigeo->mostrarUno($_POST['ubi_id']);
	$dt = mysql_fetch_array($dts);
		$coddep=$dt['tb_ubigeo_coddep'];
		$codpro=$dt['tb_ubigeo_codpro'];
		$coddis=$dt['tb_ubigeo_coddis'];
		$nom=$dt['tb_ubigeo_nom'];
		$tip=$dt['tb_ubigeo_tip'];
	mysql_free_result($dts);
}
?>
<script type="text/javascript">
function cargar_cmb_ubigeo_dep($ubigeo_dep)
{	
	$.ajax({
		type: "POST",
		url: "cmb_ubigeo.php",
		async:true,
		dataType: "html",                      
		data: ({
			tip: "Departamento",
			coddep: '00',
			codpro: '00',
			ubigeo: $ubigeo_dep
		}),
		success: function(html){
			$('#cmb_ubigeo_dep').html(html);
		}, 
	});
}

function cargar_cmb_ubigeo_pro(ubigeo_dep,ubigeo_pro)
{	
	$.ajax({
		type: "POST",
		url: "cmb_ubigeo.php",
		async:true,
		dataType: "html",                      
		data: ({
			tip:	'Provincia',
			coddep: ubigeo_dep,
			codpro: '00',
			ubigeo: ubigeo_pro
		}),
		success: function(html){
			$('#cmb_ubigeo_pro').html(html);
		}, 
	});
}

function tipoEdicion(tipo)
{
	if(tipo=='Departamento')
	{
		$("#cmb_ubigeo_dep").attr('disabled',true);
		$("#cmb_ubigeo_pro").attr('disabled',true);
		
		$("#txt_ubigeo_codpro").attr('value','00');
		$("#txt_ubigeo_coddis").attr('value','00');
		
		$("#txt_ubigeo_codpro").attr('readonly',true);
		$("#txt_ubigeo_coddis").attr('readonly',true);
		
		cargar_cmb_ubigeo_dep('00');
		cargar_cmb_ubigeo_pro('00','00');
	}
	
	if(tipo=='Provincia')
	{
		cargar_cmb_ubigeo_dep();
		cargar_cmb_ubigeo_pro('00','00');
		$("#cmb_ubigeo_dep").attr('disabled',false);
		$("#cmb_ubigeo_pro").attr('disabled',true);
		
		$("#txt_ubigeo_codpro").attr('value','');
		$("#txt_ubigeo_coddis").attr('value','00');
		
		$("#txt_ubigeo_codpro").attr('readonly',false);
		$("#txt_ubigeo_coddis").attr('readonly',true);
	}
	if(tipo=='Distrito')
	{
		cargar_cmb_ubigeo_dep();
		$("#cmb_ubigeo_dep").attr('disabled',false);
		$("#cmb_ubigeo_pro").attr('disabled',false);
		
		$("#txt_ubigeo_codpro").attr('value','');
		$("#txt_ubigeo_coddis").attr('value','');
		
		$("#txt_ubigeo_codpro").attr('readonly',false);
		$("#txt_ubigeo_coddis").attr('readonly',false);
	}
}

$('#cmb_ubigeo_tip').change(function() {			
	tipoEdicion($('#cmb_ubigeo_tip').val());		
});

$('#cmb_ubigeo_dep').change(function() {
	$("#txt_ubigeo_coddep").attr("value", $('#cmb_ubigeo_dep').val());
	cargar_cmb_ubigeo_pro($('#cmb_ubigeo_dep').val());
	$("#txt_ubigeo_codpro").attr("value", "");	
});
$('#txt_ubigeo_coddep').change(function() {
	var dato=$('#txt_ubigeo_coddep').val();
	cargar_cmb_ubigeo_dep(dato);
	//cargar_cmb_ubigeo_pro($('#cmb_ubigeo_dep').val());
	//$("#txt_ubigeo_codpro").attr("value", "");
});


$('#cmb_ubigeo_pro').change(function() {
	$("#txt_ubigeo_codpro").attr("value", $('#cmb_ubigeo_pro').val());	
});
$('#txt_ubigeo_codpro').change(function() {
	var dato=$('#txt_ubigeo_codpro').val();
	cargar_cmb_ubigeo_pro($('#cmb_ubigeo_dep').val(),dato);
});

<?php
if($_POST['action']=="editar" and $tip=='Distrito'){
?>
	//tipoEdicion('<?php //echo $tip?>');
    cargar_cmb_ubigeo_dep('<?php echo $coddep?>');
	cargar_cmb_ubigeo_pro('<?php echo $coddep?>','<?php echo $codpro?>');
	//$("#cmb_ubigeo_dep").attr('disabled',true);
	//$("#cmb_ubigeo_pro").attr('disabled',true);
	$("#txt_ubigeo_codpro").attr("value","<?php echo $codpro?>");
	$("#txt_ubigeo_coddis").attr("value","<?php echo $coddis?>");
<?php 
}
if($_POST['action']=="editar" and $tip=='Provincia'){
?>
	//tipoEdicion('<?php //echo $tip?>');
    cargar_cmb_ubigeo_dep('<?php echo $coddep?>');
	cargar_cmb_ubigeo_pro('<?php echo $coddep?>','<?php echo $codpro?>');
	//$("#cmb_ubigeo_dep").attr('disabled',true);
	$("#cmb_ubigeo_pro").attr('disabled',true);
	$("#txt_ubigeo_codpro").attr("value","<?php echo $codpro?>");
	$("#txt_ubigeo_coddis").attr("value","<?php echo $coddis?>");
<?php 
}
if($_POST['action']=="editar" and $tip=='Departamento'){
?>
	//tipoEdicion('<?php //echo $tip?>');
    cargar_cmb_ubigeo_dep('<?php echo $coddep?>');
	cargar_cmb_ubigeo_pro('<?php echo $coddep?>','<?php echo $codpro?>');
	$("#cmb_ubigeo_dep").attr('disabled',true);
	$("#cmb_ubigeo_pro").attr('disabled',true);
	$("#txt_ubigeo_codpro").attr("value","<?php echo $codpro?>");
	$("#txt_ubigeo_coddis").attr("value","<?php echo $coddis?>");
<?php 
}
?>

$(function() {

	//cargar_cmb_ubigeo_dep();
	//cargar_cmb_ubigeo_pro();

	$("#for_ubigeo").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "ubigeo_reg.php",
				async:true,
				dataType: "html",
				data: ({
					action:				$('#action').val(),
					hdd_ubigeo_id:		$('#hdd_ubigeo_id').val(),
					txt_ubigeo_coddep:	$('#txt_ubigeo_coddep').val(),
					txt_ubigeo_codpro:	$('#txt_ubigeo_codpro').val(),
					txt_ubigeo_coddis:	$('#txt_ubigeo_coddis').val(),
					txt_ubigeo_nom:		$('#txt_ubigeo_nom').val(),
					cmb_ubigeo_tip:		$('#cmb_ubigeo_tip').val()	
				}),
				beforeSend: function() {
					$("#div_ubigeo_form" ).dialog( "close" );
					$('#msj_ubigeo').html("Guardando...");
					$('#msj_ubigeo').show(100);
				},
				success: function(html){
					$('#msj_ubigeo').html(html);
				},
				complete: function(){
					ubigeo_tabla();
				}
			});
		},
		rules: {
			txt_ubigeo_coddep: {
				required: true,
				minlength: 2,
				digits: true
			},
			txt_ubigeo_codpro: {
				required: true,
				minlength: 2,
				digits: true
			},
			txt_ubigeo_coddis: {
				required: true,
				minlength: 2,
				maxlength: 2,
				digits: true
			},
			txt_ubigeo_nom: {
				required: true
			},
			cmb_ubigeo_tip: {
				required: true
			}
		},
		messages: {
			txt_ubigeo_coddep: {
				required: '*'
			},
			txt_ubigeo_codpro: {
				required: '*'
			},
			txt_ubigeo_coddis: {
				required: '*'
			},
			txt_ubigeo_nom: {
				required: '*'
			},
			cmb_ubigeo_tip: {
				required: '*'
			}
		}
	});
});
</script>

<form id="for_ubigeo">
<input name="action" id="action" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_ubigeo_id" id="hdd_ubigeo_id" type="hidden" value="<?php echo $_POST['ubi_id']?>">
    <table>
        <tr>
          <td align="right"><label for="cmb_ubigeo_tip">Tipo:</label></td>
          <td><select name="cmb_ubigeo_tip" id="cmb_ubigeo_tip">
          <option value="" selected>-seleccione-</option>
            <option value="Departamento" <?php if($tip=='Departamento') echo 'selected'?>>Departamento</option>
            <option value="Provincia" <?php if($tip=='Provincia') echo 'selected'?>>Provincia</option>
            <option value="Distrito" <?php if($tip=='Distrito') echo 'selected'?>>Distrito</option>
          </select></td>
        </tr>
        <tr>
          <td align="right"><label for="txt_ubigeo_coddep">Código Departamento:</label></td>
          <td>
          <input name="txt_ubigeo_coddep" type="text" id="txt_ubigeo_coddep" value="<?php echo $coddep?>" size="5" maxlength="2">
          <select name="cmb_ubigeo_dep" id="cmb_ubigeo_dep">
          </select></td>
        </tr>
        <tr>
          <td align="right"><label for="txt_ubigeo_codpro">Código Provincia:</label></td>
          <td><input name="txt_ubigeo_codpro" type="text" id="txt_ubigeo_codpro"value="<?php echo $codpro?>" size="5" maxlength="2">
            <select name="cmb_ubigeo_pro" id="cmb_ubigeo_pro">
          </select></td>
        </tr>
        <tr>
          <td align="right"><label for="txt_ubigeo_coddis">Código Distrito:</label></td>
          <td><input name="txt_ubigeo_coddis" type="text" id="txt_ubigeo_coddis"value="<?php echo $coddis?>" size="5" maxlength="2"></td>
        </tr>
        <tr>
        <td align="right"><label for="txt_ubigeo_nom">Nombre:</label></td>
        <td><input name="txt_ubigeo_nom" type="text" id="txt_ubigeo_nom" value="<?php echo $nom?>" size="50" maxlength="50"></td>
        </tr>
    </table>

</form>