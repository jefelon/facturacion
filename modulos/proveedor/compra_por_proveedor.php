<?php
require_once ("../../config/Cado.php");
require_once ("../proveedor/cProveedor.php");
$oProveedor = new cProveedor();
$dts1=$oProveedor->mostrarUno($_POST['pro_id']);
$dt = mysql_fetch_array($dts1);
		$tip=$dt['tb_proveedor_tip'];
		$nom=$dt['tb_proveedor_nom'];
		$doc=$dt['tb_proveedor_doc'];
		$dir=$dt['tb_proveedor_dir'];
		$con=$dt['tb_proveedor_con'];
		$tel=$dt['tb_proveedor_tel'];
		$ema=$dt['tb_proveedor_ema'];
$num_rows= mysql_num_rows($dts1);
mysql_free_result($dts1);
?>
<script type="text/javascript">
function compra_filtro_por_proveedor(){
	$.ajax({
		type: "POST",
		url: "compra_filtro_por_proveedor.php",
		async:true,
		dataType: "html",                      
		//data: ({
			//producto: $('#txt_fil_pro').val()
		//}),
		beforeSend: function() {
			$('#div_compra_filtro_por_proveedor').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){				
			$('#div_compra_filtro_por_proveedor').html(html);
		},
		complete: function(){
			compra_tabla_por_proveedor();
		}
	});
}

function compra_tabla_por_proveedor(){		
	$.ajax({
		type: "POST",
		url: "compra_tabla_por_proveedor.php",
		async:true,
		dataType: "html",                      
		data: ({
			com_fec1:	$('#txt_fil_com_fec1').val(),
			com_fec2:	$('#txt_fil_com_fec2').val(),
			pro_id:		'<?php echo $_POST["pro_id"]?>'		
		}),
		beforeSend: function() {
			$('#div_compra_tabla_por_proveedor').addClass("ui-state-disabled");
    },
		success: function(html){
			$('#div_compra_tabla_por_proveedor').html(html);
		},
		complete: function(){			
			$('#div_compra_tabla_por_proveedor').removeClass("ui-state-disabled");
		}
	});     
}

$(function() {
	compra_filtro_por_proveedor();
});
</script>
<div id="div_datos_proveedor">
<fieldset>
	<legend>Datos Proveedor:</legend>
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
    	  <td align="right"><strong>Proveedor:</strong></td>
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
<div id="div_compra_filtro_por_proveedor">
</div>
<div id="div_compra_tabla_por_proveedor">
</div>