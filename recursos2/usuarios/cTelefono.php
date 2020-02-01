<?php
class cTelefono{
	function insertar($tip,$ope,$num, $usu){
	$sql = "INSERT INTO tb_telefono(
	`tb_telefono_tip`,
	`tb_telefono_ope`,
	`tb_telefono_num`,
	`tb_usuario_id`
	)
	VALUES (
	'$tip', '$ope', '$num', '$usu'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos_usuario($id){
	$sql="SELECT * 
	FROM  tb_usuario u
	INNER JOIN tb_telefono t ON u.tb_usuario_id=t.tb_usuario_id
	WHERE u.tb_usuario_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_telefono 
	WHERE tb_telefono_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$tip,$ope,$num){
	$sql = "UPDATE  tb_telefono	SET
	`tb_telefono_tip` =  '$tip',
	`tb_telefono_ope` =  '$ope',
	`tb_telefono_num` =  '$num'
	WHERE tb_telefono_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verificaE($id){
		$sql = "SELECT * 
FROM  `tb_usosoftware` 
WHERE tb_software_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_telefono WHERE tb_telefono_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar_por_usuario($id){
	$sql="DELETE FROM tb_telefono WHERE tb_usuario_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>