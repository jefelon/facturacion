<?php
class cVehiculo{
	function insertar($placa, $con_id,$mar,$mod,$num_asi,$pis){
	$sql = "INSERT tb_vehiculo (
		`tb_vehiculo_placa`,
		`tb_conductor_id`,
		`tb_vehiculo_marca`,
		`tb_vehiculo_modelo`,
		`tb_vehiculo_numasi`,
		`tb_vehiculo_pisos`
		)
		VALUES (
		 '$placa',
		 '$con_id',
		 '$mar',
		 '$mod',
		 '$num_asi',
		 '$pis'
		);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function ultimoInsert(){
	$sql = "SELECT last_insert_id()"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT v.tb_vehiculo_id,v.tb_vehiculo_placa,v.tb_conductor_id,v.tb_vehiculo_marca,v.tb_vehiculo_modelo,v.tb_vehiculo_numasi,v.tb_vehiculo_pisos, c.tb_conductor_id,c.tb_conductor_nom
	FROM tb_vehiculo v
    LEFT JOIN tb_conductor c ON v.tb_conductor_id=c.tb_conductor_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_vehiculo
	WHERE tb_vehiculo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$placa, $con_id,$mar,$mod,$num_asi,$pis){
	$sql = "UPDATE tb_vehiculo SET  
	`tb_vehiculo_placa` =  '$placa',
	`tb_conductor_id` =  '$con_id',
	`tb_vehiculo_marca` =  '$mar',
	`tb_vehiculo_modelo` =  '$mod',
	`tb_vehiculo_numasi` =  '$num_asi',
	`tb_vehiculo_pisos` =  '$pis'
	
	WHERE  tb_vehiculo_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_vehiculo_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_vehiculo_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_vehiculo WHERE tb_vehiculo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>