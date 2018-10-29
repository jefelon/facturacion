<?php
require_once ("../../config/Cado.php");
require_once ("cCompra.php");
$oCompra = new cCompra();


require_once ("../formatos/formato.php");

	$dts= $oCompra->mostrarUno($_POST['com_id']);
	$dt = mysql_fetch_array($dts);
		$fec	=mostrarFecha($dt['tb_compra_fec']);
		$doc_id	=$dt['tb_documento_id'];
		$numdoc	=$dt['tb_compra_numdoc'];
		$pro_id	=$dt['tb_proveedor_id'];
		$subtot	=$dt['tb_compra_subtot'];
		$des	=$dt['tb_compra_des'];
		$descal	=$dt['tb_compra_descal'];
		$fle	=$dt['tb_compra_fle'];
		$tipfle	=$dt['tb_compra_tipfle'];
		$ajupos	=$dt['tb_compra_ajupos'];
		$ajuneg	=$dt['tb_compra_ajuneg'];
		$valven	=$dt['tb_compra_valven'];
		$igv	=$dt['tb_compra_igv'];
		$tot	=$dt['tb_compra_tot'];
		
		$tipper	=$dt['tb_compra_tipper'];
		$per	=$dt['tb_compra_per'];
		
		$alm_id	=$dt['tb_almacen_id'];
		$est	=$dt['tb_compra_est'];
	mysql_free_result($dts);

$dts1=$oCompra->mostrar_compra_detalle($_POST['com_id']);
$num_rows= mysql_num_rows($dts1);
$dts2=$oCompra->mostrar_compra_detalle_servicio($_POST['com_id']);
$num_rows2= mysql_num_rows($dts2);


?>
<script type="text/javascript">
$(function() {
	$('#txt_com_des,#txt_com_descal,#txt_com_fle,#cmb_com_tipfle,#txt_com_subtot,#txt_com_ajupos,#txt_com_ajuneg,#txt_com_valven,#txt_com_igv,#txt_com_tot').attr('disabled', 'disabled');
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_compra_detalle").tablesorter({ 
		headers: {
			//4: {sorter: 'shortDate' },
			//8: { sorter: false}
			},
		//sortForce: [[0,0]],
		//sortList: [[2,0]]
    });

    $('.btn_tabla_lote').button({
        icons: {primary: "ui-icon-newwin"},
        text: false
    });



});

$( "#div_lote_tabla" ).dialog({
    title:'Lotes',
    autoOpen: false,
    resizable: false,
    height: 'auto',
    width: 550,
    modal: true,
    buttons: {
        Cerrar: function() {
            $( this ).dialog( "close" );
        }
    },
    close: function() {
        $("#div_lote_tabla").html('Cargando...');
    }
});


</script>

<?php
$num_rows_total = ($num_rows + $num_rows2);
if($num_rows_total =="" or $num_rows_total==0)echo $num_rows_total.' Ningún registro.';
if($num_rows_total==1)echo $num_rows_total.' registro.';
if($num_rows_total>=2)echo ($num_rows_total).' registros.';

?>
        <table cellspacing="1" id="tabla_compra_detalle" class="tablesorter">
            <thead>
                <tr>
                  <th align="right">CANT</th>
                  <th>UND</th>
                  <th>NOMBRE / PRESENTACION</th>
                  <th>CATEGORIA / MARCA</th>
                  <th align="right" nowrap="nowrap" title="PRECIO UNITARIO">PRECIO UNIT</th>
                  <th align="right" nowrap="nowrap" title="DESCUENTO %">DSCTO %</th>
                  <th align="right">IMPORTE</th>
                  <th align="right">FLETE S/.</th>                   
                  <!--<th align="right">FLETE</th> --> 
                  <th align="right" title="COSTO UNITARIO">COSTO UNIT S/.</th>
                    <th align="center"></th>
                </tr>
            </thead>
			<?php
            if($num_rows_total>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){
				?>
                        <tr>
                          <td align="right"><?php 
							echo $dt1['tb_compradetalle_can'];
							?></td>
                          <td title="<?php echo $dt1['tb_unidad_nom']?>"><?php echo $dt1['tb_unidad_abr']?></td>
                            <td>
							<?php 
							echo '<strong>'.$dt1['tb_producto_nom'].'</strong>';
							echo ' / '.$dt1['tb_presentacion_nom'];
							?></td>
                            <td><?php 
							echo $dt1['tb_categoria_nom'];
							echo ' / '.$dt1['tb_marca_nom'];
							?></td>
                            <td align="right"><?php 
							echo $dt1['tb_compradetalle_preuni'];
							?></td>
                            <td align="right"><?php 
							echo $dt1['tb_compradetalle_des'];
							?></td>
                            <td align="right"><?php 
							echo formato_money($dt1['tb_compradetalle_imp']);
							?></td>
                            <td align="right"><?php 
							echo formato_money($dt1['tb_compradetalle_fle']);
							?></td>
                            <!--<td align="right"><?php 
							//echo $dt1['tb_compradetalle_fle'];
							?></td>-->
                            <td align="right"><?php 
							echo formato_money($dt1['tb_compradetalle_cosuni']);
							?></td>
                            <td align="center"><a class="btn_tabla_lote" onClick="lote_tabla(<?php echo $dt1['tb_compradetalle_id'] ?>)">Ver Lote</a></td>
                        </tr>
                <?php
                	}
                mysql_free_result($dts1);
                ?>
                <?php
                while($dt2 = mysql_fetch_array($dts2)){
                ?>
                <tr>
                    <td align="right"><?php
                        echo $dt2['tb_compradetalle_can'];
                        ?></td>
                    <td title="ZZ">ZZ</td>
                    <td>
                        <?php
                        echo '<strong>'.$dt2['tb_servicio_nom'].'</strong>';
                        ?></td>
                    <td><?php
                        echo $dt2['tb_categoria_nom'];
                        ?></td>
                    <td align="right"><?php
                        echo $dt2['tb_compradetalle_preuni'];
                        ?></td>
                    <td align="right"><?php
                        echo $dt2['tb_compradetalle_des'];
                        ?></td>
                    <td align="right"><?php
                        echo formato_money($dt2['tb_compradetalle_imp']);
                        ?></td>
                    <td align="right"><?php
                        echo formato_money($dt2['tb_compradetalle_fle']);
                        ?></td>
                    <!--<td align="right"><?php
                    //echo $dt1['tb_compradetalle_fle'];
                    ?></td>-->
                    <td align="right"><?php
                        echo formato_money($dt2['tb_compradetalle_cosuni']);
                        ?></td>
                    <td align="center"></td>
                </tr>
                <?php
                	}
                mysql_free_result($dts2);
                ?>
                </tbody>
                <?php
				}
				?>
        </table>
        <div id="div_lote_tabla"></div>

<br>
        <hr>
<div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="80"><label for="txt_com_des">DSCTO %</label></td>
        <td><input name="txt_com_des" type="text" id="txt_com_des" style="text-align:right" value="<?php echo formato_money($des)?>" size="10" maxlength="5" class="porcentaje2"></td>
      </tr>
      <tr>
        <td><label for="txt_com_fle">FLETE S/.</label></td>
        <td nowrap="nowrap"><input name="txt_com_fle" type="text" id="txt_com_fle" style="text-align:right" value="<?php echo formato_money($fle)?>" size="10" maxlength="8" class="moneda2">
          <label for="cmb_com_tipfle"></label>
          <select name="cmb_com_tipfle" id="cmb_com_tipfle">
            <option value="1"<?php if($tipfle==1)echo 'selected'?>>Con IGV</option>
            <option value="2"<?php if($tipfle==2)echo 'selected'?>>Sin IGV</option>
            <option value="3"<?php if($tipfle==3)echo 'selected'?>>Con IGV afecta Compra</option>
            <option value="4"<?php if($tipfle==4)echo 'selected'?>>Sin IGV afecta Compra</option>
          </select>
		</td>
      </tr>
    </table>
    </td>
    <td valign="top">
    <div style="margin-left:20px; float:right">
    <table border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td width="110"><label for="txt_com_subtot">SUB TOTAL</label></td>
        <td width="190"><input name="txt_com_subtot" type="text" id="txt_com_subtot" value="<?php echo formato_money($subtot)?>" readonly style="text-align:right"></td>
      </tr>
      <tr>
        <td><label for="txt_com_descal">DESCUENTO</label></td>
        <td><input type="text" name="txt_com_descal" id="txt_com_descal" value="<?php echo formato_money($descal)?>" readonly style="text-align:right"></td>
      </tr>
      <tr>
        <td title="AJUSTE APLICADO AL VALOR VENTA">AJUSTE*</td>
        <td>
        <label for="txt_com_ajupos">+</label><input name="txt_com_ajupos" type="text" id="txt_com_ajupos" style="text-align:right" value="<?php echo $ajupos?>" size="6" maxlength="6" class="moneda2">
|        
<label for="txt_com_ajuneg">-</label><input name="txt_com_ajuneg" type="text" id="txt_com_ajuneg" style="text-align:right" value="<?php echo $ajuneg?>" size="6" maxlength="6" class="moneda2">
        </td>
      </tr>
    </table>
    </div>
    </td>
    <td valign="top">
    	<div style="margin-right:50px; float:right">
<table border="0" align="right" cellpadding="0" cellspacing="0">
  <tr>
    <td width="110">VALOR VENTA</td>
    <td width="140" align="right"><input type="text" name="txt_com_valven" id="txt_com_valven" value="<?php echo formato_money($valven)?>" readonly style="text-align:right"></td>
  </tr>
  <tr>
    <td><label for="txt_com_igv">IGV</label></td>
    <td align="right"><input type="text" name="txt_com_igv" id="txt_com_igv" value="<?php echo formato_money($igv)?>" readonly style="text-align:right"></td>
  </tr>
  <?php if($tipper==1){?>
  <tr>
    <td><label for="txt_com_per">PERCEPCION(2%)</label></td>
    <td align="right"><input type="text" name="txt_com_per" id="txt_com_per" value="<?php echo formato_money($per)?>" readonly style="text-align:right"></td>
  </tr>
  <?php }?>
  <tr>
    <td><label for="txt_com_tot"><strong>TOTAL</strong></label></td>
    <td align="right"><input type="text" name="txt_com_tot" id="txt_com_tot" value="<?php echo formato_money($tot)?>" readonly style="text-align:right"></td>
  </tr>
</table>
</div>
    </td>
  </tr>
</table>
</div>