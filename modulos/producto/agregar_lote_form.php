<?php
require_once ("../../config/Cado.php");
require_once ("../lote/cLote.php");
$oLote = new cLote();

if($_POST['action']=="editar")
{
//	$dts=$oMarca->mostrarUno($_POST['lot_id']);
//	$dt = mysql_fetch_array($dts);
//		$mar_nom=$dt['tb_lote_nom'];
//	mysql_free_result($dts);
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
        minDate: "-7D",
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

    $("#for_agregar_lote").validate({
        submitHandler: function() {
            $.ajax({
                type: "POST",
                url: "../producto/lote_reg.php",
                async:true,
                dataType: "json",
                data: $("#for_agregar_lote").serialize(),
                beforeSend: function() {
                    $("#div_agregar_lote_form" ).dialog( "close" );
                    $('#msj_lote').html("Guardando...");
                    $('#msj_lote').show(100);
                },
                success: function(data){
                    $('#msj_lote').html(data.lote_msj);
                },
                complete: function(){
                    lote_form('',<?php echo $_POST['pre_id'] ?>,<?php echo $_POST['alm_id']?>,<?php echo $_POST['sto_id']?>)
                }
            });
        },
        rules: {
            txt_lote_num: {
                required: true
            }
        },
        messages: {
            txt_lote_num: {
                required: '*'
            }
        }
    });

</script>
<form id="for_agregar_lote">
    <input name="action_lote" id="action_lote" type="hidden" value="<?php echo $_POST['action']?>">
    <input name="hdd_alm_id" id="hdd_alm_id" type="hidden" value="<?php echo $_POST['alm_id']?>">
    <input name="hdd_pre_id" id="hdd_pre_id" type="hidden" value="<?php echo $_POST['pre_id']?>">
    <input name="sto_id" id="sto_id" type="hidden" value="<?php echo $_POST['sto_id']?>">
    <label for="txt_lote_num">Lote Num:</label>
    <input name="txt_lote_num" type="text" class="cantidad" id="txt_lote_num" style="text-align:right" size="10" maxlength="6" value="<?php echo $stock_num?>">
    <label for="txt_lote_fecfab">Fecha Fab.:</label>
    <input name="txt_lote_fecfab" type="text" class="fecha" id="txt_lote_fecfab" value="<?php echo $fec?>" size="10" maxlength="10" readonly>
    <label for="txt_lote_fecven">Fecha Ven.:</label>
    <input name="txt_lote_fecven" type="text" class="fecha" id="txt_lote_fecven" value="<?php echo $fec?>" size="10" maxlength="10" readonly>
    <label for="txt_lote_sto_num">Stock:</label>
    <input name="txt_lote_sto_num" type="text" class="cantidad" id="txt_lote_sto_num" style="text-align:right" size="10" maxlength="6" value="<?php echo $stock_num?>">
</form>