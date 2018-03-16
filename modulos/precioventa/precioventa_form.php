<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("../catalogo/cCatalogo.php");
$oCatalogo = new cCatalogo();

require_once ("../formatos/formato.php");

unset($_SESSION['precioventa']);


$dts2=$oCatalogo->mostrar_unidad_de_presentacion($_POST['pre_id']);
while($dt2 = mysql_fetch_array($dts2)){
	if($dt2['verven']=="1")
	{
		$_SESSION['precioventa'][]=$dt2['cat_id'];
	}
}
mysql_free_result($dts2);

foreach($_SESSION['precioventa'] as $indice=>$valor){	
	if($indice==0)$rule= "txt_preven_$valor: {required: true}";
	if($indice>=1)$rule.= ",txt_preven_$valor: {required: true}";
	
	if($indice==0)$mesj= "txt_preven_$valor: {required: '*'}";
	if($indice>=1)$mesj.= ",txt_preven_$valor: {required: '*'}";
}

?>

<script type="text/javascript">
$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9999.99'
});

$(function() {	

	$("#for_preven").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "precioventa_reg.php",
				async:true,
				dataType: "html",
				data: $("#for_preven").serialize(),
				beforeSend: function() {			
					$("#div_precioventa_form" ).dialog( "close" );
					$('#msj_precioventa').html("Guardando...");
					$('#msj_precioventa').show(100);
				},
				success: function(html){						
					$('#msj_precioventa').html(html);
				},
				complete: function(){
					//precioventa_tabla();
				}
			});			
		},
		rules: {								
			<?php echo $rule?>
		},
		messages: {
			<?php echo $mesj?>
		}
	});	

}); 
</script>
<form id="for_preven">
        <table cellspacing="0">
            <?php
			$dts1=$oPresentacion->mostrarUno($_POST['pre_id']);
			$num_rows= mysql_num_rows($dts1);
			if($num_rows>=1)
			{
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
				?>
                        <tr>
                          <td><strong><?php echo $_POST['pro_nom']?></strong></td>
                        </tr>
                        <tr bgcolor="#FBEFEF">
                            <td><strong><?php echo $dt1['tb_presentacion_nom']?></strong></td>
                        </tr>
                        <tr>
                          <td>
                          <?php
							$dts2=$oCatalogo->mostrar_unidad_de_presentacion($_POST['pre_id']);
							$num_rows2= mysql_num_rows($dts2);
							?>
                            <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tablesorter">
                            <thead>
                                <tr>
                                  <th>UNIDAD</th>
                                    <th align="right">PRECIO VENTA</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            while($dt2 = mysql_fetch_array($dts2)){
								if($dt2['verven']=="1")
								{								
							?>
                              <tr class="even">
                                <td width="90" title="<?php echo $dt2['ue_nom']?>"><?php echo $dt2['ue_abr']?></td>
                                <td width="130" align="right"><input name="txt_preven_<?php echo $dt2['cat_id']?>" type="text" id="txt_preven_<?php echo $dt2['cat_id']?>" class="moneda" value="<?php echo $dt2['preven']?>" size="10" maxlength="8" style="text-align:right"></td>
                              </tr>
                            <?php
								}
							}
							mysql_free_result($dts2);
							?>
                            </tbody>

                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                <?php
                }
                mysql_free_result($dts1);
                ?>
            </tbody>
            <?php
            }
            ?>
        </table>
</form>