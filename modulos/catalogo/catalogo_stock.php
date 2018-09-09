<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("./cCatalogo.php");
$oCatalogo = new cCatalogo();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once("../producto/cStock.php");
$oStock = new cStock();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();

require_once ("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();
require_once("../kardex/cKardex.php");
$oKardex = new cKardex();
//require_once ("../catalogo/cst_producto.php");

require_once ("../formatos/formato.php");


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
function categoria_form(act,idf)
{
    $.ajax({
        type: "POST",
        url: "../categoria/categoria_form.php",
        async:true,
        dataType: "html",
        data: ({
            action: act,
            cat_id:	idf,
            vista:	'cmb_cat_id'
        }),
        beforeSend: function() {
            $("#btn_cmb_cat_id").click(function(e){
                x=e.pageX+5;
                y=e.pageY+15;
                $('#div_categoria_form').dialog({ position: [x,y] });
                $('#div_categoria_form').dialog("open");
            });
            //$('#msj_categoria').hide();
            $('#div_categoria_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
        success: function(html){
            $('#div_categoria_form').html(html);
        }
    });
}
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

                //Aquí cargar para registrar lotes
                categoria_form('insertar');
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
		sortList: [[0,0]]
		<?php }?>
    });


}); 
</script>
        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>LOTE/SERIE</th>
                    <th>MARCA</th>
                    <th>CATEGORIA</th>
                    <th>UNIDAD</th>
                    <th align="right">STOCK INICIAL</th>
                    <th align="right">STOCK ACTUAL</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
						//stock
						$rws = $oStock->stock_por_presentacion($dt1['tb_presentacion_id'],$_POST['alm_id']);
						$num_filas=mysql_num_rows($rws);
						$rw = mysql_fetch_array($rws);
						$stock_id=$rw['tb_stock_id'];
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
						

						//fin

						//consulta si hay stock inicial
						$can="";

						$rs = $oCatalogoproducto->presentacion_unidad_base($dt1['tb_presentacion_id']);
					    $dt = mysql_fetch_array($rs);
					    $cat_id = $dt['tb_catalogo_id'];
					    mysql_free_result($rs);

						$dts= $oNotalmacen->consultar_existencia_saldo_inicial($cat_id, $_POST['alm_id']);
						$dt = mysql_fetch_array($dts);
						$notalm_id=$dt['tb_notalmacen_id'];
						$notalmdet_id=$dt['tb_notalmacendetalle_id'];
						$notalmdet_can=$dt['tb_notalmacendetalle_can'];
						mysql_free_result($dts);

						if($notalm_id>0)
						{
							$tipoperacion_id=9;
							$dts= $oKardex->consulta_por_operacion_si($tipoperacion_id,$notalm_id);
							$dt = mysql_fetch_array($dts);
							$kardet_id=$dt['tb_kardexdetalle_id'];
							$kardet_can=$dt['tb_kardexdetalle_can'];
							mysql_free_result($dts);

							if($notalmdet_can==$kardet_can)
							{
								$can=$kardet_can;
							}
							else
							{
								$can="Err Can";
							}

							$action_stock='editar';
						}
						else
						{
							$action_stock='insertar';
						}

						//actualizar stock
						/*if($stock_id>0)
						{
							$stock_kardex=stock_kardex($dt1['tb_catalogo_id'],$_POST['alm_id'],'',date('Y-m-d'),$_SESSION['empresa_id']);
							if($stock_unidad!=$stock_kardex)
							{
								$oStock->modificar(
									$stock_id,
									$stock_kardex
								);
							}
						}*/

					?>
                        <tr>
                            <td>
                            <span style="">
							<?php echo $dt1['tb_producto_nom']?>
                            </span>
                            </td>
                            <td>
							<span style="">
							<?php
                            if($dt1['tb_producto_lote']==1) {
                                echo 'L';
                            }
                            elseif($dt1['tb_producto_lote']==0) {
                                echo '';
                            }
                            ?>
                            </span>
                            </td>
                            <td><?php echo $dt1['tb_marca_nom']?></td>
                            <td><?php echo $dt1['tb_categoria_nom']?></td>
                            <td title="<?php echo $dt1['tb_unidad_nom']?>">
							<span style="">
							<?php echo $dt1['tb_unidad_abr'];?>
                            </span>
                            </td>
                            <td nowrap>
                            <?php 
                            if($dt1['tb_catalogo_unibas']==1)
							{
							?>
							<label id="lbl_sto_<?php echo $dt1['tb_catalogo_id']?>" style="display:none"></label>
                            <input class="cantidad" name="txt_sto_<?php echo $dt1['tb_catalogo_id']?>" id="txt_sto_<?php echo $dt1['tb_catalogo_id']?>"  type="text" value="<?php echo $can?>" style="text-align:right" size="8" maxlength="6">
                            <?php 
                            
                            	if($notalm_id=="")
								{
							
							?>
                            <a class="btn_guardar" href="#editar" onClick="actualizar_stock('<?php echo $action_stock?>','<?php echo $dt1['tb_catalogo_id']?>','<?php echo $dt1['tb_presentacion_id']?>','<?php echo $_POST['alm_id']?>','<?php echo $stock_id?>')">Registrar</a>
                            <?php 
                            	}

                            	if($notalm_id>0)
								{
                            ?>
								<a class="btn_guardar2" href="#editar" onClick="actualizar_stock('<?php echo $action_stock?>','<?php echo $dt1['tb_catalogo_id']?>','<?php echo $dt1['tb_presentacion_id']?>','<?php echo $_POST['alm_id']?>','<?php echo $stock_id?>')">Corregir</a>
                            <?php 
                            	}
							}
                            ?>
                            </td>
                            <td align="right">
                            	<?php echo $stock_unidad;?>
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
                <tr class="even">
                  <td colspan="7"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
<div id="div_categoria_form">
</div>