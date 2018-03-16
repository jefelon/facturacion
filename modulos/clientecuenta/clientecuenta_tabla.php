<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cClientecuenta.php");
require_once ("../formatos/formato.php");
$oClienteCuenta = new cClienteCuenta();

//$dts=$oClienteCuenta->mostrarTodos();
$cli_id = $_POST['cli_id'];
$emp_id=$_SESSION['empresa_id'];

if($emp_id==1)$emp_id_resumen=2;
if($emp_id==2)$emp_id_resumen=1;

$dts=$oClienteCuenta->mostrar_cuenta_por_cliente($cli_id,$emp_id);
$num_rows= mysql_num_rows($dts);

?>
<script type="text/javascript">
function clientecuenta_detalle(ids,emp)
{   
    $.ajax({
        type: "POST",
        url: "../clientecuenta/clientecuenta_detalle.php",
        async:true,
        dataType: "html",                    
        data: ({
            cli_id: ids,
            emp_id: emp,
            vista: 1
        }),
        beforeSend: function() {
            $('#div_clientecuenta_detalle').html('<option value="">Cargando...</option>');
        },
        success: function(html){
            $('#div_clientecuenta_detalle').html(html);
        }
    });
    //$('#div_clientecuenta_detalle').html(ids);
}

$(function() {
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	$('.btn_mostrar').button({
		icons: {primary: "ui-icon-newwin"},
		text: true
	});
	$('.btn_pagar').button({
		//icons: {primary: "ui-icon-pencil"},
		text: true
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});

    clientecuenta_detalle(<?php echo $cli_id;?>,<?php echo $emp_id_resumen?>);

	$("#tabla_clientecuenta").tablesorter({ 
		widgets : ['zebra','zebraHover'],
		headers: {
			0: {sorter: 'shortDate' },
			5: { sorter: false}
		},
		widgetZebra: {
			css: ["even", "odd"]
		},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
        <table cellspacing="1" id="tabla_clientecuenta" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th>CODIGO</th>
                <th>GLOSA</th>
                <th align="center">VENTA</th>
                <th align="right">CARGO</th>
                <th align="right">ABONO</th>
                <th align="right">ESTADO</th>                
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
                <td nowrap="nowrap"><?php echo mostrarFecha($dt['tb_clientecuenta_fec'])?></td>
                <td style="font-weight:<?php if($dt['tb_clientecuenta_tip']==1)echo 'bold'?>"><?php if($dt['tb_clientecuenta_tip']==1)echo $dt['tb_clientecuenta_id']?></td>
                <td style="font-weight:<?php if($dt['tb_clientecuenta_tip']==1)echo 'bold'?>"><?php echo $dt['tb_clientecuenta_glo']?></td>
                <td align="center">
                <?php if($dt['tb_clientecuenta_tip']==1)
								{
									if($dt['tb_clientecuenta_ventip']==1)
									{
								?>
                <a class="btn_mostrar" title="Mostrar Información de Venta" href="#update" onClick="venta_form('editar','<?php echo $dt['tb_clientecuenta_ven_id']?>')">Venta</a>
                <?php }
								if($dt['tb_clientecuenta_ventip']==2)
									{?>
                <a class="btn_mostrar" title="Mostrar Información de Nota de Venta" href="#update" onClick="ventanota_form('editar','<?php echo $dt['tb_clientecuenta_ven_id']?>')">NVenta</a>
                <?php }
								}?>
                </td>
                <td align="right" nowrap="nowrap"><?php if($dt['tb_clientecuenta_tip']==1){echo 'S/. '.formato_money($dt['tb_clientecuenta_mon']);}?></td>
                <td align="right" nowrap="nowrap"><?php if($dt['tb_clientecuenta_tip']==2){echo 'S/. '.formato_money($dt['tb_clientecuenta_mon']);}?></td>
                <td align="right" title="<?php echo $dt['tb_clientecuenta_id']?>">
				<?php if($dt['tb_clientecuenta_est']==1){
						echo "<strong>CANCELADA</strong>";
						}else{
							if($dt['tb_clientecuenta_est']==3){
								echo "<span class='alerta_a'>PAGO PARCIAL</span>";							
							}else{
								if($dt['tb_clientecuenta_tip']==1){
									echo "<span class='alerta_r'>POR CANCELAR</span>";
								}else{
									echo "-";	
								}	
							}						
							
						}?>
                </td>
                <td align="center" nowrap>
                <?php
				if($dt['tb_clientecuenta_est']==2 or $dt['tb_clientecuenta_est']==3)
				{
				?><a class="btn_pagar" href="#pagar" onClick="clientecuenta_form_pago('insertar_pago','pago_insertar','<?php echo $dt['tb_clientecuenta_id']?>')">Pagar</a>
                <?php }?>
                <?php if($dt['tb_clientecuenta_tipreg']==2){?>
                <a class="btn_editar" href="#editar" onClick="clientecuenta_form_pago('editar_pago','pago_editar','<?php echo $dt['tb_clientecuenta_id']?>')">Editar</a>
                <?php /*?><a class="btn_eliminar" href="#" onClick="eliminar_clientecuenta('<?php echo $dt['tb_clientecuenta_id']?>')">Eliminar</a><?php */?>
                <?php }?>
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
        
        <?php 
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
?>
        		<tr class="even">
        		  <td colspan="4"><strong>TOTAL</strong></td>
        		  <td align="right" nowrap="nowrap"><?php echo 'S/. '.formato_money($total['entradas'])?></td>
                    <td align="right" nowrap="nowrap"><?php echo 'S/. '.formato_money($total['salidas'])?></td>
                    <td align="right"><?php echo 'SALDO = S/. '.formato_money(formato_decimal($total['entradas'] - $total['salidas'], 2))?></td>
                    <td align="center">&nbsp;</td>
                </tr>
                <!--<tr class="odd">
                  <td colspan="6"><?php //echo $num_rows.' registros'?></td>
                </tr>-->
        </table>
        

<fieldset>
  <legend>TOTAL (S/.)</legend>
  <table width="100%" border="0">
         <tbody>
             <tr>
                 <td width="50%">
                 <table border="0">
        <tr>
            <td align="right"><strong>Monto Total de Entradas:</strong></td>
            <td><?php echo formato_money($total['entradas'])?></td>
        </tr>
        <tr>
            <td align="right"><strong>Monto Total de Salidas:</strong></td>
            <td><?php echo formato_money($total['salidas'])?></td>
        </tr>
        <tr>
            <td align="right"><strong>Monto Por Cancelar:</strong></td>
            <td><?php echo formato_money(formato_decimal($total['entradas'] - $total['salidas'], 2))?></td>
        </tr>
    </table>
                </td>
                 <td width="50%"><div id="div_clientecuenta_detalle"></div></td>
             </tr>
         </tbody>
     </table>   
    
</fieldset>
       
