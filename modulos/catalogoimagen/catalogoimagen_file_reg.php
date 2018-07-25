<?php
require_once ("../../config/Cado.php");
require_once("cCatalogoimagen.php");
$oCatalogoimagen = new cCatalogoimagen();

if($_POST['action']=="insertar")
{
	$uploadDir = '../../files/catalogoimagen/';

	// Set the allowed file extensions
	//$fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions
	$fileTypes = array('jpg', 'png', 'psd');

	$verifyToken = md5('unique_salt' . $_POST['timestamp']);

	if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
		$tempFile   = $_FILES['Filedata']['tmp_name'];
		//$uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;

		$nombre=$_FILES['Filedata']['name'];

		$fileParts = pathinfo($_FILES['Filedata']['name']);

		// insertar
		$oCatalogoimagen->insertar_img(
			$_POST['catimg_id'],
			$targetFile
		);

		//ultimo insert
		$dts=$oCatalogoimagen->ultimoInsert_img();
		$dt = mysql_fetch_array($dts);
		$img_id=$dt['last_insert_id()'];
		mysql_free_result($dts);


		$nuevo_nombre=$img_id.'.'.$fileParts['extension'];
		//$targetFile = $uploadDir . $_FILES['Filedata']['name'];
		$targetFile = $uploadDir.$nuevo_nombre;

		// Validate the filetype
		if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

			//crear carpeta si no existe
			//mkdir(str_replace('//','/',$uploadDir), 0755, true);
			// Save the file
			move_uploaded_file($tempFile, $targetFile);
				
				$oCatalogoimagen->modificar_url(
					$img_id,
					$targetFile
				);

			echo 1;

		} else {

			// The file type wasn't allowed
			echo 'Tipo de archivo no permitido.';

		}
	}
}
if($_POST['action']=="eliminar")
{
	
	if(!empty($_POST['imgfil_id']))
	{
		$dts=$oCatalogoimagen->mostrarUno_imagenfile($_POST['imgfil_id']);
		$dt = mysql_fetch_array($dts);
			$fil=$dt['tb_catalogoimagenfile_url'];
		mysql_free_result($dts);

		// $uploadDir = '../../files/catalogoimagen/';
		// $targetFile = $uploadDir.$fil;

		//$target = $_SERVER['DOCUMENT_ROOT'] .'/m-trainingperu/sistema/'. $url;
		
		$ban=unlink($fil);
		
		if($ban==true){			
			$oCatalogoimagen->eliminar_file($_POST['imgfil_id']);
			echo 'Se eliminó archivo correctamente.';
		}
		else
		{
			echo 'No se pudo eliminar '.$fil;
		}
				
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}
?>