<?php
class cDocumento{
	function insertar($xac,$abr,$nom, $tip,$def){
	$sql = "INSERT tb_documento (
		`tb_documento_xac`,
		`tb_documento_abr`,
		`tb_documento_nom`,
		`tb_documento_tip`,
		`tb_documento_def`
		)
		VALUES (
		 '$xac','$abr', '$nom', '$tip', '$def'
		);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * 
	FROM tb_documento
	ORDER BY tb_documento_tip, tb_documento_abr";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_tipo(){
	$sql="SELECT * 
	FROM tb_documento
	GROUP BY tb_documento_tip";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_tipo($tip,$mos){
	$sql="SELECT * 
	FROM tb_documento 
	WHERE tb_documento_xac=1";
	if($tip>0)$sql.=" AND tb_documento_tip=$tip ";
	if($mos>0)$sql.=" AND tb_documento_mos=$mos ";
	
	$sql.=" ORDER BY tb_documento_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrar_por_tipo_cot($tip,$tip_cot,$mos){
        $sql="SELECT * 
	FROM tb_documento 
	WHERE tb_documento_xac=1";
        if($tip>0)$sql.=" AND tb_documento_tip=$tip ";
        if($tip_cot>0)$sql.="OR tb_documento_tip=$tip_cot ";
        if($mos>0)$sql.=" AND tb_documento_mos=$mos ";
        $sql.=" ORDER BY tb_documento_id ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_documento d 
	LEFT JOIN cs_tipodocumento td ON d.cs_tipodocumento_id=td.cs_tipodocumento_id
	WHERE tb_documento_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$abr,$nom,$tip,$def,$mos){ 
	$sql = "UPDATE tb_documento SET  
	`tb_documento_abr` =  '$abr',
	`tb_documento_nom` =  '$nom',
	`tb_documento_tip` =  '$tip',
	`tb_documento_def` =  '$def',
	`tb_documento_mos` =  '$mos'
	WHERE  tb_documento_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_documento_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_documento_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_documento WHERE tb_documento_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>