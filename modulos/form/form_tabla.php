<?php
require_once ("../../config/Cado.php");
require_once ("cForm.php");
$oForm = new cForm();

$dts1=$oForm->mostrarTodos();
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
	$("#tabla_form").tablesorter({ 
		headers: {
			6: {sorter: false }, 
			7: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_form" class="tablesorter">
            <thead>
                <tr>
                	<th>ELEMENTO</th>                                
                    <th>CATEGORIA</th>
                    <th>DESCRIPCIÓN</th>
                    <th>ORDEN</th>                                        
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
                        	<td><?php echo $dt1['tb_form_ele']?></td>  
                          <td><?php echo $dt1['tb_form_cat']?></td>                            
                          	<td><?php echo $dt1['tb_form_des']?></td>
                            <td><?php echo $dt1['tb_form_ord']?></td>
                                                        
                            <td align="center"><a class="btn_editar" href="#" onClick="form_form('editar','<?php echo $dt1['tb_form_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_form('<?php echo $dt1['tb_form_id']?>')">Eliminar</a></td>
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