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

    $( "#txt_lote_fecfab, #txt_lote_fecven" ).datepicker({
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
            // hdd_stock_total: {
            //     required: true,
            //     maxlength: parseInt($('#hdd_txt_cant').val())+parseInt($('#txt_lote_sto_num').val())
            // }
        },
        messages: {
            txt_lote_num: {
                required: '*'
            },
            // hdd_stock_total: {
            //     maxlength: 'Se supero el stock'
            // }
        }
    });

</script>
<form id="for_lote_form">
    <input name="action" id="action_lote" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="cat_id" id="cat_id" type="hidden" value="<?php echo $_POST['cat_id']?>">
    <label for="txt_lote_num">Lote Num:</label>
    <input name="txt_lote_num" type="text" class="cantidad" id="txt_lote_num" style="text-align:right" size="10" maxlength="10" value="<?php echo $_SESSION['lote_car'][$_POST['cat_id']][$_POST['lote_num']] ?>">
    <label for="txt_lote_fecfab">Fecha Fab.:</label>
    <input name="txt_lote_fecfab" type="text" id="txt_lote_fecfab" value="<?php echo $_SESSION['lote_fecfab'][$_POST['cat_id']][$_POST['lote_num']]?>" size="10" maxlength="10">
    <label for="txt_lote_fecven">Fecha Ven.:</label>
    <input name="txt_lote_fecven" type="text" id="txt_lote_fecven" value="<?php echo $_SESSION['lote_fecven'][$_POST['cat_id']][$_POST['lote_num']]?>" size="10" maxlength="10">
    <label for="txt_lote_sto_num">Stock Actual:</label>
    <input name="txt_lote_sto_num" type="text" class="cantidad" id="txt_lote_sto_num" style="text-align:right" size="10" maxlength="6" value="<?php echo $_SESSION['lote_sto_num'][$_POST['cat_id']][$_POST['lote_num']]?>">
    <input name="hdd_stock_total" id="hdd_stock_total" type="hidden" value="<?php echo $stock_total?>">
</form>