<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/formato.php");

$dts1=$oVenta->mostrar_filtro_adm(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec1']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id'],$_POST['chk_fil_ven_may']);

$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(function() {  
  
  $('.btn_editar').button({
    icons: {primary: "ui-icon-pencil"},
    text: false
  });


  $("#tabla_venta").tablesorter({
    widgets: ['zebra', 'zebraHover'],
    headers: {
      0: {sorter: 'shortDate' },
      11: { sorter: false}
      },
    //sortForce: [[0,0]],
    sortList: [[2,0],[0,0],[1,0]]
    });
  
}); 
</script>
COMPROBANTES ELECTRÓNICOS
        <table cellspacing="1" id="tabla_venta" class="tablesorter">
            <thead>
                <tr>
                  <th align="center">TIPO DE DOCUMENTO</th>
                  <th align="center">DOCUMENTO</th>
                  <th align="center">FECHA EMISIÓN</th>
                  <th align="center">CLIENTE</th>
                  <th align="center">RUC/DNI</th>
                  <th align="center">MONEDA</th>
                  <th align="center">IMPORTE TOTAL</th>
                  <th align="center">ESTADO DOC.</th>
                  <th align="center">ESTADO SUNAT</th>
                </tr>
            </thead>
            <?php
      if($num_rows>0){
      ?>
            <tbody>
                <?php
        while($dt1 = mysql_fetch_array($dts1))
        {
          if($dt1['tb_venta_est']=='CANCELADA'){
            $total_ventas+=$dt1['tb_venta_tot'];
          }
        ?>
                    <tr>
                      <td nowrap="nowrap"><?php echo $dt1['tb_documento_nom'];?></td>
                      <td nowrap="nowrap"><?php echo $dt1['tb_venta_ser'].'-'.$dt1['tb_venta_num']?></td>
                      <td nowrap="nowrap" align="center"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                      <td><?php echo $dt1['tb_cliente_nom']?></td>
                      <td><?php echo $dt1['tb_cliente_doc']?></td>
                      <td align="center">
                      <?php 
                      if($dt1['cs_tipomoneda_id']=='1'){
                        echo 'SOLES';
                      }
                      ?>
                      </td>
                      <td align="right"><?php echo formato_money($dt1['tb_venta_tot'])?></td>
                      <td><?php echo $dt1['tb_venta_est']?></td>
                      <td>
                      <?php
                      $mostrar_envio_sunat=0;
                      if($dt1['tb_documento_ele']==1)
                      {
                        if($dt1['tb_venta_estsun']=='0')
                        {
                          echo 'PENDIENTE ENVIO';
                          $mostrar_envio_sunat=1;
                        }
                        if($dt1['tb_venta_estsun']=='1')
                        {
                          echo 'ACEPTADO';
                        }
                        if($dt1['tb_venta_estsun']=='2')
                        {
                          echo 'RECHAZADO';
                        }
                        if($dt1['tb_venta_estsun']=='10')
                        {
                          echo 'RESUMEN';
                        }
                      }
                      else
                      {
                        echo '';
                      }
                      ?>
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
                  <td colspan="6">TOTAL</td>
                  <td align="right"><strong><?php echo formato_money($total_ventas)?></strong></td>
                  <td colspan="4" align="right">&nbsp;</td>
                </tr>
                <tr class="even">
                  <td colspan="11"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>