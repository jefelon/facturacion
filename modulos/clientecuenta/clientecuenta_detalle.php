<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../formatos/formato.php");
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();

require_once ("cClientecuenta.php");
$oClienteCuenta = new cClienteCuenta();

//$dts=$oClienteCuenta->mostrarTodos();
$cli_id = $_POST['cli_id'];
$emp_id=$_POST['emp_id'];
$vista=$_POST['vista'];;
//$emp_id=1;

	$dts=$oEmpresa->mostrarUno($emp_id);
	$dt = mysql_fetch_array($dts);
		$ruc=$dt['tb_empresa_ruc'];
		$nomcom=$dt['tb_empresa_nomcom'];
		$razsoc=$dt['tb_empresa_razsoc'];
		$dir=$dt['tb_empresa_dir'];
		$dir2=$dt['tb_empresa_dir2'];
		$tel=$dt['tb_empresa_tel'];
		$ema=$dt['tb_empresa_ema'];
		$fir=$dt['tb_empresa_fir'];
		$rep=$dt['tb_empresa_rep'];		
	mysql_free_result($dts);

	$dts=$oCliente->mostrarUno($_POST['cli_id']);
	$dt = mysql_fetch_array($dts);
		$tip=$dt['tb_cliente_tip'];
		$nom=$dt['tb_cliente_nom'];
		$doc=$dt['tb_cliente_doc'];
		$dir=$dt['tb_cliente_dir'];
		$con=$dt['tb_cliente_con'];
		$tel=$dt['tb_cliente_tel'];
		$ema=$dt['tb_cliente_ema'];
	mysql_free_result($dts);

//Obteniendo Totales
	$dts = $oClienteCuenta->obtener_total_entradas_salidas($cli_id,$emp_id);
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
	mysql_free_result($dts);	

$y=date('Y');
$m=date('m');
$d=date('d');
	
$fec1="01-01-2013";
$fec2="$d-$m-$y";
$ven_est='CANCELADA';

//numero de ventas
$dts1=$oVenta->mostrar_filtro_adm(fecha_mysql($fec1),fecha_mysql($fec2),$_POST['cmb_fil_ven_doc'],$cli_id,$ven_est,$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$emp_id,$_POST['chk_fil_ven_may']);
$num_ventas= mysql_num_rows($dts1);
mysql_free_result($dts1);
?>
<script type="text/javascript">
function clientecuenta_tabla_2(){
	$.ajax({
		type: "POST",
		url: "../clientecuenta/clientecuenta_detalle_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			cli_id:	'<?php echo $cli_id?>',
			emp_id:	'<?php echo $emp_id?>'
		}),
		beforeSend: function() {
			$('#div_clientecuenta_tabla_2').dialog("open");
			$('#div_clientecuenta_tabla_2').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
    },
		success: function(html){
			$('#div_clientecuenta_tabla_2').html(html);
		},
		complete: function(){			
			//$('#div_clientecuenta_tabla_2').removeClass("ui-state-disabled");				
		}
	}); 
}

$(function(){
	$( "#div_clientecuenta_tabla_2" ).dialog({
		title:'Estado de Cuenta | <?php echo $doc.' | '.$nom?>',
		autoOpen: false,
		resizable: false,
		height: 550,
		width: 940,
		modal: true,
		position: "top",
		closeOnEscape: false,
		buttons: {
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			$('#div_clientecuenta_tabla_2').html('cliente_cuenta');
		}
	});

});
</script>
    <table>
    <?php if($vista==1){?>
        <tr>
        	<td align="right" colspan="3"><strong><?php echo $razsoc?></strong></td>
        </tr>
    <?php }?>
        <tr>
        	<td>Cuentas por Cobrar:</td>
          <td align="right"><?php echo 'S/. '.formato_money(formato_decimal($total['entradas'] - $total['salidas'], 2))?></td>
          <td align="right"><a id="btn_estado_cuenta" href="#detalle" onClick="clientecuenta_tabla_2()" title="Ver Estado de Cuenta">Ver</a></td>
        </tr>
        <tr>
          <td>N° de Compras:</td>
          <td align="right"><?php echo $num_ventas?></td>
          <td>&nbsp;</td>
        </tr>
    </table>
<div id="div_clientecuenta_tabla_2">
</div>