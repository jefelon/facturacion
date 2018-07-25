<?php 
	session_start();
	require_once ("../../config/Cado.php");		
	require_once ("../producto/cCatalogoproducto.php");	
	$oCatalogoproducto = new cCatalogoproducto();
	$rs = $oCatalogoproducto->presentacion_catalogo($_POST['cat_id']);	
	$num_rows = mysql_num_rows($rs);
?>
<script type="text/javascript">
$('.btn_editar_pro').button({
	icons: {primary: "ui-icon-pencil"},
	text: true
});
function producto_form(act,idf){
	$.ajax({
		type: "POST",
		url: "../producto/producto_form.php",
		async:true,
		dataType: "html",                      
		data: ({
			action: act,
			pro_id:		idf,
			vista:	'catalogo_tabla'
		}),
		beforeSend: function() {
			$('#msj_producto').hide();
			$('#div_producto_form').dialog("open");
			$('#div_producto_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_producto_form').html(html);				
		}
	});
}

$(function(){
	$( "#div_producto_form" ).dialog({
		title:'Información de Producto',
		autoOpen: false,
		resizable: false,
		height: 'auto',
		width: 990,
		modal: true,
		position: 'top',
		buttons: {
			Guardar: function() {
				$("#for_pro").submit();
			},
			Cancelar: function() {
				$('#for_pro').each (function(){this.reset();});
				$( this ).dialog("close");
			}
		},
		close: function() 
		{
			$("#div_producto_form").html('Cargando...');
		}
	});
});
</script>
<fieldset>
	<legend>Datos del Producto</legend><?php
	if($num_rows > 0){
		while($dt = mysql_fetch_array($rs)){								
			$mar = $dt['tb_marca_nom'];//Marca			
			$cat = $dt['tb_categoria_nom'];//Categoría
			$nom = $dt['tb_producto_nom'];//descripcion
			
			$pro_id = $dt['tb_producto_id'];//descripcion
		}	
	}				
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table>              
        <tr>
        	<td align="right"><strong>Descripción:</strong></td>
            <td>
				<?php echo $nom;?>
                <!--hdd_pro_sel_id: Guarda el Id del Catalogo Seleccionado-->
            	<input type="hidden" name="hdd_cat_sel_id" id="hdd_cat_sel_id" value="<?php echo $_POST['cat_id']?>" />
            </td>
        </tr>
        
        <tr>
        	<td align="right"><strong>Categoría:</strong></td>
            <td><?php echo $cat?></td>
        </tr>
        
        <tr>
        	<td align="right"><strong>Marca:</strong></td>
            <td><?php echo $mar?></td>
        </tr>
    </table></td>
    <td><div style="float:right">
    <?php if($_SESSION['usuariogrupo_id']==2){?>
    <a class="btn_editar_pro" href="#editar" onClick="producto_form('editar','<?php echo $pro_id?>')">Editar Producto</a>
    <?php }?>
    </div></td>
  </tr>
</table>
</fieldset>
<div id="div_producto_form">
</div>          	