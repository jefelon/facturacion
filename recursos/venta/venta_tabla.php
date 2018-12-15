<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once ("../../modulos/formatos/formato.php");
require_once ("../../modulos/venta/cVentapago.php");
$oVentapago = new cVentapago();
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

$dts1=$oVenta->mostrar_filtro_cui($_SESSION['cliente_cui'],fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['cmb_fil_ven_est']);
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
                <td nowrap="nowrap" title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_ser'].'-'.$dt1['tb_venta_num']?></td>
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

                    <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">DETALLE</a>
                    <?php
                    $doc_nom=$dt1['tb_documento_nom'];
                    if($doc_nom=='FACTURA')$archivo_destino='../../modulos/venta/venta_impresion_gra_factura.php';
                    if($doc_nom=='BOLETA')$archivo_destino='../../modulos/venta/venta_impresion_gra_boleta.php';
                    if($doc_nom=='FACTURA ELECTRONICA')$archivo_destino='../../modulos/venta/venta_cpeimp_facturaexo_mat.php';
                    if($doc_nom=='BOLETA ELECTRONICA')$archivo_destino='../../modulos/venta/venta_cpeimp_boleta_mat.php';
                    if($doc_nom=='NOTA DE SALIDA')$archivo_destino='../../modulos/venta/venta_cpeimp_nota_mat.php';

                    $xml="";
                    $xml=$ruc_empresa."-0".$dt1['cs_tipodocumento_cod']."-".$dt1['tb_venta_ser']."-".$dt1['tb_venta_num'];
                    $cdr="";
                    $cdr="R-".$ruc_empresa."-0".$dt1['cs_tipodocumento_cod']."-".$dt1['tb_venta_ser']."-".$dt1['tb_venta_num'];
                    ?>
                    <form action="<?php echo $archivo_destino?>" target="_blank" method="post">
                        <input name="ven_id" type="hidden" value="<?php echo $dt1['tb_venta_id']?>">
                        <button class="btn_bar" id="btn_bar" type="submit" title="PDF">PDF</button>
                    </form>
                    <a class="btn_xml" id="btn_xml" target="_blank" href="<?php echo "../../cperepositorio/send/$xml.zip";?>" title="Descargar XML">XML</a>
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
