<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("./cCuadromi.php");
$oCuadromi = new cCuadromi();
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once ("../formatos/formatos.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();

$y=date('Y');
$m=date('m');
$d=date('d');

$com_est='CANCELADA';
$ven_est='CANCELADA';

?>
<script type="text/javascript">
function marca_tabla()
{	
	$.ajax({
		type: "POST",
		url: "marca_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			//pro_est:	$('#cmb_fil_pro_est').val()
		}),
		beforeSend: function() {
			$('#div_marca_tabla').addClass("ui-state-disabled");
        },
		success: function(html){
			$('#div_marca_tabla').html(html);
		},
		complete: function(){			
			$('#div_marca_tabla').removeClass("ui-state-disabled");
		}
	});     
}
function facturas_pendientes_tabla()
{
    $.ajax({
        type: "POST",
        url: "../cuadromi/cuadromi_tabla_facturas_pendientes.php",
        async:true,
        dataType: "html",
        data: ({
            //pro_est:	$('#cmb_fil_pro_est').val()
        }),
        beforeSend: function() {
            $('.cuadromi_tabla_facturas_pendientes').addClass("ui-state-disabled");
        },
        success: function(html){
            $('.cuadromi_tabla_facturas_pendientes').html(html);
        },
        complete: function(){
            $('.cuadromi_tabla_facturas_pendientes').removeClass("ui-state-disabled");
        }
    });
}
function resumen_pendientes_tabla()
{
    $.ajax({
        type: "POST",
        url: "../cuadromi/prueba.php",
        async:true,
        dataType: "html",
        data: ({
            //pro_est:	$('#cmb_fil_pro_est').val()
        }),
        beforeSend: function() {
            $('.cuadromi_tabla_resumen_pendientes').addClass("ui-state-disabled");
        },
        success: function(html){
            $('.cuadromi_tabla_resumen_pendientes').html(html);
        },
        complete: function(){
            $('.cuadromi_tabla_resumen_pendientes').removeClass("ui-state-disabled");
        }
    });
}

function marca_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "marca_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			mar_id:	idf
		}),
		beforeSend: function() {
			$('#msj_marca').hide();
			$('#div_marca_form').dialog("open");
			$('#div_marca_form').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_marca_form').html(html);				
		}
	});
}

function eliminar_marca(id)
{   
	$('#msj_marca').hide();   
	if(confirm("Realmente desea eliminar?")){
		$.ajax({
			type: "POST",
			url: "marca_reg.php",
			async:true,
			dataType: "html",
			data: ({
				action: "eliminar",
				id:		id
			}),
			beforeSend: function() {
				$('#msj_marca').html("Cargando...");
				$('#msj_marca').show(100);
			},
			success: function(html){
				$('#msj_marca').html(html);
			},
			complete: function(){
				marca_tabla();
			}
		});
	}
}
//
function enviar_sunat(id)
{
    if(confirm("Realmente desea Enviar a la Sunat?")){
        $.ajax({
            type: "POST",
            url: "../venta/enviar_sunat.php",
            async:true,
            dataType: "json",
            data: ({
                ven_id:		id
            }),
            beforeSend: function() {
                $('#msj_venta').html("Enviando a SUNAT...");
                $('#msj_venta').show(100);
            },
            success: function(data){
                $('#msj_venta').html(data.msj);
                //$('#msj_venta').html(data.msj2);
                $('#msj_venta').show();
            },
            complete: function(){
                facturas_pendientes_tabla();
            }
        });
    }
}

$(function() {
	
	$( "#div_marca_form" ).dialog({
		title:'Información de Marca',
		autoOpen: false,
		resizable: false,
		height: 200,
		width: 500,
		modal: true,
		buttons: {
			Guardar: function() {
				$("#for_mar").submit();
			},
			Cancelar: function() {
				$('#for_mar').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});
    $('.btn_sunat').button({
        text: true
    });
    facturas_pendientes_tabla();
    resumen_pendientes_tabla();

});

</script>
<style>
	body { font-size: 62.5%; }
	label, input { display:block; }
	input.text { margin-bottom:12px; width:95%; padding: .4em; }
	fieldset { padding:0; border:0; margin-top:25px; }
	h1 { font-size: 1em; margin: .6em 0; }
	div#cuadro-contain { width: 300px; margin: 20px 0; }
	div#cuadro-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
	div#cuadro-contain table td, div#cuadro-contain table th { border: 1px solid #eee; padding: .6em 10px; }
	.ui-dialog .ui-state-error { padding: .3em; }
	.validateTips { border: 1px solid transparent; padding: 0.3em; }
</style>
<div align="left">
<?php
    echo fechaActual(1);
?>
    <div id="msj_venta" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
</div>
<div id="cuadro-contain" class="ui-widget" style="float:left; margin-left:20px">
    <table id="cuadro" class="ui-widget ui-widget-content">
	  <thead>
			<tr class="ui-widget-header ">
				<th colspan="2" align="left">COMPRAS</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			  <td colspan="2" align="left">Producto más comprado del mes: 
		      <?php
                $dts=$oCuadromi->producto_mas_ope('tb_compradetalle','tb_compra','dt.tb_compra_id=op.tb_compra_id','tb_compra_fec',"$y-$m-%",$_SESSION['empresa_id'],'5');?>
              	<ul>
		        <?php
				while($dt = mysql_fetch_array($dts)){
					echo '<li>'.$dt['tb_producto_nom']./*' '.$dt['tb_presentacion_nom'].' '.$dt['tb_unidad_abr'].*/'</li>';
				}
				mysql_free_result($dts);
				?>
                </ul>
                </td>
		  </tr>
			<tr>
			  <td align="left">Compras hoy
              <?php
			  echo nombre_dia("$d-$m-$y");
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->num_reg_ope_fecha('tb_compra','tb_compra_fec',"$y-$m-$d",$_SESSION['empresa_id']);
				$dt = mysql_fetch_array($dts);
				echo $dt['numero'];
				mysql_free_result($dts);
				?></td>
	      </tr>
			<tr>
			  <td align="left">Compras en 
              <?php
			  echo nombre_mes($m);
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->num_reg_ope_fecha('tb_compra','tb_compra_fec',"$y-$m-%",$_SESSION['empresa_id']);
				$dt = mysql_fetch_array($dts);
				echo $dt['numero'];
				mysql_free_result($dts);
				?></td>
	      </tr>
			<tr>
			  <td align="left">Total Compras hoy
              <?php
			  echo nombre_dia("$d-$m-$y");
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$y-$m-$d",'tb_compra_est',$com_est,$_SESSION['empresa_id']);
				$dt = mysql_fetch_array($dts);
					if($dt['total']!=""){
						echo 'S/. '.formato_money($dt['total']);
					}else{
						echo 'S/. 0.00';
					}
				mysql_free_result($dts);
				?></td>
	      </tr>
			<tr>
			  <td align="left">Total Compras en 
              <?php
			  echo nombre_mes($m);
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$y-$m-%",'tb_compra_est',$com_est,$_SESSION['empresa_id']);
				$dt = mysql_fetch_array($dts);
					if($dt['total']!=""){
						echo 'S/. '.formato_money($dt['total']);
					}else{
						echo 'S/. 0.00';
					}
				mysql_free_result($dts);
				?></td>
	      </tr>
			<?php /*?><tr>
			  <td align="left">Compras en 
              <?php
			  echo $y.': ';
                $dts=$oCuadromi->num_reg_ope_fecha('tb_compra','tb_compra_fec',"$y-$m-%");
				$dt = mysql_fetch_array($dts);
				echo $dt['numero'];
				mysql_free_result($dts);
				?></td>
		  </tr><?php */?>
		</tbody>
	</table>
</div>
<div id="cuadro-contain" class="ui-widget" style="float:left; margin-left:20px; margin-right:20px">
    <table id="cuadro" class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th colspan="2" align="left">VENTAS</th>
			</tr>
	  </thead>
		<tbody>
			<tr>
			  <td colspan="2" align="left">Producto más vendido del mes:
              <?php
                $dts=$oCuadromi->producto_mas_ope('tb_ventadetalle','tb_venta','dt.tb_venta_id=op.tb_venta_id','tb_venta_fec',"$y-$m-%",$_SESSION['empresa_id'],'5');?>
              	<ul>
		        <?php
				while($dt = mysql_fetch_array($dts)){
					echo '<li>'.$dt['tb_producto_nom']./*' '.$dt['tb_presentacion_nom'].' '.$dt['tb_unidad_abr'].*/'</li>';
				}
				mysql_free_result($dts);
				?>
                </ul>
                </td>
		  </tr>
			<tr>
			  <td align="left">Ventas hoy
			    <?php
			  echo nombre_dia("$d-$m-$y");
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->num_reg_ope_fecha('tb_venta','tb_venta_fec',"$y-$m-$d",$_SESSION['empresa_id']);
				$dt = mysql_fetch_array($dts);
				echo $dt['numero'];
				mysql_free_result($dts);
				?></td>
	      </tr>
			<tr>
			  <td align="left">Ventas en 
			    <?php
			  echo nombre_mes($m);
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->num_reg_ope_fecha('tb_venta','tb_venta_fec',"$y-$m-%",$_SESSION['empresa_id']);
				$dt = mysql_fetch_array($dts);
				echo $dt['numero'];
				mysql_free_result($dts);
				?></td>
	      </tr>
			<tr>
			  <td align="left">Total Ventas hoy
			    <?php
			  echo nombre_dia("$d-$m-$y");
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$y-$m-$d",'tb_venta_est',$ven_est,$_SESSION['empresa_id']);
				$dt = mysql_fetch_array($dts);
					if($dt['total']!=""){
						echo 'S/. '.formato_money($dt['total']);
					}else{
						echo 'S/. 0.00';
					}
				mysql_free_result($dts);
				?></td>
	      </tr>
			<tr>
			  <td align="left">Total Ventas en
			    <?php
			  echo nombre_mes($m);
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$y-$m-%",'tb_venta_est',$ven_est,$_SESSION['empresa_id']);
				$dt = mysql_fetch_array($dts);
					if($dt['total']!=""){
						echo 'S/. '.formato_money($dt['total']);
					}else{
						echo 'S/. 0.00';
					}
				mysql_free_result($dts);
				?></td>
	      </tr>
			<?php /*?><tr>
			  <td align="left">Ventas en
			    <?php
			  echo $y.': ';
                $dts=$oCuadromi->num_reg_ope_fecha('tb_venta','tb_venta_fec',"$y-$m-%");
				$dt = mysql_fetch_array($dts);
				echo $dt['numero'];
				mysql_free_result($dts);
				?></td>
		  </tr><?php */?>
		</tbody>
  </table>
</div>

<?php /*?>
<div id="cuadro-contain" class="ui-widget" style="float:left">
<?php 
$rws=$oAlmacen->mostrar_para_venta($_SESSION['empresa_id']);
while($rw = mysql_fetch_array($rws)){
?>
	<table id="cuadro" class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th align="left">STOCK <?php echo $rw['tb_almacen_nom']?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
			  <td align="left">Producto por debajo del stock mínimo: <?php
                $dts=$oCuadromi->producto_debajo_stock($rw['tb_almacen_id']);
				echo $num_rows= mysql_num_rows($dts);
				?>
              <ul>
		        <?php
				while($dt = mysql_fetch_array($dts)){
					//if($dt['tb_stock_num']>0)
					//{
						echo '<li>'.$dt['tb_producto_nom'].' '.$dt['tb_presentacion_nom'].'. En stock= '.$dt['tb_stock_num'].'.</li>';
					//}
				}
				mysql_free_result($dts);
				?>
              </ul>  
		      </td>
		  </tr>
		</tbody>
	</table>
<?php
}
mysql_free_result($rws);
?>
</div>
<?php */?>
<div id="cuadro-contain" class="ui-widget cuadromi_tabla_facturas_pendientes" style="float:left;" >

</div>

<div id="cuadro-contain" class="ui-widget cuadromi_tabla_resumen_pendientes" style="float:left;" >

</div>
