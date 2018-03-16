<?php
require_once ("Cado.php");	
require_once ("Clases/cKardex.php");
$oKardex = new cKardex();
require_once ("Libreria/formato.php");

	
$rs = $oKardex->mostrar_datos_producto($_POST['cat_id']);
$dt = mysql_fetch_array($rs);			
	$alm = $dt['tb_almacen_nom'];//establecimiento			
	$cod = $dt['tb_presentacion_cod'];//codigo de la existencia			
	$cat = $dt['tb_categoria_nom'];//tipo
	$nom = $dt['tb_producto_nom'];//descripcion
	$cat_precos = $dt['tb_catalogo_precos'];//descripcion
mysql_free_result($rs);
	
	$fecini='01-01-2013';
	$fecfin='';
	
	$dts1 = $oKardex->mostrar_kardex_por_producto($_POST['cat_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin));	
	$num_rows_1 = mysql_num_rows($dts1);
	if($num_rows_1 > 0){
	}
?>
<script type="text/javascript">
function kardex_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "kardex_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			alm_id:	idf,
			vista:	'almacen_tabla'
		}),
		beforeSend: function() {
			$('#msj_almacen').hide();
			$('#div_almacen_form').dialog("open");
			$('#div_almacen_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_almacen_form').html(html);				
		}
	});
}

$(function() {
	
	//$.tablesorter.defaults.widgets = ['zebra'];
	//$("#tabla_kardex").tablesorter({});
	$('.btn_act_stock').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$( "#div_kardex_form" ).dialog({
		title:'Información de Almacén',
		autoOpen: false,
		resizable: false,
		height: 180,
		width: 500,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_alm").submit();
			},
			Cancelar: function() {
				$('#for_alm').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
}); 
</script>
<style>
	div#div_tabla_kardex { margin: 0 0; }
	div#div_tabla_kardex table { margin: 0 0; border-collapse: collapse; width: 100%; }
	div#div_tabla_kardex table td, div#div_tabla_kardex table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#div_tabla_kardex table th { height:18px }
	div#div_tabla_kardex table td { height:17px }
</style>

<div id="div_kardex_form"></div>
<div id="div_tabla_kardex" class="ui-widget">
<table border="0" cellspacing="2" cellpadding="2" class="ui-widget ui-widget-content">
    <thead>
    	<tr class="ui-widget-header">
        	<th colspan="4">DOCUMENTO</th>            
            <th rowspan="2">TIPO DE OPERACI&Oacute;N</th>
            <th colspan="1">ENTRADAS</th>
            <th colspan="1">SALIDAS</th>
            <th colspan="1">SALDO FINAL</th>
        </tr>
        <tr class="ui-widget-header">
            <th>ID</th>
            <th>FECHA</th>
            <?php /*?><th>NOTA ALMACEN</th><?php */?>
            <th>TIPO DE DOCUMENTO</th>
            <th>NUMERO DE DOCUMENTO</th>
            <!--TIPO OPERACIÓN-->
            <th>CANTIDAD</th>
            <?php /*?><th>COSTO UNITARIO</th>
            <th>COSTO TOTAL</th><?php */?>
            <th>CANTIDAD</th>
            <?php /*?><th>COSTO UNITARIO</th>
            <th>COSTO TOTAL</th><?php */?>
            <th>CANTIDAD</th>
            <?php /*?><th>COSTO UNITARIO</th>
            <th>COSTO TOTAL</th><?php */?>                      
        </tr>
    </thead>
    <tbody>
        <?php
			$cantidad_total = 0;
			$precio_promedio = 0;
			$costo_total = 0;
			$cantidad_total_entradas = 0;
			$cantidad_total_salidas = 0;
			$costo_total_entradas = 0;
			$costo_total_salidas = 0;
			
            while($dt1 = mysql_fetch_array($dts1)){

            	//if($dt1['tb_documento_id']==6){
            	//}

            	$documento=$dt1['tb_documento_nom'];

            	if($dt1['tb_tipoperacion_id']==1){
            		$operacion='STOCK INICIAL';
            		$documento='DOC. INTERNO';
            	}

            	if($dt1['tb_tipoperacion_id']==2)$operacion='COMPRA';
            	if($dt1['tb_tipoperacion_id']==3)$operacion='VENTA';
            	if($dt1['tb_tipoperacion_id']==4){
            		$operacion='TRANS. INGRESO';
            		$documento='TRANS. INTERNA';
            	}
            	if($dt1['tb_tipoperacion_id']==5){
            		$operacion='TRANS. SALIDA';
            		$documento='TRANS. INTERNA';
            	}
            	if($dt1['tb_tipoperacion_id']==6){
            		$operacion='NOTA ALMACEN';
            		$documento='NOTA INTERNA';
            	}

            	if($dt1['tb_tipoperacion_id']==7){
            		$operacion='NOTA DE CREDITO';
            		$documento='DOC. INT.';
            	}
			?>
                <tr>
                	<td><?php echo $dt1['tb_kardex_id']?></td>
                    <td nowrap="nowrap" title="<?php echo 'Registrado: '.mostrarFechaHoraH($dt1['tb_kardex_reg'])?>"><?php echo mostrarFecha($dt1['tb_kardex_fec'])?></td>
                    <?php /*?><td nowrap="nowrap"><?php echo $dt1['tb_kardex_cod']?></td><?php */?>
					<td><?php echo $documento?></td>
    				<td><?php echo $dt1['tb_kardex_numdoc'].$tra_ref;?></td>                	
                    <td><?php echo $operacion?></td>
                    <?php 					
						$can = $dt1['tb_kardexdetalle_can'];						
						$tip = $dt1['tb_kardex_tip'];//Verificando si es Entrada o Salida (1: ENTRADA | 2: SALIDA)
						
						if($tip == 1){							
							$precos = $dt1['tb_kardexdetalle_cos'];
							
							if($dt1['tb_tipoperacion_id']==1)$precos=$cat_precos;
							
							$subtotal = $can*$precos;
							$cantidad_total += $can;
							$cantidad_total_entradas += $can;
							$costo_total_entradas += $subtotal;
							}?>

                        	<td align="right" nowrap="nowrap"><?php
							 if($tip == 1)echo $can;
							 if($dt1['tb_tipoperacion_id']==1){/*
							 ?>
                             <a class="btn_act_stock" onClick="kardex_form('actualizar_saldo_inicial','<?php echo $dt1['tb_kardexdetalle_id']?>','<?php echo $dt['tb_almacen_id']?>','<?php echo $stock_id?>')">Actualizar</a>
                             <?php */}?>
                             </td>
							<?php /*?><td align="right"><?php //if($tip == 1)echo formato_moneda($precos);?></td>  
                    		<td align="right"><?php //if($tip == 1)echo formato_moneda($subtotal);?></td><?php */?>
<?php														
						
						if($tip == 2){							
							$precos = $dt1['tb_kardexdetalle_pre'];
							$subtotal = $can*$precos;
							$cantidad_total -= $can;
							$cantidad_total_salidas += $can;
							$costo_total_salidas += $subtotal;}?>

                  <td align="right"><?php if($tip == 2)echo $can?></td>
							<?php /*?><td align="right"><?php //if($tip == 2)echo formato_moneda($precos);?></td>  
                    		<td align="right"><?php //if($tip == 2)echo formato_moneda($subtotal);?></td><?php */?>
							<?php								
									
						if($cantidad_total>0)$precio_promedio = ($subtotal+$costo_total)/$cantidad_total;			
					?>
                  <td align="right"><?php echo $cantidad_total?></td>
                    <?php /*?><td align="right"><?php //echo formato_moneda($precio_promedio);?></td>  
                    <td align="right"><?php //echo formato_moneda($cantidad_total*$precio_promedio);?></td><?php */?>              
      </tr>                                                            
                <?php
            }
			mysql_free_result($dts1);
			?>
            <tr>
                <td colspan="5"><strong>TOTAL</strong></td>                    
				<td align="right"><strong><?php echo $cantidad_total_entradas?></strong></td>
                <?php /*?><td align="right">&nbsp;</td>
                <td align="right"><strong><?php //echo formato_moneda($costo_total_entradas)?></strong></td><?php */?>             
                <td align="right"><strong><?php echo $cantidad_total_salidas?></strong></td>
                <?php /*?><td align="right">&nbsp;</td>
                <td align="right"><strong><?php //echo formato_moneda($costo_total_salidas)?></strong></td><?php */?>
                <td align="right"><strong><?php echo $cantidad_total_entradas-$cantidad_total_salidas?></strong></td>
                <?php /*?><td align="right">&nbsp;</td>
                <td align="right">&nbsp;</td><?php */?>
            </tr>
    </tbody>
</table>
</div>