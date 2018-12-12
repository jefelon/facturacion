<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoProducto = new cCatalogoProducto();
require_once ("../servicio/cServicio.php");
$oServicio = new cServicio();
require_once ("../formatos/formato.php");

$igv_dato=0.18;
$almacen_venta=$_SESSION['almacen_id'];

//agregar a cesta
if($_POST['action']=='agregar'){
	if($_POST['cat_can']>0){
		//producto por catalogo y stock y almacen
		$dts= $oCatalogoProducto->presentacion_catalogo_stock_almacen($_POST['cat_id'],$almacen_venta);
		$dt = mysql_fetch_array($dts);
			$pro_nom=$dt['tb_producto_nom'];
			$pre_nom=$dt['tb_presentacion_nom'];
			$pre_id	=$dt['tb_presentacion_id'];
			$sto_num=$dt['tb_stock_num'];
			$cat_mul=$dt['tb_catalogo_mul'];
			$nombre_producto=$pro_nom.' '.$pre_nom;
		mysql_free_result($dts);
		
		$num=0;
		if(isset($_SESSION['venta_car'])){
			foreach($_SESSION['venta_car'] as $indice=>$cantidad){
				if(($_POST['cat_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$indice])){
					$num++;
				}
			}
		}
		
		if($num==0){
			//IDENTIFICADOR CATALOGO Y CANTIDAD
			$_SESSION['venta_car'][$_POST['cat_id']]=$_POST['cat_can'];
			
			//PRECIO DE VENTA
			$_SESSION['venta_preven'][$_POST['cat_id']]=moneda_mysql($_POST['cat_preven']);
			
			//TIPO DE DESCUENTO  1 PORCENTAJE	2 SOLES		
			$_SESSION['venta_tipdes'][$_POST['cat_id']]=$_POST['cat_tipdes'];
			
			//DESCUENTO
			$_SESSION['venta_des'][$_POST['cat_id']]=moneda_mysql($_POST['cat_des']);
			
			//IGV
			//$_SESSION['venta_igv'][$_POST['cat_id']]=$_POST['cat_igv'];
						
			////PRESENTACION para verificar si ingresa otra unidad de la misma presentacion
			$_SESSION['presentacion_id'][$_POST['cat_id']]=$pre_id;
			
			//CATALOGO MULTIPLO para calculo de cantidades
			$_SESSION['catalogo_mul'][$_POST['cat_id']]=$cat_mul;
		}
		
		if($num==1){
			foreach($_SESSION['venta_car'] as $indice=>$cantidad){
				// diferente unidad y misma presentacion
				if(($_POST['cat_id']!=$indice) and ($pre_id==$_SESSION['presentacion_id'][$indice])){
					$t1=$cat_mul*$_POST['cat_can'];//cantidad que ingresa
					$t2=$_SESSION['catalogo_mul'][$indice]*$_SESSION['venta_car'][$indice];//cantidad q hay en carrito
					//echo 'N='.$_POST['cat_id'].' nN='.$t1.'<br>';
					//echo 'S='.$indice.' nS='.$t2.'<br>';
					//echo 'stock='.$sto_num.'<br>';
					
					$ped=$t1+$t2;//sumatoria total de cantidad en unidad base
					$dif=$ped-$sto_num;
					//echo 'pedido='.$ped.'<br>';
					
					//verificando el mayor multiplo
					if($cat_mul>$_SESSION['catalogo_mul'][$indice])
					{
						//echo 'El mayor mul es N'.$cat_mul;
						if($dif>0){
							$st_uni=floor($sto_num/$cat_mul);
							$st_res=$sto_num%$cat_mul;
						}
						
						if($ped<=$sto_num)
						{
							$st_uni=floor($ped/$cat_mul);
							$st_res=$ped%$cat_mul;
						}
						
						//unidad nueva agregar a carrito
						
						$_SESSION['venta_car'][$_POST['cat_id']]=$st_uni;//id cat - cantidad
						$_SESSION['venta_des'][$_POST['cat_id']]=moneda_mysql($_POST['cat_des']);//id cat - descuento
						$_SESSION['venta_tipdes'][$_POST['cat_id']]=$_POST['cat_tipdes'];
						//$_SESSION['venta_igv'][$_POST['cat_id']]=$_POST['cat_igv'];//id cat - igv
						$_SESSION['venta_preven'][$_POST['cat_id']]=moneda_mysql($_POST['cat_preven']);//id cat - precio venta
						$_SESSION['presentacion_id'][$_POST['cat_id']]=$pre_id;//id cat-presentacion - pre_id
						$_SESSION['catalogo_mul'][$_POST['cat_id']]=$cat_mul;//id cat-presentacion - mul
						
						//unidad en sesion.... agregar o eliminar del carrito
						if($st_res>0)
						{
							$_SESSION['venta_car'][$indice]=$st_res;
						}
						else
						{
							unset($_SESSION['venta_car'][$indice]);
							unset($_SESSION['venta_des'][$indice]);
							unset($_SESSION['venta_tipdes'][$indice]);
							//unset($_SESSION['venta_igv'][$indice]);
							unset($_SESSION['venta_preven'][$indice]);
							unset($_SESSION['presentacion_id'][$indice]);
							unset($_SESSION['catalogo_mul'][$indice]);
						}
						$msj='Se ajustó automaticamente cantidad de '.$nombre_producto;
						if($dif>0)$msj.=' desface en '.$dif.'.';
					}
					else
					{
						//echo 'El mayor mul es S'.$_SESSION['catalogo_mul'][$indice];
						if($dif>0){
							$st_uni=floor($sto_num/$_SESSION['catalogo_mul'][$indice]);
							$st_res=$sto_num%$_SESSION['catalogo_mul'][$indice];
						}
						
						if($ped<=$sto_num)
						{
							$st_uni=floor($ped/$_SESSION['catalogo_mul'][$indice]);
							$st_res=$ped%$_SESSION['catalogo_mul'][$indice];
						}

						//unidad en sesion
						if($st_res>0)
						{
							//unidad nueva
							$_SESSION['venta_car'][$_POST['cat_id']]=$st_res;//id cat - cantidad
							$_SESSION['venta_tipdes'][$_POST['cat_id']]=$_POST['cat_tipdes'];//id cat - tipodescuento
							$_SESSION['venta_des'][$_POST['cat_id']]=$_POST['cat_des'];//id cat - descuento							
							//$_SESSION['venta_igv'][$_POST['cat_id']]=$_POST['cat_igv'];//id cat - igv
							$_SESSION['venta_preven'][$_POST['cat_id']]=$_POST['cat_preven'];//id cat - precio venta
							$_SESSION['presentacion_id'][$_POST['cat_id']]=$pre_id;//id cat-presentacion - pre_id
							$_SESSION['catalogo_mul'][$_POST['cat_id']]=$cat_mul;//id cat-presentacion - mul
						}
						
						$_SESSION['venta_car'][$indice]=$st_uni;
						
						$msj='Se ajustó automaticamente cantidad de '.$nombre_producto;
						if($dif>0)$msj.=' desface en '.$dif.'.';
					}
				} //fin if
			}//fin foreach venta_car		
		}
		
		if($num>1)
		{
			$msj='No se permite agregar mas de 2 unidades de una sola presentación de producto.';
		}
		
	}
}

//agregar servicio
if($_POST['action']=='agregar_servicio'){
	$_SESSION['servicio_car'][$_POST['ser_id']]		=$_POST['ser_can'];//id servicio - cantidad			
	$_SESSION['servicio_preven'][$_POST['ser_id']]		=moneda_mysql($_POST['ser_pre']);//id servicio - precio
	$_SESSION['servicio_tipdes'][$_POST['ser_id']]	=$_POST['ser_rad_tipdes'];//id servicio - tipodescuento (1 ó 2)
	$_SESSION['servicio_des'][$_POST['ser_id']]		=moneda_mysql($_POST['ser_des']);//id servicio - descuento	
}


//quitar valores del array
if($_POST['action']=='quitar'){
	unset($_SESSION['venta_car'][$_POST['cat_id']]);
	unset($_SESSION['venta_preven'][$_POST['cat_id']]);
	unset($_SESSION['venta_tipdes'][$_POST['cat_id']]);
	unset($_SESSION['venta_des'][$_POST['cat_id']]);
	//unset($_SESSION['venta_igv'][$_POST['cat_id']]);
	unset($_SESSION['presentacion_id'][$_POST['cat_id']]);
	unset($_SESSION['catalogo_mul'][$_POST['cat_id']]);
}

if($_POST['action']=='quitar_servicio'){
	unset($_SESSION['servicio_car'][$_POST['ser_id']]);
	unset($_SESSION['servicio_preven'][$_POST['ser_id']]);
	unset($_SESSION['servicio_tipdes'][$_POST['ser_id']]);
	unset($_SESSION['servicio_des'][$_POST['ser_id']]);	
}


//restablecer o eliminar array
if($_POST['action']=='restablecer')
{
	unset($_SESSION['venta_car']);
	unset($_SESSION['venta_des']);
	unset($_SESSION['venta_tipdes']);
	//unset($_SESSION['venta_igv']);
	unset($_SESSION['venta_preven']);
	unset($_SESSION['presentacion_id']);
	unset($_SESSION['catalogo_mul']);
	unset($_SESSION['venta_descuento']);
	
	unset($_SESSION['servicio_car']);
	unset($_SESSION['servicio_preven']);
	unset($_SESSION['servicio_tipdes']);
	unset($_SESSION['servicio_des']);	
}


if(isset($_SESSION['venta_car']) or isset($_SESSION['servicio_car']))
{
	if(isset($_SESSION['venta_car']))	$num_rows=count($_SESSION['venta_car']);
	if(isset($_SESSION['servicio_car']))$num_rows2=count($_SESSION['servicio_car']);
	
	$filas=$num_rows+$num_rows2;
	if($filas==0)$num_rows="";
}
else
{
	$filas="";
}
?>
<script type="text/javascript">

$('.btn_rest_act').button({
	icons: {
		//primary: "ui-icon-cart"//,
		secondary: "ui-icon-refresh"
	},
	text: false
});

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

$('.btn_item').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});

$('.btn_quitar').button({
	icons: {primary: "ui-icon-minus"},
	text: false
});

$('.moneda2').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9999.99'
});

function calcular_vuelto(){
	var importe = $("#txt_importe_cliente").val();
	var total = $('#txt_ven_tot').val();	
	$.ajax({
		type: "POST",
		url: "../venta/venta_vuelto.php",
		async:true,
		dataType: "html",                      
		data: ({
			importe: importe,				
			total:	total
		}),
		beforeSend: function(){				
			
		},
		success: function(vuelto){
			$('#lbl_ven_vuelto').val(vuelto);					
		}
	});	
}

$(function() {	
	$("#txt_importe_cliente").keyup(function() {		
		calcular_vuelto();
	});
	
	$("#tabla_venta_car").tablesorter({
		widgets: ['zebra'],
		headers: {
			//7: {sorter: false }
			},
		//sortForce: [[0,0]],
		//sortList: [[1,0]]
    });

}); 
</script>
<input name="hdd_ven_numite" id="hdd_ven_numite" type="hidden" value="<?php echo $filas?>">
<fieldset><legend>Detalle de Venta</legend>
<?php if($_POST['vista']!='cange'){?>
<a class="btn_agregar_producto" title="Agregar Producto y/o Servicio (A+P)" href="#" onClick="catalogo_venta_tab()">Agregar</a>
<a class="btn_rest_car" href="#" onClick="venta_car('restablecer')">Vaciar</a>
<?php }?>
<a class="btn_rest_act" href="#" onClick="venta_car('actualizar')">Actualizar</a>
<div id="msj_ventanota_car" class="ui-state-error ui-corner-all" style="width:auto; float:right; padding:2px; display:<?php if($msj!=""){echo 'block';} else{ echo 'none';}?>"><?php echo $msj?></div>
<div id="msj_venta_check" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
<?php 
	if($filas=="" or $filas==0)echo 'Ningún ítem agregado.';
	if($filas==1)echo $filas.' ítem agregado.';
	if($filas>=2)echo $filas.' ítems agregados.';
?>
</fieldset>
        <table cellspacing="1" id="tabla_venta_car" class="tablesorter">
            <thead>
                <tr>
                  <th>TIPO</th>
                  <th>CODIGO</th>
                  <th>ARTICULO</th>
                  <!--<th>PRESENTACION</th>-->
                  <th align="left" title="UNIDAD">UNID</th>
                  <th align="right" title="CANTIDAD">CANT</th>
                  <th align="right" title="PRECIO UNITARIO">PRECIO UNIT</th>
                  <th align="right" title="DESCUENTO">DSCTO</th>
                  <th align="right" nowrap="nowrap" title="VALOR VENTA">VALOR VEN</th>
                  <th align="right" nowrap="nowrap" title="PRECIO VENTA">PREC VENTA</th>
                  <!--<th align="right">IGV</th>-->
                  <th width="25">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php
			if($num_rows>0)foreach($_SESSION['venta_car'] as $indice=>$cantidad){			
				$dts1=$oCatalogoProducto->presentacion_catalogo_stock_almacen($indice,$almacen_venta);
				$dt1 = mysql_fetch_array($dts1);
				
				//precio de venta ingresado
				$precio_venta	=$_SESSION['venta_preven'][$indice];
								
				//precio unitario de venta
				$precio_unitario=$precio_venta/(1+$igv_dato);
				
				
				//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
				$tipdes = $_SESSION['venta_tipdes'][$indice];				
				$descuento_linea=$_SESSION['venta_des'][$indice];
				//descuento en porcentaje
				if($tipdes == 1){
					$descuento_calculo = ($descuento_linea/100)*$precio_unitario;
				}
				//descuento en soles
				if($tipdes == 2){
					$descuento_calculo = $descuento_linea;	
				}
				
				//precio unitario linea al que se vende
				$precio_unitario_linea=$precio_unitario-$descuento_calculo;
				
				//valor venta
				$valor_venta=$cantidad*(moneda_mysql($precio_unitario_linea));
				
				//igv
				$igv=$valor_venta*$igv_dato;

				
				//sumatoria linea
				$importe=$sub_total+$igv_total;
				
				//sumatoria factura
				$igv_total+=$igv;
				$sub_total+=$valor_venta;
				$des_total+=$descuento_calculo;
				?>
                        <tr>
                          <td>Producto</td>
                          <td><?php echo $dt1['tb_presentacion_cod']?></td>
                          <td><?php echo $dt1['tb_producto_nom']?></td>
                            <!--<td><?php //echo $dt1['tb_presentacion_nom']?></td>-->
                            <td align="left" title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                          	<td align="right"><?php echo $cantidad?></td>
                            <td align="right"><?php echo formato_money($precio_unitario)?></td>
                          	<td align="right">
								<?php 
									if($tipdes == 1 and $descuento_linea!=0){										
										echo $descuento_linea."%";	
									}
									if($tipdes == 2 and $descuento_linea!=0){
										echo "S/. ".$descuento_linea;
									}									
								?>
                            </td>
                            <td align="right"><?php echo formato_money($valor_venta)?></td>
                            <td align="right"><?php echo formato_money($precio_venta)?></td>
                            <!--<td align="right"><?php //echo formato_money($igv)?></td>-->
                            <td align="center" nowrap="nowrap">
                            <?php if($_POST['vista']!='cange'){?>
                            <a class="btn_item" href="#" onClick="editar_datos_item('editar_producto','<?php echo $dt1['tb_catalogo_id']?>')">Actualizar Datos de Item</a><a class="btn_quitar" href="#" onClick="venta_car('quitar','<?php echo $dt1['tb_catalogo_id']?>')">Quitar</a>
                            <?php }?>
                            </td>
                        </tr>
            <?php
                mysql_free_result($dts1);
			}	
            ?>
            
            <?php 
            	if($num_rows2>0)foreach($_SESSION['servicio_car'] as $indice=>$cantidad){
					$dts1=$oServicio->mostrarUno($indice);
					$dt1 = mysql_fetch_array($dts1);
								
					//precio de venta ingresado
					$precio_venta = $_SESSION['servicio_preven'][$indice];
					
					//precio unitario de venta
					$precio_unitario=$precio_venta/(1+$igv_dato);
					
					
					//Verifico si el descuento realizado es de tipo porcentaje o en dinero 1% - 2S/.
					$tipdes = $_SESSION['servicio_tipdes'][$indice];				
					$descuento_linea = $_SESSION['servicio_des'][$indice];
					
					//descuento en porcentaje
					if($tipdes == 1){
						$descuento_calculo = ($descuento_linea/100)*$precio_unitario;
					}
					//descuento en soles
					if($tipdes == 2){
						$descuento_calculo = $descuento_linea;	
					}
					
					
					//precio unitario linea al que se vende
					$precio_unitario_linea=$precio_unitario-$descuento_calculo;
					
					//valor venta
					$valor_venta=$cantidad*(moneda_mysql($precio_unitario_linea));
					
					//igv
					$igv=$valor_venta*$igv_dato;
					
					
					//sumatoria linea
					$importe=$sub_total+$igv_total;
					
					//sumatoria factura
					$igv_total+=$igv;
					$sub_total+=$valor_venta;
					$des_total+=$descuento_calculo;
					?>               	
                	<tr>
                	  <td>Servicio</td>
                	  <td>&nbsp;</td>
                    	<td><?php echo $dt1['tb_servicio_nom']?></td>
                    	<td>UN</td>
                    	<td align="right"><?php echo $cantidad?></td>
                    	<td align="right"><?php echo formato_money($precio_unitario)?></td>
                        <td align="right">
                        	<?php 
								if($tipdes == 1 and $descuento_linea!=0){										
									echo $descuento_linea."%";	
								}
								if($tipdes == 2 and $descuento_linea!=0){
									echo "S/. ".$descuento_linea;
								}						
							?>
                        </td>                      
                        
                        <td align="right"><?php echo formato_money($valor_venta)?></td>
                        <td align="right"><?php echo formato_money($precio_venta)?></td>
                      <td align="center" nowrap="nowrap">
                      <?php if($_POST['vista']!='cange'){?>
                      <a class="btn_item" href="#" onClick="editar_datos_item('editar_servicio','<?php echo $dt1['tb_servicio_id']?>')">Actualizar Datos de Item</a><a class="btn_quitar" href="#" onClick="venta_car_servicio('quitar_servicio','<?php echo $dt1['tb_servicio_id']?>')">Quitar</a>
                      <?php }?>
                      </td>
                    </tr>
			<?php
            		mysql_free_result($dts1);										
				}
			?>
            </tbody>
        </table>
<?php 
$total_factura=$sub_total+$igv_total;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="div_calcular_vuelto">
<fieldset style="width:200px">
	<legend>Calcular Vuelto</legend>
	<table>
    	<tr>
        	<td align="right"><label style="font-size:12px">Paga con:</label></td>
    <td align="right"><input type="text" name="txt_importe_cliente" id="txt_importe_cliente" size="10" style="text-align:right; font-size:14px" class="moneda2" /></td>
        </tr>
        
        
        <tr>
        	<td align="right"><label for="lbl_ven_vuelto" style="font-size:12px">Vuelto:</label></td>
    <td align="right"><input type="text" name="lbl_ven_vuelto" id="lbl_ven_vuelto" readonly size="10" style="text-align:right; font-size:14px" class="moneda2" /></td>   
        </tr>
    </table>
</fieldset>
</div></td>
    <td valign="top"><div style="margin-left:20px; margin-top:10px; float:right">
    <?php /*?><table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td><label for="txt_ven_subtot" style="font-size:14px"><strong>SUB TOTAL</strong></label></td>
        <td align="right"><input name="txt_ven_subtot" type="text" id="txt_ven_subtot" value="<?php echo formato_money($sub_total)?>" readonly style="text-align:right; font-size:14px"></td>
      </tr>
      <tr>
        <td width="110"><label style="font-size:14px"><strong>DESCUENTO</strong></label></td>
        <td width="190" align="right"><input type="text" name="txt_ven_des" id="txt_ven_des" value="<?php echo formato_money($des_total)?>" style="text-align:right; font-size:14px" readonly></td>
      </tr>
    </table><?php */?>
    </div></td>
    <td valign="top"><div style="margin-right:53px; margin-top:10px;">
<table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td width="120"><label for="txt_ven_valven" style="font-size:12px"><strong>VALOR VENTA</strong></label></td>
    <td width="140" align="right">
      <input name="txt_ven_valven" type="text" id="txt_ven_valven" style="text-align:right; font-size:14px" value="<?php echo formato_money($sub_total)?>" size="15" readonly></td>
  </tr>
  <tr>
    <td><label for="txt_ven_igv" style="font-size:12px"><strong>IGV</strong></label></td>
    <td align="right"><input name="txt_ven_igv" type="text" id="txt_ven_igv" style="text-align:right; font-size:14px" value="<?php echo formato_money($igv_total)?>" size="15" readonly></td>
  </tr>
  <tr>
    <td><label for="txt_ven_tot" style="font-size:12px"><strong>TOTAL</strong></label></td>
    <td align="right"><input name="txt_ven_tot" type="text" id="txt_ven_tot" style="text-align:right; font-size:14px; font-weight:bold;" value="<?php echo formato_money($total_factura)?>" size="13" readonly></td>   
    
  </tr>
</table>
</div></td>
  </tr>
</table>
<script type="text/javascript">
$(function() {
	//lenar monto de pagos
	var total= $('#txt_ven_tot').autoNumericGet();
	$('#txt_venpag_mon').autoNumericSet(total);
}); 
</script>