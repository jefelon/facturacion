<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 08/09/2018
 * Time: 19:17
 */
//
require_once ("../../config/Cado.php");
require_once ("cPle.php");
$oPle = new cPle();
//
if($_POST['libro']=1)//compras
{
    $dts1=$oPle->mostrar_compras($_POST['anio']);
    $num_rows= mysql_num_rows($dts1);
}
elseif($_POST['libro']=3)//ventas
{
    $dts1=$oPle->mostrar_ventas($_POST['anio']);
    $num_rows= mysql_num_rows($dts1);
}
$libro=$_POST['libro'];
echo $_POST['libro'];
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
			6: {sorter: false },
			7: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
});
</script>

<?php if($_POST['libro']==1) {//REGISTRO COMPRAS?>
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
        <th>8 AÑO DUA</th>
        <th>9 NUM COMPROBANTE</th>
        <th>10 N FINAL CONSOLID</th>
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
        <th>25 TC</th>
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
                    $fecha=$dt1['tb_compra_fec'];
                    $periodo=explode("-",$fecha);
                    ?>
                1<td><?php echo $periodo[0].$periodo[1]; ?></td>
                2<td><?php echo $periodo[0].$periodo[1].$lineas;?></td>
                    <?php
                    if($periodo[1]=="01"){$amc="A";}
                    if($periodo[1]=="13"){$amc="C";}
                    else{$amc="M";}
                    ?>
                3<td><?php echo $periodo[0].$periodo[1].$lineas.$amc;?></td>
                4<td><?php echo $dt1['tb_compra_fec'] ?></td>
                5<td><?php echo $dt1['tb_compra_fec'] ?></td>

                    <?php if(strlen($dt1['cs_tipodocumento_cod'])==1)
                    {$coddoc = '0' . $dt1['cs_tipodocumento_cod'];}
                    else{$coddoc=$dt1['cs_tipodocumento_cod'];}
                    ?>
                6<td><?php echo $coddoc; ?></td>

                <?php
                    $numero =$dt1['tb_compra_numdoc'];
                    $serie_numero=explode("-",$numero);
                ?>
                7<td><?php echo $serie_numero[0]; ?></td>
                8<td></td>
                9<td><?php echo $serie_numero[1]; ?></td>
                10<td></td>
                    <?php
                    $ctipo="";
                    if($dt1['tb_proveedor_tip']==1){
                        $ctipo=1;
                    } elseif($dt1['tb_proveedor_tip']==2){
                        $ctipo=6;
                    }
                    ?>
                11<td><?php echo $ctipo ?></td>
                12<td><?php echo $dt1['tb_proveedor_doc']; ?></td>
                13<td><?php echo $dt1['tb_proveedor_nom']; ?></td>
                14<td><?php echo $dt1['tb_compra_gra']; ?></td>
                15<td><?php echo $dt1['tb_compra_igv']; ?></td>
                16<td></td>
                17<td></td>
                18<td></td>
                19<td></td>
                20<td><?php echo $dt1['tb_compra_exo']; ?></td>
                21<td><?php echo $dt1['tb_compra_isc']; ?></td>
                22<td></td>
                23<td><?php echo $dt1['tb_compra_tot']; ?></td>
                24<td><?php echo $dt1['cs_tipomoneda_cod']; ?></td>
                25<td><?php echo $dt1['tb_compra_tipcam']; ?></td>
            </tr>
            <?php
        }
        mysql_free_result($dts1);
        ?>
        </tbody>
    <?php }?>
    <tr class="even">
        <td colspan="8"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>
<?php } elseif($_POST['libro']==3) { // REGISTRO VENTAS?>
    <table cellspacing="1" id="tabla_ple" class="tablesorter">
        <thead>
        <tr>
            <!--        <th>1 PERIODO</th>-->
            <!--        <th>2 CUO</th>-->
            <!--        <th>3 CUO AMC</th>-->
            <!--        <th>4 FECHA</th>-->
            <!--        <th>5 FECHA VENCE</th>-->
            <!--        <th>6 TIPO COMPROBANTE</th>-->
            <!--        <th>7 SERIE</th>-->
            <!--        <th>8 AÑO DUA</th>-->
            <!--        <th>9 NUM COMPROBANTE</th>-->
            <!--        <th>10 N FINAL CONSOLID</th>-->
            <!--        <th>11 TIPO DOC PROVEE</th>-->
            <!--        <th>12 RUC PROV</th>-->
            <!--        <th>13 PROVEEDOR</th>-->
            <!--        <th>14 OP GRAVADA</th>-->
            <!--        <th>15 IGV</th>-->
            <!--        <th>16 BI2</th>-->
            <!--        <th>17 IGV2</th>-->
            <!--        <th>18 BI3</th>-->
            <!--        <th>19 IGV3</th>-->
            <th>20 NO GRA</th>
            <th>21 ISC</th>
            <th>22 OTROS CARGOS</th>
            <th>23 TOTAL</th>
            <th>24 MON</th>
            <th>25 TC</th>
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
                    $fecha=$dt1['tb_venta_fec'];
                    $periodo=explode("-",$fecha);
                    ?>
                    <!--                1<td>--><?php //echo $periodo[0].$periodo[1]; ?><!--</td>-->
                    <!--                2<td>--><?php //echo $periodo[0].$periodo[1].$lineas;?><!--</td>-->
                    <!--                    --><?php
                    //                    if($periodo[2]=="01"){$amc="A";}
                    //                    if($periodo[2]=="13"){$amc="C";}
                    //                    else{$amc="M";}
                    //                    ?>
                    <!--                3<td>--><?php //echo $periodo[0].$periodo[1].$lineas.$amc;?><!--</td>-->
                    <!--                4<td>--><?php //echo $dt1['tb_venta_fec'] ?><!--</td>-->
                    <!--                5<td>--><?php //echo $dt1['tb_venta_fec'] ?><!--</td>-->
                    <!--                6<td>--><?php //echo '0'.$dt1['cs_tipodocumento_cod']; ?><!--</td>-->
                    <!--                7<td>--><?php //echo $dt1['tb_venta_ser']; ?><!--</td>-->
                    <!--                8<td></td>-->
                    <!--                9<td>--><?php //echo $dt1['tb_venta_num']; ?><!--</td>-->
                    <!--                10<td></td>-->
                    <!--                    --><?php
                    //                    $ctipo="";
                    //                    if($dt1['tb_cliente_tip']==1){
                    //                        $ctipo=1;
                    //                    } elseif($dt1['tb_cliente_tip']==2){
                    //                        $ctipo=6;
                    //                    }
                    //                    ?>
                    <!--                11<td>--><?php //echo $ctipo ?><!--</td>-->
                    <!--                12<td>--><?php //echo $dt1['tb_cliente_doc']; ?><!--</td>-->
                    <!--                13<td>--><?php //echo $dt1['tb_cliente_nom']; ?><!--</td>-->
                    <!--                14<td>--><?php //echo $dt1['tb_venta_gra']; ?><!--</td>-->
                    <!--                15<td>--><?php //echo $dt1['tb_venta_igv']; ?><!--</td>-->
                    <!--                16<td></td>-->
                    <!--                17<td></td>-->
                    <!--                18<td></td>-->
                    <!--                19<td></td>-->
                    20<td><?php echo $dt1['tb_venta_exo']; ?></td>
                    21<td><?php echo $dt1['tb_venta_isc']; ?></td>
                    22<td><?php echo $dt1['tb_venta_otrcar']; ?></td>
                    23<td><?php echo $dt1['tb_venta_tot']; ?></td>
                    24<td><?php echo $dt1['cs_tipomoneda_cod']; ?></td>
                    25<td></td>
                </tr>
                <?php
            }
            mysql_free_result($dts1);
            ?>
            </tbody>
        <?php }?>
        <tr class="even">
            <td colspan="8"><?php echo $num_rows.' registros'?></td>
        </tr>
    </table>
<?php } //fin ventas?>
