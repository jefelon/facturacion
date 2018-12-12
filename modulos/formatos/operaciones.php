<?php
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
?>