<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../formatos/formato.php");

//agregar a cesta
if($_POST['action']=='agregar')
{
		//producto por catalogo y stock y almacen
		$dts= $oCatalogoproducto->presentacion_catalogo($_POST['cat_id']);
		$dt = mysql_fetch_array($dts);
			$pro_nom=$dt['tb_producto_nom'];
			$pre_nom=$dt['tb_presentacion_nom'];
			$pre_id	=$dt['tb_presentacion_id'];
			$cat_mul=$dt['tb_catalogo_mul'];
			$nombre_producto=$pro_nom.' '.$pre_nom;
		mysql_free_result($dts);
		
		//verificar si el producto se encuentra en el carrito de encarte, con otra presentacion
		$num=0;
		if(isset($_SESSION['encarte_car']))
		{
			foreach($_SESSION['encarte_car'] as $indice=>$catalogo_id){
				if(($_POST['cat_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$indice]))
				{
					$num++;
				}
			}
		}
		
		if($num==0 or $num==1)
		{
			$_SESSION['encarte_car'][$_POST['cat_id']]=$_POST['cat_id'];
			
			//utilidad 1
			$_SESSION['encarte_cos'][$_POST['cat_id']]=$_POST['cat_cos'];
			
			//utilidad 1
			$_SESSION['encarte_uti1'][$_POST['cat_id']]=$_POST['cat_uti1'];
			//preven 1
			$_SESSION['encarte_preven1'][$_POST['cat_id']]=$_POST['cat_preven1'];
			
			//descuento porcentaje		
			$_SESSION['encarte_despor'][$_POST['cat_id']]=$_POST['encdet_despor'];
			
			//utilidad 2
			$_SESSION['encarte_uti2'][$_POST['cat_id']]=$_POST['cat_uti2'];
			//preven 2
			$_SESSION['encarte_preven2'][$_POST['cat_id']]=$_POST['cat_preven2'];

		}
		
		if($num>1)
		{
			$msj='No se permite agregar más de 2 unidades de una sola presentación de producto.';
		}

}

//quitar valores del array
if($_POST['action']=='quitar')
{
	unset($_SESSION['encarte_car'][$_POST['cat_id']]);
	unset($_SESSION['encarte_cos'][$_POST['cat_id']]);
	unset($_SESSION['encarte_uti1'][$_POST['cat_id']]);
	unset($_SESSION['encarte_preven1'][$_POST['cat_id']]);
	unset($_SESSION['encarte_despor'][$_POST['cat_id']]);
	unset($_SESSION['encarte_uti2'][$_POST['cat_id']]);
	unset($_SESSION['encarte_preven2'][$_POST['cat_id']]);
}

//restablecer o eliminar array
if($_POST['action']=='restablecer')
{
	unset($_SESSION['encarte_car']);
	unset($_SESSION['encarte_cos']);
	unset($_SESSION['encarte_uti1']);
	unset($_SESSION['encarte_preven1']);
	unset($_SESSION['encarte_despor']);
	unset($_SESSION['encarte_uti2']);
	unset($_SESSION['encarte_preven2']);
}

if(isset($_SESSION['encarte_car']))
{
	$num_rows=count($_SESSION['encarte_car']);
	if($num_rows==0)$num_rows="";
}
else
{
	$num_rows="";
}
?>
<script type="text/javascript">
$('.moneda2').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9999.99'
});
$('.porcentaje_car').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99.99'
});
$('.btn_rest_car').button({
	icons: {
		//primary: "ui-icon-cart"//,
		secondary: "ui-icon-cart"
	},
	text: true
});
$('.btn_rest_act').button({
	icons: {
		//primary: "ui-icon-cart"//,
		secondary: "ui-icon-refresh"
	},
	text: false
});

$('.btn_agregar_producto').button({
	icons: {
		primary:  "ui-icon-plus"
	},
	text: true
});

$('.btn_quitar').button({
	icons: {primary: "ui-icon-minus"},
	text: false
});
	
$('.btn_item').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});

$(function() {
	
	$("#tabla_encarte_car").tablesorter({
		widgets : ['zebra'],
		//headers: {
			//0: {sorter: false },
			//8: {sorter: false }
			//},
		//sortForce: [[0,0]],	
		//sortList: [[2,0]]
    });
}); 
</script>
<input name="hdd_enc_numite" id="hdd_enc_numite" type="hidden" value="<?php echo $num_rows?>">
<fieldset><legend>Detalle de Encarte</legend>
<a class="btn_agregar_producto" title="Agregar Producto (A+P)" href="#" onClick="catalogo_encarte()">Agregar</a>
<a class="btn_rest_car" href="#" onClick="encarte_car('restablecer')">Vaciar</a>
<a class="btn_rest_act" href="#" onClick="encarte_car('actualizar')">Actualizar</a>

<div id="msj_encarte_car" class="ui-state-error ui-corner-all" style="width:auto; float:right; padding:2px; display:<?php if($msj!=""){echo 'block';} else{ echo 'none';}?>"><?php echo $msj?></div>

<div id="msj_encarte_car_item" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>

<div style="width:auto; float:right;">
<?php 
	if($num_rows=="" or $num_rows==0)echo 'Ningún ítem agregado.';
	if($num_rows==1)echo $num_rows.' ítem agregado.';
	if($num_rows>=2)echo $num_rows.' ítems agregados.';
?>
</div>
</fieldset>
        <table cellspacing="1" id="tabla_encarte_car" class="tablesorter">
            <thead>
                <tr>
                  	<th>PRODUCTO</th>
                    <th title="UNIDAD">UNID</th>
                    <th align="right" nowrap title="COSTO PROMEDIO EN SOLES">COSTO PROM</th>
                  	<th align="right" title="PRECIO UNITARIO">UTI %</th>
                  	<th align="right" nowrap title="PRECIO DE VENTA">  P.  VENTA S/.</th>
                  	<th align="right" nowrap="nowrap" title="DESCUENTO %">DSCTO %</th>
                    <th align="right" nowrap="nowrap" title="DESCUENTO %">UTI%</th>
                    <th align="right" nowrap title="PRECIO MINIMO">  P.  VENTA. S/.</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
<?php
if($num_rows>0){
?>
            <tbody>
            <?php
			foreach($_SESSION['encarte_car'] as $indice=>$catalogo_id){
				
				//consulta de datos			
				$dts1=$oCatalogoproducto->presentacion_catalogo($indice);
				$dt1 = mysql_fetch_array($dts1);
				
				//$precos	=$dt1['tb_catalogo_precos'];
				//$uti1		=$dt1['tb_catalogo_uti'];
				//$preven1=$dt1['tb_catalogo_preven'];
				
				$cos		=$_SESSION['encarte_cos'][$indice];
				$uti1		=$_SESSION['encarte_uti1'][$indice];
				$preven1=$_SESSION['encarte_preven1'][$indice];
				$despor	=$_SESSION['encarte_despor'][$indice];
				$uti2		=$_SESSION['encarte_uti2'][$indice];
				$preven2=$_SESSION['encarte_preven2'][$indice];

				?>
                        <tr>
                          	<td><?php echo $dt1['tb_producto_nom']?></td>
                            <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                          	<td align="right"><?php echo formato_money($cos)?></td>
                            <td align="right"><?php echo formato_money($uti1)?></td>
                            <td align="right"><strong><?php echo formato_money($preven1)?></strong></td>
                            <td align="right"><?php echo formato_money($despor)?></td>
                            <td align="right"><?php echo formato_money($uti2)?></td>
                            <td align="right"><strong><?php echo formato_money($preven2)?></strong></td>
                            <td align="center" nowrap="nowrap">
                            <a class="btn_item" href="#" onClick="editar_datos_item('<?php echo $dt1['tb_catalogo_id']?>','<?php echo $dt1['tb_producto_nom']?>')">Actualizar Datos de Item</a>
                            <a class="btn_quitar" href="#" onClick="encarte_car('quitar','<?php echo $dt1['tb_catalogo_id']?>')">Quitar</a></td>
                        </tr>
            <?php
                mysql_free_result($dts1);
			}	
            ?>
            </tbody>
<?php
}
else
{
?>
            <tr>
              <td colspan="9">&nbsp;</td>
            </tr>
<?php
}
?>
        </table>