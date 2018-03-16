<?php
class cGuiapago{
	function insertar($xac,$usureg,$usumod,$guipagtip_id,$cli_id,$per_id,$eje_id,$fecven,$fecpag,$des,
		$pag,$codtri,$imppag,$codtriaso,$numdoc,
		$numrucarr,$tipdocinq,$numdocinq,$monalq,$arrrec,$numordope,$imppagser,$arrimppag,
		$toting,$cat,$moncom,$rusimppag,$privez,$compag,
		$imppagbas,$numdia,$tas,$int,$monact,
		$envcor,$est){
		$sql="INSERT INTO tb_guiapago(
		`tb_guiapago_xac` ,
		`tb_guiapago_fecreg` ,
		`tb_guiapago_fecmod` ,
		`tb_guiapago_usureg` ,
		`tb_guiapago_usumod` ,
		`tb_guiapagotipo_id` ,
		`tb_cliente_id` ,
		`tb_periodo_id` ,
		`tb_ejercicio_id` ,
		`tb_guiapago_fecven` ,
		`tb_guiapago_fecpag` ,
		`tb_guiapago_des` ,
		`tb_guiapago_pag` ,
		`tb_guiapago_codtri` ,
		`tb_guiapago_imppag` ,
		`tb_guiapago_codtriaso` ,
		`tb_guiapago_numdoc` ,
		`tb_guiapago_numrucarr` ,
		`tb_guiapago_tipdocinq` ,
		`tb_guiapago_numdocinq` ,
		`tb_guiapago_monalq` ,
		`tb_guiapago_arrrec` ,
		`tb_guiapago_numordope` ,
		`tb_guiapago_imppagser` ,
		`tb_guiapago_arrimppag` ,
		`tb_guiapago_toting` ,
		`tb_guiapago_cat` ,
		`tb_guiapago_moncom` ,
		`tb_guiapago_rusimppag` ,
		`tb_guiapago_privez` ,
		`tb_guiapago_compag` ,
		`tb_guiapago_imppagbas` ,
		`tb_guiapago_numdia` ,
		`tb_guiapago_tas` ,
		`tb_guiapago_int` ,
		`tb_guiapago_monact` ,
		`tb_guiapago_envcor` ,
		`tb_guiapago_est`
		)
		VALUES (
		'$xac', NOW( ) , NOW( ) ,  '$usureg',  '$usumod',  '$guipagtip_id',  '$cli_id',  '$per_id',  '$eje_id',  '$fecven',  '$fecpag', '$des',
		'$pag',  '$codtri',  '$imppag',  '$codtriaso',  '$numdoc',  
		'$numrucarr', '$tipdocinq',  '$numdocinq',  '$monalq',  '$arrrec',  '$numordope', '$imppagser', '$arrimppag',  
		'$toting',  '$cat',  '$moncom',  '$rusimppag',  '$privez',  '$compag',
		'$imppagbas',  '$numdia',  '$tas',  '$int',  '$monact',
		'$envcor',  '$est'
		);";
				
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}

	function complete_des($des){
		$sql="SELECT DISTINCT(tb_guiapago_des) FROM tb_guiapago
		WHERE tb_guiapago_des like '%$des%'
		ORDER BY tb_guiapago_des
		LIMIT 0 , 10";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function mostrarUno($id){
		$sql="SELECT * 
		FROM tb_guiapago
		WHERE tb_guiapago_id=$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function modificar_campo($id,$usumod,$campo,$valor){
		$sql = "UPDATE tb_guiapago SET
		`tb_guiapago_fecmod` = NOW( ) ,
		`tb_guiapago_usumod` =  '$usumod',
		`tb_guiapago_$campo` =  '$valor' 
		WHERE tb_guiapago_id =$id;"; 
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;	
	}
	function guiapago_control($cli_id,$guipagtip_id,$per_id,$eje_id){
		$sql="SELECT *
		FROM tb_guiapago gp 
		INNER JOIN tb_cliente c ON gp.tb_cliente_id=c.tb_cliente_id
		WHERE gp.tb_cliente_id=$cli_id
		AND tb_guiapagotipo_id=$guipagtip_id
		AND tb_periodo_id=$per_id
		AND tb_ejercicio_id=$eje_id ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function listar_cliente_control($crofec_id){
		$sql="SELECT *
		FROM tb_probalancecontrol 
		WHERE tb_probalancecontrol_xac=1
		AND tb_probalancefecha_id=$crofec_id ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function insertar_control($xac,$usureg,$usumod,$cli_id,$probalite_id,$per_id,$eje_id){
		$sql="INSERT INTO tb_probalancecontrol(
	`tb_probalancecontrol_xac` ,
	`tb_probalancecontrol_fecreg` ,
	`tb_probalancecontrol_fecmod` ,
	`tb_probalancecontrol_usureg` ,
	`tb_probalancecontrol_usumod` ,
	`tb_cliente_id` ,
	`tb_probalanceitem_id` ,
	`tb_periodo_id` ,
	`tb_ejercicio_id`
	)
	VALUES (
	'$xac', NOW( ) , NOW( ) , '$usureg', '$usumod',  '$cli_id',  '$probalite_id',  '$per_id',  '$eje_id'
	);";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function editar_control($probalcon_id,$xac,$usumod){
	$sql="UPDATE tb_probalancecontrol SET  
	`tb_probalancecontrol_xac` =  '$xac',
	`tb_probalancecontrol_fecmod` = NOW( ),
	`tb_probalancecontrol_usumod` =  '$usumod'
	WHERE tb_probalancecontrol_id =$probalcon_id;";
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

}
?>