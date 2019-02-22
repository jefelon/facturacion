<?php
class cUsuariodetalle{	

	function insertar($use){
	$sql = "INSERT INTO tb_usuariodetalle(
		`tb_usuario_id`
		)
		VALUES (
		'$use'
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
	
	function mostrarUno($id){
	$sql="SELECT * 
	FROM  `tb_usuariodetalle` 
	WHERE tb_usuario_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	//eliminar		
	function eliminar($id){
	$sql="delete from tb_usuariodetalle where tb_usuario_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
		
//modificar		
	function modificar_sup($id,$dni){
	$sql="UPDATE tb_usuariodetalle SET
`tb_usuario_dni` =  '$dni'
WHERE tb_usuario_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function modificar_vendedor($id,$dni,$punven_id,$hor_id){
	$sql="UPDATE tb_usuariodetalle SET
	`tb_usuario_dni` =  '$dni',
	`tb_puntoventa_id` =  '$punven_id',
	`tb_horario_id` =  '$hor_id'
	WHERE tb_usuario_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function modificar_datos($id,$dni){
	$sql="UPDATE tb_usuariodetalle SET
`tb_usuario_dni` =  '$dni'
WHERE tb_usuario_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function modificar_2($id,$dni,$con,$fun,$are){
	$sql="UPDATE tb_usuariodetalle SET
	`tb_usuario_dni` =  '$dni',
	`tb_usuario_con` =  '$con',
	`tb_funcion_id` =  '$fun',
	`tb_area_id` =  '$are'
	WHERE tb_usuario_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function modificar_curvit($id,$curvit){
	$sql="UPDATE tb_usuariodetalle SET
`tb_usuario_curvit` =  '$curvit'
WHERE tb_usuario_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
}
?>