<?php
require_once ("../../config/Cado.php");
require_once ("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once ("../producto/cTag.php");
$oTag = new cTag();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
require_once ("../formatos/formato.php");

if($_POST['cat_id']>0)
{
	$dts1=$oCategoria->mostrarUno($_POST['cat_id']);
	$dt1 = mysql_fetch_array($dts1);
	$idp1=$dt1['tb_categoria_idp'];
	mysql_free_result($dts1);
	
	if($idp1==0)
	{
		$cat_id=$_POST['cat_id'];
	}
	else
	{
		$dts1=$oCategoria->mostrarUno($idp1);
		$dt1 = mysql_fetch_array($dts1);
		$idp2=$dt1['tb_categoria_idp'];
		mysql_free_result($dts1);
		
		if($idp2==0)
		{
			$cat_id=$idp1;
		}
		else
		{
			$cat_id=$idp2;		
		}	
	}
}
?>
<script type="text/javascript">
$(function() {
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_tag_agregar').button({
		icons: {primary: "ui-icon-plus"},
		text: false
	});
	
	$('.btn_eliminar_tag').button({
		icons: {primary: "ui-icon-minus"},
		text: false
	});
}); 
</script>
<style>
	div#tabla_tag { margin: 0 0; }
	div#tabla_tag table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#tabla_tag table td, div#tabla_tag table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#tabla_tag table th { height:16px }
</style>   
		<table cellspacing="0">
            <?php
			$dts1=$oPresentacion->mostrar_por_producto($_POST['pro_id']);
			$num_rows= mysql_num_rows($dts1);
			if($num_rows>=1)
			{
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
				?>
                		<tr>
                          <td><?php echo $dt1['tb_presentacion_nom']?></td>
                        </tr>
                        <tr>
                          <td valign="top">
                            <div id="tabla_tag" class="ui-widget">
    					<table class="ui-widget ui-widget-content">
                            <thead>
                                <tr class="ui-widget-header">
                                  <th>ATRIBUTO</th>
                                  <th>VALOR</th>
                                    <th><a id="btn_tag_form" class="btn_tag_agregar" href="#" onClick="tag_form('insertar',<?php echo $dt1['tb_presentacion_id']?>)" title="Agregar Atributo">Agregar</a></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
							$dts2=$oTag->mostrar_atributo_valor_por_presentacion($dt1['tb_presentacion_id']);
							$num_rows2= mysql_num_rows($dts2);
                            while($dt2 = mysql_fetch_array($dts2)){
								if($cat_id!=$dt2['tb_categoria_id'])
								{
									$msj="Una o más atributos no pertenecen a la categoría. Para no tener incongruencia en los filtros de búsqueda elimine los atributos y agregue nuevos o bien cambie de categoría.";
								}
							?>
                              <tr class="even">
                                <td><?php echo $dt2['atributo']?></td>
                                <td><?php echo $dt2['valor']?></td>
                                <td>
                                <a class="btn_eliminar_tag" onClick="eliminar_tag(<?php echo $dt2['tb_tag_id']?>)">Quitar Atributo</a>
                                </td>
                              </tr>
                            <?php
							}
							mysql_free_result($dts2);
							?>
                           	</tbody>
                            </table>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td><div class="ui-state-error ui-corner-all" style="width:auto; float:left; padding:2px; display:<?php if($msj!=""){echo 'block';} else{ echo 'none';}?>"><?php echo $msj?></div></td>
                        </tr>
                        <tr>
                          <td>&nbsp;
						  
						  </td>
                        </tr>
                <?php
                }
                mysql_free_result($dts1);
                ?>
            </tbody>
            <?php
            }
            ?>
        </table>