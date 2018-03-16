<?php
require_once ("../../config/Cado.php");
require_once ("cFormula.php");
$oFormula = new cFormula();

$dts1=$oFormula->mostrarTodos();
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
	$("#tabla_formula").tablesorter({ 
		headers: {
			6: {sorter: false }, 
			7: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_formula" class="tablesorter">
            <thead>
                <tr>
                	<th>ELEMENTO</th>                                
                    <th>IDENTIFICADOR</th>
                    <th>DATO</th>
                    <th>DESCRIPCIÓN</th>                    
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
                        	<td><?php echo $dt1['tb_formula_ele']?></td>  
                          <td><?php echo $dt1['tb_formula_ide']?></td>                            
                            <td><?php echo $dt1['tb_formula_dat']?></td>
                            <td><?php echo $dt1['tb_formula_des']?></td>                            
                            <td align="center" nowrap="nowrap"><a class="btn_editar" href="#" onClick="formula_form('editar','<?php echo $dt1['tb_formula_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_formula('<?php echo $dt1['tb_formula_id']?>')">Eliminar</a></td>
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