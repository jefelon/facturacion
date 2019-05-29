<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");



if($_SESSION['almacen_id']>0)
{
    $dts1=$oCatalogo->catalogo_filtro($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$_SESSION['almacen_id'],$cadena_atr,1,1,$_POST['unibas']);
    $num_rows= mysql_num_rows($dts1);
}
else
{
    $num_rows=0;
}

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

        $("#tabla_producto").tablesorter({
            widgets: ['zebra', 'zebraHover'] ,
            widthFixed: true,
            headers: {
                //4: {sorter: 'shortDate' }
                10: {sorter: false }
            },
            //sortForce: [[0,0]],
            <?php if($num_rows>0){?>
            sortList: [[2,0],[1,0],[0,0]]
            <?php }?>
        });


    });
</script>
<table cellspacing="1" id="tabla_producto" class="tablesorter">
    <thead>
    <tr>
        <th>CODIGO</th>
        <th>NOMBRE</th>
        <?php /*?><th>PRES</th><?php */?>
        <th>MARCA</th>
        <th>CATEGORIA</th>
        <?php /*?><th>UNIDAD</th><?php */?>
        <th align="right" nowrap>P. COSTO S/.</th>
        <th align="right" nowrap>UTI %</th>
        <th align="right" nowrap>P.  VENTA S/.</th>
        <th align="right">STOCK</th>
        <th align="right">STOCK MINIMO</th>
    </tr>
    </thead>
    <?php
    if($num_rows>=1){
        ?>
        <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){
            $stock=$dt1['tb_stock_num'];

            $st_uni=floor($stock/$dt1['tb_catalogo_mul']);
            $st_res=$stock%$dt1['tb_catalogo_mul'];

            if($st_res!=0){
                //$stock_unidad="$st_uni + r$st_res";
                $stock_unidad="$st_uni";
            } else{
                $stock_unidad="$st_uni";
            }

            if ($stock_unidad<$dt1['tb_presentacion_stomin']){

            ?>
            <tr>
                <td><?php echo $dt1['tb_presentacion_cod']?></td>
                <td>
                            <span style="">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                </td>
                <?php /*?><td>
							<span style="">
							<?php echo $dt1['tb_presentacion_nom']?>
                            </span>
                            </td><?php */?>
                <td><?php echo $dt1['tb_marca_nom']?></td>
                <td><?php echo $dt1['tb_categoria_nom']?></td>
                <?php /*?><td title="<?php echo $dt1['tb_unidad_nom']?>">
							<span style="">
							<?php echo $dt1['tb_unidad_abr']?>
                            </span>
                            </td><?php */?>
                <td align="right"><?php if($dt1['tb_catalogo_precos']!=0)echo formato_money($dt1['tb_catalogo_precos'])?></td>
                <td align="right"><?php echo $dt1['tb_catalogo_uti']?></td>
                <td align="right"><?php if($dt1['tb_catalogo_preven']!=0)echo formato_money($dt1['tb_catalogo_preven'])?></td>
                <td align="right">
                    <?php echo $stock_unidad?>
                </td>
                <td><?php echo $dt1['tb_presentacion_stomin']?></td>
                <?php /*?><td align="right">
							<?php if($dt1['tb_catalogo_unibas']==1 and $stock_unidad<=$dt1['tb_presentacion_stomin'])
							{
								echo "Por debajo de stock mínimo.";
							}
							?></td><?php */?>
            </tr>
            <?php
            }
        }
        mysql_free_result($dts1);
        ?>
        </tbody>
        <?php
    }
    ?>
    <tr class="even">
        <td colspan="9"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>
