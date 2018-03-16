<?php
require_once ("../../config/Cado.php");
require_once ("cUbigeo.php");
$oUbigeo = new cUbigeo();

$tip=$_POST['tip'];
$coddep=$_POST['coddep'];
$codpro=$_POST['codpro'];

?>
<option value="">-</option>
<?php
$dts=$oUbigeo->mostrarCombo($tip,$coddep,$codpro);
while($dt = mysql_fetch_array($dts))
{
	if($tip=='Departamento')$codigo=$dt['tb_ubigeo_coddep'];
	elseif($tip=='Provincia')$codigo=$dt['tb_ubigeo_codpro'];
	elseif($tip=='Distrito')$codigo=$dt['tb_ubigeo_coddis'];
	
?>
	<option value="<?php echo $codigo?>" <?php if($codigo==$_POST['ubigeo'])echo 'selected'?>><?php echo $dt['tb_ubigeo_nom']?></option>
                    <?php
	
}
mysql_free_result($dts);
?>