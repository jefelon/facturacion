<?php
require_once ("../../config/Cado.php");
require_once ("cVale.php");
$oVale = new cVale();
require_once ("../formatos/formatos.php");


$codigo2=$_GET['code'];
//echo '<br>';
//echo $codigo=substr($codigo_gen, 8);

$tipo=$_GET['t'];

//validar el email de confirmacion con el registro de datos
//$result = $oVale->verificar_restabclave($email_c,$codigo);
//$fila = mysql_fetch_array($result);
//	
//if($fila['tb_restabclave_ema']!="")
//{
//	
if($codigo2!="" and $tipo=="confirm")
{
//		$use_id=$fila['tb_usuario_id'];
		
		$dts=$oVale->mostrar_vale($codigo2);
		$dt = mysql_fetch_array($dts);
			$val_registro		=$dt['registro'];
			$val_titulo			=$dt['titulo'];
			$val_dscripcion	=$dt['descripcion'];
			$val_inicio			=mostrarFecha($dt['inicio']);
			$val_fin					=mostrarFecha($dt['fin']);
			$val_condiciones	=$dt['condiciones'];
			$val_tipo				=$dt['tipo'];
			$val_dato				=$dt['dato'];
			$val_estado			=$dt['estado_vale'];
			
			$cli_nombre	=$dt['nombre'];
			$cli_dni	=$dt['dni'];
			$cli_correo	=$dt['correo'];
			
			$det_codigo	=$dt['codigo'];
			$det_codigo2	=$dt['codigo2'];
			$det_fecha	=mostrarFecha2($dt['fecha']);
			$det_estado	=$dt['estado'];

		mysql_free_result($dts);

//	}
//	else
//	{
//		$aviso2="Se ha cancelado la operacion. Ingresar.";
//		//header("Location: login.php?mm=".$aviso2."..");
//	}
//}
//else
//{
//	$aviso3="ERROR. Enlace alterado.";
//	//header("Location: login.php?mm=".$aviso3."..");
}
if($det_codigo>0)
{
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
    div.zone { border: none; border-radius: 6mm; background: #FFFFFF; border-collapse: collapse; padding:3mm; font-size: 2.7mm;}
    h1 { padding: 0; margin: 0; color: #DD0000; font-size: 7mm; }
    h2 { padding: 0; margin: 0; color: #222222; font-size: 5mm; position: relative; }
-->
</style>
<div style="font: arial; border: dashed ; font-family:Arial">
<div class="zone" style="position: relative;font-size: 5mm;">
<table border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td class="_title2"><img src="http://granadosllantas.com/portal/images/granados/logo/logo470x100.png" alt="Logo" width="420" height="80"></td>
      <td align="right" class="_title2">
        <?php echo "<h1>$val_titulo</h1>";?>
        <?php
			if($val_tipo==1)$tipo_vale='S/. '.$val_dato;
			if($val_tipo==2)$tipo_vale=$val_dato.' %';
			 echo "<h1>$tipo_vale</h1>";?>
      </td>
      </tr>
    <tr>
      <td class="_title2"><?php echo $val_dscripcion?></td>
      <td align="right" class="_title2"><?php echo "<b>COD: $det_codigo2</b>";?></td>
      </tr>
    <tr>
      <td class="_title2">
			NOMBRE: <?php echo $cli_nombre?><br>
      DNI: <?php echo $cli_dni?><br>
      CORREO: <?php echo $cli_correo?><br>
      </td>
      <td align="right" class="_title2"><?php echo "Fecha: $det_fecha"?><br></td>
      </tr>
    <tr>
      <td class="_title2"><?php echo "Válido desde $val_inicio hasta $val_fin.";?></td>
      <td class="_title2">&nbsp;</td>
      </tr>
    <tr>
      <td class="_title2">
			<div style="vertical-align: middle; text-align: justify">
          <b>Condiciones:</b><br>
          <?php echo $val_condiciones?>
      </div>
      </td>
      <td class="_title2">&nbsp;</td>
      </tr>
    <tr>
      <td class="_title2">www.granadosllantas.com | ventas@granadosllantas.com.</td>
      <td align="right" class="_title2">Impresión <?php echo date('d/m/Y H:i:s'); ?></td>
      </tr>
  </table>
</div>
</div>
<?php }
else
{
	echo "Código incorrecto.";
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<td class="_title2"><a href="http://www.granadosllantas.com">www.granadosllantas.com</a></td>
<?php }?>