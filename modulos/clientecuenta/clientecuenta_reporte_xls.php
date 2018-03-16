<?php 
session_start();
require_once ("../../config/Cado.php");
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();

	$dts=$oCliente->mostrarUno($_POST['hdd_cliente']);
	$dt = mysql_fetch_array($dts);
		$tip=$dt['tb_cliente_tip'];
		$nom=$dt['tb_cliente_nom'];
		$doc=$dt['tb_cliente_doc'];
		$dir=$dt['tb_cliente_dir'];
		$con=$dt['tb_cliente_con'];
		$tel=$dt['tb_cliente_tel'];
		$ema=$dt['tb_cliente_ema'];
	mysql_free_result($dts);

/*header("Content-type: application/vnd.ms-excel; name='excel'"); 
header("Pragma: no-cache"); 
header("Expires: 0");*/

header('Pragma: public'); 
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
$nombre_archivo='estadocuenta_'.$doc.'_'.$fecha_actual.'.xls';
header('Content-Disposition: attachment; filename="'.$nombre_archivo.'"');


$empresa= utf8_decode ('EMPRESA: '.$_SESSION['empresa_nombre']);
$title= 'ESTADO DE CUENTA AL '.date('d/m/Y');
$cliente= 'CLIENTE: '.utf8_decode ($nom);
$documento= 'DOCUMENTO: '.$doc;
$direccion= 'DIRECCION: '.utf8_decode ($dir);
$fechor=utf8_decode ('Fecha de Impresión: ').date('d/m/Y H:i:s');

$com=6;

$tabla1='<table xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">';
$tabla1.='
		<tr>
			<td colspan="'.$com.'"><strong>'.$empresa.'</strong></td>
		</tr>';
		
$tabla1.='
		<tr>
			<td colspan="'.$com.'"><strong>'.$title.'</strong></td>
		</tr>';
$tabla1.='
		<tr>
			<td colspan="'.$com.'">'.$cliente.'</td>
		</tr>';
$tabla1.='
		<tr>
			<td colspan="'.$com.'">'.$documento.'</td>
		</tr>';
$tabla1.='
		<tr>
			<td colspan="'.$com.'">'.$direccion.'</td>
		</tr>';
$tabla1.='
		<tr>
			<td colspan="'.$com.'">'.$fechor.'</td>
		</tr>';
		
	$tabla1.='
		<tr>
			<td colspan="'.$com.'"></td>
		</tr>
	</table>';

	echo $tabla1;

echo utf8_decode($_POST['hdd_tabla']); 
?> 