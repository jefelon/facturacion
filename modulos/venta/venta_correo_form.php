<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../../config/datos.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once("../formatos/formato.php");


require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$logo_empresa = $dt['tb_empresa_logo'];
$email_empresa = $dt['tb_empresa_ema'];


$dts= $oVenta->mostrarUno($_POST['ven_id']);
$dt = mysql_fetch_array($dts);
$doc_id	=$dt['tb_documento_id'];
$doc_nom=$dt['tb_documento_nom'];
$ser	=$dt['tb_venta_ser'];
$num	=$dt['tb_venta_num'];

$cli_id	=$dt['tb_cliente_id'];
$cli_nom=$dt['tb_cliente_nom'];
$cli_doc=$dt['tb_cliente_doc'];

if($doc_nom=='FACTURA ELECTRONICA')$nom_arch.='../venta/venta_cfactura_reg.php';

if($doc_nom=='BOLETA ELECTRONICA')$nom_arch.='../venta/venta_cboleta_reg.php';
/*
$valven	=$dt['tb_venta_valven'];
$igv	=$dt['tb_venta_igv'];
$tot	=$dt['tb_venta_tot'];*/
mysql_free_result($dts);

if($cli_id>0){
    $dts=$oCliente->mostrarUno($cli_id);
    $dt = mysql_fetch_array($dts);
    //$tip=$dt['tb_cliente_tip'];
    $cli_nom=$dt['tb_cliente_nom'];
    $cli_doc=$dt['tb_cliente_doc'];
    //$dir=$dt['tb_cliente_dir'];

    $cli_con=$dt['tb_cliente_con'];
    $cli_tel=$dt['tb_cliente_tel'];
    $cli_ema=$dt['tb_cliente_ema'];

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

$key = 'RqvMXL87JGXZIfG9GCrR';

if($_POST['action']=='enviar')
{

    $periodo=str_pad($_POST['per_id'], 2, "0", STR_PAD_LEFT);
    $ejercicio=$_POST['eje_id'];

    $asu="$doc_nom $ser-$num | $empresa";
    $destinatario='Estimado Cliente:<br>'.$cli_nom.'<br>';


    $mentip="<p>Sírvase presionar los siguientes links para descargar su Comprobante de Pago Electrónico CPE:</p>";

    $mentip.="<p><strong>$doc_nom $ser-$num</strong></p>";

    $tabla.='';


    // $emisor="<p>Atentamente,</p>
    // $usuario_reg";
    $emisor="<p>Atentamente,</p>
	";

    $firma='
	<table align="left" border="0" cellpadding="1" cellspacing="1" style="width:100%">
		<tbody>
			<tr>
				<td style="width:20%"><img width="100" alt="Logo" src="../empresa/'. $logo_empresa .'" /></td>
				<td style="width:80%">
				Modulo de Consultas <a href="'.$d_documentos_app.'" target="_blank">'.$d_documentos_app.'</a>
				</td>
			</tr>
		</tbody>
	</table>';
    // $firma='
    // <table align="left" border="0" cellpadding="1" cellspacing="1" style="width:100%">
    // 	<tbody>
    // 		<tr>
    // 			<td style="width:20%"><img alt="Logo" src="../../images/logo.jpg" /></td>
    // 			<td style="width:80%">
    // 			Sitio Web <a href="http://www.granadosllantas.com/portal/" target="_blank">www.granadosllantas.com</a><br>
    // 			Facebook <a href="https://www.facebook.com/granadosllantas" target="_blank">www.facebook.com/granadosllantas</a>
    // 			</td>
    // 		</tr>
    // 	</tbody>
    // </table>';

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
        $("#for_ven_cor").validate({
            submitHandler: function() {
                var datos1=CKEDITOR.instances.txt_cor_men.getData();
                $("#txt_cor_men").val(datos1);
                //var dataString = $("#for_ven_cor").serialize();
                //var dataString2 = $("#for_fil_ven").serialize();
                //var datos = dataString+'&'+dataString2;
                //var datos = dataString;

                var fd = new FormData($("#for_ven_cor")[0]);



                if(confirm("Confirmar envío de correo?"))
                {
                    $.ajax({
                            type: "POST",
                            url: '<?php echo $nom_arch; ?>',
                            async:false,
                            dataType: "html",
                            data: ({
                                ven_id:	<?php echo $_POST['ven_id'];?>
                            }),
                            beforeSend: function() {
                                $('#msj_venta').html("Cargando archivos...");
                                $('#msj_venta').show(100);
                            },
                            success: function(html){
                                $('#msj_venta').html("Archivos cargados");
                            }
                        });


                    $.ajax({
                        type: "POST",
                        url: "../venta/venta_correo_reg.php",
                        async:false,
                        dataType: "json",
                        data: fd,
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend: function(){
                            $('#div_venta_correo_form').dialog("close");
                            $('#msj_venta').html("Enviando...");
                            $('#msj_venta').show(100);
                        },
                        success: function(data){
                            $('#msj_venta').html(data.ven_cor_msj);
                        },
                        complete: function(){
                            venta_tabla();
                        }
                    });

                }
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

    CKEDITOR.config.height = 380;
    CKEDITOR.replace('txt_cor_men');

</script>

<div>
    <form id="for_ven_cor">
        <input type="hidden" id="action_correo" name="action_correo" value="<?php echo $_POST['action']?>">
        <input type="hidden" id="hdd_rep_emp_id" name="hdd_rep_emp_id" value="<?php echo $_SESSION['empresa_id']?>">
        <input type="hidden" id="hdd_ven_id" name="hdd_ven_id" value="<?php echo $_POST['ven_id']?>" />
        <input type="hidden" id="hdd_cli_id" name="hdd_cli_id" value="<?php echo $cli_id?>" />

        <input type="hidden" id="hdd_cli_nom" name="hdd_cli_nom" value="<?php echo $cli_nom?>" />

        <table border="0" cellspacing="0" cellpadding="1" width="100%">

            <?php /*<tr>
      <td align="left">Destinatario:</td>
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
                <td align="left"><label for="txt_cli_ema">Destinatario:</label></td>
                <td><input type="text" name="txt_cli_ema" id="txt_cli_ema" size="77" value="<?php echo $cli_ema?>" /></td>
            </tr>
            <?php /*?>
    <tr>
      <td align="left"><label for="txt_cli_con">Nombre:</label></td>
      <td>
      	<input type="text" name="txt_cli_con" id="txt_cli_con" size="77" value="<?php echo $cli_con?>" readonly="true" />
      </td>
    </tr><?php */?>

            <tr>
                <td align="left">Cliente:</td>
                <td>
                    <input name="txt_cli_doc" type="text" id="txt_cli_doc" value="<?php echo $cli_doc?>" size="12" maxlength="11" readonly="true" />
                    <input type="text" id="txt_cli_nom" name="txt_cli_nom" size="62" value='<?php echo $cli_nom?>' readonly="true" />
                </td>
            </tr>

            <tr>
                <td align="left">&nbsp;</td>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td align="left"><label for="txt_cli_emacop">C. Copia:</label></td>
                <td><input type="text" name="txt_cli_emacop" id="txt_cli_emacop" size="77" value="<?php echo $cli_emacop?>"/></td>
            </tr>

            <?php /*
    <tr>
      <td align="left">Con Copia a:</td>
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
      <td align="left"><label for="txt_cli_emacop">Correo Copia:</label></td>
      <td><input type="text" name="txt_cli_emacop" id="txt_cli_emacop" size="77" value="<?php echo $cli_emacop?>" readonly="true" /></td>
    </tr>
    <tr>
      <td align="left"><label for="txt_cli_concop">Nombre:</label></td>
      <td>
      	<input type="text" name="txt_cli_concop" id="txt_cli_concop" size="51" value="<?php echo $cli_concop?>" readonly="true" />
      	<label for="txt_cli_carcop">Cargo:</label>
      	<input type="text" name="txt_cli_carcop" id="txt_cli_carcop" size="16" value="<?php echo $cli_carcop?>" readonly="true" />
      </td>
    </tr>

    <tr>
      <td align="left">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="left"><label for="fil_cor_adj">Adjuntar:</label></td>
      <td><input type="file" multiple="multiple" id="fil_cor_adj" name="fil_cor_adj[]" /></td>
    </tr>
    */ ?>
            <tr>
                <td align="left" height="30px"><label for="txt_cor_asu">Asunto:</label></td>
                <td><input type="text" name="txt_cor_asu" id="txt_cor_asu" size="77" style="font-size:10pt;" value="<?php echo $asu?>" /></td>
            </tr>
            <tr>
                <td align="left" valign="top"><label for="txt_cor_men">Mensaje</label></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><textarea name="txt_cor_men" cols="76" rows="7" id="txt_cor_men"><?php echo $men?></textarea></td>
            </tr>
        </table>
    </form>
</div>