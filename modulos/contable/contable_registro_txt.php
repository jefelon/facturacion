<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 27/08/2018
 * Time: 15:18
 */
/*header("Content-type: application/vnd.ms-excel; name='excel'");
header("Pragma: no-cache");
header("Expires: 0");*/

//set_time_limit (0);

//ini_set('memory_limit', '128M');

ini_set('post_max_size','10M');
//ini_set('upload_max_filesize','12M');

ini_set('max_execution_time','60');
ini_set('max_input_time','60');

//header('Pragma: public');
//header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header("Expires: 0");
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
header('Cache-Control: pre-check=0, post-check=0, max-age=0'); // HTTP/1.1
header('Pragma: no-cache');
header('Expires: 0');
header('Content-Transfer-Encoding: none');
header("Content-Type: application/vnd.ms-excel; name='excel'"); // This should work for IE & Opera
header('Content-type: application/x-msexcel'); // This should work for the rest

$fecha_actual=$d=date('d-m-Y');
$nombre_archivo='TXT-contable_registro_'.$fecha_actual.'.txt';
header('Content-Disposition: attachment; filename="TXT-'.$nombre_archivo.'"');

echo utf8_decode($_POST['hdd_tabla']);
?>