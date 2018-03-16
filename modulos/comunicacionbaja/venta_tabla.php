<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/formato.php");

$estado='ANULADA';

$dts1=$oVenta->mostrar_filtro($_SESSION['empresa_id'],fecha_mysql($_POST['txt_fil_ven_fec1']),$estado);
$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(function() {	
	$('.btn_sunat').button({
    text: true
  });

	$("#tabla_venta").tablesorter({
		widgets: ['zebra', 'zebraHover'],
		headers: {
			0: {sorter: 'shortDate' },
		10: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[2,0]]
    });
	
}); 
</script>
COMPROBANTES ELECTRÓNICOS ANULADOS
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
                  <th align="center">DETALLE</th>
                </tr>
            </thead>
            <?php
			if($num_rows>0){
			?>
            <tbody>
                <?php
        while($dt1 = mysql_fetch_array($dts1)){
        ?>
                    <tr>
                      <td nowrap="nowrap"><?php echo $dt1['tb_cliente_nom']?></td>
                      <td nowrap="nowrap">
                      <?php 
                      if($dt1['tb_documento_id']=='2'){
                        echo 'Factura';
                      }
                      if($dt1['tb_documento_id']=='3'){
                        echo 'Boleta';
                      }
                      if($dt1['tb_documento_id']=='11'){
                        echo 'Factura Electrónica';
                      }
                      if($dt1['tb_documento_id']=='12'){
                        echo 'Boleta Electrónica';
                      }
                      ?>
                      </td>
                      <td nowrap="nowrap" title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_venta_ser'].'-'.$dt1['tb_venta_num']?></td>
                      <td>
                      <?php 
                      if($dt1['cs_tipomoneda_id']=='1'){
                        echo 'Nuevo Sol';
                      }elseif($dt1['cs_tipomoneda_id']=='2'){
                        echo 'Dollar';
                      }?>
                      </td>
                      <td align="right"><?php echo formato_money($dt1['tb_venta_tot'])?></td>
                      <td nowrap="nowrap" align="center"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                      <td><?php echo $dt1['tb_venta_est']?></td>
                      <td>
                      <?php
                      $mostrar_envio_sunat=0;
                      if($dt1['tb_documento_ele']==1)
                      {
                        if($dt1['tb_venta_estsun']=='1')
                        {
                          echo 'ACEPTADO';
                        }
                        else
                        {
                          if($dt1['tb_venta_estsun']=='2')
                          {
                            echo 'RECHAZADO';
                          }else{
                            echo 'PENDIENTE ENVIO';
                            $mostrar_envio_sunat=1;
                          }
                        }
                      }
                      else
                      {
                        echo '';
                      }
                      ?>
                      </td>
                      <td align="center">
                      <?php
                        echo mostrarFechaHora($dt1['tb_venta_fecenvsun']);
                      ?></td>
                      <td align="center">
                      <?php
                        $dts2=$oVenta->comparar_combaja_detalle($dt1['tb_venta_id']);
                        if(mysql_num_rows($dts2)>0)echo 'DECLARADO';
                      ?>
                      </td>
                      <?php /* <td align="center" nowrap="nowrap">
                      <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">Editar</a>
                      <a class="btn_sunat" href="#sunat" onClick="enviar_sunat('<?php echo $dt1['tb_venta_id']?>')">E. Sunat</a>
                      <a class="btn_accion" id="btn_accion" href="#correo" title="Enviar correo" onClick="correo_form('enviar',
                      '<?php echo $dt1['tb_venta_id']?>',
                      '<?php echo $dt1['tb_cliente_id']?>',
                      '',
                      ''
                      )">Enviar Correo</a>
                      <a class="btn_pdf" id="btn_pdf" href="#print" title="Descargar pdf" onClick="venta_impresion('<?php echo $dt1['tb_venta_id']?>')">PDF</a>
                      <a class="btn_xml" id="btn_xml" target="_blank" href="descargar_xml.php?id_factura=<?php echo $dt1['tb_venta_id']?>" title="Descargar XML">XML</a>
                      <?php if($dt1['tb_venta_est']!='ANULADA' and $_POST['chk_ven_anu']==1){?>
                      <a class="btn_anular" href="#anular" onClick="venta_anular('<?php echo $dt1['tb_venta_id']?>','<?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_numdoc']?>')">Anular</a>

                      <?php } ?>
                      <!--<a class="btn_eliminar" href="#delete" onClick="eliminar_venta('<?php //echo $dt1['tb_venta_id']?>')">Eliminarr</a>-->
                      </td> */ ?>
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
                  <td colspan="5" align="right">&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="10"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>