<?php
$key = 'RqvMXL87JGXZIfG9GCrR';

session_start();
require_once ("../../config/Cado.php");
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once("../formatos/formato.php");

if($_POST['cli_id']>0){
	$dts=$oCliente->mostrarUno($_POST['cli_id']);
	$dt = mysql_fetch_array($dts);
		//$tip=$dt['tb_cliente_tip'];
		$cli_nom=$dt['tb_cliente_nom'];
		$cli_doc=$dt['tb_cliente_doc'];
		//$dir=$dt['tb_cliente_dir'];

		$cli_con=$dt['tb_cliente_con'];
		$cli_car=$dt['tb_cliente_car'];
		$cli_tel=$dt['tb_cliente_tel'];
		$cli_ema=$dt['tb_cliente_ema'];

		$cli_con1=$dt['tb_cliente_con1'];
		$cli_car1=$dt['tb_cliente_car1'];
		$$cli_tel1=$dt['tb_cliente_tel1'];
		$cli_ema1=$dt['tb_cliente_ema1'];

		$cli_con2=$dt['tb_cliente_con2'];
		$cli_car2=$dt['tb_cliente_car2'];
		$cli_tel2=$dt['tb_cliente_tel2'];
		$cli_ema2=$dt['tb_cliente_ema2'];

	mysql_free_result($dts);
}

//usuarios
if($_SESSION['usuario_id']>0)
{
	$dts=$oUsuario->mostrarUno($_SESSION['usuario_id']);
	$dt = mysql_fetch_array($dts);
		$usugru		=$dt['tb_usuariogrupo_id'];
		$usugru_nom	=$dt['tb_usuariogrupo_nom'];
		$usu_nom	=$dt['tb_usuario_nom'];
		$apepat		=$dt['tb_usuario_apepat'];
		$apemat		=$dt['tb_usuario_apemat'];
		$ema		=$dt['tb_usuario_ema'];

		$fircor		=$dt['tb_usuario_fircor'];
	
	mysql_free_result($dts);
	
	$usuario_reg="$usu_nom $apepat $apemat";
}

$empresa=$_SESSION['empresa_nombre'];


if($_POST['action']=='enviar')
{

	$periodo=str_pad($_POST['per_id'], 2, "0", STR_PAD_LEFT);
	$ejercicio=$_POST['eje_id'];

	$asu='FACTURACIÓN ELECTRÓNICA - '.$empresa;
	$destinatario='Estimado(a) cliente:<br>'.$cli_nom.'<br>';
	$titulo='FACTURA ELECTRÓNICA';


	$mentip="<p>Sírvase presionar el link para descargar los documentos:</p>";
	$mentip.='<a href="../venta/pre_cargarPDF.php?id_factura='.md5($key.$_POST['venta_id']).'&action=paraAhora">Descargar PDF</a><br/>';
	$mentip.='<a href="../venta/pre_cargarXML.php?id_factura='.md5($key.$_POST['venta_id']).'&action=paraAhora">Descargar XML</a><br/>';
	
	
 
	$tabla.='';


	$emisor="<p>Atentamente,</p>
	$fircor";

	$firma='
	<table align="left" border="0" cellpadding="1" cellspacing="1" style="width:100%">
		<tbody>
			<tr>
				<td style="width:20%"><img alt="Logo" src="../../images/logo.jpg" /></td>
				<td style="width:80%">
				Sitio Web <a href="http://www.granadosllantas.com/portal/" target="_blank">www.granadosllantas.com</a><br>
				Facebook <a href="https://www.facebook.com/granadosllantas" target="_blank">www.facebook.com/granadosllantas</a>
				</td>
			</tr>
		</tbody>
	</table>';

	$men=$destinatario.''.$mentip.''.$tabla.''.$emisor.''.$firma;
}

/*if($_POST['action']=='reenviar')
{
	if($_POST['guipagnot_id']>0){
		$dts=$oGuiapagonota->mostrarUno($_POST['guipagnot_id']);
		$dt = mysql_fetch_array($dts);
			$asu=trim($dt['tb_guiapagonota_asu']);
			$men=$dt['tb_guiapagonota_men'];
			$cor=trim($dt['tb_guiapagonota_cor']);
		mysql_free_result($dts);

		if($cor==$cli_ema){
			$cli_con=$cli_con;
			$cli_car=$cli_car;
			$cli_tel=$cli_tel;
			$cli_ema=$cli_ema;
		}
		elseif($cor==$cli_ema1){
			$cli_con=$cli_con1;
			$cli_car=$cli_car1;
			$cli_tel=$cli_tel1;
			$cli_ema=$cli_ema1;
		}
		elseif($cor==$cli_ema2){
			$cli_con=$cli_con2;
			$cli_car=$cli_car2;
			$cli_tel=$cli_tel2;
			$cli_ema=$cli_ema2;
		}
		else
		{
			$cli_con='';
			$cli_car='';
			$cli_tel='';
			$cli_ema=$coremi;
		}
	}
}*/
?>


<script type="text/javascript">
$('.btn_action').button({
    //icons: {primary: "ui-icon-email"},
    text: true
});

function destinatario(num)
{	
	if(num==1)
	{
		$('#txt_cli_con').attr('readonly', true);
		$('#txt_cli_ema').attr('readonly', true);
		$('#txt_cli_con').val('<?php echo $cli_con?>');
		$('#txt_cli_car').val('<?php echo $cli_car?>');
		$('#txt_cli_ema').val('<?php echo $cli_ema?>');
	} 
	if(num==2)
	{
		$('#txt_cli_con').attr('readonly', true);
		$('#txt_cli_ema').attr('readonly', true);
		$('#txt_cli_con').val('<?php echo $cli_con1?>');
		$('#txt_cli_car').val('<?php echo $cli_car1?>');
		$('#txt_cli_ema').val('<?php echo $cli_ema1?>');
	} 
	if(num==3)
	{
		$('#txt_cli_con').attr('readonly', true);
		$('#txt_cli_ema').attr('readonly', true);
		$('#txt_cli_con').val('<?php echo $cli_con2?>');
		$('#txt_cli_car').val('<?php echo $cli_car2?>');
		$('#txt_cli_ema').val('<?php echo $cli_ema2?>');
	} 
	if(num=="")
	{
		$('#txt_cli_con').val('');
		$('#txt_cli_car').val('');
		$('#txt_cli_ema').val('');
		$('#txt_cli_con').attr('readonly', false);
		$('#txt_cli_ema').attr('readonly', false);
		$('#txt_cli_ema').focus();
	}    
}

function destinatario_copia(num)
{	
	if(num==1)
	{
		$('#txt_cli_concop').attr('readonly', true);
		$('#txt_cli_emacop').attr('readonly', true);
		$('#txt_cli_concop').val('<?php echo $cli_con?>');
		$('#txt_cli_carcop').val('<?php echo $cli_car?>');
		$('#txt_cli_emacop').val('<?php echo $cli_ema?>');
	} 
	if(num==2)
	{
		$('#txt_cli_concop').attr('readonly', true);
		$('#txt_cli_emacop').attr('readonly', true);
		$('#txt_cli_concop').val('<?php echo $cli_con1?>');
		$('#txt_cli_carcop').val('<?php echo $cli_car1?>');
		$('#txt_cli_emacop').val('<?php echo $cli_ema1?>');
	} 
	if(num==3)
	{
		$('#txt_cli_concop').attr('readonly', true);
		$('#txt_cli_emacop').attr('readonly', true);
		$('#txt_cli_concop').val('<?php echo $cli_con2?>');
		$('#txt_cli_carcop').val('<?php echo $cli_car2?>');
		$('#txt_cli_emacop').val('<?php echo $cli_ema2?>');
	} 
	if(num=="")
	{
		$('#txt_cli_concop').val('');
		$('#txt_cli_carcop').val('');
		$('#txt_cli_emacop').val('');
		$('#txt_cli_concop').attr('readonly', false);
		$('#txt_cli_emacop').attr('readonly', false);
		$('#txt_cli_emacop').focus();
	}    
}

$(function() {

//formulario			
	$("#for_procon_cor").validate({
		submitHandler: function() {
			var datos1=CKEDITOR.instances.txt_cor_men.getData();
			$("#txt_cor_men").val(datos1);
			//var dataString = $("#for_procon_cor").serialize();
			//var dataString2 = $("#for_fil_ven").serialize();
			//var datos = dataString+'&'+dataString2;
			//var datos = dataString;

			var fd = new FormData($("#for_procon_cor")[0]);

			$.ajax({
				type: "POST",
				url: "../guiapagocontrol/guiapagocontrol_correo_reg.php",
				async:true,
				dataType: "json",
				data: fd,
				cache: false,
				processData: false,
      			contentType: false,
				beforeSend: function(){
					$('#div_guiapagocontrol_correo_form').dialog("close");
					$('#msj_guiapagocontrol').html("Enviando...");
					$('#msj_guiapagocontrol').show(100);
				},
				success: function(data){
					$('#msj_guiapagocontrol').html(data.guipagnot_cor_msj);
				},
				complete: function(){
					guiapagocontrol_tabla();
				}
			});			
		},
		rules: {
			txt_cli_doc: {
				required: true
			},
			txt_cli_nom: {
				required: true
			},
			txt_cli_con: {
				required: true
			},
			txt_cli_ema: {
				required: true,
				email: true
			},
			txt_cli_emacop: {
				email: true
			},
			txt_cor_asu: {
				required: true
			},
			txt_cor_men: {
				required: false
			},
			fil_cor_adj: {
				required: false,
				//accept:'docx?|txt|pdf'
			}
		},
		messages: {
			txt_cli_doc: {
				required: '*'
			},
			txt_cli_nom: {
				required: '*'
			},
			txt_cli_con: {
				required: '*'
			},
			txt_cli_ema: {
				required: '*',
				email: 'Email¿?'
			},
			txt_cli_emacop: {
				email: 'Email¿?'
			},
			txt_cor_asu: {
				required: '*'
			},
			txt_cor_men: {
				required: '*'
			},
			fil_cor_adj: {
				required: '*'
			}
		}
	});

});
</script>
<script>
/*CKEDITOR.config.toolbar = [
	{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	{ name: 'editing', items: ['Scayt' ] },
	{ name: 'links', items: [ 'Link', 'Unlink'] },
	{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule'] },
	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks', '-', 'Source'] },
	'/',
	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', '-', 'RemoveFormat' ] },
	{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] }
];*/

CKEDITOR.config.toolbar = [
	{ name: 'basicstyles', items: [ 'Bold', 'Italic', '-', 'RemoveFormat' ] },
	{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
	{ name: 'links', items: [ 'Link', 'Unlink' ] },
	{ name: 'insert', items: [ 'Image','Table', 'HorizontalRule' ] },
	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	{ name: 'document', items: ['Maximize','-', 'Source' ] }
];

CKEDITOR.config.height = 300; 
CKEDITOR.replace('txt_cor_men');

</script>

<div>
<form id="for_procon_cor">
<input type="hidden" id="action_correo" name="action_correo" value="<?php echo $_POST['action']?>">
<input type="hidden" id="hdd_rep_emp_id" name="hdd_rep_emp_id" value="<?php echo $_SESSION['empresa_id']?>">
<input type="hidden" id="hdd_cli_id" name="hdd_cli_id" value="<?php echo $_POST['cli_id']?>" />
<input type="hidden" id="hdd_per_id" name="hdd_per_id" value="<?php echo $_POST['per_id']?>" />
<input type="hidden" id="hdd_eje_id" name="hdd_eje_id" value="<?php echo $_POST['eje_id']?>" />
<input type="hidden" id="hdd_cli_nom" name="hdd_cli_nom" value="<?php echo $cli_nom?>" />

<fieldset>
<legend>Información General</legend>
  <table border="0" cellspacing="0" cellpadding="1" width="100%">

    <?php /*<tr>
      <td align="right">Destinatario:</td>
      <td>
      	<?php if($cli_ema!=""){?>
      	<a class="btn_action" href="#des" onclick="destinatario('1')"><?php echo $cli_con?></a>
      	<?php }?>
      	<?php if($cli_ema1!=""){?>
      	<a class="btn_action" href="#des" onclick="destinatario('2')"><?php echo $cli_con1?></a>
      	<?php }?>
      	<?php if($cli_ema2!=""){?>
      	<a class="btn_action" href="#des" onclick="destinatario('3')"><?php echo $cli_con2?></a>
      	<?php }?>
      	<a class="btn_action" href="#des" onclick="destinatario('')">Ingresar</a>
      </td>
    </tr> */?>

    <tr>
      <td align="right"><label for="txt_cli_ema">Correo:</label></td>
      <td><input type="text" name="txt_cli_ema" id="txt_cli_ema" size="77" value="<?php echo $cli_ema?>" /></td>
    </tr>
    <tr>
      <td align="right"><label for="txt_cli_con">Nombre:</label></td>
      <td>
      	<input type="text" name="txt_cli_con" id="txt_cli_con" size="51" value="<?php echo $cli_con?>" readonly="true" />
      	<label for="txt_cli_car">Cargo:</label>
      	<input type="text" name="txt_cli_car" id="txt_cli_car" size="16" value="<?php echo $cli_car?>" readonly="true" />
      </td>
    </tr>

    <tr>
    	<td align="right">Cliente:</td>
    	<td>
    		<input name="txt_cli_doc" type="text" id="txt_cli_doc" value="<?php echo $cli_doc?>" size="12" maxlength="11" readonly="true" />
    		<input type="text" id="txt_cli_nom" name="txt_cli_nom" size="61" value='<?php echo $cli_nom?>' readonly="true" />
    	</td>
    </tr>

	<?php /*<tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>

    <tr>
      <td align="right">Con Copia a:</td>
      <td>
      	<?php if($cli_ema!=""){?>
      	<a class="btn_action" href="#des" onclick="destinatario_copia('1')"><?php echo $cli_con?></a>
      	<?php }?>
      	<?php if($cli_ema1!=""){?>
      	<a class="btn_action" href="#des" onclick="destinatario_copia('2')"><?php echo $cli_con1?></a>
      	<?php }?>
      	<?php if($cli_ema2!=""){?>
      	<a class="btn_action" href="#des" onclick="destinatario_copia('3')"><?php echo $cli_con2?></a>
      	<?php }?>
      	<a class="btn_action" href="#des" onclick="destinatario_copia('')">Ingresar</a>
      </td>
    </tr>

    <tr>
      <td align="right"><label for="txt_cli_emacop">Correo Copia:</label></td>
      <td><input type="text" name="txt_cli_emacop" id="txt_cli_emacop" size="77" value="<?php echo $cli_emacop?>" readonly="true" /></td>
    </tr>
    <tr>
      <td align="right"><label for="txt_cli_concop">Nombre:</label></td>
      <td>
      	<input type="text" name="txt_cli_concop" id="txt_cli_concop" size="51" value="<?php echo $cli_concop?>" readonly="true" />
      	<label for="txt_cli_carcop">Cargo:</label>
      	<input type="text" name="txt_cli_carcop" id="txt_cli_carcop" size="16" value="<?php echo $cli_carcop?>" readonly="true" />
      </td>
    </tr>

    <tr>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right"><label for="fil_cor_adj">Adjuntar:</label></td>
      <td><input type="file" multiple="multiple" id="fil_cor_adj" name="fil_cor_adj[]" /></td>
    </tr>
    */ ?>
    <tr>
      <td align="right" height="30px"><label for="txt_cor_asu">Asunto:</label></td>
      <td><input type="text" name="txt_cor_asu" id="txt_cor_asu" size="77" style="font-size:10pt;" value="<?php echo $asu?>" /></td>
    </tr>
    <tr>
      <td align="right" valign="top"><label for="txt_cor_men">Mensaje:</label></td>
      <td><textarea name="txt_cor_men" cols="76" rows="7" id="txt_cor_men"><?php echo $men?></textarea></td>
    </tr>
  </table>
</fieldset>
</form>

</div>