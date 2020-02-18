<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../compra/cCompra.php");
$oCompra = new cCompra();
require_once ("../formatos/formatos.php");

require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa = $dt['tb_empresa_ruc'];

$igv=0.18;
$coeficiente=$_POST['txt_coeficiente'];

$dts1=$oVenta->mostrar_filtro_suma($_POST['cmb_ano'],$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['chk_fil_ven_may']);
$dt1 = mysql_fetch_array($dts1);
$num_rows1= mysql_num_rows($dts1);

$dts2=$oCompra->mostrar_filtro_suma($_POST['cmb_ano'],'',$_POST['cmb_fil_ven_est'],$_SESSION['empresa_id']);
$dt2 = mysql_fetch_array($dts2);
$num_rows2= mysql_num_rows($dts2);

?>

<script type="text/javascript">
    $(function() {


        $("#tabla_venta").tablesorter({
            widgets: ['zebra', 'zebraHover'],
            headers: {
            }
            //sortForce: [[0,0]],
        });

    });
</script>
<table cellspacing="1" id="tabla_venta" class="tablesorter">
    <thead>
    <tr>
        <th rowspan="2" align="center">Periodo</th>
        <th rowspan="2" align="center">Ventas Netas</th>
        <th rowspan="2" align="center">Compras Netas</th>
        <th colspan="2" align="center">PERCEPCIÓN <br>Saldo disponible:0</th>
        <th colspan="2" align="center">RETENCIÓN <br>Saldo disponible:0</th>
        <th colspan="6" align="center">IGV</th>
        <th colspan="6" align="center">RENTA</th>
    </tr>
    <tr>
        <th align="center">En el periodo</th>
        <th align="center">Saldo usado</th>
        <th align="center">En el periodo</th>
        <th align="center">Saldo Usado</th>
        <th align="center">Débito Fiscal</th>
        <th align="center">Credito Fiscal</th>
        <th align="center">Impuesto Resultante</th>
        <th align="center">Saldo a favor</th>
        <th align="center">Saldo aplicado</th>
        <th align="center">IGV por pagar</th>
        <th align="center">Base Imponible</th>
        <th align="center">Coef</th>
        <th align="center">Impuesto Resultante</th>
        <th align="center">Saldo a favor</th>
        <th align="center">Saldo aplicado</th>
        <th align="center">Renta por pagar</th>
    </tr>


    </thead>
    <?php

        ?>
        <tbody>
        <?php
        $suma_ventas_total=0;
        $suma_compras_total=0;
        $suma_debito_fiscal=0;
        $suma_credito_fiscal=0;
        $suma_renta_x_pagar=0;

        for ($mes = 1; $mes <= 12; $mes++) {
            if ($dt1['mes']==$mes){
                $suma_ventas=round($dt1['suma_ventas'],0);
                $dt1 = mysql_fetch_array($dts1);
            }else{
                $suma_ventas=0;
            }
            if ($dt2['mes']==$mes){
                $suma_compras=round($dt2['suma_compras'],0);
                $dt2 = mysql_fetch_array($dts2);
            }else{
                $suma_compras=0;
            }

            $suma_ventas_total+=$suma_ventas;
            $suma_compras_total+=$suma_compras;
            ?>
            <tr>
                <td nowrap="nowrap"><?php echo nombre_mes($mes).'-'.$_POST['cmb_ano'];?></td>
                <td nowrap="nowrap"><?php echo $suma_ventas;?></td>
                <td nowrap="nowrap"><?php echo $suma_compras?></td>
                <td nowrap="nowrap" align="center">0</td>
                <td>0</td>
                <td>0</td>
                <td align="center">0</td>
                <td><?php
                    $debito_fiscal=round($igv*$suma_ventas,0);
                    $suma_debito_fiscal+=$debito_fiscal;
                    echo $debito_fiscal;
                    ?></td>
                <td>
                    <?php
                    $credito_fiscal=round($igv*$suma_compras,0);
                    $suma_credito_fiscal+=$credito_fiscal;
                    echo $credito_fiscal?>
                </td>
                <td align="center" nowrap>
                    <?php $impuesto_resultante_igv=$debito_fiscal-$credito_fiscal;
                    echo $impuesto_resultante_igv;
                    ?>
                </td>
                <td align="center" nowrap>
                    <?php
                    $saldo_aplicado=$impuesto_resultante_igv;
                    if ($mes==1){
                        $saldo_favor=$impuesto_resultante_igv;
                        $saldo_aplicado=0;
                    }
                    echo $saldo_favor;
                    ?>
                </td>
                <td align="right"><?php


                    $igv_x_pagar=$saldo_favor+$saldo_aplicado;
                    if($saldo_aplicado>0){
                        echo $saldo_aplicado;
                    }else{
                        echo 0;
                    }
                    ?>
                    </td>
                <td align="right"><?php
                    echo $igv_x_pagar;
                    ?></td>
                <td align="right"><?php echo $suma_ventas;?></td>
                <td align="right"><?php echo $coeficiente; ?></td>
                <td align="right"><?php
                    $impuesto_resultante_renta=round($suma_ventas*$coeficiente,0);
                    $suma_renta_x_pagar+=$impuesto_resultante_renta;
                    echo $impuesto_resultante_renta;
                    ?></td>
                <td align="right">0</td>
                <td align="right">0</td>
                <td align="right"><?php echo $impuesto_resultante_renta; ?></td>
            </tr>
            <?php
            if ($igv_x_pagar>0){
                $saldo_favor=0;
            }else{
                $saldo_favor=$igv_x_pagar;
            }

        }
        mysql_free_result($dts1);
        ?>
        </tbody>
        <?php
    ?>
    <tr class="even">
        <td></td>
        <td align="right"><strong><?php echo round($suma_ventas_total,0)?></strong></td>
        <td align="right"><strong><?php echo round($suma_compras_total,0)?></strong></td>
        <td colspan="4" align="right">&nbsp;</td>
        <td align="right"><strong><?php echo round($suma_debito_fiscal,0)?></strong></td>
        <td align="right"><strong><?php echo round($suma_credito_fiscal,0)?></strong></td>
        <td colspan="9"></td>
        <td colspan="1"><strong><?php echo round($suma_renta_x_pagar,0); ?></strong></td>
    </tr>
</table>