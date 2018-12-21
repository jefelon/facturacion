<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 08/09/2018
 * Time: 19:17
 */
//
session_start();
require_once ("../../config/Cado.php");
require_once ("cPle.php");
$oPle = new cPle();
require_once("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
//
if($_POST['libro']="080200")//compras
{
    $dts1=$oPle->mostrar_comprasnd($_POST['anio'],$_POST['mes']);
    $num_rows= mysql_num_rows($dts1);
    $libro="080200";
}

//empresa
$dts8=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt8 = mysql_fetch_array($dts8);
//$emp_ruc=$dt8['tb_empresa_ruc'];
//$emp_nomcom=$dt8['tb_empresa_nomcom'];
//$emp_razsoc=$dt8['tb_empresa_razsoc'];
//$emp_dir=$dt8['tb_empresa_dir'];
//$emp_dir2=$dt8['tb_empresa_dir2'];
//$emp_tel=$dt8['tb_empresa_tel'];
//$emp_ema=$dt8['tb_empresa_ema'];
//$emp_fir=$dt8['tb_empresa_fir'];
$regimen=$dt8['tb_empresa_regimen'];
mysql_free_result($dts8);

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

	$('.btn_info').button({
		icons: {primary: "ui-icon-info"},
		text: false
	});

    $.tablesorter.defaults.widgets = ['zebra'];
    $("#tabla_ple").tablesorter({
        headers: {
            1: {sorter: false }, 2: {sorter: false }, 3: {sorter: false}, 4: {sorter: false}, 5: {sorter: false}, 6: {sorter: false},
            7: {sorter: false}, 8: {sorter: false}, 9: {sorter: false}, 10: {sorter: false}, 11: {sorter: false}, 12: {sorter: false},
            13: {sorter: false}, 14: {sorter: false}, 15: {sorter: false}, 16: {sorter: false}, 17: {sorter: false}, 18: {sorter: false},
            19: {sorter: false}, 20: {sorter: false}, 21: {sorter: false}, 22: {sorter: false}, 23: {sorter: false}, 24: {sorter: false},
            25: {sorter: false}, 26: {sorter: false}, 27: {sorter: false}, 28: {sorter: false}, 29: {sorter: false}, 30: {sorter: false},
            31: {sorter: false}, 32: {sorter: false}, 33: {sorter: false}, 34: {sorter: false}, 35: {sorter: false,36: {sorter: false}
        }
    });
});
</script>
<table cellspacing="1" id="tabla_ple" class="tablesorter">
    <thead>
    <tr>
        <th>1 PERIODO</th>
        <th>2 CUO</th>
        <th>3 CUO AMC</th>
        <th>4 FECHA</th>
        <th>5 TIPO COMPROBANTE</th>
        <th>6 SERIE</th>
        <th>7 NUM COMPROBANTE</th>
        <th>8 VALOR ADQUISICIONES</th>
        <th>11 TIPO DOC PROVEE</th>
        <th>12 RUC PROV</th>
        <th>13 PROVEEDOR</th>
        <th>14 OP GRAVADA</th>
        <th>15 IGV</th>
        <th>16 BI2</th>
        <th>17 IGV2</th>
        <th>18 BI3</th>
        <th>19 IGV3</th>
        <th>20 NO GRA</th>
        <th>21 ISC</th>
        <th>22 OTROS CARGOS</th>
        <th>23 TOTAL</th>
        <th>24 MON</th>

        <th>24 PAIS PROV</th>
        <th>25 VINCULO</th>
        <th>26 RENTA BRUTA</th>
        <th>27 DEDUCC C/E BC</th>
        <th>28 RENTA NETA</th>
        <th>29 TASA RET </th>
        <th>30 IMP RET</th>
        <th>31 CONV DOBLE IMP</th>
        <th>32 EXO APL</th>
        <th>33 TIPO RENTA</th>
        <th>34 MOD</th>
        <th>35 ART 76</th>
        <th>36 ESTADO</th>
        <th></th>
    </tr>
    </thead>
    <?php
    if($num_rows>0){
        ?>
        <tbody>
        <?php
        $lineas=0;
        while($dt1 = mysql_fetch_array($dts1)){ $lineas++;?>
            <tr>
                    <?php
                    $amc="";
                    $peridostring=$dt1['tb_compra_reg'];
                    $fecha=$dt1['tb_compra_fec'];
                    $fechavence=$dt1['tb_compra_fecven'];
                    $periodoarray=explode("/",$peridostring);
                    $periodo=$periodoarray[2].$periodoarray[1];
                    ?>
                <!--1--><td><?php echo $periodo."00"; ?></td>
                <!--2--><td><?php echo $periodo.$dt1['tb_compra_id'].$lineas;?></td>
                    <?php
                        if ($periodoarray[1] == "01") {
                            $amc = "A";
                        }
                        if ($periodoarray[1] == "13") {
                            $amc = "C";
                        } else {
                            $amc = "M";
                        }
                        $cuoamc=$amc.$periodo.$lineas;

                        if($regimen==3){
                            $cuoamc="M-RER";
                        }
                    ?>
                <!--3--><td><?php echo $cuoamc ?></td>
                <!--4--><td><?php echo $fecha ?></td>

                    <?php if(strlen($dt1['cs_tipodocumento_cod'])==1)
                    {$coddoc = '0' . $dt1['cs_tipodocumento_cod'];}
                    else{$coddoc=$dt1['cs_tipodocumento_cod'];}
                    ?>
                <!--5--><td><?php echo $coddoc; ?></td>

                <?php
                    $numero =$dt1['tb_compra_numdoc'];
                    $serie_numero=explode("-",$numero);
                ?>
                <!--6--><td><?php echo $serie_numero[0]; ?></td>
                <!--7--><td><?php echo $serie_numero[1]; ?></td>
                <!--8--><td></td>
                    <?php
                    $ctipo="";
                    $prov_doc=$dt1['tb_proveedor_doc'];
                    $prov_nom=$dt1['tb_proveedor_nom'];
                    if($dt1['tb_proveedor_tip']==1){
                        $ctipo=1;
                    } elseif($dt1['tb_proveedor_tip']==2){
                        $ctipo=6;
                    }
                    ?>
                <!--11--><td><?php echo $ctipo ?></td>
                <!--12--><td><?php echo $prov_doc; ?></td>
                <!--13--><td><?php echo $prov_nom; ?></td>
                <?php
                $gravado=$dt1['tb_compra_gra'];$descuento=$dt1['tb_venta_des'];$igv=$dt1['tb_compra_igv'];$exo=$dt1['tb_compra_exo'];
                $ina=$dt1['tb_venta_ina'];$isc=$dt1['tb_compra_isc'];$otrcar=$dt1['tb_venta_otrcar'];$tot=$dt1['tb_compra_tot'];
                $moneda=$dt1['cs_tipomoneda_cod'];$tc=$dt1['tb_compra_tipcam'];
                if($dt1['tb_venta_est']=="ANULADA"){$gravado="";$descuento="";$igv="";$exo="";
                    $ina="";$isc="";$otrcar="";$tot=""; $moneda="";$tipocambiov="";}
                ?>
                <!--14--><td><?php echo $gravado; ?></td>
                <!--15--><td><?php echo $igv; ?></td>
                <!--16--><td></td>
                <!--17--><td></td>
                <!--18--><td></td>
                <!--19--><td></td>
                <!--20--><td><?php echo $exo; ?></td>
                <!--21--><td><?php echo $isc; ?></td>
                <!--22--><td></td>
                <!--23--><td><?php echo $tot; ?></td>
                <!--24--><td><?php echo $moneda; ?></td>

                <!--24--><td><?php echo $paisprov; ?></td>
                <!--25--><td><?php echo $vinculo; ?></td>
                <!--26--><td><?php echo $renta_bruta; ?></td>
                <!--27--><td><?php echo $deduccion; ?></td>

                <?php $rentaneta=0;?>
                <!--28--><td><?php echo $rentaneta; ?></td>
                <?php $tasaret=0;?>
                <!--29--><td><?php echo $tasaret; ?></td>
                <?php $impretenido=0; ?>
                <!--30--><td><?php echo $impretenido; ?></td>
                <?php $convenio=0;?>
                <!--31--><td><?php echo $convenio; ?></td>
                <!--32--><td></td>
                <?php
                $tiporenta=0;
                ?>
                <!--33--><td><?php echo $tiporenta; ?></td>
                <!--34--><td></td>
                <!--35--><td></td>
                <?php $estado=0;?>
                <!--36--><td><?php echo $estado;?></td>
                <td></td>
            </tr>
            <?php
        }
        mysql_free_result($dts1);
        ?>
        </tbody>
    <?php }?>
    <tr class="even">
        <td colspan="41"><?php echo $num_rows.' registros'; ?></td>
    </tr>
</table>

