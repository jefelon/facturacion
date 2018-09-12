<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 08/09/2018
 * Time: 19:17
 */

require_once ("../../config/Cado.php");
require_once ("cPle.php");
$oPle = new cPle();

//if($_POST['cli_id']!="")
//{
//    $dts1=$oCliente->mostrar_filtro($_POST['cli_id']);
//    $num_rows= mysql_num_rows($dts1);
//}
//else{
    $dts1=$oPle->mostrar_filtro($_POST['anio'],$_POST['libro']);
    $num_rows= mysql_num_rows($dts1);
//}
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
                  <th>PERIODO</th>
                  <th>CUO</th>
                  <th>CUO AMC</th>
                  <th>FECHA</th>
                  <th>FECHA VENCE</th>
                  <th>COD DOC</th>
                  <th>SERIE</th>
                  <th>NUMERO</th>
                  <th>CAMPO 10</th>
                  <th>TIPO DOC PROV</th>
                  <th>RUC PROV</th>
                  <th>PROVEEDOR</th>
                  <th>OP GRAVADA</th>
                  <th>IGV</th>
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
                            <td>
                                <?php
                                $fecha=$dt1['tb_venta_fec'];
                                $periodo=explode("-",$fecha);
                                echo $periodo[0].$periodo[1];
                                ?>
                            </td>
                            <td>
                                <?php
                                $fecha=$dt1['tb_venta_fec'];
                                $periodo=explode("-",$fecha);
                                echo $periodo[0].$periodo[1].$lineas;
                                ?>
                            </td>
                            <td>
                                <?php
                                $amc="";
                                $fecha=$dt1['tb_venta_fec'];
                                $periodo=explode("-",$fecha);
                                if($periodo[2]=="01"){$amc="A";}
                                if($periodo[2]=="13"){$amc="C";}
                                else{$amc="M";}
                                echo $periodo[0].$periodo[1].$lineas.$amc;
                                ?>
                            </td>
                            <td><?php echo $dt1['tb_venta_fec'] ?></td>
                            <td><?php echo $dt1['tb_venta_fec'] ?></td>
                            <td> <?php echo $dt1['cs_tipodocumento_cod']; ?></td>
                            <td><?php echo $dt1['tb_venta_ser']; ?></td>
                            <td><?php echo $dt1['tb_venta_num']; ?></td>
                            <td></td>
                            <td><?php
                               if($dt1['tb_cliente_tip']==1){
                                   echo "1";
                               } elseif($dt1['tb_cliente_tip']==2){
                                   echo "6";
                               }
                                ?>
                            </td>
                            <td><?php echo $dt1['tb_cliente_doc']; ?></td>
                            <td><?php echo $dt1['tb_cliente_nom']; ?></td>
                            <td><?php echo $dt1['tb_venta_gra']; ?></td>
                            <td><?php echo $dt1['tb_venta_igv']; ?></td>
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