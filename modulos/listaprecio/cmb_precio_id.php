<?php
require_once ("../../config/Cado.php");
require_once ("cPrecio.php");
$oPrecio = new cPrecio();
?>
	<option value="">-</option>
<?php
    $dts1=$oPrecio->mostrarTodos();

    $dts2=$oPrecio->mostrar_filtro_cliente($_POST['cliente_id']);
    $dt2 = mysql_fetch_array($dts2);

	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_precio_id']?>" <?php if($dt1['tb_precio_id']==$_POST['precio_id'])echo 'selected'?>><?php echo $dt1['tb_precio_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>