<?php
session_start();
require_once ("../../config/Cado.php");

require_once("../formula/cFormula.php");
$oFormula = new cFormula();

require_once("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../cajadetalle/cCajadetalle.php");
$oCajadetalle = new cCajadetalle();
require_once("../formatos/formato.php");
require_once("../menu/acceso.php");
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

$pvs=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv = mysql_fetch_array($pvs);
$caja_venta		=$pv['tb_caja_id'];

if($_POST['action']=="insertar"){
	//$cli_id=1;
	$fec=date('d-m-Y H:i');
    $fec_ape=date('d-m-Y H:i');
	$est='CANCELADA';
	$venpag_fec=date('d-m-Y');
	$unico_id=uniqid();

    $cdets = $oCajadetalle->ultimoInsertCaja($caja_venta);
    $cdet = mysql_fetch_array($cdets);
    if ($cdet['tb_cajadetalle_id']){
        $cdetants = $oCajadetalle->mostrarUno($cdet['tb_cajadetalle_id']);
        $cdetant = mysql_fetch_array($cdetants);
        $saldo_anterior_sol =  $cdetant['tb_caja_final'];
    }else{
        $saldo_anterior_sol =  0;
    }

}

?>
<script type="text/javascript">

    $('.moneda').autoNumeric({
        aSep: ',',
        aDec: '.',
        //aSign: 'S/. ',
        //pSign: 's',
        vMin: '0.00',
        vMax: '9999.99'
    });

$(function() {



//formulario
    $("#for_cdet").validate({
        submitHandler: function(){

            $.ajax({
                type: "POST",
                url: "../cajadetalle/cajadetalle_reg.php",
                async:true,
                dataType: "json",
                data: $("#for_cdet").serialize(),
                beforeSend: function(){
                    $('#div_cajadetalle_form').dialog("close");
                    $('#msj_cajadetalle').html("Guardando...");
                    $('#msj_cajadetalle').show(100);
                },
                success: function(data){
                    if(data.respuesta=='1'){
                        $("#btn_abrir" ).button( "option", "disabled", true );
                        $("#btn_cerrar" ).button( "option", "disabled", false );
                    }
                    $('#msj_cajadetalle').html(data.caj_msj);

                },
                complete: function(){
                    cajadetalle_tabla();
                }
            });
        },
        rules: {
            txt_mon_inicial: {
                required: true
            }
        },
        messages: {
            txt_mon_inicial: {
                required: '*'
            }
        }
    });

});
</script>
<div>
    <form id="for_cdet">
        <input name="action_caja" id="action_caja" type="hidden" value="<?php echo $_POST['action'] ?>">
        <input name="hdd_punven_id" id="hdd_punven_id" type="hidden" value="<?php echo $_SESSION['puntoventa_id']?>">
        <fieldset>
            <legend>Apertura Caja</legend>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <div id="msj_cajadetalle_form" class="ui-state-highlight ui-corner-all"
                         style="width:auto; float:right; padding:2px; display:none"></div>
                    <td style="width:30%;"><label for="txt_ven_fec">Punto de Venta:</label>
                    </td>
                    <td style="width:50%;">
                        <input name="cmb_fil_usu_punven" type="text" id="cmb_fil_usu_punven"
                               style="text-align:right; font-size:12px"
                               value="<?php echo $pv['tb_puntoventa_nom'] ?>" size="30" readonly>
                    </td>
                </tr>
                <tr>
                    <td style="width:30%;">
                        <label for="txt_usu_nombre">Usuario:</label>
                    </td>
                    <td style="width:50%;">
                        <input name="txt_usu_nombre" type="text" id="txt_usu_nombre"
                               style="text-align:right; font-size:12px"
                               value="<?php echo $_SESSION['usuario_nombre'] ?>" size="30" readonly>
                    </td>
                </tr>
                <tr>
                    <td style="width:30%;">
                        <label for="txt_fec_ape">Fecha Apertura:</label>
                    </td>
                    <td style="width:50%;">
                        <input id="txt_fec_ape" name="txt_fec_ape" class="timepicker"
                               style="text-align:right; font-size:12px" size="30"
                               value="<?php echo $fec_ape ?>" maxlength="20" readonly/>
                    </td>
                <tr>
                    <td style="width:30%;">
                        <label for="txt_mon_inicial"><b>SALDO ANTERIOR:</b></label>
                    </td>
                    <td style="width:50%;">
                        <input name="txt_sal_anterior" type="text" class="moneda" id="txt_mon_inicial"
                               style="text-align:right; font-size:14px;font-weight: bold;color: green;" size="23" maxlength="20" value="<?php echo formato_moneda($saldo_anterior_sol) ?>" disabled>
                    </td>
                </tr>
                <tr>
                    <td style="width:30%;">
                        <label for="txt_mon_inicial">Monto Apertura:</label>
                    </td>
                    <td style="width:50%;">
                        <input name="txt_mon_inicial" type="text" id="txt_mon_inicial"
                               style="text-align:right; font-size:12px; " size="30" maxlength="20" value="<?php echo formato_moneda(0) ?>" >
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>

