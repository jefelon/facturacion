<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../formatos/formato.php");
require_once ("cCompra.php");
$oCompra = new cCompra();

$estado="'EMITIDA','CANCELADA'";

$dts1=$oCompra->mostrar_duplicidad($_POST['doc'],$_POST['numdoc'],$pro_id,$estado,$_SESSION['empresa_id']);
$num_rows= mysql_num_rows($dts1);

$num_doc=$_POST['numdoc'];

if($num_rows>0){
echo "EXISTE REGISTRO DE COMPRA(S) CON N° DE DOCUMENTO $num_doc.";
?>
<script type="text/javascript">
$(function() {	
	$("#tabla_compra_dup").tablesorter({
		widgets : ['zebra','zebraHover'],
		headers: {
			0: {sorter: 'shortDate' },
			10: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
}); 
</script>
<table cellspacing="1" id="tabla_compra_dup" class="tablesorter">
            <thead>
                <tr>
                  <th>FECHA</th>
                  <th title="DOCUMENTO">DOC</th>
                  <th title="NUMERO DE DOCUMENTO">NUM DOC</th>                    
                  <th>PROVEEDOR</th>
                  <th>RUC/DNI</th>
                  <th align="right" title="MONEDA">MON</th>
                  <th align="right">VALOR VENTA</th>
                  <th align="right">IGV</th>
                  <th align="right">PERC</th>
                  <th align="right">TOTAL</th>
                  <th align="right">ESTADO</th>
                </tr>
            </thead>

            <tbody>
                <?php
				while($dt1 = mysql_fetch_array($dts1)){
				?>
                    <tr>
                      <td nowrap="nowrap"><?php echo mostrarFecha($dt1['tb_compra_fec'])?></td>
                      <td title="<?php echo $dt1['tb_documento_nom']?>"><?php echo $dt1['tb_documento_abr']?></td>
                      <td><?php echo $dt1['tb_compra_numdoc']?></td>
                      <td><?php echo $dt1['tb_proveedor_nom']?></td>
                      <td><?php echo $dt1['tb_proveedor_doc']?></td>
                      <td align="right"><?php if($dt1['tb_compra_mon']==1)echo "S/."; if($dt1['tb_compra_mon']==2)echo "US$";?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_compra_valven'])?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_compra_igv'])?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_compra_per'])?></td>
                      <td align="right"><?php echo formato_money($dt1['tb_compra_tot'])?></td>
                      <td align="right"><?php echo $dt1['tb_compra_est']?></td>
                    </tr>
                <?php
				}
                mysql_free_result($dts1);
                ?>
            </tbody>
                <tr class="even">
                  <td colspan="11"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
<?php
}
else
{
	echo "VERIFICANDO...";
?>
<script type="text/javascript">
$(function() {	
	$('#div_duplicidad').dialog("close");
}); 
</script>
<?php }?>