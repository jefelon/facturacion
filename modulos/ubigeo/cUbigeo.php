<?php
class cUbigeo{
	function insertar($coddep,$codpro,$coddis,$nom,$tip){
	$sql = "INSERT INTO tb_ubigeo(
	`tb_ubigeo_coddep`,
	`tb_ubigeo_codpro`,
	`tb_ubigeo_coddis`,
	`tb_ubigeo_nom`,
	`tb_ubigeo_tip`
	)
	VALUES (
	'$coddep','$codpro','$coddis', '$nom', '$tip'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT *
	FROM tb_ubigeo
	ORDER BY tb_ubigeo_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarCombo($tip,$coddep,$codpro){
	$sql="SELECT *
	FROM tb_ubigeo
	WHERE tb_ubigeo_tip='$tip' ";
		if($coddep!='00')$sql.=" AND tb_ubigeo_coddep=$coddep ";
		if($codpro!='00')$sql.=" AND tb_ubigeo_codpro=$codpro "; 
	$sql.=" ORDER BY tb_ubigeo_nom ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUbigeo($ubigeo){
		 $coddep=substr($ubigeo, 0, 2);
		 $codpro=substr($ubigeo, 2, 2);
		 $coddis=substr($ubigeo, 4, 2);
	$sql="SELECT u3.tb_ubigeo_coddep, u3.tb_ubigeo_nom AS Departamento, u2.tb_ubigeo_codpro, u2.tb_ubigeo_nom AS Provincia, u1.tb_ubigeo_coddis, u1.tb_ubigeo_nom AS Distrito
FROM tb_ubigeo u1
INNER JOIN tb_ubigeo u2 ON 
u1.tb_ubigeo_coddep=u2.tb_ubigeo_coddep AND u1.tb_ubigeo_codpro=u2.tb_ubigeo_codpro AND
u2.tb_ubigeo_coddis='00'
INNER JOIN tb_ubigeo u3 ON
u2.tb_ubigeo_coddep=u3.tb_ubigeo_coddep AND
u3.tb_ubigeo_codpro = '00' AND
u3.tb_ubigeo_coddis = '00'
WHERE u1.tb_ubigeo_coddis ='$coddis'
AND u1.tb_ubigeo_codpro='$codpro'
AND u1.tb_ubigeo_coddep='$coddep' ;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_ubigeo 
	WHERE tb_ubigeo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$coddep,$codpro,$coddis,$nom,$tip){
	$sql = "UPDATE  tb_ubigeo	SET
	`tb_ubigeo_coddep` =  '$coddep',
	`tb_ubigeo_codpro` =  '$codpro',
	`tb_ubigeo_coddis` =  '$coddis',
	`tb_ubigeo_nom` =  '$nom',
	`tb_ubigeo_tip` =  '$tip'
	WHERE tb_ubigeo_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_codigo($coddep,$codpro,$coddis){
		$sql = "SELECT * 
	FROM  tb_ubigeo 
	WHERE tb_ubigeo_coddep = '$coddep' AND tb_ubigeo_codpro='$codpro' AND tb_ubigeo_coddis =  '$coddis' ;";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_ubigeo WHERE tb_ubigeo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>