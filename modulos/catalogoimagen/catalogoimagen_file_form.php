<?php
require_once ("../../config/Cado.php");
require_once ("cCatalogoimagen.php");
$oCatimagen = new cCatalogoimagen();

require_once("../formatos/formato.php");

?>

<script type="text/javascript">
$('#btn_subir_fil').button({
icons: {primary: "ui-icon ui-icon-arrowthickstop-1-n"},
text: true
});

$('#btn_bajar_fil').button({
icons: {primary: "ui-icon ui-icon-arrowthickstop-1-s"},
text: true
});

$(function() {

    <?php $timestamp = time();?>
    $(function() {
        $('#file_upload').uploadifive({
            'auto'             : true,
            //'checkScript'      : 'programacion_file_check.php',
            'formData'         : {
                                   'timestamp' : '<?php echo $timestamp;?>',
                                   'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
                                   'action'    : 'insertar',
                                   'catimg_id' : '<?php echo $_POST['catimg_id'];?>'
                                 },
            'queueID'          : 'queue',
            'uploadScript'     : 'catalogoimagen_file_reg.php',
            'queueSizeLimit'   : 10,
            'uploadLimit'      : 10,
            'multi'            : false,
            'buttonText'       : 'Archivo',
            'height'           : 20,
            'width'            : 150,
            //'removeCompleted': true,
            //'fileSizeLimit'    : 2097152,
            //'fileSizeLimit'    : '5MB',
            'fileType'         :[
                //'image/jpeg',
                //'image/png',
                'application/vnd.ms-excel',
                'application/vnd.ms-powerpoint',
                'doc',
                'application/pdf',
                ''
                ],
            'onUploadComplete' : function(file, data) { //console.log(data);
                // $('#div_programacion_file_form').dialog( "close" );
                // programacion_tabla();
                catalogo_imagen_tabla();             
            },
            'onError': function (errorType) {
                var message = "Error desconocido.";
                if (errorType == 'FILE_SIZE_LIMIT_EXCEEDED') {
                    message = "Tamaño de archivo debe ser menor a 3MB.";
                } else if (errorType == 'FORBIDDEN_FILE_TYPE') {
                    message = "Tipo de archivo no válido.";
                    alert(message);
                }
                //$(".uploadifive-queue-item.error").hide();
                //
                //$.FormFeedbackError(message);
            },
            'onAddQueueItem' : function(file) {
                //console.log('The file ' + file.name + ' was added to the queue!');
                //alert(file.type);
            },
            /*'onCheck'      : function(file, exists) {
                if (exists) {
                    alert('El archivo ' + file.name + ' ya existe.');
                }
            }*/
        });
    });

});
</script>


<form>
   
    <table>        
        <tr align="left">
        	<td colspan="2" ></td>
        </tr>
        <tr align="left">
        	<td colspan="2" >Seleccione un archivo. (Extensiones: .doc, .ppt, .rar, .pdf)</td>
        </tr>
    </table>
</form>
<div>
	<div id="queue"></div>
	<input id="file_upload" name="file_upload" type="file" multiple="true">    
	<br>
	<br>
</div>