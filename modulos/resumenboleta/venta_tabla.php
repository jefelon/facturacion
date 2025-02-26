<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cVenta.php");
$oVenta = new cVenta();
require_once ("../formatos/formato.php");

//contar para declarar
$dts1=$oVenta->mostrar_filtro($_SESSION['empresa_id'],fecha_mysql($_POST['txt_fil_ven_fec1']));
$num_row1 = mysql_num_rows($dts1);
while($dt1 = mysql_fetch_array($dts1))
{
  $dts2=$oVenta->comparar_resumenboleta_detalle($dt1['tb_venta_id']);
  $d=mysql_num_rows($dts2);

  if($d==0)
    {
      $num++;
    }

    if($d==1)
    {
      if($dt1['tb_venta_est']=='CANCELADA')$dec++;
      if($dt1['tb_venta_est']=='ANULADA')$num++;
    }
    if($d==2)
    {

    }

    mysql_free_result($dts2);
}
mysql_free_result($dts1);


$dts1=$oVenta->mostrar_filtro($_SESSION['empresa_id'],fecha_mysql($_POST['txt_fil_ven_fec1']));
$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
$(function() {	
	$('.btn_sunat, .btn_ticket').button({
    text: true
  });

	$("#tabla_venta").tablesorter({
		widgets: ['zebra', 'zebraHover'],
		headers: {
			//0: {sorter: 'shortDate' },
		  //10: { sorter: false}
			},
		//sortForce: [[0,0]],
		//sortList: [[0,0],[2,1],[1,1]]
    });
	
}); 
</script>
COMPROBANTES ELECTRÓNICOS
<?php if($num>0)echo ' <span style="color:red">Falta enviar '.$num.' comprobante(s)</span>';?>
        <table cellspacing="1" id="tabla_venta" class="tablesorter">
          <thead>
            <tr>
              <th align="center">NÚMERO</th>
              <th align="center">COMPROBANTE</th>
              <th align="center">N° DOCUMENTO</th>
              <th align="center">CLIENTE</th>
              <th align="center">RUC/DNI</th>
              <th align="center">MONEDA</th>
              <th align="right">OP. GRAVADAS</th>
              <th align="right">IGV</th>
              <th align="right">TOTAL</th>
              <th align="center">ESTADO</th>
              <th align="center">DETALLE</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $filas=0;
              while ($dt1 = mysql_fetch_array($dts1))
              {
                $filas++;
                $estado="";
      
                //sumatorias
                $opegra=($dt1['tb_venta_gra']);
                $igv=($dt1['tb_venta_igv']);
                $total=($dt1['tb_venta_tot']);
            ?>
              <tr>
                <td align="right"><?php echo $filas?></td>
                <td align="center"><?php echo $dt1['cs_tipodocumento_des']?></td>
                <td align="center"><?php echo $dt1['tb_venta_ser'].'-'.$dt1['tb_venta_num']?></td>
                <td align="left"><?php echo $dt1['tb_cliente_nom']?></td>
                <td align="left"><?php echo $dt1['tb_cliente_doc']?></td>
                <td align="center">PEN</td>
                <td align='right'><?php echo formato_moneda($opegra)?></td>
                <td align='right'><?php echo formato_moneda($igv)?></td>
                <td align='right'><?php echo formato_moneda($total)?></td>
                <td align="center">
                  <?php 
                    if($dt1['tb_venta_est']=='CANCELADA')echo 'REGISTRADA';
                    if($dt1['tb_venta_est']=='ANULADA')echo '<span style="color:red">ANULADA</span>';
                  ?>
                </td>
                <td align="center">
                  <?php
                    $dts2=$oVenta->comparar_resumenboleta_detalle($dt1['tb_venta_id']);
                    $d=mysql_num_rows($dts2);
                    if($d==0)
                    {
                      echo '<span style="color:green">ADICIONAR</span>';
                    }
                    if($d==1)
                    {
                      if($dt1['tb_venta_est']=='CANCELADA')echo 'DECLARADO';
                      if($dt1['tb_venta_est']=='ANULADA')echo '<span style="color:blue">ADICIONAR (A)</span>';
                    }
                    if($d==2)
                    {
                      echo 'DECLARADO';
                    }
                    
                  ?>
                </td>
              </tr>
            <?php }
            mysql_free_result($dts1); ?>
          </tbody>          
          <tr class="even">
            <td colspan="11"><?php echo $num_rows.' registros'?></td>
          </tr>
        </table>
