<?php
require_once ("../../config/Cado.php");
require_once ("cUsuario.php");
$oUsuario = new cUsuario();
require_once ("cUsuariodetalle.php");
$oUsuariodetalle = new cUsuariodetalle();
require_once("cDireccion.php");
$oDireccion = new cDireccion();
require_once("../ubigeo/cUbigeo.php");
$oUbigeo = new cUbigeo();
require_once("cTelefono.php");
$oTelefono = new cTelefono();


if($_POST['id']!="")
{
	$usu_id=$_POST['id'];
	$dts=$oUsuario->mostrarUno($usu_id);
	$dt = mysql_fetch_array($dts);
		$usugru	=$dt['tb_usuariogrupo_id'];
		$nom	=$dt['tb_usuario_nom'];
		$apepat	=$dt['tb_usuario_apepat'];
		$apemat	=$dt['tb_usuario_apemat'];
		$use	=$dt['tb_usuario_use'];
		$ema	=$dt['tb_usuario_ema'];
		
		$apenom=$apepat.' '.$apemat.' '.$nom;

	mysql_free_result($dts);
	
	$dts2=$oUsuariodetalle->mostrarUno($usu_id);
	$dt2 = mysql_fetch_array($dts2);
	
		$dni	=$dt2['tb_usuario_dni'];
		$con	=$dt2['tb_usuario_con'];
		$fun	=$dt2['tb_funcion_id'];
		$are	=$dt2['tb_area_id'];

	mysql_free_result($dts2);
	
}
else
{
	$usu_id=0;
}
?>
<script type="text/javascript">
$(function() {	
	$('.btn_editar_participante').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
});
</script>
<?php
if($usu_id>0){
?>
<input name="hdd_par_id" id="hdd_par_id" type="hidden" value="<?php echo $_POST['id']?>">
<input name="txt_par_apenom" type="hidden" id="txt_par_apenom" value="<?php echo $apenom?>">
<table cellpadding="0" cellspacing="3">
    <tr>
      <td><label for="txt_par_apenom">Apellidos y Nombres:</label></td>
      <td><?php echo $apenom?></td>
    </tr>
    <tr>
      <td><label for="txt_par_dni">DNI:</label></td>
      <td><?php echo $dni?></td>
    </tr>
    <tr>
      <td>Correo Electrónico:</td>
      <td><?php echo $ema?></td>
    </tr>
    <tr>
      <td>Nombre de usuario:</td>
      <td><?php echo $use?></td>
    </tr>
</table>
<br>
<div>
Dirección:
<table>
        <tbody>
          <?php
	$dts1=$oDireccion->mostrarTodos_usuario($usu_id);
$num_rows= mysql_num_rows($dts1);
        if($num_rows>0)
        {
        while($dt1 = mysql_fetch_array($dts1)){	  
        ?>
          <tr>
            <td><?php echo '*'?></td>
            <td><?php echo $dt1['tb_direccion_dir']?></td>
            <td><?php
		$dts2=$oUbigeo->mostrarUbigeo($dt1['tb_ubigeo_cod']);
			$dt2=mysql_fetch_array($dts2);
			echo $dt2['Distrito'].' - '.$dt2['Provincia'].' - '.$dt2['Departamento'];
		mysql_free_result($dts2);
		?></td>
          </tr>
          <?php
         }
         mysql_free_result($dts1);
         }
         ?>
        </tbody>
</table>
</div>
<br>
<div>
Teléfono(s):
  <table>
        <tbody>
          <?php
		  $dts1=$oTelefono->mostrarTodos_usuario($usu_id);
$num_rows= mysql_num_rows($dts1);
        if($num_rows>0)
        {
        while($dt1 = mysql_fetch_array($dts1)){	  
        ?>
          <tr>
          <td><?php echo '*'?></td>
            <td><?php echo $dt1['tb_telefono_num']?></td>
            <td><?php echo $dt1['tb_telefono_tip']?></td>
            <td><?php echo $dt1['tb_telefono_ope']?></td>
          </tr>
          <?php
         }
         mysql_free_result($dts1);
         }
         ?>
        </tbody>
      </table>
</div>
<?php
}
?>