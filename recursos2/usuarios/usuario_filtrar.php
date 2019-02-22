<?php
/*require_once ("../formatos/formatos.php");
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	
	$fec1="01-$m-$y";
	
	//$d=ultimoDia($m,$y);
	//$fec2="$d-$m-$y";
	$fec2="$d-$m-$y";
	*/
?>
<script type="text/javascript">
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: true
	});

$(function() {
	
	$( "#txt_fil_usu_bus" ).autocomplete({
   		minLength: 1,
   		source: "dao/usuario_complete_nom.php?usugru=Vendedor"
    });

});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_ins" id="for_fil_ins" method="post" action="">
<fieldset><legend>Filtro</legend>
  <label for="txt_fil_usu_bus">Buscar:</label>
  <input name="txt_fil_usu_bus" type="text" id="txt_fil_usu_bus" size="50">
  <a href="#" onClick="usuario_tabla()" id="btn_filtrar">Filtrar</a>
</fieldset>
</form>