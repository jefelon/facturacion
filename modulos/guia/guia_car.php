<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
require_once ("../traspaso/cTraspaso.php");
require_once ("../venta/cVenta.php");
$oCatalogoProducto = new cCatalogoProducto();
$oTraspaso = new cTraspaso();
$oVenta = new cVenta();
require_once ("../formatos/formato.php");

$igv_dato=0.18;

//agregar a cesta
if($_POST['action']=='agregar')
{
	if($_POST['cat_can']>0)
	{
		//producto por catalogo y stock y almacen
		$dts= $oCatalogoProducto->presentacion_catalogo($_POST['cat_id']);
		$dt = mysql_fetch_array($dts);
			$pro_nom=$dt['tb_producto_nom'];
			$pre_nom=$dt['tb_presentacion_nom'];
			$pre_id	=$dt['tb_presentacion_id'];
			$sto_num=$dt['tb_stock_num'];
			$cat_mul=$dt['tb_catalogo_mul'];
			$nombre_producto=$pro_nom.' '.$pre_nom;
		mysql_free_result($dts);
		
		$num=0;
		if(isset($_SESSION['guia_car']))
		{
			foreach($_SESSION['guia_car'] as $indice=>$cantidad){
				if(($_POST['cat_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$indice]))
				{
					$num++;
				}
			}
		}
		
		if($num==0 or $num==1)
		{
			$_SESSION['guia_car'][$_POST['cat_id']]=$_POST['cat_can'];//id cat - cantidad		
			$_SESSION['presentacion_id'][$_POST['cat_id']]=$pre_id;//id cat-presentacion - pre_id
		}
		
		if($num>1)
		{
			$msj='No se permite agregar mas de 2 unidades de una sola presentación de producto.';
		}		
	}
}

//quitar valores del array
if($_POST['action']=='quitar')
{
	unset($_SESSION['guia_car'][$_POST['cat_id']]);	
	unset($_SESSION['presentacion_id'][$_POST['cat_id']]);
}

//restablecer o eliminar array
if($_POST['action']=='restablecer'){
	unset($_SESSION['guia_car']);	
	unset($_SESSION['presentacion_id']);
}


if($_POST['action']=="consultar_detalle_trapaso"){
	//$_POST[cat_id] (en este caso es el traspaso_id)
	$dts = $oTraspaso->mostrar_traspaso_detalle($_POST['cat_id']);
	while($dt = mysql_fetch_array($dts)){				
		$_SESSION['guia_car'][$dt['tb_catalogo_id']] = $dt['tb_traspasodetalle_can'];		
	}		
}

if($_POST['action']=="consultar_detalle_venta"){
	//$_POST[cat_id] (en este caso es el venta_id)
	$dts = $oVenta->mostrar_venta_detalle($_POST['cat_id']);
	while($dt = mysql_fetch_array($dts)){			
		$_SESSION['guia_car'][$dt['tb_catalogo_id']] = $dt['tb_ventadetalle_can'];		
	}		
}

if(isset($_SESSION['guia_car']))
{
	$num_rows=count($_SESSION['guia_car']);
	if($num_rows==0)$num_rows="";
}
else
{
	$num_rows="";
}
?>
<script type="text/javascript">

$(document).ready(function() {
	$('.btn_rest_car').button({
		icons: {
			//primary: "ui-icon-cart"//,
            secondary: "ui-icon-cart"
		},
		text: true
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
	
$('.btn_preven').button({
	icons: {primary: "ui-icon-newwin"},
	text: false
});
$(".btn_preven").css({width: "13px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_guia_car").tablesorter({ 
		headers: {
			0: {sorter: false },
			8: {sorter: false }
			},
		//sortForce: [[0,0]],
		
		//sortList: [[2,0]]
    });

}); 
</script>
<input name="hdd_com_numite" id="hdd_com_numite" type="hidden" value="<?php echo $num_rows?>">
<!--/*<fieldset><legend>Detalle de Guía</legend>
<a class="btn_agregar_producto" title="Agregar Producto (A+P)" href="#" onClick="catalogo_guia()">Agregar Producto</a>
<a class="btn_rest_car" href="#" onClick="guia_car('restablecer')">Vaciar</a>
<div id="msj_guia_car" class="ui-state-error ui-corner-all" style="width:auto; float:right; padding:2px; display:<?php if($msj!=""){echo 'block';} else{ echo 'none';}?>"><?php echo $msj?></div>
<?php 
	if($num_rows=="" or $num_rows==0)echo 'Ningún item agregado.';
	if($num_rows==1)echo $num_rows.' item agregado.';
	if($num_rows>=2)echo $num_rows.' items agregados.';
?>
</fieldset>*/-->
        <table cellspacing="1" id="tabla_guia_car" class="tablesorter">
            <thead>
                <tr>
                  	
                  	<th>CODIGO</th>
                    <th>PRODUCTO</th>
                    <th>PRESENTACION</th>                    
                  	<th align="right">CANT</th>                  
                </tr>
            </thead>
<?php
if($num_rows>0){
?>
            <tbody>
            <?php
			foreach($_SESSION['guia_car'] as $indice=>$cantidad){			
				$dts1=$oCatalogoProducto->presentacion_catalogo($indice);
				$dt1 = mysql_fetch_array($dts1);				
				?>
                        <tr>                          	
                          	<td><?php echo $dt1['tb_presentacion_cod']?></td>
                            <td><?php echo $dt1['tb_producto_nom']?></td>
                            <td><?php echo $dt1['tb_presentacion_nom']?></td>                            
                          	<td align="right"><?php echo $cantidad?></td>                            
                            <!--<td align="center"><a class="btn_quitar" href="#" onClick="guia_car('quitar','<?php echo $dt1['tb_catalogo_id']?>')">Quitar</a></td>-->
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
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>                                                    
            </tr>

<?php
}
?>
        </table>
