<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cCaja.php");
$oCaja = new cCaja();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
	//caja
if($_SESSION['puntoventa_id']>0)
{
	$dts=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
	$dt = mysql_fetch_array($dts);
		$caj_id		=$dt['tb_caja_id'];
	mysql_free_result($dts);
}

?>
	<option value="">-</option>
<?php
	$dts1=$oCaja->mostrarTodos();
	while($dt1 = mysql_fetch_array($dts1))
	{
		if($_SESSION['usuariogrupo_id']==3)
		{
			if($caj_id==$dt1['tb_caja_id'])
			{
?>
	<option value="<?php echo $dt1['tb_caja_id']?>" <?php if($dt1['tb_caja_id']==$_POST['caj_id'])echo 'selected'?>><?php echo $dt1['tb_caja_nom']?></option>
<?php
			}
		}
		else
		{
?>
	<option value="<?php echo $dt1['tb_caja_id']?>" <?php if($dt1['tb_caja_id']==$_POST['caj_id'])echo 'selected'?>><?php echo $dt1['tb_caja_nom']?></option>
<?php
		}
	}
	mysql_free_result($dts1);
?>