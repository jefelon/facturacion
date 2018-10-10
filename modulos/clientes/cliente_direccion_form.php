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


$(function() {
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

    $("#for_dir").validate({
        submitHandler: function() {
            $.ajax({
                type: "POST",
                url: "../clientes/cliente_direccion_reg.php",
                async:true,
                dataType: "json",
                data: $("#for_dir").serialize(),
                beforeSend: function() {
                    $("#div_direccion_form" ).dialog( "close" );
                    // $('#msj_marca').html("Guardando...");
                    // $('#msj_marca').show(100);
                },
                success: function(data){
                   // $( "#cmb_cli_suc" ).html('venta');
                },
                complete: function(){

                    cmb_dir_id($( "#hdd_cli_id" ).val());
                    
                }
            });
        },
        rules: {
            txt_cli_nom: {
                required: true
            }
        },
        messages: {
            txt_cli_nom: {
                required: '*'
            }
        }
    });
});
</script>
<form id="for_dir">
<input name="action_direccion" id="action_direccion" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_cli_id" id="hdd_cli_id" type="hidden" value="<?php echo $_POST['cli_id']?>">
    <table>
        <tr>
    	  <td align="right" valign="top"><label for="txt_cli_nom">Dirección:</label></td>
    	  <td><textarea name="txt_cli_direccion" cols="40" rows="2" id="txt_cli_direccion"><?php echo $nom?></textarea></td>
  	  </tr>
    </table>
</form>