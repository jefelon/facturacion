<?php
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
	
	function mostrarFechaHoraH($fec){
		if(!empty($fec))
		{
			if($fec!='0000-00-00 00:00:00'){
				$fecha	=date('d-m-Y H:i:s', strtotime($fec));
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
			if($hor!='NULL'){
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
	
	function mostrarHora_fh($fec){
		if(!empty($fec))
		{
			if($fec!='0000-00-00 00:00:00'){
				$fecha	=date('h:i:s a', strtotime($fec));
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
	
	function formato_hora($hor){
		if(!empty($hor))
		{
			if($hor!='NULL'){
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
	
	function hora_mysql($hor){
		if(!empty($hor) and $hor!="")
		{
			$hora=$hor;
		}
		else
		{
			$hora="NULL";
		}
		return $hora;
	}
	
	function fecha_mysql($fec){
		if(!empty($fec))
		{
			$fecha=date('Y-m-d', strtotime($fec));
		}
		else
		{
			$fecha="";
		}
		return $fecha;
	}
	
	function fechahora_mysql($fechor){
		
		if(!empty($fechor))
		{
			//$fec=substr($fechor,0,10);
			//$hora=substr($fechor,-8);
			
			$fechahora=date('Y-m-d H:i:s', strtotime($fechor));
			
			//$fechahora=$fecha.' '.$hora;
		}
		else
		{
			$fechahora="";
		}
		return $fechahora;
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
		if($monto!="")
		{
			$dato=str_replace(",","",$monto);
		}
		else
		{
			$dato="";
		}
		return $dato;
	}
	
	function mostrar_blanco($text){
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
	function limpia_espacios($cadena){
		$cadena=trim($cadena);
		$cadena = ereg_replace( "([  ]+)", " ", $cadena );
		$cadena = str_replace('  ', ' ', $cadena);

		return $cadena;
	}
?>