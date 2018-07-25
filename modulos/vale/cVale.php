<?php
class cVale{	
	function insertar_cliente($nombre,$dni,$correo){
	$sql = "INSERT INTO va_cliente(
		`nombre` ,
		`dni` ,
		`correo`
		)
		VALUES (
		'$nombre',  '$dni',  '$correo'
		);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function ultimoInsert(){
	$sql = "SELECT last_insert_id();"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function insertar_vale($vale_id,$cliente_id,$codigo,$codigo2,$estado){
	$sql = "INSERT INTO va_detalle(
	`vale_id` ,
	`cliente_id` ,
	`codigo` ,
	`codigo2` ,
	`fecha` ,
	`estado`
	)
	VALUES (
	'$vale_id',  '$cliente_id',  '$codigo', '$codigo2', NOW( ) ,  '$estado'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_cliente($atributo,$dato){
	$sql = "SELECT * 
		FROM  va_cliente 
		WHERE $atributo LIKE '$dato';";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_vale($codigo2){
	$sql="SELECT * 
	FROM  va_cliente c
	INNER JOIN va_detalle d ON c.cliente_id = d.cliente_id
	INNER JOIN va_vale v ON d.vale_id = v.vale_id	
	WHERE d.codigo2 =$codigo2;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function mostrar_max_codigo($vale_id){
	$sql="SELECT MAX(d.codigo) as codigo
	FROM  va_vale v
	INNER JOIN va_detalle d ON v.vale_id = d.vale_id	
	WHERE v.vale_id =$vale_id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	//eliminar		
	function eliminar($id){
	$sql="delete from tb_usuario where tb_usuario_id=$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
		
//mostrar		
	function acceso($use,$pas){
	$sql="SELECT * FROM tb_usuario WHERE tb_usuario_use='$use' AND tb_usuario_pas=MD5('$pas');";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function registroAcceso($id){
	$sql="SELECT * 
		FROM tb_usuario u
		INNER JOIN tb_usuariogrupo g ON u.tb_usuariogrupo_id=g.tb_usuariogrupo_id
		INNER JOIN tb_empresa e ON u.tb_empresa_id=e.tb_empresa_id
		WHERE tb_usuario_id=$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verificaUsuario($use){
	$sql="SELECT * FROM tb_usuario WHERE tb_usuario_use='$use';";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verificaClave($id,$pas){
	$sql="SELECT * FROM tb_usuario WHERE tb_usuario_id='$id' AND tb_usuario_pas=MD5('$pas');";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verificar_restabclave($ema,$cod){
	$sql="SELECT * FROM tb_restabclave WHERE tb_restabclave_ema='$ema' AND tb_restabclave_cod='$cod';";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_usuario_con_email($ema){
	$sql="SELECT * 
	FROM tb_usuario 
	WHERE tb_usuario_ema='$ema';";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	

	function modificar_nombreusuario($id,$use){
	$sql="UPDATE tb_usuario SET  `tb_usuario_use` = '$use' 
	WHERE tb_usuario_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function mostrarTodos(){
	$sql="SELECT * 
		FROM tb_usuario;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	
	function complete_nom($dato,$usugru){
	$sql="SELECT CONCAT(tb_usuario_apepat,' ',tb_usuario_apemat,' ',tb_usuario_nom)AS nombre 
		FROM tb_usuario u
		INNER JOIN tb_usuariogrupo ug ON u.tb_usuariogrupo_id=ug.tb_usuariogrupo_id ";
	
	if($usugru!="")$sql.=" WHERE ug.tb_usuariogrupo_nom LIKE '$usugru' ";
	
	$sql.=" HAVING nombre LIKE '%$dato%'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
}
?>