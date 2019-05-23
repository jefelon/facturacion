<script type="text/javascript">
$('#btn_agregar_nuevo_usuario').button({
		icons: {primary: "ui-icon-plus"},
		text: true
	});

function cargarTabla_usuario_seleccionar(dato)
{	
	//if(dato!=""){
		$.ajax({
			type: "POST",
			url: "usuario_seleccionar_tabla.php",
			async:true,
			dataType: "html",                      
			data: ({
				usugru			: '<?php echo $_POST['usugru']?>',
				dato_busqueda	: dato
			}),
			beforeSend: function() {
				$('#div_usuario_seleccionar_tabla').html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
			},
			success: function(html){
				$('#div_usuario_seleccionar_tabla').html(html);
			}
		});
	//}
}

$(function() {
	
	cargarTabla_usuario_seleccionar($("#txt_bus_usu").val());
		
	$("#txt_bus_usu").keyup(function() {
		cargarTabla_usuario_seleccionar($("#txt_bus_usu").val());
	});
	
	
});
</script>
Buscar: <input name="txt_bus_usu" type="text" id="txt_bus_usu" value="<?php echo $_POST['apenom']?>" size="50">
<a id="btn_agregar_nuevo_usuario" href="#" onClick="insertar_usuario()">Nuevo</a>
<br>
</br>
<div id="div_usuario_seleccionar_tabla">
</div>