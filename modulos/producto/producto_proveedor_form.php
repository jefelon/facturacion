<?php
require_once("../../config/Cado.php");
require_once("cProducto.php");
$oProducto = new cProducto();
require_once("../proveedor/cProveedor.php");
$oProveedor = new cProveedor();
require_once("../formatos/formato.php");

$dts= $oProducto->mostrarUno($_POST['pro_id']);
//$dts= $oProducto->mostrarUno(6);
$dt = mysql_fetch_array($dts);
$pro_nom	=$dt['tb_producto_nom'];
$pro_des	=$dt['tb_producto_des'];
$pro_est	=$dt['tb_producto_est'];
mysql_free_result($dts);

//$dts = $oProveedor->mostrarUno($_POST['prov_id']);
//$dt = mysql_fetch_array($dts);
//$tip = $dt['tb_proveedor_tip'];
//$nom = $dt['tb_proveedor_nom'];
//$doc = $dt['tb_proveedor_doc'];
//$dir = $dt['tb_proveedor_dir'];
//$con = $dt['tb_proveedor_con'];
//$tel = $dt['tb_proveedor_tel'];
//$ema = $dt['tb_proveedor_ema'];
//mysql_free_result($dts);

?>
<script type="text/javascript">

    $(function() {

        <?php
        if($_POST['action']=="insertar")
        {
        ?>
        $('#txt_mar_nom').focus();
        <?php }?>

        $('#txt_mar_nom').keyup(function(){
            $(this).val($(this).val().toUpperCase());
        });

        // $("#for_prodprov").validate({
        //     submitHandler: function() {
        //         $.ajax({
        //             type: "POST",
        //             url: "../marca/productoproveedor_reg.php",
        //             async:true,
        //             dataType: "json",
        //             data: $("#for_mar").serialize(),
        //             beforeSend: function() {
        //                 $("#div_marca_form" ).dialog( "close" );
        //                 $('#msj_marca').html("Guardando...");
        //                 $('#msj_marca').show(100);
        //             },
        //             success: function(data){
        //
        //             },
        //             complete: function(){
        //
        //             }
        //         });
        //     },
        //     rules: {
        //         txt_mar_nom: {
        //             required: true
        //         }
        //     },
        //     messages: {
        //         txt_mar_nom: {
        //             required: '*'
        //         }
        //     }
        // });
    });
</script>
 <form id="for_prodprov">
        <input name="action_marca" id="action_marca" type="hidden" value="<?php echo $_POST['action']?>">
        <input name="hdd_mar_id" id="hdd_mar_id" type="hidden" value="<?php echo $_POST['pro_id']?>">
        <table>
        <tr>
        <td align="right" valign="top">Nombre:</td>
        <td><input name="txt_mar_nom" type="text" id="txt_mar_nom" value="<?php echo $pro_nom?> " size="55" maxlength="50"></td>
        </tr>
        </table>
</form>