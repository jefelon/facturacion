<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once ("../../modulos/formatos/formato.php");

require_once ("../../modulos/formatos/numletras.php");
require_once ("../../modulos/formatos/formato.php");
require_once ("../../modulos/empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../../modulos/usuarios/cUsuario.php");
$oUsuario = new cUsuario();


require_once ("../../modulos/lote/cLote.php");
$oLote = new cLote();

$dts=$oEmpresa->mostrarUno(1);
$dt = mysql_fetch_array($dts);
$ruc_empresa=$dt['tb_empresa_ruc'];
$razon_defecto = $dt['tb_empresa_razsoc'];
$direccion_defecto = $dt['tb_empresa_dir'];
$contacto_empresa = "Teléfono:" . $dt['tb_empresa_tel'] ."Correo:" . $dt['tb_empresa_ema'];
$empresa_logo = '../../modulos/empresa/'.$dt['tb_empresa_logo'];
mysql_free_result($dts);

$dts1=$oVenta->mostrar_filtro(fecha_mysql($_POST['txt_fil_ven_fec1']),$_POST['cmb_fil_ven_doc'],$_POST['txt_fil_ser'],$_POST['txt_fil_cor'],$_POST['txt_fil_mon']);
$num_rows= mysql_num_rows($dts1);

?>

<script type="text/javascript">
    $(function() {
        $('.btn_editar').button({
            //icons: {primary: "ui-icon-pencil"},
            //text: false
        });
        $('.btn_pdf').button({
            //icons: {primary: "ui-icon-document"},
            //text: false
        });
        $('.btn_xml').button({
            //icons: {primary: "ui-icon-document"},
            //text: false
        });
        $('.btn_bar').button({
        });

        $("#tabla_venta").tablesorter({
            widgets: ['zebra', 'zebraHover'],
            headers: {
                0: {sorter: 'shortDate' },
                10: { sorter: false}
            },
            //sortForce: [[0,0]],
            sortList: [[0,0],[2,1],[1,1]]
        });

    });
</script>
<style>
    table.tablesorter tbody tr.even td{
        background: none;
    }
</style>
<?php
if($num_rows>0){
    ?>
    <table cellspacing="1" id="tabla_venta" class="tablesorter">
        <thead>
        <tr>
            <th align="center">CLIENTE</th>
            <th align="center">TIPO DOCUMENTO</th>
            <th align="center">DOCUMENTO</th>
            <th align="center">MONEDA</th>
            <th align="center">IMPORTE TOTAL</th>
            <th align="center">FECHA EMISIÓN</th>
            <th align="center">ESTADO DOC.</th>
            <th>&nbsp;</th>
        </tr>
        </thead>

        <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){
            if($dt1['tb_venta_est']=='CANCELADA'){
                $total_ventas+=$dt1['tb_venta_tot'];
            }
            ?>
            <tr>
                <td nowrap="nowrap"><?php echo $dt1['tb_cliente_nom']?></td>
                <td nowrap="nowrap">
                    <?php
                    echo $dt1['tb_documento_nom'];
                    ?>
                </td>
                <td nowrap="nowrap" title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_venta_ser'].'-'.$dt1['tb_venta_num']?></td>
                <td>
                    <?php
                    if($dt1['cs_tipomoneda_id']=='1'){
                        echo 'Nuevo Sol';
                    }elseif($dt1['cs_tipomoneda_id']=='2'){
                        echo 'Dollar';
                    }?>
                </td>
                <td align="right"><?php echo formato_money($dt1['tb_venta_tot'])?></td>
                <td nowrap="nowrap" align="center"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                <td><?php echo $dt1['tb_venta_est']?></td>
                <td align="center" nowrap="nowrap">
                    <table class="lista_pagos">
                        <td>
                            <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">DETALLE</a>
                        </td>
                        <?php
                        $xml="";
                        $xml=$ruc_empresa."-0".$dt1['cs_tipodocumento_cod']."-".$dt1['tb_venta_ser']."-".$dt1['tb_venta_num'];
                        $cdr="";
                        $cdr="R-".$ruc_empresa."-0".$dt1['cs_tipodocumento_cod']."-".$dt1['tb_venta_ser']."-".$dt1['tb_venta_num'];
                        ?>
                        <td>
                            <a class="btn_pdf" id="btn_pdf" href="#print" title="Descargar pdf" onClick="
                            <?php if($dt1['tb_encomiendaventa_id']){?>
                                    venta_impresion_enc('<?php echo $dt1['tb_venta_id']?>')"
                                <?php }else if($dt1['tb_viajeventa_id']){?>
                               venta_impresion_pas('<?php echo $dt1['tb_venta_id']?>')"
                            <?php }else{?>
                                venta_impresion('<?php echo $dt1['tb_venta_id']?>')"
                            <?php } ?>
                            >PDF</a>
                        </td>
                        <td>
                            <a class="btn_xml" id="btn_xml" target="_blank" href="<?php echo "../../cperepositorio/send/$xml.zip";?>" title="Descargar XML">XML</a>
                            <a class="btn_xml" id="btn_xml" target="_blank" href="<?php echo "../../cperepositorio/cdr/$cdr.zip";?>" title="Descargar CDR">CDR</a>
                        </td>
                    </table>
                    </td>
            </tr>
            <?php
        }
        mysql_free_result($dts1);
        ?>
        </tbody>
    </table>
    <?php
}
?>
