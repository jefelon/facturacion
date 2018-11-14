<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cLetras.php");
$oLetras = new cLetras();
require_once ("../formatos/formato.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();

$dts=$oLetras->mostrar_filtro(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_SESSION['puntoventa_id'],$_SESSION['empresa_id']);
$num_rows= mysql_num_rows($dts);

?>
<script type="text/javascript">


    //function imprimir(ids)
    //{
    //    $.ajax({
    //        type: "POST",
    //        url: "../venta/venta_impresion_gra_letras.php",
    //        async:true,
    //        dataType: "html",
    //        data: ({
    //            ven_id: ids,
    //            emp_id: '<?php //echo $_SESSION['empresa_id']?>//',
    //        }),
    //        beforeSend: function() {
    //            //$('#div_clientecuenta_detalle').html('<option value="">Cargando...</option>');
    //        },
    //        success: function(html){
    //            //$('#div_clientecuenta_detalle').html(html);
    //        }
    //    });
    //    //$('#div_clientecuenta_detalle').html(ids);
    //}

$(function() {
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});

	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_letra").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_letra" class="tablesorter">
            <thead>
                <tr>
                <th>Numero</th>
                <th>CONDICION</th>
                <th>VENCE</th>
                <th>CLIENTE</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
        <?php
        if($num_rows>=1){
		?>  
            <tbody>
			<?php
           	while($dt = mysql_fetch_array($dts)){
            ?>
                <tr>
                <td><?php echo str_pad($dt['tb_letras_numero'], 7, "0", STR_PAD_LEFT)?></td>
                <td>
                    <?php
                        $date1 = new  DateTime($dt['tb_venta_fec']);
                        $date2 = new DateTime($dt['tb_letras_fecha']);
                        $interval = $date1->diff($date2 );
                        $diferencia=$interval->format('%a');
                    echo $diferencia.' Dias.';
                    ?>
                </td>
                <td><?php echo $dt['tb_letras_fecha']?></td>
                <td><?php echo $dt['tb_cliente_nom']?></td>
                <td align="center">
                    <a class="btn_editar" href="#" onClick="letra_form('editar','<?php echo $dt['tb_letra_id']?>')">Editar</a>
                </td>
                <td align="center">
                    <a id="imprimir" class="btn_imprimir" target="_blank" title="Imprimir" href="#print">
                        <form id="for_preimp"  method="post" action="../venta/venta_impresion_gra_letras.php">
                            <input name="ven_id" type="hidden" value="<?php echo $dt['tb_venta_id']?>">
                            <input name="letra_id" type="hidden" value="<?php echo $dt['tb_letras_id']?>">
                            <input type="submit" value="Imprimir" formtarget="_blank">
                        </form>
                    </a>
                </td>
                </tr>
			<?php
				}
				mysql_free_result($dts);
            ?>
            </tbody>
     	<?php
        }
		?>
                <tr class="even">
                  <td colspan="6"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>