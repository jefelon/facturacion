<?php
class cPuntoventa{
	function insertar($nom,$alm_id,$emp_id,$dir){
	$sql = "INSERT tb_puntoventa (
		`tb_puntoventa_nom`,
		`tb_almacen_id`,
		`tb_empresa_id`,
		`tb_puntoventa_direccion`
		)
		VALUES (
		 '$nom', '$alm_id', '$emp_id', '$dir'
		);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * 
	FROM tb_puntoventa pv
	INNER JOIN tb_almacen a ON pv.tb_almacen_id=a.tb_almacen_id
	ORDER BY tb_puntoventa_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro($emp_id){
	$sql="SELECT * 
	FROM tb_puntoventa pv
	INNER JOIN tb_almacen a ON pv.tb_almacen_id=a.tb_almacen_id
	WHERE pv.tb_empresa_id=$emp_id
	ORDER BY tb_puntoventa_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro_punven($emp_id,$punven_id){
	$sql="SELECT * 
	FROM tb_puntoventa pv
	INNER JOIN tb_almacen a ON pv.tb_almacen_id=a.tb_almacen_id
	WHERE pv.tb_empresa_id=$emp_id ";
	if($punven_id>0)$sql.=" AND pv.tb_puntoventa_id = $punven_id ";
	$sql.=" ORDER BY tb_puntoventa_nom ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_presentacion(){
	$sql="SELECT * 
	FROM tb_puntoventa
	ORDER BY tb_puntoventa_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_puntoventa
	WHERE tb_puntoventa_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom,$alm_id,$emp_id,$dir){
	$sql = "UPDATE tb_puntoventa SET  
	`tb_puntoventa_nom` =  '$nom',
	`tb_almacen_id` =  '$alm_id',
	`tb_empresa_id` =  '$emp_id',
	`tb_puntoventa_direccion` =  '$dir'
	WHERE  tb_puntoventa_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_puntoventa_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_puntoventa_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_puntoventa WHERE tb_puntoventa_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	//usuario punto de venta
	function insertar_usuariopv($usu_id,$punven_id){
	$sql = "INSERT INTO  tb_usuariopv(
	`tb_usuario_id` ,
	`tb_puntoventa_id`
	)
	VALUES (
	'$usu_id',  '$punven_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrar_puntoventa_por_usuario($usu_id,$punven_id){
	$sql="SELECT * 
	FROM tb_usuariopv u
	INNER JOIN tb_puntoventa pv ON u.tb_puntoventa_id=pv.tb_puntoventa_id
	INNER JOIN tb_empresa e ON pv.tb_empresa_id = e.tb_empresa_id
	WHERE u.tb_usuario_id= $usu_id ";
	
	if($punven_id>0)$sql.=" AND u.tb_puntoventa_id = $punven_id";
	
	$sql.="	ORDER BY e.tb_empresa_razsoc, pv.tb_puntoventa_nom ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar_usuariopv($id){
	$sql="DELETE FROM tb_usuariopv WHERE tb_usuariopv_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>