<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../cuadromi/cCuadromi.php");
$oCuadromi = new cCuadromi();
require_once ("../formatos/formatos.php");

$y=date('Y');
$m=date('m');
$d=date('d');

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
<div  style="float:left;width: 50%;">
    <div class="iconos">
        <a href="../venta/venta_vista.php" target="_blank" class="botonera">
            <div class="ventas"></div><span>VENDER</span>
        </a>
        <a href="../clientes/" target="_blank" class="botonera">
            <div class="clientes"></div><span>CLIENTES</span>
        </a>
        <a href="../kardex/" target="_blank" class="botonera">
            <div class="kardex"></div><span>KARDEX</span>
        </a>
    </div>
    <div class="iconos">
        <a href="../producto/" target="_blank" class="botonera">
            <div class="productos"></div><span>PRODUCTOS</span>
        </a>
        <a href="../categoria/" target="_blank" class="botonera">
            <div class="categorias"></div><span>CATEGORIAS</span>
        </a>
        <a href="../catalogo/" target="_blank" class="botonera">
            <div class="catalogo"></div><span>CAT. DE PRODUCTOS</span>
        </a>
    </div>
    <div class="iconos">
        <a href="../grafico/" target="_blank" class="botonera">
            <div class="grafico"></div><span>GRAFICO VENTAS</span>
        </a>
        <a href="../flujocaja/caja_vista.php" target="_blank" class="botonera">
            <div class="caja"></div><span>CAJA</span>
        </a>
        <a href="../ingreso/" target="_blank" class="botonera">
            <div class="ingresos"></div><span>INGRESOS</span>
        </a>
    </div>
    <div class="iconos">
        <a href="../usuarios/usuario_datos_vista.php" target="_blank" class="botonera">
            <div class="usuario"></div><span>MIS DATOS</span>
        </a>
        <a href="https://youtu.be/c1Zu3txOpAc" target="_blank" class="botonera">
            <div class="videos"></div><span>VIDEOS</span>
        </a>
        <a href="../egreso/" target="_blank" class="botonera">
            <div class="egresos"></div><span>EGRESOS</span>
        </a>
    </div>
</div>
<div align="left">
<?php
echo fechaActual(1);
?>
</div>
<div id="cuadro-contain" class="ui-widget" style="float:left; margin-left:20px">
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
			  <td align="left">Mis ventas hoy
			    <?php
			  echo nombre_dia("$d-$m-$y");
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->num_reg_ope_fecha_ven('tb_venta','tb_venta_fec',"$y-$m-$d",$_SESSION['usuario_id'],$_SESSION['puntoventa_id']);
				$dt = mysql_fetch_array($dts);
				echo $dt['numero'];
				mysql_free_result($dts);
				?></td>
	      </tr>
			<tr>
			  <td align="left">Mis ventas en 
			    <?php
			  echo nombre_mes($m);
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->num_reg_ope_fecha_ven('tb_venta','tb_venta_fec',"$y-$m-%",$_SESSION['usuario_id'],$_SESSION['puntoventa_id']);
				$dt = mysql_fetch_array($dts);
				echo $dt['numero'];
				mysql_free_result($dts);
				?></td>
	      </tr>
			<tr>
			  <td align="left">Total de ventas hoy
			    <?php
			  echo nombre_dia("$d-$m-$y");
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->total_ope_usu('tb_venta_tot','tb_venta','tb_venta_fec',"$y-$m-$d",'tb_venta_est',$ven_est,$_SESSION['usuario_id'],$_SESSION['puntoventa_id']);
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
			  <td align="left">Total Ventas hoy
			    <?php
			  echo nombre_dia("$d-$m-$y");
				?></td>
			  <td align="right"><?php
                $dts=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$y-$m-$d");
				$dt = mysql_fetch_array($dts);
					if($dt['total']!=""){
						echo 'S/. '.$dt['total'];
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
                $dts=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$y-$m-%");
				$dt = mysql_fetch_array($dts);
					if($dt['total']!=""){
						echo 'S/. '.$dt['total'];
					}else{
						echo 'S/. 0.00';
					}
				mysql_free_result($dts);
				?></td>
	      </tr><?php */?>
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
<div id="cuadro-contain" class="ui-widget" style="float:left; margin-left:20px; margin-right:20px">
    <table id="cuadro" class="ui-widget ui-widget-content">
		<thead>
			<tr class="ui-widget-header ">
				<th align="left">STOCK</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			  <td align="left">Producto por debajo del stock mínimo: <?php
                $dts=$oCuadromi->producto_debajo_stock($_SESSION['almacen_id']);
				echo $num_rows= mysql_num_rows($dts);
				?>
              <ul>
		        <?php
				while($dt = mysql_fetch_array($dts)){
					echo '<li>'.$dt['tb_producto_nom'].' '.$dt['tb_presentacion_nom'].'. En stock= '.$dt['tb_stock_num'].'.</li>';
				}
				mysql_free_result($dts);
				?>
              </ul>  
		      </td>
		  </tr>
		</tbody>
	</table>
</div>
<?php */?>

<div id="cuadro-contain" class="ui-widget" style="float:left">
    
</div>