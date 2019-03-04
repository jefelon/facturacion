<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../compra/cCompra.php");
$oCompra = new cCompra();
require_once ("../formatos/formato.php");
require_once ("../formatos/operaciones.php");

$dts1=$oCompra->mostrar_filtro_integracion(fecha_mysql($_POST['com_fec1']),fecha_mysql($_POST['com_fec2']),$_POST['com_mon'],$_POST['pro_id'],$_POST['com_est'],$_SESSION['empresa_id']);
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

	$("#tabla_compra").tablesorter({
		widgets : ['zebra','zebraHover']
    });
}); 
</script>
        <table cellspacing="1" id="tabla_compra" class="tablesorter">
            <thead>
                <tr>
                    <th align="center">SUCR_codigo</th>
                    <th align="center">CABA_ano</th>
                    <th align="center">CABA_mes</th>
                    <th align="center">TIPO_tipReg</th>
                    <th align="center">CABA_nrovoucher</th>
                    <th align="center">CABA_Glosa</th>
                    <th align="center">CABA_usrCrea</th>
                    <th align="center">CABA_moneda</th>
                    <th align="center">Deta_moneda</th>
                    <th align="center">ENTC_ruc</th>
                    <th align="center">ENTC_razonSoc</th>
                    <th align="center">CUEN_codigo</th>
                    <th align="center">DETA_elemento</th>
                    <th align="center">DETA_Glosa</th>
                    <th align="center">CENT_codigo</th>
                    <th align="center">TIPO_tipOrigen</th>
                    <th align="center">DETA_FecDocOrigen</th>
                    <th align="center">DETA_SerieDocOrigen</th>
                    <th align="center">DETA_nroDocOrigen</th>
                    <th align="center">DETA_Referencia</th>
                    <th align="center">DETA_debe</th>
                    <th align="center">DETA_haber</th>
                    <th align="center">DETA_DebeDol</th>
                    <th align="center">DETA_HaberDol</th>
                    <th align="center">TIPO_tipOpe</th>
                    <th align="center">DETA_Tcambio</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
                while($dt1 = mysql_fetch_array($dts1)){
                    $estado = $dt1['tb_venta_est'];
                    $tipodoc = $dt1['cs_tipodocumento_cod'];
                    $simb_moneda = "";

                    ?>
                    <tr>
                        <td nowrap="nowrap">01</td>
                        <td nowrap="nowrap"><?php echo mostrarDiaMesAnio(3,$dt1['tb_compra_fec']); ?></td>
                        <td nowrap="nowrap"><?php echo date("m", strtotime($dt1['tb_compra_fec'])); ?></td>
                        <td nowrap="nowrap">002</td>
                        <td nowrap="nowrap"><?php echo str_pad($dt1['tb_compra_id'],6, "0", STR_PAD_LEFT); ?></td>
                        <td nowrap="nowrap">VENTA MERCADERIA</td>
                        <td nowrap="nowrap">contabilidad</td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_compra_mon']; ?></td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_compra_mon']; ?></td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_cliente_doc']; ?></td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_cliente_nom']; ?></td>
                        <td nowrap="nowrap">12.1.3.1</td>
                        <td nowrap="nowrap">1</td>
                        <td nowrap="nowrap">VENTA MERCADERIA</td>
                        <td nowrap="nowrap"></td>
                        <td nowrap="nowrap"></td>
                        <td nowrap="nowrap"><?php echo date('d/m/Y', strtotime($dt1['tb_compra_fec'])); ?></td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_compra_ser'] ?></td>
                        <td nowrap="nowrap" align="center"><?php echo $dt1['tb_compra_num'] ?></td>
                        <td></td>
                        <td><?php echo $dt1['tb_compra_tot'] ?></td>
                        <td align="center">

                        </td>
                        <td align="right">
                            <?php echo formato_money($dt1['tb_compra_tot']/$dt1['tb_tipocambio_dolsunv']); ?>
                        </td>
                        <td align="right">
                        </td>
                        <td align="right">
                            001
                        </td>
                        <td><?php echo $dt1['tb_tipocambio_dolsunv'] ?></td>

                    </tr>
                    <tr>
                        <td nowrap="nowrap">01</td>
                        <td nowrap="nowrap"><?php echo mostrarDiaMesAnio(3,$dt1['tb_compra_fec']); ?></td>
                        <td nowrap="nowrap"><?php echo date("m", strtotime($dt1['tb_compra_fec'])); ?></td>
                        <td nowrap="nowrap">002</td>
                        <td nowrap="nowrap"><?php echo str_pad($dt1['tb_compra_id'],6, "0", STR_PAD_LEFT); ?></td>
                        <td nowrap="nowrap">VENTA MERCADERIA</td>
                        <td nowrap="nowrap">contabilidad</td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_compra_mon']; ?></td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_compra_mon']; ?></td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_cliente_doc']; ?></td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_cliente_nom']; ?></td>
                        <td nowrap="nowrap">40.1.1.1</td>
                        <td nowrap="nowrap">2</td>
                        <td nowrap="nowrap">VENTA MERCADERIA</td>
                        <td nowrap="nowrap"></td>
                        <td nowrap="nowrap"></td>
                        <td nowrap="nowrap"><?php echo date('d/m/Y', strtotime($dt1['tb_compra_fec'])); ?></td>
                        <td nowrap="nowrap"><?php echo $dt1['tb_compra_ser'] ?></td>
                        <td nowrap="nowrap" align="center"><?php echo $dt1['tb_compra_num'] ?></td>
                        <td></td>
                        <td></td>
                        <td align="center">
                            <?php echo $dt1['tb_compra_igv'] ?>
                        </td>
                        <td align="right">

                        </td>
                        <td align="right">
                            <?php echo formato_money($dt1['tb_compra_igv']/$dt1['tb_tipocambio_dolsunv']); ?>
                        </td>
                        <td align="right">
                            001
                        </td>
                        <td><?php echo $dt1['tb_tipocambio_dolsunv'] ?></td>

                    </tr>
                    <?php
                    $cont_rel++;
                    $cds=$oCompra->mostrar_compra_detalle($dt1['tb_compra_id']);
                    $num_rows= mysql_num_rows($cds);

                    $cont_det=3;
                    while($cd = mysql_fetch_array($cds)){
                        ?>
                        <tr>
                            <td nowrap="nowrap">01</td>
                            <td nowrap="nowrap"><?php echo mostrarDiaMesAnio(3,$dt1['tb_compra_fec']); ?></td>
                            <td nowrap="nowrap"><?php echo date("m", strtotime($dt1['tb_compra_fec'])); ?></td>
                            <td nowrap="nowrap">002</td>
                            <td nowrap="nowrap"><?php echo str_pad($dt1['tb_venta_id'],6, "0", STR_PAD_LEFT); ?></td>
                            <td nowrap="nowrap">VENTA MERCADERIA</td>
                            <td nowrap="nowrap">contabilidad</td>
                            <td nowrap="nowrap"><?php echo $dt1['tb_compra_mon']; ?></td>
                            <td nowrap="nowrap"><?php echo $dt1['tb_compra_mon']; ?></td>
                            <td nowrap="nowrap"><?php echo $dt1['tb_proveedor_doc']; ?></td>
                            <td nowrap="nowrap"><?php echo $dt1['tb_proveedor_nom']; ?></td>
                            <td nowrap="nowrap">70.1.1.1</td>
                            <td nowrap="nowrap"><?php echo $cont_det; ?></td>
                            <td nowrap="nowrap">VENTA MERCADERIA</td>
                            <td nowrap="nowrap">01.01.<?php echo str_pad($cont_det-2,2, "0", STR_PAD_LEFT); ?></td>
                            <td nowrap="nowrap"></td>
                            <td nowrap="nowrap"><?php echo date('d/m/Y', strtotime($dt1['tb_compra_fec'])); ?></td>
                            <td nowrap="nowrap"><?php echo $dt1['tb_compra_ser'] ?></td>
                            <td nowrap="nowrap" align="center"><?php echo $dt1['tb_compra_num'] ?></td>
                            <td></td>
                            <td></td>
                            <td align="center">
                                <?php echo $cd['tb_compradetalle_imp'] ?>
                            </td>
                            <td align="right">

                            </td>
                            <td align="right">
                                <?php echo formato_money($cd['tb_compradetalle_imp']/$dt1['tb_tipocambio_dolsunv']); ?>
                            </td>
                            <td align="right">
                                001
                            </td>
                            <td><?php echo $dt1['tb_tipocambio_dolsunv'] ?></td>

                        </tr>
                        <?php
                        $cont_det++;
                    }
                }
                mysql_free_result($dts1);
                ?>
            </tbody>
            <?php
			}
			?>
        </table>