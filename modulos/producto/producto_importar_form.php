<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cProducto.php");
$oProducto = new cProducto();
require_once("cProductoproveedor.php");
$oProductoproveedor = new cProductoproveedor();
require_once("../formatos/formato.php");


?>



<script type="text/javascript">

$("#for_pro_imp").validate({
    submitHandler: function() {
        var form_data=new FormData($('#for_pro_imp')[0]);
        $.ajax({
            type: "POST",
            url: "../producto/importar_producto_reg.php",
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: form_data,

            beforeSend: function(){
                $('#div_producto_importar').dialog("close");
                $('#msj_producto').html("Guardando...");
                $('#msj_producto').show(100);
            },
            success: function(data){
                $('#msj_producto').html(data.message);
            },
            complete: function(){

            }
        });
    },
    rules: {
        file_xls: {
            required: true
        }
    },
    messages: {
        file_xls: {
            required: '*'
        }
    }
});


</script>
<form id="for_pro_imp" enctype="multipart/form-data">
<div style="float:left;width: 350px;">
  <fieldset style="min-width: 300px">
      <div>
          <label>Elija Archivo Excel</label>
          <input type="file" name="file_xls"
                 id="file_xls" accept=".xls,.xlsx,.csv">
      </div>
</fieldset>
<div id="msj_producto" class="ui-state-error ui-corner-all" style="width:auto; float:left; padding:4px; display:none"></div>
</div>
</form>