<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
$y=date('Y');
$m=date('m');
$d=date('d');
$fec1="$d-$m-$y";
//$d=ultimoDia($m,$y);
$fec2="$d-$m-$y";
?>

<script type="text/javascript">
    function cmb_fil_pro_alm()
    {
        $.ajax({
            type: "POST",
            url: "../almacen/cmb_alm_id.php",
            async:false,
            dataType: "html",
            data: ({
                alm_id: '<?php echo $_POST['alm_id']?>'
            }),
            beforeSend: function() {
                $('#cmb_fil_pro_alm').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_fil_pro_alm').html(html);
            },
            complete: function(){
            }
        });
    }
    function cmb_punven_id(idf)
    {
        $.ajax({
            type: "POST",
            url: "../puntoventa/cmb_punven_id.php",
            async:true,
            dataType: "html",
            data: ({
                punven_id: idf
            }),
            beforeSend: function() {
                $('#cmb_fil_ven_punven').html('<option value="">Cargando...</option>');
            },
            success: function(html){
                $('#cmb_fil_ven_punven').html(html);
            },
            complete: function(){
                //venta_tabla();
            }
        });
    }

    $(function() {
        cmb_punven_id();
        $('.btn_bar').button({
        });
        $('#cmb_fil_ven_punven').change(function(e) {
            $('#cmb_fil_ven_punvennom').val($('#cmb_fil_ven_punven option:selected').text());
        });
        var dates = $( "#txt_fil_ven_fec1, #txt_fil_ven_fec2" ).datepicker({
            //defaultDate: "+1w",
            maxDate:"+0D",
            changeMonth: true,
            numberOfMonths: 1,
            dateFormat: 'dd-mm-yy',
            onSelect: function( selectedDate ) {
                var option = this.id == "txt_fil_ven_fec1" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
    });
</script>
<form id="for_mas_ven" action="reporte_producto_mas_vendido.php" method="post" target="_blank">
    <table>
        <tr>
            <td><b>Cantidad de filas.</b></td><td><input type="text" id="txt_fil_filas" name="txt_fil_filas" size="24" value="10"/></td>
        </tr>
        <tr>
            <td width="50px"><b>Desde:</b></td><td width="50px"><input name="txt_fil_ven_fec1" type="text" id="txt_fil_ven_fec1" value="<?php echo $fec1?>" size="8" readonly> <b style="width: 50px">Hasta:</b><input name="txt_fil_ven_fec2" type="text" id="txt_fil_ven_fec2" value="<?php echo $fec2?>" size="8" readonly></td>
        </tr>
        <tr>
            <td><b>Punto de venta.</b></td><td><select style="width: 195px" name="cmb_fil_ven_punven" id="cmb_fil_ven_punven"></select><input
                        type="hidden" name="cmb_fil_ven_punvennom" id="cmb_fil_ven_punvennom"></td>
        </tr>
    </table>
</form>