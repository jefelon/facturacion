<?php
require_once ("../../config/Cado.php");
require_once ("../notadebito/cNotadebitocorreo.php");
$oNotadebitocorreo = new cNotadebitocorreo();
require_once("../formatos/formato.php");

$celeste_oscuro ="#A9D0F5";//celeste oscuro
$blanco         ="#FFFFFF";//blanco
$celeste_claro  ="#CEE3F6";//celeste claro
$celeste        ="#AFDCF8";
$gris_claro     ="#E6E6E6";//gris claro
$rosado         ="#FBEFF2";//rosado
$verde          ="#A9F5A9";//verde
$naranja        ="#F7BE81";//naranja
$azul           ="#81BEF7";//azul
$plomo          ="#BDBDBD";//plomo
$rojo           ="#F78181";
$amarillo       ="#F5DA81";
$rojo_oscuro    ="#FA5858";

$color11="#F5A9A9";
$color22="#F5D0A9";
$color33="#F2F5A9";
$color44="#D0F5A9";

$dts=$oNotadebitocorreo->listar($_POST['ven_id']);
$num_rows= mysql_num_rows($dts);

?>
<script type="text/javascript">
$(function() {	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});

    $('.btn_action').button({
        //icons: {primary: "ui-icon-pencil"},
        text: true
    });

}); 
</script>
        <table cellspacing="1" width="100%">
        <?php
        if($num_rows>=1){
		?>  
            <tbody>
			<?php
           	while($dt = mysql_fetch_array($dts)){
            ?>
                <tr>
                    <td valign="top" style="font-size:9pt; background:<?php echo $celeste_claro?>;"><?php echo '<strong>FECHA: '.mostrarFechaHora($dt['tb_ventacorreo_fecreg']).'</strong>'?></td>
                    <td valign="top" align="left" style="font-size:9pt; background:<?php echo $celeste_claro?>;">
                    <?php
                        echo '<strong> DE: '.$dt['tb_ventacorreo_coremi'].'</br> PARA: '.$dt['tb_ventacorreo_cor'].'</strong>';
                        if($dt['tb_ventacorreo_corcop']!=""){
                            echo '</br><strong>COPIA: '.$dt['tb_ventacorreo_corcop'].'</strong>';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top" style="font-size:9pt; background:<?php echo $celeste_claro?>;">
                        <?php echo '<strong>ASUNTO: '.$dt['tb_ventacorreo_asu'].'</strong>'?>
                        <?php if($dt['tb_ventacorreo_adj']!="")echo 'ADJUNTO: '.$dt['tb_ventacorreo_adj']?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" valign="top"><?php echo $dt['tb_ventacorreo_men']?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
			<?php
				}
				mysql_free_result($dts);
            ?>
            </tbody>
     	<?php
        }
		?>
                <tr>
                  <td><?php //echo $num_rows.' registros'?></td>
                </tr>
        </table>