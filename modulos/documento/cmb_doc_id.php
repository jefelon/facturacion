<?php
require_once ("../../config/Cado.php");
require_once ("cDocumento.php");
$oDocumento = new cDocumento();
?>
	<option value="">-</option>

<?php
$mos=1;

    $dts1=$oDocumento->mostrar_por_tipo_cot($_POST['doc_tip'],$_POST['doc_cot'],$mos);

	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_documento_id']?>" <?php 
	if($_POST['vista']=='insertar'){ if($dt1['tb_documento_def']==1)echo 'selected';} 
	if($_POST['vista']=='editar'){ if($dt1['tb_documento_id']==$_POST['doc_id'])echo 'selected';}
	if($_POST['vista']==''){ if($dt1['tb_documento_id']==$_POST['doc_id'])echo 'selected';}?>><?php echo $dt1['tb_documento_abr'].' | '.$dt1['tb_documento_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>