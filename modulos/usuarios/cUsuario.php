<?php
class cUsuario{	

	function nuevo_registro($usugru,$emp){
	$sql = "INSERT INTO tb_usuario(
		`tb_usuario_reg` ,
		`tb_usuario_mod` ,
		`tb_usuariogrupo_id`,
		`tb_empresa_id`
		)
		VALUES (
		NOW( ), NOW( ),  '$usugru',  '$emp'
		);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	
	function insertar($use,$pas,$apepat,$apemat,$nom,$ema,$usugru,$emp){
	$sql = "INSERT INTO tb_usuario(
		`tb_usuario_use` ,
		`tb_usuario_pas` ,
		`tb_usuario_apepat` ,
		`tb_usuario_apemat` ,
		`tb_usuario_nom` ,
		`tb_usuario_ema` ,
		`tb_usuario_reg` ,
		`tb_usuario_mod` ,
		`tb_usuariogrupo_id`,
		`tb_empresa_id`
		)
		VALUES (
		'$use', MD5('$pas'),  '$apepat',  '$apemat',  '$nom',  '$ema', NOW( ), NOW( ),  '$usugru',  '$emp'
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
	
	function mostrarUno($id){
	$sql="SELECT * 
	FROM  tb_usuario u
	INNER JOIN tb_usuariogrupo ug ON u.tb_usuariogrupo_id = ug.tb_usuariogrupo_id	
	WHERE tb_usuario_id =$id;";
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
	if(preg_match("/^[0-9a-zA-Z@.]+$/",$use))
	{
		$use=$use;
	}
	else
	{
		$use="?invalido?";
	}
	//$use=mysql_real_escape_string($use);
	$sql="SELECT * FROM tb_usuario WHERE tb_usuario_use='$use' AND tb_usuario_pas=MD5('$pas');";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function registroAcceso($id){
	$sql="SELECT * FROM tb_usuario u
		INNER JOIN tb_usuariogrupo g ON u.tb_usuariogrupo_id=g.tb_usuariogrupo_id
		INNER JOIN tb_empresa e ON u.tb_empresa_id=e.tb_empresa_id
		WHERE u.tb_usuario_id=$id;";
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
	
	//restableciemiento de clave
	function insertar_restabclave($ema,$cod,$est,$usu_id){
	$sql = "INSERT INTO tb_restabclave (
	`tb_restabclave_ema`,
	`tb_restabclave_cod`, 
	`tb_restabclave_est`, 
	`tb_usuario_id`
	) VALUES (
	'$ema', '$cod', '$est', '$usu_id');"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar_restabclave($id,$est){
	$sql = "UPDATE tb_restabclave SET  
	`tb_restabclave_est` =  '$est' 
	WHERE tb_restabclave_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
		
//modificar		
	function modificar_clave($id,$pas){
	$sql="UPDATE tb_usuario SET  `tb_usuario_pas` = MD5('$pas') WHERE tb_usuario_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function modificar_sup($id,$apepat,$apemat,$nom,$ema,$usugru,$emp){
	$sql="UPDATE tb_usuario SET
	`tb_usuario_mod` = NOW( ) ,
	`tb_usuario_apepat` =  '$apepat',
	`tb_usuario_apemat` =  '$apemat',
	`tb_usuario_nom` =  '$nom',
	`tb_usuario_ema` =  '$ema',
	`tb_usuariogrupo_id` =  '$usugru',
	`tb_empresa_id` =  '$emp' 
	WHERE tb_usuario_id=$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function modificar_usu_ven($id,$apepat,$apemat,$nom,$ema,$usugru,$emp){
	$sql="UPDATE tb_usuario SET
	`tb_usuario_mod` = NOW( ) ,
	`tb_usuario_apepat` =  '$apepat',
	`tb_usuario_apemat` =  '$apemat',
	`tb_usuario_nom` =  '$nom',
	`tb_usuario_ema` =  '$ema',
	`tb_usuariogrupo_id` =  '$usugru',
	`tb_empresa_id` =  '$emp' 
	WHERE tb_usuario_id=$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function modificar_datos($id,$apepat,$apemat,$nom,$ema){
	$sql="UPDATE tb_usuario SET
	`tb_usuario_mod` = NOW( ) ,
	`tb_usuario_apepat` =  '$apepat',
	`tb_usuario_apemat` =  '$apemat',
	`tb_usuario_nom` =  '$nom',
	`tb_usuario_ema` =  '$ema' 
	WHERE tb_usuario_id=$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function modificarUltimaVisita($id){
	$sql="UPDATE tb_usuario SET
`tb_usuario_ultvis` =  NOW( ) 
WHERE tb_usuario_id=$id;";
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
	function mostrarTodos_usugru($usugru,$bus){
	$sql="SELECT * 
		FROM tb_usuario u
		INNER JOIN tb_usuariogrupo ug ON u.tb_usuariogrupo_id=ug.tb_usuariogrupo_id
		WHERE ug.tb_usuariogrupo_nom LIKE '$usugru' ";
		
	if($bus!="")$sql.=" HAVING CONCAT(tb_usuario_apepat,' ',tb_usuario_apemat,' ',tb_usuario_nom) LIKE '%$bus%' ";
	
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function mostrar_vendedor($usugru,$bus,$punven_id,$emp_id){
	$sql="SELECT * 
	FROM tb_usuario u
	INNER JOIN tb_usuariodetalle ud ON u.tb_usuario_id=ud.tb_usuario_id
	INNER JOIN tb_usuariogrupo ug ON u.tb_usuariogrupo_id=ug.tb_usuariogrupo_id
	LEFT JOIN tb_puntoventa pv ON ud.tb_puntoventa_id=pv.tb_puntoventa_id
	LEFT JOIN tb_horario h ON ud.tb_horario_id=h.tb_horario_id
		WHERE u.tb_empresa_id = $emp_id
		AND ug.tb_usuariogrupo_nom LIKE '$usugru' ";
		
	if($bus!="")$sql.=" HAVING CONCAT(tb_usuario_apepat,' ',tb_usuario_apemat,' ',tb_usuario_nom) LIKE '%$bus%' ";
	if($punven_id>0)$sql.=" AND ud.tb_puntoventa_id=$punven_id ";
	
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function mostrar_por_usugru($usugru){
	$sql="SELECT * 
		FROM tb_usuario u
		INNER JOIN tb_usuariogrupo ug ON u.tb_usuariogrupo_id=ug.tb_usuariogrupo_id
		WHERE ug.tb_usuariogrupo_id IN ($usugru) 
		ORDER BY tb_usuario_apepat, tb_usuario_apemat, tb_usuario_nom;";
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
	function mostrarGrupo_emp($gru,$emp){
	$sql="SELECT * 
FROM  tb_usuario
WHERE tb_usuariogrupo_id=$gru AND tb_empresa_id=$emp
ORDER BY tb_usuario_apepat, tb_usuario_apemat, tb_usuario_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function filtro1($usugru, $dato){
	$sql="SELECT u.tb_usuario_id, tb_usuario_apepat, tb_usuario_apemat, tb_usuario_nom, tb_usuario_dni, CONCAT(tb_usuario_apepat,' ',tb_usuario_apemat,' ',tb_usuario_nom,' ',tb_usuario_dni) AS nombre 
		FROM tb_usuario u
		INNER JOIN tb_usuariogrupo ug ON u.tb_usuariogrupo_id=ug.tb_usuariogrupo_id
		INNER JOIN tb_usuariodetalle ud ON u.tb_usuario_id=ud.tb_usuario_id
		WHERE tb_usuariogrupo_nom = '$usugru'
		HAVING nombre LIKE '%$dato%'
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function verifica_usuario_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_usuario_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>