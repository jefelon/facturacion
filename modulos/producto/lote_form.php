<?php
require_once ("../../config/Cado.php");
require_once ("../lote/cLote.php");
$oLote = new cLote();

if($_POST['action']=="editar")
{
//	$dts=$oMarca->mostrarUno($_POST['lot_id']);
//	$dt = mysql_fetch_array($dts);
//		$mar_nom=$dt['tb_lote_nom'];
//	mysql_free_result($dts);
}
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

        $.tablesorter.defaults.widgets = ['zebra'];
        $("#tabla_lote").tablesorter({
            headers: {
                1: {sorter: false },
                2: { sorter: false}},
            //sortForce: [[0,0]],
            sortList: [[0,0]]
        });
    });
</script>
<form id="for_mar">
<input name="action_marca" id="action_marca" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_mar_id" id="hdd_mar_id" type="hidden" value="<?php echo $_POST['mar_id']?>">
    <table cellspacing="1" id="tabla_lote" class="tablesorter">
        <thead>
        <tr>
            <th>LOTE</th>
            <th>FECHA FABRICACION</th>
            <th>FECHA VENCIMIENTO</th>
            <th>STOCK INICIAL</th>
            <th>STOCK ACTUAL</th>
            <th align="center">ESTADO</th>
            <th align="center">&nbsp;</th>
        </tr>
        </thead>
        <?php
        $dts1=$oLote->mostrarLoteProducto($_POST['pre_id'],$_POST['alm_id']);
        $num_rows= mysql_num_rows($dts1);
        if($num_rows>=1)
        {
            ?>
            <tbody>
            <?php while($dt1 = mysql_fetch_array($dts1)){?>
                <tr>
                    <td><strong><?php echo $dt1['tb_lote_numero']?></strong></td>
                    <td><strong><?php echo $dt1['tb_lote_fechafab']?></strong></td>
                    <td align="right"><?php echo $dt1['tb_lote_fechavence']?></td>
                    <td align="center"><?php echo $dt1['tb_lote_exisini']?></td>
                    <td align="center"><?php echo $dt1['tb_lote_exisact']?></td>
                    <td align="center"><a class="btn_editar" onClick="lote_form('editar','<?php echo $dt1['tb_lote_id']?>')">Editar Lote</a><a class="btn_eliminar" onClick="eliminar_lote('<?php echo $dt1['tb_lote_id']?>')"> Eliminar Lote</a></td>
                </tr>
                <?php
            }
            mysql_free_result($dts1);
            ?>
            </tbody>
            <?php
        }
        else
        {
            ?>
            <tr>
                <!--<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>-->
            </tr>
        <?php }?>
    </table>
</form>