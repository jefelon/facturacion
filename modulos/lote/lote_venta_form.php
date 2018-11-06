<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../lote/cLote.php");
$oLote = new cLote();


$stock_total = 0;
foreach ($_SESSION['lote_car'][$_POST['cat_id']] as $indice => $linea_cantidad) {
    $stock_total += $_SESSION['lote_sto_num'][$_POST['cat_id']][$indice];
}
?>
<script type="text/javascript">
    $(function() {
        $('.btn_editar').button({
            icons: {primary: "ui-icon-pencil"},
            text: false
        });

        $('.btn_eliminar').button({
            icons: {primary: "ui-icon-trash"},
            text: false
        });

        $.tablesorter.defaults.widgets = ['zebra'];
        $("#tabla_lote").tablesorter({
            headers: {
                1: {sorter: false },
                2: { sorter: false}},
            //sortForce: [[0,0]],
            sortList: [[0,0]]
        });
    });

    jQuery.validator.addMethod("max_cant", function(value, element, parameter) {

        var rest_act=0;
        var max_cant='<?php echo $_SESSION['venta_car'][$_POST['unico_id']][$_POST['cat_id']] ?>';
        var cant_act = '<?php echo $_POST['cant_act'] ?>';
        rest_act = '<?php echo $_SESSION['lote_can'][$_POST['cat_id']][$_POST['lote_num']] ?>';
        <?php  if ($_POST['action']=='editar'){ ?>
        cant_act -= rest_act;
        <?php } ?>

        <?php  if ($_POST['action']=='agregar'){
            foreach ($_SESSION['lote_car'][$_POST['cat_id']] as $indice => $linea_cantidad) {
                if ($indice==$_POST['lote_num']){?>
                    rest_act = '<?php echo $_SESSION['lote_can'][$_POST['cat_id']][$indice]?>';
            <?php }
            }?>
        cant_act -= rest_act;
        <?php } ?>
        return parseInt(cant_act)+parseInt(value) <= parseInt(max_cant);
    }, "Se supero la cantidad.");

    $( "#txt_lote_num").autocomplete({
        minLength: 0,
        source: "../lote/lote_complete_num.php?cat_id=<?php echo $_POST['cat_id']?>",
        select: function(event, ui){
            $("#txt_lote_fecfab").val(ui.item.fecfab);
            $("#txt_lote_fecven").val(ui.item.fecven);
            $("#txt_lote_sto_num").val(ui.item.stock);
            $("#txt_lote_cant").focus();
        }
    }).click(function () {
        $(this).autocomplete("search", $(this).val());
    });

    $("#for_lote_form").validate({
        submitHandler: function() {
            $.ajax({
                type: "POST",
                url: "../lote/lote_venta_car.php",
                async:true,
                dataType: "html",
                data: $("#for_lote_form").serialize(),
                beforeSend: function() {
                    $("#div_lote_venta_form" ).dialog( "close" );
                    $('#msj_lote').html("Guardando...");
                    $('#msj_lote').show(100);
                },
                success: function(html){
                    $('#div_tabla_lote_venta').html(html);
                },
                complete: function(){

                }
            });
        },
        rules: {
            txt_lote_num: {
                required: true
            },
            txt_lote_cant: {
                required: true,
                max_cant: '<?php echo $_SESSION['venta_car'][$_POST['unico_id']][$_POST['cat_id']] ?>'
            }
        },
        messages: {
            txt_lote_num: {
                required: '*'
            },
            txt_lote_cant: {
                required: '*'
            }
            // hdd_stock_total: {
            //     maxlength: 'Se supero el stock'
            // }
        }
    })

</script>
<form id="for_lote_form">
    <input name="action" id="action_lote" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="cat_id" id="cat_id" type="hidden" value="<?php echo $_POST['cat_id']?>">
    <label for="txt_lote_num">Lote Num:</label>
    <input name="txt_lote_num" type="text" class="cantidad" id="txt_lote_num" style="text-align:right" size="40" value="<?php echo $_SESSION['lote_car'][$_POST['cat_id']][$_POST['lote_num']] ?>">
    <input name="txt_lote_fecfab" type="hidden" id="txt_lote_fecfab" value="<?php echo $_SESSION['lote_fecfab'][$_POST['cat_id']][$_POST['lote_num']]?>" size="10" maxlength="10">
    <input name="txt_lote_fecven" type="hidden" id="txt_lote_fecven" value="<?php echo $_SESSION['lote_fecven'][$_POST['cat_id']][$_POST['lote_num']]?>" size="10" maxlength="10">
    <input name="txt_lote_sto_num" type="hidden" class="cantidad" id="txt_lote_sto_num" readonly style="text-align:right" size="10"  value="<?php echo $_SESSION['lote_sto_num'][$_POST['cat_id']][$_POST['lote_num']]?>">
    <label for="txt_lote_sto_num">Cantidad:</label>
    <input name="txt_lote_cant" type="text" class="cantidad" id="txt_lote_cant" style="text-align:right" size="10"  value="<?php echo $_SESSION['lote_can'][$_POST['cat_id']][$_POST['lote_num']]?>">
    <input name="unico_id" type="hidden" id="unico_id" style="text-align:right" size="20" maxlength="20" value="<?php echo $_POST['unico_id']?>">
</form>