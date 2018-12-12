<?php
class cAtributo{
	function insertar($nom,$idp, $cat){
	$sql = "INSERT tb_atributo (
		`tb_atributo_nom`,
		`tb_atributo_idp`,
		`tb_categoria_id`
		)
		VALUES (
		 '$nom',  '$idp', '$cat'
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
	$sql="SELECT * 
	FROM tb_atributo
	ORDER BY tb_atributo_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_categorias(){
	$sql="SELECT * 
	FROM tb_atributo a
	INNER JOIN tb_categoria c ON a.tb_categoria_id = c.tb_categoria_id
	GROUP BY c.tb_categoria_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_atr_idp(){
	$sql="SELECT * 
	FROM tb_atributo a
	INNER JOIN tb_categoria c ON a.tb_categoria_id = c.tb_categoria_id 
	WHERE tb_atributo_idp=0
	ORDER BY tb_categoria_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_categoria($cat_id){
	$sql="SELECT * 
	FROM tb_atributo a
	INNER JOIN tb_categoria c ON a.tb_categoria_id = c.tb_categoria_id 
	WHERE a.tb_categoria_id=$cat_id
	ORDER BY tb_categoria_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_idp($idp){
	$sql="SELECT * 
	FROM tb_atributo
	WHERE tb_atributo_idp=$idp
	ORDER BY tb_atributo_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_atributo
	WHERE tb_atributo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_atributo_valor($id){
	$sql="SELECT ap.tb_atributo_nom AS atributo, a.tb_atributo_nom AS valor, a.tb_atributo_id, a.tb_atributo_idp 
	FROM tb_atributo a
	INNER JOIN tb_atributo ap ON a.tb_atributo_idp=ap.tb_atributo_id
	WHERE a.tb_atributo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom,$idp, $cat){ 
	$sql = "UPDATE tb_atributo SET  
	`tb_atributo_nom` =  '$nom',
	`tb_atributo_idp` =  '$idp',
	`tb_categoria_id` =  '$cat'
	WHERE  tb_atributo_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_atributo_padre($idp){
		$sql = "SELECT * 
	FROM  `tb_atributo` 
	WHERE tb_atributo_idp =$idp";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function verifica_atributo_dupli($nom,$atr_idp,$cat_id){
		$sql = "SELECT * 
	FROM  tb_atributo 
	WHERE tb_atributo_nom LIKE '$nom' AND tb_atributo_idp='$atr_idp' AND tb_categoria_id='$cat_id'; ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function verifica_atributo_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_atributo_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_atributo WHERE tb_atributo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>