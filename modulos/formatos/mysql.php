<?php
//require_once ("../../config/Cado.php");
class cMysql{
	function DATE_ADD($exp_date,$numero,$type = 'DAY'){
	$sql="SELECT DATE_ADD('$exp_date',INTERVAL $numero $type) AS date;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	
	$rs = mysql_fetch_array($rst);
		$date	=$rs['date'];
	mysql_free_result($rst);

	return $date;
	}
}
?>