<?php
	function fechaActual($tipo){
	// Obtenemos y traducimos el nombre del día
		$dia=date("l");
		if ($dia=="Monday") $dia="Lunes";
		if ($dia=="Tuesday") $dia="Martes";
		if ($dia=="Wednesday") $dia=utf8_encode("Miércoles");
		if ($dia=="Thursday") $dia="Jueves";
		if ($dia=="Friday") $dia="Viernes";
		if ($dia=="Saturday") $dia=utf8_encode("Sábado");
		if ($dia=="Sunday") $dia="Domingo";
		
		// Obtenemos el número del día
		$dia2=date("d");
		
		// Obtenemos y traducimos el nombre del mes
		$mes=date("F");
		if ($mes=="January") $mes="Enero";
		if ($mes=="February") $mes="Febrero";
		if ($mes=="March") $mes="Marzo";
		if ($mes=="April") $mes="Abril";
		if ($mes=="May") $mes="Mayo";
		if ($mes=="June") $mes="Junio";
		if ($mes=="July") $mes="Julio";
		if ($mes=="August") $mes="Agosto";
		if ($mes=="September") $mes="Setiembre";
		if ($mes=="October") $mes="Octubre";
		if ($mes=="November") $mes="Noviembre";
		if ($mes=="December") $mes="Diciembre";
		
		// Obtenemos el año
		$ano=date("Y");
		
		switch ($tipo) {
			case 1:
				return $fecha="$dia, $dia2 de $mes del $ano";
				break;
			case 2:
				return $fecha="$dia2 de $mes del $ano";
				break;
		}
	}
	
	function mostrarFechaHora($fec){
		if(!empty($fec))
		{
			if($fec!='0000-00-00 00:00:00'){
				$fecha	=date('d-m-Y h:i:s a', strtotime($fec));
			}
			else
			{
				$fecha="";
			}
		}
		else
		{
			$fecha="";
		}
		
		return $fecha;
	}
	
	function mostrarFecha2($fec){
		if(!empty($fec))
		{
			if($fec!='0000-00-00 00:00:00'){
				$fecha	=date('d-m-Y', strtotime($fec));
			}
			else
			{
				$fecha="";
			}
		}
		else
		{
			$fecha="";
		}
		
		return $fecha;
	}
	
	function mostrarFecha($fec){
		if(!empty($fec))
		{
			if($fec!='0000-00-00'){
				$fecha	=date('d-m-Y', strtotime($fec));
			}
			else
			{
				$fecha="";
			}
		}
		else
		{
			$fecha="";
		}
		
		return $fecha;
	}
	
	function mostrarHora($hor){
		if(!empty($hor))
		{
			if($hor!='00:00:00'){
				$hora	=date('h:i a', strtotime($hor));
			}
			else
			{
				$hora="";
			}
		}
		else
		{
			$hora="";
		}
		
		return $hora;
	}
	
	function formato_hora($hor){
		if(!empty($hor))
		{
			if($hor!='00:00:00'){
				$hora	=date('H:i', strtotime($hor));
			}
			else
			{
				$hora="";
			}
		}
		else
		{
			$hora="";
		}
		
		return $hora;
	}
	
	function fecha_mysql($fec){
		if(!empty($fec))
		{
			$fecha=date('Y-m-d', strtotime($fec));
		}
		return $fecha;
	}
	

	function calcula_numero_dia_semana($dia,$mes,$ano){ 
		$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano)); 
		if ($numerodiasemana == 0) 
			 $numerodiasemana = 6; 
		else 
			 $numerodiasemana--; 
		return $numerodiasemana;	
	}
	
	function ultimoDia($mes,$ano){ 
		$ultimo_dia=28; 
		while (checkdate($mes,$ultimo_dia + 1,$ano)){ 
			 $ultimo_dia++; 
		} 
		return $ultimo_dia; 
		} 
	
	function nombre_mes($mes){ 
	 switch ($mes){ 
		 case 1: 
			 $nombre_mes="Enero"; 
			 break; 
		 case 2: 
			 $nombre_mes="Febrero"; 
			 break; 
		 case 3: 
			 $nombre_mes="Marzo"; 
			 break; 
		 case 4: 
			 $nombre_mes="Abril"; 
			 break; 
		 case 5: 
			 $nombre_mes="Mayo"; 
			 break; 
		 case 6: 
			 $nombre_mes="Junio"; 
			 break; 
		 case 7: 
			 $nombre_mes="Julio"; 
			 break; 
		 case 8: 
			 $nombre_mes="Agosto"; 
			 break; 
		 case 9: 
			 $nombre_mes="Septiembre"; 
			 break; 
		 case 10: 
			 $nombre_mes="Octubre"; 
			 break; 
		 case 11: 
			 $nombre_mes="Noviembre"; 
			 break; 
		 case 12: 
			 $nombre_mes="Diciembre"; 
			 break; 
	} 
	return $nombre_mes; 
	}
	
	function nombre_dia($fecha){
		//$fecha = "05-08-2004"; //5 agosto de 2004 por ejemplo  
		$fechats = strtotime($fecha); //a timestamp 
		//el parametro w en la funcion date indica que queremos el dia de la semana 
		//lo devuelve en numero 0 domingo, 1 lunes,.... 
		switch (date('w', $fechats)){ 
			case 0: $dia= "Domingo"; break; 
			case 1: $dia= "Lunes"; break; 
			case 2: $dia= "Martes"; break; 
			case 3: $dia= "Miercoles"; break; 
			case 4: $dia= "Jueves"; break; 
			case 5: $dia= "Viernes"; break; 
			case 6: $dia= "Sabado"; break; 
		}
	return $dia;
	}
	
	function restaFechas($dFecIni, $dFecFin)
	{
		$dFecIni = str_replace("-","",$dFecIni);
		$dFecIni = str_replace("/","",$dFecIni);
		$dFecFin = str_replace("-","",$dFecFin);
		$dFecFin = str_replace("/","",$dFecFin);
	 
		ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
		ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);
	 
		$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
		$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);
	 
		return round(($date2 - $date1) / (60 * 60 * 24));
	}
	
	function formato_moneda($monto){
		$dato=number_format($monto, 2, '.', '');
		return $dato;
	}
	function formato_money($monto){
		$dato=number_format($monto, 2);
		return $dato;
	}
	function formato_decimal($monto,$decimales){
		$dato=number_format($monto, $decimales, '.', '');
		return $dato;
	}

	function moneda_mysql($monto){
		$dato=str_replace(",","",$monto);
		return $dato;
	}
	function edad($fecha_nac){
		if(!empty($fecha_nac))
		{
			if($fecha_nac!='0000-00-00'){
				$dia=date("j");
				$mes=date("n");
				$anno=date("Y");
			
				//descomponer fecha de nacimiento
				/*$dia_nac=substr($fecha_nac, 8, 2);
				$mes_nac=substr($fecha_nac, 5, 2);
				$anno_nac=substr($fecha_nac, 0, 4);*/
				
				$dia_nac=date('d', strtotime($fecha_nac));
				$mes_nac=date('m', strtotime($fecha_nac));
				$anno_nac=date('Y', strtotime($fecha_nac));
			
				if($mes_nac>$mes){
					$calc_edad= $anno-$anno_nac-1;
				}else{
					if($mes==$mes_nac and $dia_nac>$dia){
						$calc_edad= $anno-$anno_nac-1;  
					}else{
						$calc_edad= $anno-$anno_nac;
					}
				}
			//
				//$fecha	=date('d-m-Y h:i:s a', strtotime($fec));
			}
			else
			{
				$calc_edad="";
			}
		}
		else
		{
			$calc_edad="";
		}
			
		return $calc_edad;
	}
	
	function numero_3cifras($num){
		if ($num<=9) $numero='00'.$num;
		elseif ($num<=99) $numero="0".$num;
		elseif ($num>99) $numero=$num;
		
		return $numero;
	}
	
	function mostrar_espacio($text){
		if($text!="") {
			$texto=$text;
		}
		else
		{
			$texto='&nbsp;';
		}
		return $texto;
	}
	function mostrar_siigual($texto_entrada,$condicion,$texto_salida){
		if($texto_entrada=="$condicion") {
			$ret=$texto_salida;
		}
		else
		{
			$ret='&nbsp;';
		}
		return $ret;
	}
	
	function GeneraPassword($longitud)
    {
		if(!is_numeric($longitud) || $longitud <= 0)
		{
			$longitud = 8;
		}
		if($longitud > 32)
		{
			$longitud = 32;
		}
	 
		//$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+-/*%&_';
		$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	 
		mt_srand(microtime() * 1000000);
	 
		for($i = 0; $i < $longitud; $i++)
		{
			$key = mt_rand(0,strlen($caracteres)-1);
			$password = $password . $caracteres{$key};
		}
 
    	return $password;
    }
	
?>