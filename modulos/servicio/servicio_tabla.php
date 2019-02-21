<?php
require_once ("../../config/Cado.php");
require_once ("cServicio.php");
$oServicio = new cServicio();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");


if(isset($_POST['ser_cat']) and $_POST['ser_cat']>0)
{
	$dc=$_POST['ser_cat'].'';
	
	$dts2=$oCategoria->mostrar_por_idp($_POST['ser_cat']);
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

$dts1=$oServicio->mostrar_filtro($_POST['ser_nom'], $dc, $_POST['ser_est'],$_POST['limit']);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('.btn_presentacion').button({
		icons: {primary: "ui-icon-clipboard"},
		text: false
	});
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_servicio").tablesorter({ 
		headers: {
			4: {sorter: 'shortDate' },
			7: {sorter: false }, 
			8: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>

        <table cellspacing="1" id="tabla_servicio" class="tablesorter">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>DESCRIPCION</th>
                    <th>PRECIO</th>                    
                    <th>CATEGORIA</th>                    
                    <th>ESTADO</th>                    
                    <th>&nbsp;</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){?>
                        <tr>
                            <td><?php echo $dt1['tb_servicio_nom']?></td>
                            <td><?php echo $dt1['tb_servicio_des']?></td> 
                             <td><?php echo formato_money($dt1['tb_servicio_pre'])?></td>                            
                            <td><?php echo $dt1['tb_categoria_nom']?></td>                            
                            <td><?php echo $dt1['tb_servicio_est']?></td>
                            <?php if($dt1['tb_servicio_id']!='1'){?>
                                <td align="center" nowrap><a class="btn_editar" href="#editar" onClick="servicio_form('editar','<?php echo $dt1['tb_servicio_id']?>')">Editar</a><a class="btn_eliminar" href="#eliminar" onClick="eliminar_servicio('<?php echo $dt1['tb_servicio_id']?>')"> Eliminar</a></td>
                            <?php }?>
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
                  <td colspan="8"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
