<?php
class cPrecio{
	function insertar($nom){
	$sql = "INSERT tb_precio (
		`tb_precio_nom`
		)
		VALUES (
		 '$nom'
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
	FROM tb_precio WHERE tb_precio_id  NOT IN (1,2,3)
	ORDER BY tb_precio_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrar_filtro_cliente($cli_id){
        $sql="SELECT *
	FROM tb_precio p
	INNER JOIN  tb_cliente c on p.tb_precio_id=c.tb_precio_id 
	WHERE p.tb_precio_id  NOT IN (1,2,3)";

	if($cli_id!="")$sql.=" AND c.tb_cliente_id=$cli_id ";

	$sql.=" ORDER BY tb_precio_nom";

	print $sql;
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_precio
	WHERE tb_precio_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom){ 
	$sql = "UPDATE tb_precio SET  
	`tb_precio_nom` =  '$nom'
	WHERE  tb_precio_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_precio_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_precio_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_precio WHERE tb_precio_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>