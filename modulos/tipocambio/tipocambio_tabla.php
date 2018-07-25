<?php
require_once ("../../config/Cado.php");
require_once ("cTipoCambio.php");
require_once("../formatos/formato.php");
$oTipoCambio = new cTipoCambio();

$dts1=$oTipoCambio->mostrarTodos();
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
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_tipocambio").tablesorter({ 
		headers: {
			0: {sorter: 'shortDate' },
			2: {sorter: false }
			},
		//sortForce: [[0,0]],
		sortList: [[0,1]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_tipocambio" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>               
                    <th>DOLAR SUNAT</th>                                        
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){?>
                        <tr>
                          <td><?php echo mostrarFecha($dt1['tb_tipocambio_fec'])?></td>                            
                            <td><?php echo number_format($dt1['tb_tipocambio_dolsun'],3)?></td>                            
                            <td align="center"><a class="btn_editar" href="#" onClick="tipocambio_form('editar','<?php echo $dt1['tb_tipocambio_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_tipocambio('<?php echo $dt1['tb_tipocambio_id']?>')">Eliminar</a></td>
                        </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
                </tbody>
            <?php }?>
                <tr class="even">
                  <td colspan="7"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>