<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../clientecuenta/cClientecuenta.php");
require_once ("../formatos/formato.php");
$oClientecuenta = new cClientecuenta();

$emp_id=$_SESSION['empresa_id'];
$est='2,3';

$dts=$oClientecuenta->mostrar_cuenta_por_cobrar($emp_id,fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['txt_fil_cli_doc'],$_POST['txt_fil_cli_nom'],$est);
$num_rows= mysql_num_rows($dts);

?>
<script type="text/javascript">
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
                  <th>CLIENTE</th>
                  <th>RUC/DNI</th>
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
							$total+=$dt['tb_clientecuenta_mon'];
						$total_pagado=0;
								//pagos realizados
								$tipo=2;
								$tipo_registro=2;
								$rws=$oClientecuenta->mostrar_por_cuenta($dt['tb_clientecuenta_id'],$tipo,$tipo_registro);
								while($rw = mysql_fetch_array($rws)){
									$total_pagado+=$rw['tb_clientecuenta_mon'];
								}
								mysql_free_result($rws);
							
							$suma_pago+=$total_pagado;
            ?>
                <tr>
                <td nowrap><?php echo mostrarFecha($dt['tb_clientecuenta_fec'])?></td>
                <td><?php echo $dt['tb_cliente_nom']?></td>
                <td><?php echo $dt['tb_cliente_doc']?></td>
                <td><?php echo $dt['tb_clientecuenta_glo'];
				/*if($dt['tb_clientecuenta_est']==2 or $dt['tb_clientecuenta_est']==3)
				{
				?>
                <a class="btn_pagar" href="#pago" onClick="clientecuenta_form_pago('insertar_pago','pago','<?php echo $dt['tb_clientecuenta_id']?>','<?php echo $dt['tb_cliente_id']?>')">Pagar</a>
                <?php }*/?>
                </td>
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
                <a class="btn_mostrar" title="Mostrar Información de NVenta" href="#update" onClick="ventanota_form('editar','<?php echo $dt['tb_clientecuenta_ven_id']?>')">NVenta</a>
                <?php }
								}?>
                </td>
                <td align="right"><?php if($dt['tb_clientecuenta_tip']==1)echo formato_money($dt['tb_clientecuenta_mon'])?></td>
                <td align="right"><?php echo formato_money($total_pagado)?></td>
                <td align="right" title="<?php echo $dt['tb_clientecuenta_id']?>"><?php if($dt['tb_clientecuenta_est']==1){
						echo "<strong>CANCELADA</strong>";
						}else{
							if($dt['tb_clientecuenta_est']==3){
								echo "<span class='alerta_a'>PAGO PARCIAL</span>";							
							}else{
								if($dt['tb_clientecuenta_tip']==1){
									echo "<span>POR CANCELAR</span>";
								}else{
									echo "-";	
								}	
							}						
							
						}?></td>
                <td align="center" nowrap>
                <?php if($dt['tb_clientecuenta_tipreg']==2){?>
                <a class="btn_editar" href="#editar" onClick="clientecuenta_form_pago('editar_pago','','<?php echo $dt['tb_clientecuenta_id']?>')">Editar</a>
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
        		<tr class="even">
        		  <td colspan="4"><strong>TOTAL</strong></td>
        		  <td align="right">&nbsp;</td>
                	<td align="right"><?php echo formato_money($total)?></td>
                	<td align="right"><?php echo formato_money($suma_pago)?></td>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <!--<tr class="odd">
                  <td colspan="6"><?php //echo $num_rows.' registros'?></td>
                </tr>-->
        </table>