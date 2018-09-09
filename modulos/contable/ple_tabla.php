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
                  <th>FECHA</th>
                    <th>N° DOC</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){?>
                        <tr>
                            <td><?php echo $dt1['tb_compra_reg'] ?></td>
                            <td><?php echo $dt1['tb_compra_numdoc'] ?></td>
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