<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once ("../../modulos/formatos/formato.php");

$dts1=$oVenta->mostrar_filtro(fecha_mysql($_POST['txt_fil_ven_fec1']),$_POST['cmb_fil_ven_doc'],$_POST['txt_fil_ser'],$_POST['txt_fil_cor'],$_POST['txt_fil_mon']);
$num_rows= mysql_num_rows($dts1);

?>

<script type="text/javascript">
$(function() {	
	$('.btn_editar').button({
		//icons: {primary: "ui-icon-pencil"},
		//text: false
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
		10: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0],[2,1],[1,1]]
    });
	
}); 
</script>
<?php
      if($num_rows>0){
      ?>
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
                  <th>&nbsp;</th>
                </tr>
            </thead>
            
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
                        echo $dt1['tb_documento_nom'];
                      ?>
                      </td>
                      <td nowrap="nowrap" title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_documento_abr'].' '.$dt1['tb_venta_ser'].'-'.$dt1['tb_venta_num']?></td>
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
                      <td align="center" nowrap="nowrap">
                          <?php
                          function encrypt($string, $key) {
                              $result = '';
                              for($i=0; $i<strlen($string); $i++) {
                                  $char = substr($string, $i, 1);
                                  $keychar = substr($key, ($i % strlen($key))-1, 1);
                                  $char = chr(ord($char)+ord($keychar));
                                  $result.=$char;
                              }
                              return base64_encode($result);
                          }
                          function decrypt($string, $key) {
                              $result = '';
                              $string = base64_decode($string);
                              for($i=0; $i<strlen($string); $i++) {
                                  $char = substr($string, $i, 1);
                                  $keychar = substr($key, ($i % strlen($key))-1, 1);
                                  $char = chr(ord($char)-ord($keychar));
                                  $result.=$char;
                              }
                              return $result;
                          }

                          $cadena_a_codificar="PIO)/((454546fgffg?¡paraDescargar&ven_id=".$dt1['tb_venta_id'];
                          $key="l09=4di_-T==";
                          $cadena_codificada=encrypt($cadena_a_codificar, $key);
                          ?>
                      <a class="btn_editar" href="#update" onClick="venta_form('editar','<?php echo $dt1['tb_venta_id']?>')">DETALLE</a>
                      <a class="btn_pdf" id="btn_pdf" target="_blank" href="venta_cpeimp.php?action=<?php echo $cadena_codificada; ?>" title="Descargar pdf">PDF</a>
                      <a class="btn_xml" id="btn_xml" target="_blank" href="../venta/descargar_xml.php?action=<?php echo $cadena_codificada; ?>" title="Descargar XML">XML</a>
                      </td>
                    </tr>
                <?php
        }
                mysql_free_result($dts1);
                ?>
            </tbody>
            </table>
            <?php
      }
        ?>
        