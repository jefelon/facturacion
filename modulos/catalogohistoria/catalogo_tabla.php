<?php
require_once ("../../config/Cado.php");
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../historial/cHistorial.php");
$oHistorial = new cHistorial();

require_once ("../formatos/formato.php");

//seleccion de las categorias
if(isset($_POST['pro_cat']) and $_POST['pro_cat']>0)
{
    $dc=$_POST['pro_cat'].'';

    $dts2=$oCategoria->mostrar_por_idp($_POST['pro_cat']);
    $num_rows2= mysql_num_rows($dts2);
    if($num_rows2>0){
        while($dt2 = mysql_fetch_array($dts2)){

            $dc.=', '.$dt2['tb_categoria_id'];

            $dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
            $num_rows3= mysql_num_rows($dts3);
            if($num_rows3>0){
                while($dt3 = mysql_fetch_array($dts3)){
                    $dc.=', '.$dt3['tb_categoria_id'];
                }
                mysql_free_result($dts3);
            }//fin nivel 3

        }
        mysql_free_result($dts2);
    }//fin nivel 2

//echo $dc;
}

//seleccion de los atributos
$atr_array=$_POST['atr_ids'];
if(is_array($atr_array)){
    $cadena_atr = implode(',',$atr_array);
}



    $dts1=$oCatalogo->catalogo_filtro($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_POST['alm_id'],$cadena_atr,$_POST['verven'],$_POST['vercom'],$_POST['unibas']);
    $num_rows= mysql_num_rows($dts1);
    $fecini=$_POST['fec_ini'];
    $fecfin=$_POST['fec_fin'];


?>
<script type="text/javascript">

    $(document).ready(function() {

        $('.btn_editar').button({
            icons: {primary: "ui-icon-pencil"},
            text: false
        });
        $('.btn_info').button({
            icons: {primary: "ui-icon-info"},
            text: false
        });
        $('.btn_bar').button({
        });

        $("#tabla_producto").tablesorter({
            widgets: ['zebra', 'zebraHover'] ,
            widthFixed: true,
            headers: {
                //4: {sorter: 'shortDate' }
                10: {sorter: false }
            },
            //sortForce: [[0,0]],
            <?php if($num_rows>0){?>
            sortList: [[3,0],[2,0],[1,0]]
            <?php }?>
        });


    });
</script>
<table cellspacing="1" id="tabla_producto" class="tablesorter">
    <thead>
    <tr>
        <th>CÓDIGO</th>
        <th>NOMBRE</th>
        <th>MARCA</th>
        <th >CATEGORIA</th>
        <th align="right" nowrap>Compras con Factura</th>
        <th align="right" nowrap>Compras Nota</th>
        <th align="right" nowrap>Ventas Factura</th>
        <th align="right">Venta Boleta</th>
        <th align="right">Ventas Nota</th>
    </tr>
    </thead>
    <?php
    if($num_rows>=1){
        ?>
        <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){
            $hs1s = $oHistorial->consultar_historial_compras_por_producto_doc($dt1['tb_catalogo_id'],$_POST['alm_id'],1,fecha_mysql($fecini),fecha_mysql($fecfin),'ASC',$_SESSION['empresa_id']);
            $hs1 = mysql_fetch_array($hs1s);

            $hs2s = $oHistorial->consultar_historial_compras_por_producto_doc($dt1['tb_catalogo_id'],$_POST['alm_id'],17,fecha_mysql($fecini),fecha_mysql($fecfin),'ASC',$_SESSION['empresa_id']);
            $hs2 = mysql_fetch_array($hs2s);

            $hs3s = $oHistorial->consultar_historial_ventas_por_producto_doc($dt1['tb_catalogo_id'],$_POST['alm_id'],1,fecha_mysql($fecini),fecha_mysql($fecfin));
            $hs3 = mysql_fetch_array($hs3s);

            $hs4s = $oHistorial->consultar_historial_ventas_por_producto_doc($dt1['tb_catalogo_id'],$_POST['alm_id'],11,fecha_mysql($fecini),fecha_mysql($fecfin));
            $hs4 = mysql_fetch_array($hs4s);

            $ven_fact=$hs3['cantidad']+$hs4['cantidad'];

            $hs5s = $oHistorial->consultar_historial_ventas_por_producto_doc($dt1['tb_catalogo_id'],$_POST['alm_id'],3,fecha_mysql($fecini),fecha_mysql($fecfin));
            $hs5 = mysql_fetch_array($hs5s);

            $hs6s = $oHistorial->consultar_historial_ventas_por_producto_doc($dt1['tb_catalogo_id'],$_POST['alm_id'],12,fecha_mysql($fecini),fecha_mysql($fecfin));
            $hs6 = mysql_fetch_array($hs6s);

            $ven_bol=$hs5['cantidad']+$hs6['cantidad'];

            $hs7s = $oHistorial->consultar_historial_ventas_por_producto_doc($dt1['tb_catalogo_id'],$_POST['alm_id'],15,fecha_mysql($fecini),fecha_mysql($fecfin));
            $hs7 = mysql_fetch_array($hs7s);

            ?>
            <tr>
                <td><?php echo $dt1['tb_presentacion_cod']?></td>
                <td>
                            <span style="">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                </td>
                <td><?php echo $dt1['tb_marca_nom']?></td>
                <td><?php echo $dt1['tb_categoria_nom']?></td>
                <td align="right"><?php echo $hs1['cantidad'] ?></td>
                <td align="right"><?php echo $hs2['cantidad'] ?></td>
                <td align="right"><?php echo $ven_fact ?></td>
                <td align="right"><?php echo $ven_bol ?></td>
                <td align="right"><?php echo $hs7['cantidad'] ?></td>
            </tr>
            <?php
        }
        mysql_free_result($dts1);
        ?>
        </tbody>
        <?php
    }
    ?>
    <tr class="even">
        <td colspan="6">TOTAL</td>
        <td align="right"></td>
        <td align="right"></td>
        <td align="right"></td>
    </tr>
    <tr class="even">
        <td colspan="12"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>