<?php
require_once ("../../config/Cado.php");
require_once ("cAtributo.php");
$oAtributo = new cAtributo();

//$dts=$oAtributo->mostrar_categorias();
//$num_rows= mysql_num_rows($dts);
//mysql_free_result($dts);
?>
<script type="text/javascript">
$(function() {	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	$('.btn_editar_val').button({
		icons: {primary: "ui-icon-plus"},
		text: true
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});

	//$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_atributo").tablesorter({ 
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		//sortList: [[1,0]]
    });
}); 
</script>
        <table width="500" cellspacing="1" id="tabla_atributo1" class="tablesorter">
            <thead>
                <tr>
                <th>NOMBRE</th>                
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
        <?php
		$dts=$oAtributo->mostrar_categorias();
		$num_rows= mysql_num_rows($dts);
        if($num_rows>=1){
			while($dt = mysql_fetch_array($dts)){
		?>  
            <tbody>
            	<tr class="hover">
                  <td><span style="font-size:11px; font-weight: bold;"><?php echo 'CATEGORÍA: '.$dt['tb_categoria_nom']?></span></td>
                  <td align="center"><a class="btn_editar_val" href="#" onClick="atributo_val_form('insertar','','<?php echo $dt['tb_categoria_id']?>')">Agregar Valores</a></td>
                  <td align="center">&nbsp;</td>
                </tr>
			<?php
            $dts1=$oAtributo->mostrar_por_categoria($dt['tb_categoria_id']);
            $num_rows1= mysql_num_rows($dts1);
            if($num_rows1>0){
            	while($dt1 = mysql_fetch_array($dts1)){
            ?>
                <tr class="even">
                <td><span style="font-size:11px; font-weight: bold; margin-left:15px;"><?php echo $dt1['tb_atributo_nom']?></span></td>
                <td align="center"><a class="btn_editar" href="#update" onClick="atributo_form('editar','<?php echo $dt1['tb_atributo_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#delete" onClick="eliminar_atributo('<?php echo $dt1['tb_atributo_id']?>')">Eliminar</a></td>
                </tr>
                <?php
				//nivel 2
				$dts2=$oAtributo->mostrar_por_idp($dt1['tb_atributo_id']);
				$num_rows2= mysql_num_rows($dts2);
				if($num_rows2>0){
				while($dt2 = mysql_fetch_array($dts2)){
				?>
                <tr class="even">
                <td><span style="font-size:11px; margin-left:30px;"><?php echo '-'.$dt2['tb_atributo_nom']?></span></td>
                <td align="center"><a class="btn_editar" href="#update" onClick="atributo_val_form('editar','<?php echo $dt2['tb_atributo_id']?>','<?php echo $dt['tb_categoria_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#delete" onClick="eliminar_atributo('<?php echo $dt2['tb_atributo_id']?>')">Eliminar</a></td>
                </tr>
                <?php
				//nivel 3
				$dts3=$oAtributo->mostrar_por_idp($dt2['tb_atributo_id']);
				$num_rows3= mysql_num_rows($dts3);
				if($num_rows3>0){
				while($dt3 = mysql_fetch_array($dts3)){
				?>
                <tr class="even">
                <td><span style="font-size:10px; margin-left:45px;"><?php echo '-'.$dt3['tb_atributo_nom']?></span></td>
                <td align="center"><a class="btn_editar" href="#update" onClick="atributo_form('editar','<?php echo $dt3['tb_atributo_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#delete" onClick="eliminar_atributo('<?php echo $dt3['tb_atributo_id']?>')">Eliminar</a></td>
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
            	<tr class="even">
                  <td colspan="3">&nbsp;</td>
                </tr>
            </tbody>
     	<?php
			}//fin wile categoria
        }//fin inicial
		?>
                <tr class="even">
                  <td colspan="3"><?php //echo $num_rows1.' registros'?></td>
                </tr>
        </table>