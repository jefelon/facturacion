<?php
session_start();
require_once ("../../config/Cado.php");

require_once("../formula/cFormula.php");
$oFormula = new cFormula();

require_once("../venta/cVenta.php");
$oVenta = new cVenta();

require_once("../formatos/formato.php");
require_once("../menu/acceso.php");
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

require_once ("../cajadetalle/cCajadetalle.php");
$oCajadetalle = new cCajadetalle();

require_once ("../egreso/cEgreso.php");
$oEgreso = new cEgreso();
require_once ("../cajaobs/cajaobs_cierre.php");

require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../cajaobs/cajaobs_cierre.php");


$pvs=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv = mysql_fetch_array($pvs);
$caja_venta		=$pv['tb_caja_id'];
mysql_free_result($dts);


if($_POST['action']=="actualizar"){
	//$cli_id=1;
    $cdets = $oCajadetalle->ultimoInsertCaja($caja_venta);
    $cdet = mysql_fetch_array($cdets);
    $apertura =mostrarFechaHora($cdet['tb_caja_apertura']);
    $cierre = mostrarFechaHora(date('d-m-Y H:i'));
    $inicial = $cdet['tb_caja_inicial'];
    $cdetalle_id = $cdet['tb_cajadetalle_id'];
    $cdetants = $oCajadetalle->mostrarUno($cdet['tb_cajadetalle_id']-1);
    $cdetant = mysql_fetch_array($cdetants);
    $saldo_anterior_sol =  $cdetant['tb_caja_final'];
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
                        $("#btn_cerrar" ).button( "option", "disabled", true );
                        $("#btn_abrir" ).button( "option", "disabled", false );
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
        <input name="hdd_cajadetalle_id" id="hdd_cajadetalle_id" type="hidden" value="<?php echo $cdetalle_id?>">
        <fieldset>
            <legend>Cerrar Caja</legend>
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
                               value="<?php echo $apertura ?>" maxlength="30" readonly/>
                    </td>
                <tr>
                <tr>
                    <td style="width:30%;">
                        <label for="txt_fec_cie">Fecha Cierre:</label>
                    </td>
                    <td style="width:50%;">
                        <input id="txt_fec_cie" name="txt_fec_cie" class="timepicker"
                               style="text-align:right; font-size:12px" size="30"
                               value="<?php echo $cierre ?>" maxlength="30" readonly/>
                    </td>
                </tr>
                <tr>
                    <td style="width:30%;">
                        <label for="txt_mon_cie">Monto Cierre:</label>
                    </td>
                    <td style="width:50%;">
                        <input id="txt_mon_cie" name="txt_mon_cie" class="moneda"
                               style="text-align:right; font-size:12px" size="30"
                               value="<?php echo formato_moneda(0) ?>" maxlength="30"/>
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
</div>



<?php

$pvs=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
$pv = mysql_fetch_array($pvs);
$caja_venta		=$pv['tb_caja_id'];

$monto_inicial=$inicial;


$dts1=$oIngreso->mostrar_filtro_fechahora($_SESSION['empresa_id'],$cdet['tb_caja_id'],fechahora_mysql($apertura),fechahora_mysql($cierre),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_doc_id'],$_POST['txt_fil_ing_numdoc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ing_est']);

$num_rows= mysql_num_rows($dts1);
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

        $('.btn_anular').button({
            icons: {primary: "ui-icon-cancel"},
            text: false
        });

        $("#tabla_ingreso").tablesorter({
            widgets: ['zebra'],
            headers: {
                0: {sorter: 'shortDate' },
                12: { sorter: false}
            },
            //sortForce: [[0,0]],
            <?php if($num_rows>0){?>
            sortList: [[0,0]]
            <?php }?>
        });
        $("#monto_inicial").tablesorter({
            widgets: ['zebra']
        });
    });
</script>

<div class="ui-widget-header ui-corner-all" style="width:auto; padding:2px; margin:3px">MONTO INICIAL</div>
<table cellspacing="1" id="monto_inicial" class="tablesorter">
    <thead>
    <tr>
        <th nowrap title="Monto Inicial">SOLES S/.	</th>
    </tr>
    </thead>
    <tbody>
    <td><?php echo formato_moneda($inicial) ?></td>
    </tbody>
</table>
<div class="ui-widget-header ui-corner-all" style="width:auto; padding:2px; margin:3px">INGRESOS</div>
<table cellspacing="1" id="tabla_ingreso" class="tablesorter">
    <thead>
    <tr>
        <th nowrap title="Fecha">FECHA</th>
        <th>DOCUMENTO</th>
        <th align="right">IMPORTE</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sum_imp_ingr=0;
    while($dt1 = mysql_fetch_array($dts1)){
        $sum_imp_ingr+=$dt1['tb_ingreso_imp'];
        $caja_estado=caja_cierre($dt1['tb_caja_id'],$dt1['tb_ingreso_fec']);
        ?>
        <tr>
            <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_ingreso_fec'])?></td>
            <td><?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_ingreso_numdoc']?></td>
            <td align="right"><?php echo formato_money($dt1['tb_ingreso_imp'])?></td>
        </tr>
        <?php
    }
    mysql_free_result($dts1);
    ?>
    </tbody>
    <tr class="even">
        <td colspan="2"><strong>TOTAL <?php echo $num_rows." registros";?></strong></td>
        <td colspan="1" align="right"><strong><?php echo formato_money($sum_imp_ingr)?></strong></td>
    </tr>
</table>
<input name="hdd_ingreso_total" id="hdd_ingreso_total" type="hidden" value="<?php echo $sum_imp_ingr?>">

<?php
$dts1=$oEgreso->mostrar_filtro_fechahora($_SESSION['empresa_id'],$cdet['tb_caja_id'],fechahora_mysql($apertura),fechahora_mysql($cierre),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_doc_id'],$_POST['txt_fil_egr_numdoc'],$_POST['hdd_fil_pro_id'],$_POST['cmb_fil_egr_est']);

$num_rows= mysql_num_rows($dts1);
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

        $('.btn_anular').button({
            icons: {primary: "ui-icon-cancel"},
            text: false
        });

        $("#tabla_gasto").tablesorter({
            widgets: ['zebra'],
            headers: {
                0: {sorter: 'shortDate' },
                11: { sorter: false}
            },
            //sortForce: [[0,0]],
            <?php if($num_rows>0){?>
            sortList: [[0,0]]
            <?php }?>
        });
    });
</script>
<div class="ui-widget-header ui-corner-all" style="width:auto; padding:2px; margin:3px">EGRESOS</div>
<table cellspacing="1" id="tabla_gasto" class="tablesorter">
    <thead>
    <tr>
        <th nowrap title="Fecha">FECHA</th>
        <th>DOCUMENTO</th>
        <th align="right">IMPORTE</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sum_imp_egr=0;
    while($dt1 = mysql_fetch_array($dts1)){
        $sum_imp_egr+=$dt1['tb_egreso_imp'];
        $caja_estado=caja_cierre($dt1['tb_caja_id'],$dt1['tb_egreso_fec']);
        ?>
        <tr>
            <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_egreso_fec'])?></td>
            <td><?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_egreso_numdoc']?></td>
            <td align="right"><?php echo formato_money($dt1['tb_egreso_imp'])?></td>
        </tr>
        <?php
    }
    mysql_free_result($dts1);
    ?>
    </tbody>
    <tr class="even">
        <td colspan="2"><strong>TOTAL <?php echo $num_rows." registros";?></strong></td>
        <td colspan="1" align="right"><strong><?php echo formato_money($sum_imp_egr)?></strong></td>
    </tr>
</table>
<input name="hdd_gasto_total" id="hdd_gasto_total" type="hidden" value="<?php echo $sum_imp_egr?>">

<?php
$saldo_sol = $saldo_anterior_sol+$monto_inicial+$sum_imp_ingr-$sum_imp_egr
?>
<div class="ui-widget-header ui-corner-all" style="width:auto; padding:2px; margin:3px">CONSULTA SALDO CAJA</div>
<table border="0" cellspacing="0" cellpadding="0" style="width:30%;float:left">
    <tr>
        <th height="24" align="left">CAJA</th>
        <th height="24" align="right">SOLES S/.</th>
        <th height="24" align="right">&nbsp;</th>
    <tr>
        <td align="left">SALDO ANTERIOR</td>
        <td align="right"><?php echo formato_money($saldo_anterior_sol)?></td>
        <td align="right">&nbsp;</td>
    </tr>
    <tr>
        <td align="left">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
    </tr>

    <tr>
        <td align="left">MONTO INICIAL</td>
        <td align="right">+<?php echo formato_money($monto_inicial)?></td>
        <td align="right">&nbsp;</td>
    </tr>
    <tr>
        <td align="left">INGRESOS</td>
        <td align="right">+<?php echo formato_money($sum_imp_ingr)?></td>
        <td align="right">&nbsp;</td>
    </tr>
    <tr>
        <td align="left">EGRESOS</td>
        <td align="right">-<?php echo formato_money($sum_imp_egr)?></td>
        <td align="right">&nbsp;</td>
    </tr>
    <tr style="font-weight:bold" height="25">
        <td align="left">SALDO</td>
        <td align="right"><?php echo formato_money($saldo_sol)?></td>
        <td align="right">&nbsp;</td>
    </tr>
</table>


