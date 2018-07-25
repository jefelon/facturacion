<?php
require_once ("../../config/Cado.php");
require_once ("cCategoria.php");
$oCategoria = new cCategoria();

$dts=$oCategoria->mostrarTodos();
$num_rows= mysql_num_rows($dts);
mysql_free_result($dts);
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

	//$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_categoria").tablesorter({ 
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[1,0]]
    });
}); 
</script>
        <table width="500" cellspacing="1" id="tabla_categorias" class="tablesorter">
            <thead>
                <tr>
                <th>NOMBRE</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
        <?php
        if($num_rows>=1){
		?>  
            <tbody>
			<?php
            $dts1=$oCategoria->mostrar_cat_idp();
            $num_rows1= mysql_num_rows($dts1);
            if($num_rows1>0){
            	while($dt1 = mysql_fetch_array($dts1)){
            ?>
                <tr class="even">
                <td><span style="font-size:11px; font-weight: bold;" title="<?php echo $dt1['tb_categoria_id']?>"><?php echo $dt1['tb_categoria_nom']?></span></td>
                <td align="center"><a class="btn_editar" href="#update" onClick="categoria_form('editar','<?php echo $dt1['tb_categoria_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#delete" onClick="eliminar_categoria('<?php echo $dt1['tb_categoria_id']?>')">Eliminar</a></td>
                </tr>
                <?php
				//nivel 2
				$dts2=$oCategoria->mostrar_por_idp($dt1['tb_categoria_id']);
				$num_rows2= mysql_num_rows($dts2);
				if($num_rows2>0){
				while($dt2 = mysql_fetch_array($dts2)){
				?>
                <tr class="even">
                <td><span style="font-size:11px; margin-left:15px;" title="<?php echo $dt2['tb_categoria_id']?>"><?php echo '-'.$dt2['tb_categoria_nom']?></span></td>
                <td align="center"><a class="btn_editar" href="#update" onClick="categoria_form('editar','<?php echo $dt2['tb_categoria_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#delete" onClick="eliminar_categoria('<?php echo $dt2['tb_categoria_id']?>')">Eliminar</a></td>
                </tr>
                <?php
				//nivel 3
				$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
				$num_rows3= mysql_num_rows($dts3);
				if($num_rows3>0){
				while($dt3 = mysql_fetch_array($dts3)){
				?>
                <tr class="even">
                <td><span style="font-size:10px; margin-left:30px;" title="<?php echo $dt3['tb_categoria_id']?>"><?php echo '-'.$dt3['tb_categoria_nom']?></span></td>
                <td align="center"><a class="btn_editar" href="#update" onClick="categoria_form('editar','<?php echo $dt3['tb_categoria_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#delete" onClick="eliminar_categoria('<?php echo $dt3['tb_categoria_id']?>')">Eliminar</a></td>
                </tr>
			<?php
				}
					mysql_free_result($dts3);
				}//fin nivel 3
				
				}
					mysql_free_result($dts2);
				}//fin nivel 2
				
				}
				mysql_free_result($dts1);
            }//fin nivel 1
            ?>
            </tbody>
     	<?php
        }
		?>
                <tr class="even">
                  <td colspan="3"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>