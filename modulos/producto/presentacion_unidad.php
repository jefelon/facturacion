<?php
require_once ("../../config/Cado.php");
require_once ("cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();

require_once ("../formatos/formato.php");

?>

<script type="text/javascript">
$(function() {	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_agregar_unidad').button({
		icons: {primary: "ui-icon-plus"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
}); 
</script>
<style>
	div#tabla_pre_unidad { margin: 0 0; }
	div#tabla_pre_unidad table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#tabla_pre_unidad table td, div#tabla_pre_unidad table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#tabla_pre_unidad table th { height:16px }
</style>   
		<table cellspacing="0">
            <?php
			$dts1=$oPresentacion->mostrar_por_producto($_POST['pro_id']);
			$num_rows= mysql_num_rows($dts1);
			if($num_rows>=1)
			{
				$num_pre=0;
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
				$num_pre++;
					//unidad base de presentacion
					$rws= $oCatalogoproducto->presentacion_unidad_base($dt1['tb_presentacion_id']);
					$rw = mysql_fetch_array($rws);
						$unidad_base_nombre	=$rw['tb_unidad_abr'];
					mysql_free_result($rws);
				?>
                        <tr>
                          <td valign="top">
                          <?php
							$dts2=$oCatalogoproducto->mostrar_unidad_de_presentacion($dt1['tb_presentacion_id']);
							$num_rows2= mysql_num_rows($dts2);
							$unidad_base=0;
							?>
                            <div id="tabla_pre_unidad" class="ui-widget">
    <table class="ui-widget ui-widget-content">
                            <thead>
                                <tr class="ui-widget-header">
                                  <th>PRESENTACION</th>
                                  <th title="UNIDAD">UND</th>
                                  <th align="right" nowrap title="PRECIO DE COSTO">CAMBIO</th>
                                  <th align="right" nowrap title="PRECIO DE COSTO">P. COSTO US$</th>
                                    <th align="right" nowrap title="PRECIO DE COSTO">P. COSTO S/.</th>
                                    <th align="right" nowrap>UTILIDAD</th>                    
                                  <th align="right" nowrap title="PRECIO DE VENTA">P. VENTA S/.</th>
                                  <!--<th align="center" nowrap title="MOSTRAR EN CATALOGO">CATALOGO</th>-->
                                  <!--<th align="center" title="TIPO DE UNIDAD">TIPO</th>-->
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            while($dt2 = mysql_fetch_array($dts2)){
								if($dt2['unibas']==1)$unidad_base=$dt2['ub_id'];
							?>
                              <tr class="even">
                                <td><?php echo $pre_nom=$dt1['tb_presentacion_nom']?></td>
                                <td title="<?php echo $dt2['ue_nom']?>"><?php echo $dt2['ue_abr']?></td>
                                <td align="right"><?php if($dt2['tb_catalogo_tipcam']!="0.00") echo $dt2['tb_catalogo_tipcam']?></td>
                                <td align="right"><?php if($dt2['tb_catalogo_precosdol']!="0.00") echo ' US$ '.$dt2['tb_catalogo_precosdol']?></td>
                                <td align="right"><?php if($dt2['precos']!="0.00") echo ' S/. '.$dt2['precos'].mostrar_siigual($dt2['igvcom'],1,'*')?></td>
                                <td align="right"><?php echo $dt2['uti'].'%'?></td>
                                <td align="right"><?php if($dt2['preven']!="0.00") echo ' S/. '.$dt2['preven'].mostrar_siigual($dt2['igvven'],1,'*')?></td>
                                <!--<td align="center" title="Mostrar en Catálogo">
								<?php 
								//if($dt2['vercom']!="0")echo '<span title="Compras">'.mostrar_siigual($dt2['vercom'],1,'Compras').'</span> ';
								//if($dt2['verven']!="0")echo '<span title="Ventas">'.mostrar_siigual($dt2['verven'],1,'Ventas').'</span>'?>
                                </td>-->
                                <!--<td align="center"><?php 
								//if($dt2['unibas']=="1")echo '<span title="Unidad Base">'.mostrar_siigual($dt2['unibas'],1,'Base').'</span>';
								//if($dt2['unibas']=="0")echo '<span title="Unidad Alternativa">'.mostrar_siigual($dt2['unibas'],0,'Alter.').'</span>';
								?></td>-->
                                <td>
                                <a class="btn_editar" onClick="catalogo_form('editar','<?php echo $dt2['cat_id']?>','<?php echo $dt1['tb_presentacion_id']?>','<?php echo $unidad_base?>')">Editar Unidad</a>
                                <?php if($dt2['unibas']!=1){?>
                                <a class="btn_eliminar" onClick="eliminar_catalogo(<?php echo $dt2['cat_id']?>)">Eliminar Unidad</a>
                                <?php }?>
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
                          <td colspan="2">&nbsp;</td>
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