<?php
require_once ("../../config/Cado.php");
require_once ("cCatalogoimagen.php");
$oCatimagen = new cCatalogoimagen();

$dts=$oCatimagen->mostrar_imagenfile($_POST['catimg_id']);
$num_rows= mysql_num_rows($dts);

?>
<script type="text/javascript">
$(function() {	

	$('.btn_eliminar1').button({
		icons: {primary: "ui-icon-trash"},
		text: true
	});

}); 
</script>
<table cellspacing="1" id="tabla_catalogo_imagen">
    <thead>
        <tr>
            <th></th>              
        </tr>
    </thead>
<?php
if($num_rows>=1){
?>  
    <tbody>
	
        <tr class="even">
            <?php
            while($dt = mysql_fetch_array($dts))
            {
            ?>
            <td align="center">
                <img src="<?php echo $dt['tb_catalogoimagenfile_url']?>" alt="" width="200" height="200">
                <br>
                <a class="btn_eliminar1" href="#img" onClick="catalogoimagen_file_eliminar('<?php echo $dt['tb_catalogoimagenfile_id']?>')">Eliminar</a>
            </td>
            <?php
            }
            mysql_free_result($dts);
            ?>
        </tr>

    </tbody>
	<?php
}
?>
</table>