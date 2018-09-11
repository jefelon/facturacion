<?php
require_once("../../config/Cado.php");
require_once("cProducto.php");
$oProducto = new cProducto();
require_once("../proveedor/cProveedor.php");
$oProveedor = new cProveedor();
require_once("../formatos/formato.php");


$fec=date('d-m-Y');
if ($_POST['action'] == "editar") {
    $dts = $oProveedor->mostrarUno($_POST['prov_id']);
    $dt = mysql_fetch_array($dts);
    $tip = $dt['tb_proveedor_tip'];
    $nom = $dt['tb_proveedor_nom'];
    $doc = $dt['tb_proveedor_doc'];
    $dir = $dt['tb_proveedor_dir'];
    $con = $dt['tb_proveedor_con'];
    $tel = $dt['tb_proveedor_tel'];
    $ema = $dt['tb_proveedor_ema'];
    mysql_free_result($dts);
}
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

        $('.venpag_moneda').autoNumeric({
            aSep: ',',
            aDec: '.',
            //aSign: 'S/. ',
            //pSign: 's',
            vMin: '0.00'
        });

        $( "#txt_fecha_ini, #txt_fecha_fin" ).datepicker({
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

        $("#for_prodprov").validate({
            submitHandler: function() {
                $.ajax({
                    type: "POST",
                    url: "../producto/proveedor_producto_reg.php",
                    async:true,
                    dataType: "html",
                    data: $("#for_prodprov").serialize(),
                    beforeSend: function(){
                        $('#div_producto_proveedor_form').dialog("close");
                        $('#msj_producto_proveedor').html("Guardando...");
                        $('#msj_producto_proveedor').show(100);
                    },
                    success: function(html){
                        $('#msj_producto_proveedor').html(html);
                        producto_proveedor();

                    },
                    complete: function(){
                        // $('#msj_producto').html("Agregado");
                    }
                });
            },
            rules: {
                hdd_com_prod_id: {
                    required: true
                },
                hdd_com_prov_id: {
                    required: true
                },
                txt_com_prov_nom: {
                    required: true
                },
                txt_com_prov_doc: {
                    required: true
                },
                txt_cat_min: {
                    required: true
                },
                txt_desc_prov: {
                    required: true
                },
                txt_fecha_ini: {
                    required: true
                },
                txt_fecha_fin: {
                    required: true
                }
            },
            messages: {
                hdd_com_prod_id: {
                    required: '*'
                },
                hdd_com_prov_id: {
                    required: true
                },
                txt_com_prov_nom: {
                    required: '*'
                },
                txt_com_prov_doc: {
                    required: '*'
                },
                txt_cat_min: {
                    required: '*'
                },
                txt_desc_prov: {
                    required: '*'
                },
                txt_fecha_ini: {
                    required: '*'
                },
                txt_fecha_fin: {
                    required: '*'
                }
            }
        });

        $( "#txt_com_prov_nom").autocomplete({
            minLength: 1,
            source: "../proveedor/proveedor_complete_nom.php",
            select: function(event, ui){
                $("#hdd_com_prov_id").val(ui.item.id);
                $("#txt_com_prov_doc").val(ui.item.documento);
                $("#txt_com_prov_nom").val(ui.item.nombre);
            }

        });

        $( "#txt_com_prov_doc" ).autocomplete({
            minLength: 1,
            source: "../proveedor/proveedor_complete_doc.php",
            select: function(event, ui){
                $("#hdd_com_prov_id").val(ui.item.id);
                $("#txt_com_prov_nom").val(ui.item.nombre);
                $("#txt_com_prov_doc").val(ui.item.documento);
            }

        });
    });
</script>
<form id="for_prodprov">
    <input name="action_proveedor_producto" id="action_proveedor_producto" type="hidden" value="<?php echo $_POST['action'] ?>">
    <input name="hdd_com_prov_id" id="hdd_com_prov_id" type="hidden">
    <input name="hdd_com_prod_id" id="hdd_com_prod_id" type="hidden" value="<?php echo $_POST['prod_id'] ?>">
    <table>
        <tr>
            <td><label for="txt_com_prov_nom">Nombre:</label></td>
            <td><input type="text" id="txt_com_prov_nom" name="txt_com_prov_nom" size="40"/></td>
        </tr>
        <tr>
            <td><label for="txt_com_prov_doc">RUC/DNI:</label></td>
            <td><input type="text" id="txt_com_prov_doc" name="txt_com_prov_doc" size="11"></td>
        </tr>
        <tr>
            <td><label for="txt_cat_min">Cantidad Minima:</label></td>
            <td><input type="text" id="txt_cat_min" name="txt_cat_min" class="venpag_moneda" size="40"/></td>
        </tr>
        <tr>
            <td><label for="txt_desc_prov">Descuento:</label></td>
            <td><input type="text" id="txt_desc_prov" name="txt_desc_prov" class="venpag_moneda" size="40"/></td>
        </tr>
        <tr>
            <td><label for="txt_fecha_ini">Desde:</label></td>
            <td><input type="text" id="txt_fecha_ini" name="txt_fecha_ini" size="40" value="<?php echo $fec ?>" readonly/></td>
        </tr>
        <tr>
            <td><label for="txt_fecha_fin">Hasta:</label></td>
            <td><input type="text" id="txt_fecha_fin" name="txt_fecha_fin" value="<?php echo $fec ?>" size="40" readonly/></td>
        </tr>
    </table>
</form>