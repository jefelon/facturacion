<?php
require_once("../../config/Cado.php");
require_once("cVale.php");
$oVale = new cVale();

$url_web		='www.granadosllantas.com';
$email_soporte	='ventas@granadosllantas.com';
$email_respuesta='ventas@granadosllantas.com';

if($_POST['action_usuario'] == 'insertar'){
	if($_POST['txt_nom']!="" and $_POST['txt_dni']!="" and $_POST['txt_ema']!="")
	{
		//$result = $oVale->verificaVale($_POST['txt_use']);
		//$fila = mysql_fetch_array($result);
		
		//if($fila[1] !="")
//		{
//			echo "El Nombre de Vale '".$_POST['txt_use']."' no está disponible.";
//		}
//		else
//		{
		$result1 = $oVale->verifica_cliente('dni',$_POST['txt_dni']);
		$dato1 = mysql_num_rows($result1);
		
		$result2 = $oVale->verifica_cliente('correo',$_POST['txt_ema']);
		$dato2 = mysql_num_rows($result2);
		
		if($dato1==0)//no hay cliente con este dni
		{
			
			if($dato2==0)//no hay cliente con este correo
			{
				$oVale->insertar_cliente(trim($_POST['txt_nom']),$_POST['txt_dni'],trim($_POST['txt_ema']));
				
					$dts=$oVale->ultimoInsert();
					$dt = mysql_fetch_array($dts);
				$cli_id=$dt['last_insert_id()'];
					mysql_free_result($dts);
				
				$vale_id=1;
				$codigo_vale="01";
				
				$dts=$oVale->mostrar_max_codigo($vale_id);
					$dt = mysql_fetch_array($dts);
				$codigo=$dt['codigo']+1;
					mysql_free_result($dts);
				
				//$codigo=1010;
				$codigo2=$_POST['txt_dni'].$codigo_vale.str_pad($codigo, 4, "0", STR_PAD_LEFT);
				$estado=1;//1 emitido
				
				
				$oVale->insertar_vale($vale_id,$cli_id,$codigo,$codigo2,$estado);
				
				$vista=1;
				
				$aviso1=$_POST['txt_nom'].", DNI: ".$_POST['txt_dni'].".";
				
				//email
				//$aviso2 = "";
				if ($_POST['txt_ema']!="")
				{
					// email de destino
					$email = $_POST['txt_ema'];
					 
					// asunto del email
					$subject = "Vale de descuento | ".$url_web;
					 
					// Cuerpo del mensaje
					$mensaje = "Hola ".$_POST['txt_nom'].", gracias por registrarte.\n";
					$mensaje.= "                               \n";
					$mensaje.= "Tu vale de descuento se ha generado correctamente.\n";
					$mensaje.= "                               \n";
					$mensaje.= "Para completar el proceso, sigue este enlace: \n";
					$mensaje.= "------------------- \n";
					$mensaje.= "http://".$url_web."/app/modulos/vale/vale_impresion.php?code=".$codigo2."&t=confirm\n";
					$mensaje.= "------------------- \n";
					//$mensaje.= "Codigo de confirmacion: ".$cod."                        \n";
					$mensaje.= "                               \n";
					$mensaje.= "                               \n";
					$mensaje.= "Visita cualquiera de nuestras tiendas con el vale impreso o muestranos en tu smartphone.\n";
					$mensaje.= "Nuestras tiendas:\n";
					$mensaje.= "Av. Augusto. B. Leguia Nro. 1160 Jose Leonardo Ortiz.\n";
					$mensaje.= "Calle Virgilio Dallorso Nro. 175 - 179 Centro.\n";
					$mensaje.= "                               \n";
					$mensaje.= "Visita nuestra web: \n";
					$mensaje.= "---------------------------------- \n";
					$mensaje.= "http://".$url_web."\n";
					$mensaje.= "                               \n";
					$mensaje.= "                               \n";
					$mensaje.= "Si tienes alguna consulta escribir a: ".$email_soporte."\n";
					$mensaje.= "Gracias.\n";
					$mensaje.= "---------------------------------- \n";
					 
					
					// headers del email
					//email de respuesta
					$emailres=$email_respuesta;
					$headers = "From: ".$emailres."\r\n";
					 
					// Enviamos el mensaje
					if (mail($email, $subject, utf8_encode($mensaje), $headers)) {
						$aviso2 = "Mensaje enviado correctamente a: ".$_POST['txt_ema'];
					} else {
						$aviso2 = "Error de envío de mensaje.";
					}
					
					//Warning: mail() [function.mail]: Failed to connect to mailserver at "localhost" port 25, verify your "SMTP" and "smtp_port" setting in php.ini or use ini_set() in
				}
				//email

			}
			else
			{
					$aviso1="Existe registro con correo electrónico ".$_POST['txt_ema']."";
			}
		}
		else
		{
				$aviso1="Existe registro con DNI ".$_POST['txt_dni']."";
		}
		
		//echo $aviso1;
		//}//else
	}
	else{
		echo "No se pudo registar. Faltan Datos.";	
	}
}

?>
<div>
<br>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <?php if($dato1==0 and $dato2==0){?>
    <tr>
      <td class="_title2">Gracias por registrarse.</td>
    </tr>
    <tr>
      <td class="_title2"><?php echo $aviso1?></td>
    </tr>
  <?php }?>
  <?php if($dato1==1 or $dato2==1){?>
    <tr>
      <td class="_title2"><?php echo $aviso1?></td>
    </tr>
  <?php }?>
    <tr>
      <td class="_title2">Por favor accede a tu correo <?php echo $_POST['txt_ema']?> y revisa el enlace para imprimir tu vale.</td>
    </tr>
  </table>
</div>