<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cUsuariogrupo.php");
$oUsuariogrupo = new cUsuariogrupo();

?>
<option value="">-</option>
<?php
$dts=$oUsuariogrupo->mostrarTodos();
while($dt = mysql_fetch_array($dts))
{
	?>
	<option value="<?php echo $dt['tb_usuariogrupo_id']?>" <?php if($dt['tb_usuariogrupo_id']==$_POST['usugru'])echo 'selected'?>><?php echo $dt['tb_usuariogrupo_nom']?></option>
    <?php
	/*
	if(($_SESSION['usuariogrupo_nombre']=='Super Usuario') and ($dt['tb_usuariogrupo_nom']=='Super Usuario' or $dt['tb_usuariogrupo_nom']=='Administrador')){
?>
	<option value="<?php echo $dt['tb_usuariogrupo_id']?>" <?php if($dt['tb_usuariogrupo_id']==$_POST['usugru'])echo 'selected'?>><?php echo $dt['tb_usuariogrupo_nom']?></option>
                    <?php
	}
	
	if(($_SESSION['usuariogrupo_nombre']=='Administrador') and ($dt['tb_usuariogrupo_nom']=='Ejecutivo de Cuenta' or $dt['tb_usuariogrupo_nom']=='Instructor')){
?>
	<option value="<?php echo $dt['tb_usuariogrupo_id']?>" <?php if($dt['tb_usuariogrupo_id']==$_POST['usugru'])echo 'selected'?>><?php echo $dt['tb_usuariogrupo_nom']?></option>
                    <?php
	}
	
		if(($_SESSION['usuariogrupo_nombre']=='Ejecutivo de Cuenta') and $dt['tb_usuariogrupo_nom']=='Participante'){
?>
	<option value="<?php echo $dt['tb_usuariogrupo_id']?>" <?php if($dt['tb_usuariogrupo_id']==$_POST['usugru'])echo 'selected'?>><?php echo $dt['tb_usuariogrupo_nom']?></option>
                    <?php
	}*/
	
}
mysql_free_result($dts);
?>