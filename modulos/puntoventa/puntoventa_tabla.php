<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();

if($_SESSION['usuariogrupo_id']==1){
    $dts=$oPuntoventa->mostrarTodos();
}
if($_SESSION['usuariogrupo_id']==2){
    $dts=$oPuntoventa->mostrar_filtro($_SESSION['empresa_id']);
}

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

	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_puntoventa").tablesorter({ 
		headers: {
			2: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_puntoventa" class="tablesorter">
            <thead>
                <tr>
                    <th>NOMBRE DE PUNTO DE VENTA</th>
                    <?php if($_SESSION['usuariogrupo_id']==1) echo '<th>EMPRESA</th>';?>
                    <th>ALMACEN PARA VENTA</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        <?php
        if($num_rows>=1){
		?>  
            <tbody>
			<?php
           	while($dt = mysql_fetch_array($dts)){
                $dt_empresas = $oEmpresa->mostrarUno($dt['tb_empresa_id']);
                $dt_empresa = mysql_fetch_array($dt_empresas)
            ?>
                <tr>
                    <td><?php echo $dt['tb_puntoventa_nom']?></td>
                    <?php if($_SESSION['usuariogrupo_id']==1) echo '<td>'. $dt_empresa['tb_empresa_razsoc'].'</td>';?>
                    <td><?php echo $dt['tb_almacen_nom']?></td>
                    <td align="center"><a class="btn_editar" href="#" onClick="puntoventa_form('editar','<?php echo $dt['tb_puntoventa_id']?>')">Editar</a> <a class="btn_eliminar" href="#" onClick="eliminar_puntoventa('<?php echo $dt['tb_puntoventa_id']?>')">Eliminar</a></td>
                </tr>
			<?php
				}
				mysql_free_result($dts);
                mysql_free_result($dt_empresas);
            ?>
            </tbody>
     	<?php
        }
		?>
                <tr class="even">
                  <td colspan="4"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>