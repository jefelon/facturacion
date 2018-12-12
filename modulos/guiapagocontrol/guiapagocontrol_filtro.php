<?php

  $eje_id=date('Y');
  $mes=date("n");
  $dia=date("j");

$per_id=$mes-1;

	if($mes==1 and $dia<26)
  {
      $eje_id=$eje_id-1;
      $per_id=12;
  }

  //$eje_id=$_POST['eje_id'];
  /*$cro_id=$_POST['cro_id'];
  $per_id=$_POST['per_id'];
  $dig_id=$_POST['dig_id'];*/
?>
<script type="text/javascript">
$('#btn_guiapagocontrol_filtrar').button({
	icons: {primary: "ui-icon-search"},
	text: false
});
$('#btn_guiapagocontrol_resfil').button({
	icons: {primary: "ui-icon-arrowrefresh-1-w"},
	text: false
});

/*
function cmb_fil_eje_id(ids)
{ 
  $.ajax({
    type: "POST",
    url: "../ejercicio/cmb_eje_id.php",
    async:false,
    dataType: "html",                      
    data: ({
      eje_id: ids
    }),
    beforeSend: function() {
      $('#cmb_fil_eje_id').html('<option value="">Cargando...</option>');
        },
    success: function(html){
      $('#cmb_fil_eje_id').html(html);
    },
    complete: function(){
      //guiapagocontrol_tabla();
    }
  });
}

function cmb_fil_per_id(ids,cro)
{ 
  $.ajax({
    type: "POST",
    url: "../periodo/cmb_per_id.php",
    async:false,
    dataType: "html",                      
    data: ({
      per_id: ids,
      tip: "",
      cro_id: cro
    }),
    beforeSend: function() {
      $('#cmb_fil_per_id').html('<option value="">Cargando...</option>');
        },
    success: function(html){
      $('#cmb_fil_per_id').html(html);
    },
    complete: function(){
      //guiapagocontrol_tabla();
    }
  });
}
*/

$(function(){

	//cmb_fil_eje_id('<?php echo $eje_id;?>');
	//cmb_fil_per_id('<?php echo $per_id;?>');


	$("#txt_fil_cli").autocomplete({
		minLength: 1,
		source: "../cliente/cliente_complete_nom.php",
		select: function(event, ui){			
			$("#hdd_fil_cli_id").val(ui.item.id);							
			$("#txt_fil_cli_doc").val(ui.item.documento);
			$("#txt_fil_cli_dir").val(ui.item.direccion);
			guiapagocontrol_tabla();		
		}
	});
  $("#txt_fil_cli").change(function(){
    var cli=$("#txt_fil_cli").val();
    if(cli=="")$("#hdd_fil_cli_id").val('');
  });

  $("#txt_fil_cli").keypress(function(e){
    if(e.which == 13){
      return false;
    }
  });

	$("#cmb_fil_eje_id, #cmb_fil_per_id").change(function(event) {
		guiapagocontrol_tabla();
	});
	
});	
</script>
<form name="for_fil_con" id="for_fil_con" target="_blank" action="" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="<?php echo $_POST['modo'];?>">
<fieldset>
	<legend>Filtro</legend>

    <input type="hidden" id="hdd_fil_cli_id" name="hdd_fil_cli_id" />
    <label for="txt_fil_cli_id">Cliente:</label>
    <input type="text" id="txt_fil_cli" name="txt_fil_cli" size="40" />

	  <?php /*<label for="cmb_fil_eje_id">Ejercicio:</label>
    <select name="cmb_fil_eje_id" id="cmb_fil_eje_id"></select>

    <label for="cmb_fil_per_id">Periodo:</label>
    <select name="cmb_fil_per_id" id="cmb_fil_per_id"></select>*/ ?>

    <a href="#" onClick="guiapagocontrol_tabla()" id="btn_guiapagocontrol_filtrar">Filtrar</a>
	<a href="#" onClick="guiapagocontrol_filtro()" id="btn_guiapagocontrol_resfil">Restablecer</a>
</fieldset>
</form>