<?php
require_once ("../../config/Cado.php");
require_once ("cDocumento.php");
$oDocumento = new cDocumento();

require_once ("../formatos/formatos.php");

$dts=$oDocumento->mostrarTodos();
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

	$.tablesorter.defaults.widgets = ['zebra'];
	/*$("#tabla_documento").tablesorter({ 
		headers: {
			2: {sorter: false }, 
			3: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });*/
}); 
</script>
        <table cellspacing="1" id="tabla_documento" class="tablesorter">
            <thead>
                <tr>
                  <th>ABREVIATURA</th>
                <th>NOMBRE</th>
                <th>MOSTRAR</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
        <?php
        if($num_rows>=1){
		?>  
            <tbody>
		<?php
		$dts1=$oDocumento->mostrar_tipo();
		while($dt1 = mysql_fetch_array($dts1)){
		?>
        		<tr class="hover">
        		  <th colspan="5" valign="bottom"><strong>
				  <?php 
					switch ($dt1['tb_documento_tip']) {
						case 0:
							echo "SIN CLASIFICAR";
						break;
						case 1:
							echo "COMPRA";
						break;
						case 2:
							echo "VENTA";
						break;
						case 3:
							echo "NOTA DE VENTA";
						break;
						case 4:
							echo "NOTA DE ALMACEN";
						break;
						case 5:
							echo "TRANSFERENCIA";
						break;
                        case 10:
                            echo "COTIZACIÓN";
					}
				  ?></strong></th>
      		  </tr>
       		  <?php	
			$dts=$oDocumento->mostrar_por_tipo($dt1['tb_documento_tip']);
           	while($dt = mysql_fetch_array($dts)){
            ?>
                <tr class="even">
                  <td><?php echo $dt['tb_documento_abr']?></td>
                <td><?php echo $dt['tb_documento_nom'];
                if($dt1['tb_documento_tip']==2){
	                echo mostrar_siigual($dt['tb_documento_mos'],1,' (Disponible)');
	                echo mostrar_siigual($dt['tb_documento_mos'],0,' ');
            	}
                ?></td>
                <td><?php echo mostrar_siigual($dt['tb_documento_def'],1,'Por defecto');
                ?></td>
                <td align="center"><a class="btn_editar" href="#" onClick="documento_form('editar','<?php echo $dt['tb_documento_id']?>')">Editar</a></td>
                <td align="center"><a class="btn_eliminar" href="#" onClick="eliminar_documento('<?php echo $dt['tb_documento_id']?>')">Eliminar</a></td>
                </tr>
			<?php
				}
				mysql_free_result($dts);
			?>
            <tr class="even">
                  <td colspan="5">&nbsp;</td>
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
                  <td colspan="5"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>