<?php

class Cado{
	var $Servidor;
	var $Usuario;
	var $Clave;
	var $BaseDatos;
	
	var $conexion;
	var $rsql;

	function Cado(){
		  $this->Servidor = 'ns1.ssdhosting.com.pe'; $this->Usuario = 'yfmhytrg_userfactura'; $this->Clave = 'eM=!hvSN(aLR'; 
		  
		  //$this->Servidor = 'localhost'; $this->Usuario = ''; $this->Clave = '';
		  $this->BaseDatos ="yfmhytrg_dbfactura";
	}
	
	function conectar()
	{
		$conexion=mysql_connect($this->Servidor,$this->Usuario,$this->Clave);
		if(!$conexion)
		{
			echo"Error al Conectar a la Base de Datos.";      
            exit();
		}
		
		$bdatos=mysql_select_db($this->BaseDatos,$conexion);
		if(!$bdatos)
		{
			echo"Error al Seleccionar la Base de Datos.";      
            exit();
		}
		
		return $conexion;
	}
	
	function cerrar_conexion($conexion)
	{
  		mysql_close($conexion);
	}
	
	function ejecute_sql($sql)
	{
		$rsql=mysql_query($sql,$this->conectar()) or die (
			'MySQL Error: ' . mysql_error()
			//"No se obtuvo ningún resultado o intentelo más tarde."
		);
		if(!$rsql)
		{
  			echo 'MySQL Error: ' . mysql_error();
	    	exit;
		}
		return $rsql;
	}
	
	function obtener_resultados($resultado)
	{
  		return mysql_fetch_array($resultado, MYSQL_ASSOC);
	}
}
?>