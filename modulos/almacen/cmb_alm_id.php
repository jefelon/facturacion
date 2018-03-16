<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cAlmacen.php");
$oAlmacen = new cAlmacen();

?>
<option value="">-</option>
<?php
$dts=$oAlmacen->mostrar_por_empresa($_SESSION['empresa_id']);

if($_GET['ventas']==1)
{
	$dts=$oAlmacen->mostrar_para_venta($_SESSION['empresa_id']);
}

while($dt = mysql_fetch_array($dts))
{	
	if($_POST['alm_ori']!=$dt['tb_almacen_id'])
	{
	?>
	<option value="<?php echo $dt['tb_almacen_id']?>" <?php if($dt['tb_almacen_id']==$_POST['alm_id'])echo 'selected'?>><?php echo $dt['tb_almacen_nom']?></option>
    <?php
	}
}
mysql_free_result($dts);
?>