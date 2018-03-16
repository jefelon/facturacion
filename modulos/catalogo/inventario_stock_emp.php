<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("./cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once("../producto/cStock.php");
$oStock = new cStock();

require_once ("../formatos/formato.php");
require_once ("../catalogo/cst_producto.php");

//almacenes array
$dts=$oAlmacen->mostrarTodos($_SESSION['empresa_id']);
while($dt = mysql_fetch_array($dts)){
	$alm_id[]=$dt['tb_almacen_id'];
	$alm_nom[]=$dt['tb_almacen_nom'];
}
mysql_free_result($dts);


if(isset($_POST['pro_cat']) and $_POST['pro_cat']>0)
{
	$dc=$_POST['pro_cat'].'';
	
	$dts2=$oCategoria->mostrar_por_idp($_POST['pro_cat']);
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

//seleccion de los atributos
$atr_array=$_POST['atr_ids'];
if(is_array($atr_array)){
	$cadena_atr = implode(',',$atr_array);
}

//fecha inventario

$fecini='01-01-2013';
$fecfin=$_POST['inv_fec'];

if($_POST['alm_id']>0)
{
	$dts1=$oCatalogo->catalogo_filtro_stock($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est'],$cadena_atr,$_POST['verven'],$_POST['vercom'],$_POST['unibas']);
$num_rows= mysql_num_rows($dts1);
}
else
{
	$num_rows=0;
}
?>
<script type="text/javascript">

$('.cantidad').autoNumeric({
	aSep: '',
	aDec: '.',
	vMin: '0',
	vMax: '99999'
});

function actualizar_stock(act,idf,preid,almid,stoid)
{
	$('#lbl_sto_'+idf).hide();
	if($('#txt_sto_'+idf).val()!="")
	{
		$.ajax({
			type: "POST",
			url: "../producto/stock_reg.php",
			async:true,
			dataType: "html",                      
			data: ({
				action:	'actualizar_stock',
				tipo:	act,
				alm_id: almid,
				pre_id: preid,
				sto_id: stoid,
				sto_num: $('#txt_sto_'+idf).val()
			}),
			beforeSend: function() {
				$('#lbl_sto_'+idf).addClass("ui-state-highlight ui-corner-all");
				$('#lbl_sto_'+idf).html('G...');
				$('#lbl_sto_'+idf).show(100);
				//$('#div_catalogo_filtro').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
			},
			success: function(html){
				$('#lbl_sto_'+idf).html(html);
				//$('#div_catalogo_filtro').html(html);
			},
			complete: function(){
				//$('#lbl_sto_'+idf).hide();
				//catalogo_tabla();
			}
		});
	}
	else
	{
		$('#lbl_sto_'+idf).addClass("ui-state-highlight ui-corner-all");
		$('#lbl_sto_'+idf).html('Número?');
		$('#lbl_sto_'+idf).show(100);
	}
}

$(document).ready(function() {
	
	$('.btn_guardar').button({
		icons: {primary: "ui-icon-disk"},
		text: true
	});
	
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			//4: {sorter: 'shortDate' }
		},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[2,0],[1,0],[0,0]]
		<?php }?>
    });


}); 
</script>
        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <th>NOMBRE</th>
                    <th>MARCA</th>
                    <th>CATEGORIA</th>
                    <th align="right" nowrap>P. COSTO US$</th>
                    <th align="right" nowrap>P. COSTO S/.</th>
                    <th align="right" nowrap="nowrap">PRECIO VENTA</th>
                    <th align="right"><?php echo $alm_nom[0]?></th>
                    <th align="right"><?php echo $alm_nom[1]?></th>
                    <th align="right"><?php echo $alm_nom[2]?></th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
						//stock
						/*	$rws = $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$_POST['alm_id']);
							$num_filas=mysql_num_rows($rws);
							$rw = mysql_fetch_array($rws);
							$stock_num=$rw['tb_stock_num'];
							mysql_free_result($rws);
								
								$stock_unidad=0;
								
								if($num_filas>0){
									$st_uni=floor($stock_num/$dt1['tb_catalogo_mul']);
									$st_res=$stock_num%$dt1['tb_catalogo_mul'];

									if($st_res!=0){
										//$stock_unidad="$st_uni + r$st_res";
										$stock_unidad=$st_uni;
									} else{
										$stock_unidad=$st_uni;
									}
									
									$action_stock='editar';
									$stock_id=$rw['tb_stock_id'];
								}
								else
								{
									$action_stock='insertar';
									$stock_unidad='-';
								}
							*/
							//fin

						//STOCK
						//$stock_unidad1=0;
						//$stock_unidad2=0;

						//almacen 1
						$rws = $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$alm_id[0]);
						$num_filas1=mysql_num_rows($rws);
						mysql_free_result($rws);

						if($num_filas1>0)
						{
							$stock=stock_kardex($dt1['tb_catalogo_id'],$alm_id[0],fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);
							$st_uni=floor($stock/$dt1['tb_catalogo_mul']);
							$st_res=$stock%$dt1['tb_catalogo_mul'];
							
							if($st_res!=0){
								//$stock_unidad="$st_uni + r$st_res";
								$stock_unidad1="$st_uni";
							} else{
								$stock_unidad1="$st_uni";
							}
						}
						else
						{
							$stock_unidad1="-";
						}

						

						//almacen 2
						$rws = $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$alm_id[1]);
						$num_filas1=mysql_num_rows($rws);
						mysql_free_result($rws);

						if($num_filas1>0)
						{
							$stock=stock_kardex($dt1['tb_catalogo_id'],$alm_id[1],fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);
							$st_uni=floor($stock/$dt1['tb_catalogo_mul']);
							$st_res=$stock%$dt1['tb_catalogo_mul'];
							
							if($st_res!=0){
								//$stock_unidad="$st_uni + r$st_res";
								$stock_unidad2="$st_uni";
							} else{
								$stock_unidad2="$st_uni";
							}
						}
						else
						{
							$stock_unidad2="-";
						}

						//almacen 3
						$rws = $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$alm_id[2]);
						$num_filas1=mysql_num_rows($rws);
						mysql_free_result($rws);

						if($num_filas1>0)
						{
							$stock=stock_kardex($dt1['tb_catalogo_id'],$alm_id[2],fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);
							$st_uni=floor($stock/$dt1['tb_catalogo_mul']);
							$st_res=$stock%$dt1['tb_catalogo_mul'];
							
							if($st_res!=0){
								//$stock_unidad="$st_uni + r$st_res";
								$stock_unidad3="$st_uni";
							} else{
								$stock_unidad3="$st_uni";
							}
						}
						else
						{
							$stock_unidad3="-";
						}

						//STOCK
						$stock_kardex=stock_kardex($dt1['tb_catalogo_id'],0,fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);
						
						//COSTOS
						
						$costo_ponderado_array=costo_ponderado_empresa($dt1['tb_catalogo_id'],$_POST['alm_id'],fecha_mysql($fecini),fecha_mysql($fecfin),$stock_kardex,$dt1['tb_catalogo_precos'],$dt1['tb_catalogo_precosdol'],$_SESSION['empresa_id']);
						
						$costo_ponderado_soles=$costo_ponderado_array['soles'];
						$costo_ponderado_dolares=$costo_ponderado_array['dolares'];
					
						//VALORIZADO
						/*$valorizado_dol=0;
						$valorizado=0;
						
						if($dt1['tb_catalogo_unibas']=='1')
						{
							if($dt1['tb_catalogo_precosdol']>0)
							{
								$valorizado_dol=$stock_unidad*$costo_ponderado_dolares;
								
								$total_valorizado_dol+=$valorizado_dol;
							}
							else
							{
								$valorizado=$stock_unidad*$costo_ponderado_soles;
								$total_valorizado+=$valorizado;
							}
						}*/


					?>
                        <tr>
                          <td>
                            <span style="">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                            </td>
                            <td><?php echo $dt1['tb_marca_nom']?></td>
                            <td><?php echo $dt1['tb_categoria_nom']?></td>
                            <td align="right"><?php echo formato_money($costo_ponderado_dolares)?></td>
                            <td align="right"><?php echo formato_money($costo_ponderado_soles)?></td>
                            <td align="right"><?php echo formato_money($dt1['tb_catalogo_preven'])?></td>
                            <?php
                            //stock
			/*$rws = $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$alm_id[0]);
			$num_filas=mysql_num_rows($rws);
			$rw = mysql_fetch_array($rws);
			$stock_num=$rw['tb_stock_num'];
			mysql_free_result($rws);
				
				$stock_unidad=0;
				
				if($num_filas>0){
					
					if($stock_num>0)
					{
						$st_uni=floor($stock_num/$dt1['tb_catalogo_mul']);
						$st_res=$stock_num%$dt1['tb_catalogo_mul'];
	
						if($st_res!=0){
							//$stock_unidad="$st_uni + r$st_res";
							$stock_unidad=$st_uni;
						} else{
							$stock_unidad=$st_uni;
						}
					}
					else
					{
						$stock_unidad=$stock_num;
					}
					$stock_id=$rw['tb_stock_id'];
				}
				else
				{
					$stock_unidad='-';
				}
			*/
			//fin
							?>
                            <td align="right" nowrap><?php echo $stock_unidad1?></td>
                            <?php 
							//stock
			/*$rws = $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$alm_id[1]);
			$num_filas=mysql_num_rows($rws);
			$rw = mysql_fetch_array($rws);
			$stock_num=$rw['tb_stock_num'];
			mysql_free_result($rws);
				
				$stock_unidad=0;
				
				if($num_filas>0){
					$st_uni=floor($stock_num/$dt1['tb_catalogo_mul']);
					$st_res=$stock_num%$dt1['tb_catalogo_mul'];

					if($stock_num>0)
					{
						$st_uni=floor($stock_num/$dt1['tb_catalogo_mul']);
						$st_res=$stock_num%$dt1['tb_catalogo_mul'];
	
						if($st_res!=0){
							//$stock_unidad="$st_uni + r$st_res";
							$stock_unidad=$st_uni;
						} else{
							$stock_unidad=$st_uni;
						}
					}
					else
					{
						$stock_unidad=$stock_num;
					}
					$stock_id=$rw['tb_stock_id'];
				}
				else
				{
					$stock_unidad='-';
				}
			*/
			//fin
							?>
                            <td align="right"><?php echo $stock_unidad2?></td>
                            <td align="right"><?php echo $stock_unidad3?></td>
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
                  <td colspan="9"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
