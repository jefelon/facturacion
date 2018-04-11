<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

if($_POST['action']=="editar")
{
	$dts=$oPuntoventa->mostrarUno($_POST['punven_id']);
	$dt = mysql_fetch_array($dts);
		$punven_nom=$dt['tb_puntoventa_nom'];
		$alm_id=$dt['tb_almacen_id'];
		$emp_id=$dt['tb_empresa_id'];
	mysql_free_result($dts);
}
?>

<script type="text/javascript">

    function cmb_pv_emp_id(idf) {
        $.ajax({
            type: "POST",
            url: "../empresa/cmb_emp_id.php",
            async: true,
            dataType: "html",
            data: ({
                emp_id: idf
            }),
            beforeSend: function () {
                $('#cmb_pv_emp_id').html('<option value="">Cargando...</option>');
            },
            success: function (html) {
                $('#cmb_pv_emp_id').html(html);
            },
        });
    }

function cmb_alm_id()
{	
	$.ajax({
		type: "POST",
		url: "../almacen/cmb_alm_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			alm_id: '<?php echo $alm_id?>'
		}),
		beforeSend: function() {
			$('#cmb_alm_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_alm_id').html(html);
		}
	});
}

$(function() {
    cmb_pv_emp_id('<?php echo $emp_id?>');

	$('#txt_punven_nom').keyup(function(){
		$(this).val($(this).val().toUpperCase());
	});
	
	cmb_alm_id();

	$("#for_punven").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../puntoventa/puntoventa_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_punven").serialize(),
				beforeSend: function() {
					$("#div_puntoventa_form" ).dialog( "close" );
					$('#msj_puntoventa').html("Guardando...");
					$('#msj_puntoventa').show(100);
				},
				success: function(html){						
					$('#msj_puntoventa').html(html);
				},
				complete: function(){
					<?php
					if($_POST['vista']=="puntoventa_tabla")
					{
						echo $_POST['vista'].'()';
					}
					
					if($_POST['vista']=="cmb_punven_id")
					{
						echo $_POST['vista'].'()';
					}
					?>
				}
			});
		},
		rules: {
			txt_punven_nom: {
				required: true
			},
			cmb_alm_id: {
				required: true
			}
		},
		messages: {
			txt_punven_nom: {
				required: '*'
			},
			cmb_alm_id: {
				required: '*'
			}
		}
	});
});
</script>
<form id="for_punven">
<input name="action_puntoventa" id="action_puntoventa" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_punven_id" id="hdd_punven_id" type="hidden" value="<?php echo $_POST['punven_id']?>">
    <table>
        <tr>
            <td><label for="cmb_pv_emp_id">Empresa:</label></td>
        </tr>
        <tr>
            <td><select name="cmb_pv_emp_id" id="cmb_pv_emp_id" <?php if($_SESSION['usuariogrupo_id']==2)echo 'disabled'?>>
                </select></td>
        </tr>
        <tr>
          <td><label for="txt_punven_nom">Nombre:</label></td>
        </tr>
        <tr>
        <td><input name="txt_punven_nom" type="text" id="txt_punven_nom" value="<?php echo $punven_nom?>" size="55" maxlength="50"></td>
        </tr>
        <tr>
          <td><label for="cmb_alm_id">Almacén para ventas:</label></td>
        </tr>
        <tr>
          <td><select name="cmb_alm_id" id="cmb_alm_id">
          </select></td>
        </tr>
    </table>
</form>