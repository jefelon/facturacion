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

if($_POST['libro']="140100")//ventas
{
    $dts1=$oPle->mostrar_ventas($_POST['anio'],$_POST['mes']);
    $num_rows= mysql_num_rows($dts1);
    $libro="140100";
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
            31: {sorter: false}, 32: {sorter: false}, 33: {sorter: false}, 34: {sorter: false}, 35: {sorter: false}
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
           <th>5 FECHA VENCE</th>
           <th>6 TIPO COMPROBANTE</th>
           <th>7 SERIE</th>
           <th>8 NUM COMPROBANTE</th>
           <th>9 N FINAL CONSOLID</th>
           <th>10 TIPO DOC CLIENTE</th>
           <th>11 RUC CLIENTE</th>
           <th>12 PROVEEDOR</th>
           <th>13 VALOR EXPORT</th>
           <th>14 OP GRAVADA</th>
           <th>15 DESC BI</th>
           <th>16 IGV</th>
           <th>17 DESC IGV</th>
           <th>18 TOTAL EXO</th>
           <th>19 TOTAL INAF</th>
           <th>20 ISC </th>
           <th>21 BI ARROZ PILADO</th>
           <th>22 IVAP</th>
           <th>23 OTROS CARGOS NO BI</th>
           <th>24 TOTAL </th>
           <th>25 MONEDA </th>
           <th>26 TC </th>
           <th>27 FECHA DOC MOD </th>
           <th>28 TIPO DOC MOD</th>
           <th>29 SERIE DOC MOD </th>
           <th>30 NUMERO DOC MOD </th>
           <th>31 ID CONTRATO </th>
           <th>32 ERROR 1 </th>
           <th>33 IND MEDIO P </th>
           <th>34 ESTADO </th>
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
                    $peridostring=$dt1['tb_venta_reg'];
                    $fecha=$dt1['tb_venta_fec'];
                    $fechavence="";
                    $periodoarray=explode("/",$peridostring);
                    $periodo=$periodoarray[2].$periodoarray[1];
                    ?>
                    <!--1--><td><?php echo $periodo.'00'; ?></td>
                   <!-- 2--><td><?php echo $periodo.$lineas;?></td>
                    <?php
                        if ($periodo[1] == "01") {
                            $amc = "A";
                        }
                        if ($periodo[1] == "13") {
                            $amc = "C";
                        } else {
                            $amc = "M";
                        }
                        $cuoamc=$amc.$periodo[2].$periodo[1].$lineas;

                        if($regimen==3){
                            $cuoamc="M-RER";
                        }
                     ?>
                   <!-- 3--><td><?php echo $cuoamc; ?></td>
                   <!-- 4--><td><?php echo $fecha ?></td>
                   <!-- 5--><td><?php echo $fechavence ?></td>
                    <?php if(strlen($dt1['cs_tipodocumento_cod'])==1)
                    {$coddoc = '0' . $dt1['cs_tipodocumento_cod'];}
                    else{$coddoc=$dt1['cs_tipodocumento_cod'];}
                    ?>
                   <!-- 6--><td><?php echo $coddoc; ?></td>
                   <!-- 7--><td><?php echo $dt1['tb_venta_ser']; ?></td>
                   <!-- 8--><td><?php echo $dt1['tb_venta_num']; ?></td>
                   <!-- 9--><td></td>
                    <?php
                    $ctipo="";
                    $cliente_doc="";
                    $cliente_nom="";
                    if($dt1['tb_cliente_tip']==1){
                        $ctipo=1;
                        if($dt1['tb_cliente_doc']="00")
                        {
                            $cliente_doc="";
                            $ctipo="";
                            $cliente_nom="";
                        }
                    } elseif($dt1['tb_cliente_tip']==2){
                        $ctipo=6;
                        $cliente_doc=$dt1['tb_cliente_doc'];
                        $cliente_nom=$dt1['tb_cliente_nom'];
                    }
                    if($dt1['tb_venta_est']=="ANULADA"){
                        $ctipo="0";
                        $cliente_doc="1";
                        $cliente_nom="ANULADO";
                    }
                    ?>
                    <!--10--><td><?php echo $ctipo ?></td>
                    <!--11--><td><?php echo $cliente_doc; ?></td>
                    <!--12--><td><?php echo $cliente_nom; ?></td>
                    <!--13--><td></td>
                    <?php
                    $gravado=$dt1['tb_venta_gra'];$descuento=$dt1['tb_venta_des'];$igv=$dt1['tb_venta_igv'];$exo=$dt1['tb_venta_exo'];
                    $ina=$dt1['tb_venta_ina'];$isc=$dt1['tb_venta_isc'];$otrcar=$dt1['tb_venta_otrcar'];$tot=$dt1['tb_venta_tot'];$moneda=$dt1['cs_tipomoneda_cod'];
                    $tc = $dt1['tc'];
                    if($tc<1) {$tc="1.000";}
                    if($dt1['tb_venta_est']=="ANULADA"){$gravado="";$descuento="";$igv="";$exo="";
                        $ina="";$isc="";$otrcar="";$tot=""; $moneda="";$tc="";}
                    ?>
                    <!--14--><td><?php echo $gravado; ?></td>
                    <!--15--><td><?php echo $descuento; ?></td>
                    <!--16--><td><?php echo $igv; ?></td>
                    <!--17--><td></td>
                    <!--18--><td><?php echo $exo; ?></td>
                    <!--19--><td><?php echo $ina; ?></td>
                    <!--20--><td><?php echo $isc; ?></td>
                    <!--21--><td></td>
                    <!--22--><td></td>
                    <!--23--><td><?php echo $otrcar; ?></td>
                    <!--24--><td><?php echo $tot; ?></td>
                    <!--25--><td><?php echo $moneda; ?></td>

                    <?php
                    $fec_ventanota="";
                    $tip_doc_mod="";
                    $tip_doc_modserie="";
                    $tip_doc_modnum="";
                    if($coddoc =="07"||$coddoc =="08"||$coddoc =="87"||$coddoc =="88"||$coddoc =="97"||$coddoc =="98")//falta acabar
                    {

                        $tip_doc_modserienumero= $dt1['tb_venta_vennumdoc'];
                        $dtst=$oPle->mostrar_doc_mod($tip_doc_modserienumero,$dt1['tb_venta_ventipdoc']);
                        $dtt = mysql_fetch_array($dtst);

                        $fec_ventanota= $dtt['tb_venta_fec'];
                        $tip_doc_modserie= $dtt['tb_venta_ser'];
                        $tip_doc_modnum=$dtt['tb_venta_num'];

                        if(strlen($dtt['cs_tipodocumento_cod'])==1)
                        {$tip_doc_mod = '0' . $dtt['cs_tipodocumento_cod'];}
                        else{$tip_doc_mod=$dtt['cs_tipodocumento_cod'];}

                    }
                    ?>
                    <!--26--><td><?php echo $tc; ?></td>
                    <!--27--><td><?php echo $fec_ventanota; ?></td>
                    <!--28--><td><?php echo $tip_doc_mod; ?></td>
                    <!--29--><td><?php echo $tip_doc_modserie; ?></td>
                    <!--30--><td><?php echo $tip_doc_modnum; ?></td>
                    <!--31--><td></td>
                    <!--32--><td></td>
                    <!--33--><td></td>
                    <?php
                    $estado=1;
                    $fechastring=explode("/",$fecha);
                    $fechadoc=$fechastring[2].$fechastring[1];
                    if($fechadoc<$periodo){
                        $estado=8;
                    }
                    if($fechadoc<$periodo && $fechastring[2]<$periodoarray[2]){
                        $estado=7;
                    }
                    if($dt1['tb_venta_est']=="ANULADA")
                    {
                        $estado=2;
                    }
                    ?>
                    <!--34--><td><?php echo $estado; ?></td>
                    <td></td>
                </tr>
            <?php
            }
            mysql_free_result($dts1);
            ?>
            </tbody>
        <?php }?>
        <tr class="even">
            <td colspan="41"><?php echo $num_rows.' registros'?></td>
        </tr>

    </table>
