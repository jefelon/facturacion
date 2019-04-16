<?php
require_once ("../../config/Cado.php");
require_once ("../formatos/formato.php");
require_once ("../clientes/cCliente.php");
require_once ("../clientecuenta/cClientecuenta.php");
$oClienteCuenta = new cClienteCuenta();
$oCliente = new cCliente();
if($_POST['txt_fil_cli_nom']!="")
{
    $cls=$oCliente->mostrar_filtro($_POST['hdd_fil_cli_id']);
    $num_rows= mysql_num_rows($cls);
}
else{
    $cls=$oCliente->mostrarTodoscl();
    $num_rows= mysql_num_rows($cls);
}


$emp_id='1';

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

	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_cuentascobrar").tablesorter({
		headers: {
			1: {sorter: false }, 
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_cuentascobrar" class="tablesorter">
            <thead>
                <tr>
                    <th>CLIENTE</th>
                    <th>RUC/DNI</th>
                    <th>SALDO</th>
                </tr>
            </thead>
        <?php
        if($num_rows>=1){
		?>  
            <tbody>
			<?php
           	while($cl = mysql_fetch_array($cls)){
                $dts = $oClienteCuenta->obtener_total_entradas_salidas(fecha_mysql($_POST['txt_fil_fec1']),
                    fecha_mysql($_POST['txt_fil_fec2']), $cl['tb_cliente_id'],$emp_id);
                $entradas = array();
                while($dt = mysql_fetch_array($dts)){
                    $tipo = $dt['tipo'];
                    if($tipo == 1){
                        $total['entradas'] = $dt['monto'];
                    }
                    if($tipo == 2){
                        $total['salidas'] = $dt['monto'];
                    }
                }
            ?>
                <tr>
                    <td><?php echo $cl['tb_cliente_nom']?></td>
                    <td><?php echo $cl['tb_cliente_doc']?></td>
                    <td><?php echo 'S/. '.formato_money(formato_decimal($total['entradas'] - $total['salidas'], 2))?></td>
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
                  <td colspan="11"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>