<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/formato.php");

$dts1=$oVenta->mostrar_filtro_adm(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id'],$_POST['chk_fil_ven_may']);

$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(function() {	
	
  $('.btn_accion').button({
    icons: {primary: "ui-icon-mail-closed"},
    text: false
  });
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
  $('.btn_sunat').button({
    text: true
  });
	$('.btn_anular').button({
		icons: {primary: "ui-icon-cancel"},
		text: false
	});
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
  $('.btn_pdf').button({
    //icons: {primary: "ui-icon-document"},
    //text: false
  });
  $('.btn_xml').button({
    //icons: {primary: "ui-icon-document"},
    //text: false
  });

	$("#tabla_venta").tablesorter({
		widgets: ['zebra', 'zebraHover'],
		headers: {
			0: {sorter: 'shortDate' },
			11: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0],[1,0]]
    });
	
}); 
</script>
        <table cellspacing="1" id="tabla_venta" class="tablesorter">
            <thead>
                <tr>
                  <th align="center">CLIENTE</th>
                  <th align="center">TIPO DOCUMENTO</th>
                  <th align="center">DOCUMENTO</th>
                  <th align="center">MONEDA</th>
                  <th align="center">IMPORTE TOTAL</th>
                  <th align="center">FECHA EMISIÓN</th>
                  <th align="center">ESTADO DOC.</th>
                  <th align="center">ESTADO SUNAT</th>
                  <th align="center">FECHA ENVIO SUNAT</th>
                  <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
					if($dt1['tb_venta_est']=='CANCELADA'){
						$total_ventas+=$dt1['tb_venta_tot'];
					}
				?>
                    <tr>
                      <td nowrap="nowrap"><?php echo $dt1['tb_cliente_nom']?></td>
                      <td nowrap="nowrap">
                      <?php 
                      if($dt1['tb_documento_id']=='2'){
                        echo 'Factura';
                      }else{
                        echo 'Boleta';
                      }?>
                      </td>
                      <td nowrap="nowrap" title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_ser'].'-'.$dt1['tb_venta_num']?></td>
                      <td>
                      <?php 
                      if($dt1['cs_tipomoneda_id']=='1'){
                        echo 'Nuevo Sol';
                      }else{
                        echo 'Dollar';
                      }?>
                      </td>
                      <td align="right"><?php echo formato_money($dt1['tb_venta_tot'])?></td>
                      <td nowrap="nowrap" align="center"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                      <td><?php echo $dt1['tb_venta_est']?></td>
                      <td>
                      <?php 
                      if($dt1['tb_venta_estsun']=='1'){
                        echo 'ACEPTADO';
                      }else{
                        if($dt1['tb_venta_estsun']=='2'){
                          echo 'RECHAZADO';
                        }else{
                          echo 'PENDIENTE ENVIO';
                        }
                      }?>
                      </td>
                      <td align="center">
                      <?php
                        if($dt1['tb_venta_fecenvsun']!='0000-00-00 00:00:00'){
                        echo $dt1['tb_venta_fecenvsun'];
                      }
                      ?></td>
                      <td align="center" nowrap="nowrap">
                      <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">Editar</a>
                      <a class="btn_sunat" href="#sunat" onClick="enviar_sunat('<?php echo $dt1['tb_venta_id']?>')">E. Sunat</a>
                      <a class="btn_accion" id="btn_accion" href="#correo" title="Enviar correo" onClick="correo_form('enviar',
                      '',
                      '<?php echo $dt1['tb_cliente_id']?>',
                      '',
                      ''
                      )">Enviar Correo</a>
                      <a class="btn_pdf" id="btn_pdf" target="_blank" href="../venta/pre_cargarPDF.php?action=paraDescargar&id_factura=<?php echo $dt1['tb_venta_id'] ?>" title="Descargar pdf">PDF</a>
                      <a class="btn_xml" id="btn_xml" target="_blank" href="../venta/pre_cargarXML.php?action=paraDescargar&id_factura=<?php echo $dt1['tb_venta_id'] ?>" title="Descargar XML">XML</a>
                      <?php /*if($dt1['tb_venta_est']!='ANULADA' and $_POST['chk_ven_anu']==1){?>
                      <a class="btn_anular" href="#anular" onClick="venta_anular('<?php echo $dt1['tb_venta_id']?>','<?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_numdoc']?>')">Anular</a>

                      <?php }*/ ?>
                      <!--<a class="btn_eliminar" href="#delete" onClick="eliminar_venta('<?php //echo $dt1['tb_venta_id']?>')">Eliminarr</a>-->
                      </td>
                    </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
            </tbody>
            <?php
			}
		    ?>
                <tr class="even">
                  <td colspan="4">TOTAL</td>
                  <td align="right"><strong><?php echo formato_money($total_ventas)?></strong></td>
                  <td colspan="4" align="right">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="13"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>