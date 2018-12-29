<?php
session_start();
class cCategoria{
	function insertar($nom,$idp){
	$sql = "INSERT tb_categoria (
		`tb_categoria_nom` ,
		`tb_categoria_idp`,
		`tb_empresa_id`
		)
		VALUES (
		 '$nom',  '$idp' ,'{$_SESSION['empresa_id']}'
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
	FROM tb_categoria
	WHERE tb_empresa_id={$_SESSION['empresa_id']}
	ORDER BY tb_categoria_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrar_filtro_nombre($nom){
        $sql="SELECT * 
	    FROM tb_categoria
	    WHERE tb_categoria_nom='$nom' AND tb_empresa_id={$_SESSION['empresa_id']}";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function mostrar_cat_idp(){
	$sql="SELECT * 
	FROM tb_categoria
	WHERE tb_categoria_idp=0 AND tb_empresa_id={$_SESSION['empresa_id']}
	ORDER BY tb_categoria_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_idp($idp){
	$sql="SELECT * 
          FROM tb_categoria
          WHERE tb_categoria_idp=$idp AND tb_empresa_id={$_SESSION['empresa_id']}
          ORDER BY tb_categoria_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	      FROM tb_categoria
	      WHERE tb_categoria_id=$id AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom,$idp){ 
	$sql = "UPDATE tb_categoria SET  
	       `tb_categoria_nom` =  '$nom',
	       `tb_categoria_idp` =  '$idp'
	       WHERE  tb_categoria_id =$id AND tb_empresa_id={$_SESSION['empresa_id']};";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_categoria_padre($idp){
		$sql = "SELECT * 
	            FROM  `tb_categoria` 
	            WHERE tb_categoria_idp =$idp AND tb_empresa_id={$_SESSION['empresa_id']}";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function verifica_categoria_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_categoria_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_categoria WHERE tb_categoria_id=$id AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>