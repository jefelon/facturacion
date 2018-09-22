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

if($_POST['libro']="140100")//ventas
{
    $dts2=$oPle->mostrar_ventas($_POST['anio'],$_POST['mes']);
    $num_rows= mysql_num_rows($dts2);
    $libro="140100";
}

echo $libro;
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
                    1<td><?php echo $periodo[0].$periodo[1]; ?></td>
                    2<td><?php echo $periodo[0].$periodo[1].$lineas;?></td>
                    <?php
                        if($periodo[2]=="01"){$amc="A";}
                        if($periodo[2]=="13"){$amc="C";}
                         else{$amc="M";}
                     ?>
                    3<td><?php echo $periodo[0].$periodo[1].$lineas.$amc;?></td>
                    4<td><?php echo $dt1['tb_venta_fec'] ?></td>
                    5<td><?php echo $dt1['tb_venta_fec'] ?></td>
                    6<td><?php echo '0'.$dt1['cs_tipodocumento_cod']; ?></td>
                    7<td><?php echo $dt1['tb_venta_ser']; ?></td>
                    8<td></td>
                    9<td><?php echo $dt1['tb_venta_num']; ?></td>
                    10<td></td>
                     <?php
                     $ctipo="";
                     if($dt1['tb_cliente_tip']==1){
                     $ctipo=1;
                     } elseif($dt1['tb_cliente_tip']==2){
                     $ctipo=6;
                     }
                     ?>
                    11<td><?php echo $ctipo ?></td>
                    12<td><?php echo $dt1['tb_cliente_doc']; ?></td>
                    13<td><?php echo $dt1['tb_cliente_nom']; ?></td>
                    14<td><?php echo $dt1['tb_venta_gra']; ?></td>
                    15<td><?php echo $dt1['tb_venta_igv']; ?></td>
                    16<td></td>
                    17<td></td>
                    18<td></td>
                    19<td></td>
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
            <td colspan="41"><?php echo $num_rows.' registros'?></td>
        </tr>
    </table>

