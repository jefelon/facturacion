<?php
require_once ("../../config/Cado.php");
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();

$dts1=$oCliente->mostrarUno($_POST['cli_id']);
$dt = mysql_fetch_array($dts1);
		$tip=$dt['tb_cliente_tip'];
		$nom=$dt['tb_cliente_nom'];
		$doc=$dt['tb_cliente_doc'];
		$dir=$dt['tb_cliente_dir'];
		$con=$dt['tb_cliente_con'];
		$tel=$dt['tb_cliente_tel'];
		$ema=$dt['tb_cliente_ema'];
$num_rows= mysql_num_rows($dts1);
mysql_free_result($dts1);
?>
<script type="text/javascript">
function venta_filtro_por_cliente(){
	$.ajax({
		type: "POST",
		url: "venta_filtro_por_cliente.php",
		async:true,
		dataType: "html",                      
		data: ({
			//producto: $('#txt_fil_pro').val()
		}),
		beforeSend: function() {
			$('#div_venta_filtro_por_cliente').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_venta_filtro_por_cliente').html(html);
		},
		complete: function(){
			venta_tabla_por_cliente();
		}
	});
}

function venta_tabla_por_cliente(){		
	$.ajax({
		type: "POST",
		url: "venta_tabla_por_cliente.php",
		async:true,
		dataType: "html",                      
		data: ({
			ven_fec1:	$('#txt_fil_ven_fec1').val(),
			ven_fec2:	$('#txt_fil_ven_fec2').val(),
			cli_id:		'<?php echo $_POST["cli_id"]?>'		
		}),
		beforeSend: function() {
			$('#div_venta_tabla_por_cliente').addClass("ui-state-disabled");
    },
		success: function(html){
			$('#div_venta_tabla_por_cliente').html(html);
		},
		complete: function(){			
			$('#div_venta_tabla_por_cliente').removeClass("ui-state-disabled");
		}
	});     
}

$(function() {
	venta_filtro_por_cliente();
});
</script>
<div id="div_datos_cliente">
<fieldset>
	<legend>Datos Cliente:</legend>
	<table>
    	<tr>
    	  <td align="right"><strong>Persona:</strong></td>
    	  <td>
          	<?php 
				if($tip == 1){
					echo "Natural";
				}else{
					if($tip == 2){
						echo "Jurídico";
					}	
				}
			?>
    	  </td>
  	  </tr>
    	<tr>
    	  <td align="right"><strong>Cliente:</strong></td>
    	  <td><?php echo $nom?></td>
  	  </tr>
    	<tr>
            <td align="right"><strong>RUC/DNI:</strong></td>
            <td><?php echo $doc?></td>
        </tr>
        <tr>
          <td align="right" valign="top"><strong>Dirección:</strong></td>
          <td><?php echo $dir?>
          </td>
      	</tr>        
    </table>
</fieldset>
</div>
<div id="div_venta_filtro_por_cliente">
</div>
<div id="div_venta_tabla_por_cliente">
</div>