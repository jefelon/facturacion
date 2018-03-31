<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../tarjeta/cTarjeta.php");
$oTarjeta = new cTarjeta();
require_once ("../cuentacorriente/cCuentacorriente.php");
$oCuentacorriente = new cCuentacorriente();
require_once ("../formatos/formato.php");

$unico_id=$_POST['unico_id'];

//agregar item
if($_POST['action']=='agregar'){
	if(moneda_mysql($_POST['venpag_mon'])!='0.00'){
	$_SESSION['venpag_mon'][$unico_id][]		=moneda_mysql($_POST['venpag_mon']);
	$_SESSION['venpag_for'][$unico_id][]		=$_POST['venpag_for'];
	$_SESSION['venpag_mod'][$unico_id][]		=$_POST['venpag_mod'];
	$_SESSION['venpag_cuecor'][$unico_id][]		=$_POST['venpag_cuecor'];
	$_SESSION['venpag_tar'][$unico_id][]		=$_POST['venpag_tar'];
	$_SESSION['venpag_numope'][$unico_id][]	=$_POST['venpag_numope'];
	$_SESSION['venpag_numdia'][$unico_id][]	=$_POST['venpag_numdia'];
	$_SESSION['venpag_fecven'][$unico_id][]	=$_POST['venpag_fecven'];
	}
}

//quitar valores del array
if($_POST['action']=='quitar'){
	unset($_SESSION['venpag_mon'][$unico_id][$_POST['item_id']]);
	unset($_SESSION['venpag_for'][$unico_id][$_POST['item_id']]);
	unset($_SESSION['venpag_mod'][$unico_id][$_POST['item_id']]);
	unset($_SESSION['venpag_cuecor'][$unico_id][$_POST['item_id']]);
	unset($_SESSION['venpag_tar'][$unico_id][$_POST['item_id']]);
	unset($_SESSION['venpag_numope'][$unico_id][$_POST['item_id']]);
	unset($_SESSION['venpag_numdia'][$unico_id][$_POST['item_id']]);
	unset($_SESSION['venpag_fecven'][$unico_id][$_POST['item_id']]);
}

//restablecer o eliminar array
if($_POST['action']=='restablecer')
{
	unset($_SESSION['venpag_mon'][$unico_id]);
	unset($_SESSION['venpag_for'][$unico_id]);
	unset($_SESSION['venpag_mod'][$unico_id]);
	unset($_SESSION['venpag_cuecor'][$unico_id]);
	unset($_SESSION['venpag_tar'][$unico_id]);
	unset($_SESSION['venpag_numope'][$unico_id]);
	unset($_SESSION['venpag_numdia'][$unico_id]);
	unset($_SESSION['venpag_fecven'][$unico_id]);
}


if(isset($_SESSION['venpag_mon'][$unico_id]))
{
	$num_rows=count($_SESSION['venpag_mon'][$unico_id]);
	if($num_rows==0)$num_rows="";
}
else
{
	$num_rows="";
}
?>
<script type="text/javascript">

$('.btn_rest_act').button({
	icons: {
		//primary: "ui-icon-cart"//,
		secondary: "ui-icon-refresh"
	},
	text: false
});

$('.btn_rest_car_pag').button({
	icons: {
		//primary: "ui-icon-cart"//,
		//secondary: "ui-icon-cart"
	},
	text: true
});

$('.btn_item').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});

$('.btn_quitar').button({
	icons: {primary: "ui-icon-minus"},
	text: false
});

$(function() {	


}); 
</script>
<style>
	div#tabla_pago_detalle { margin: 0 0; }
	div#tabla_pago_detalle table { margin: 0 0; border-collapse: collapse;}
	div#tabla_pago_detalle table td, div#tabla_pago_detalle table th { border: 1px solid #eee; padding: 2px 3px; font-size:10px; }
	div#tabla_pago_detalle table th { height:14px }
</style>
<input name="hdd_ven_pag_numite" id="hdd_ven_pag_numite" type="hidden" value="<?php echo $num_rows?>">
<?php
	/*if($num_rows==0)echo $num_rows.' Ningún registro.';
	if($num_rows==1)echo $num_rows.' registro.';
	if($num_rows>=2)echo $num_rows.' registros.';*/
if($num_rows>0){
?>
<div id="tabla_pago_detalle" class="ui-widget" style="float:left">
        <table class="ui-widget ui-widget-content">
            <thead>
                <tr class="ui-widget-header">
                  <th>FECHA</th>
                  <th>FORMA DE PAGO</th>
                  <th>DETALLE</th>
                  <th align="right" nowrap="nowrap">MONTO</th>
                  <th align="right" nowrap="nowrap">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
					foreach($_SESSION['venpag_mon'][$unico_id] as $indice=>$valor){
						$total+=$valor;
				?>
                        <tr>
                          <td><?php echo date('d-m-Y')?></td>
                          <td><?php 
						  	if($_SESSION['venpag_for'][$unico_id][$indice]==1)echo 'CONTADO ';
							if($_SESSION['venpag_for'][$unico_id][$indice]==2)echo 'CREDITO '.$_SESSION['venpag_numdia'][$unico_id][$indice].'D | FV: '.$_SESSION['venpag_fecven'][$unico_id][$indice];
							
							/*if($dt1['tb_modopago_id']==1)echo 'EFECTIVO';
							if($dt1['tb_modopago_id']==2)echo 'DEPOSITO';
							if($dt1['tb_modopago_id']==3)echo 'TARJETA';*/
							?></td>
                          <td><?php
						  	//EFECTIVO
							if($_SESSION['venpag_mod'][$unico_id][$indice]==1)echo 'EFECTIVO';
							
							//DEPOSITO
							$cuecor_nom="";
							if($_SESSION['venpag_cuecor'][$unico_id][$indice]>0)
							{
								$dts=$oCuentacorriente->mostrarUno($_SESSION['venpag_cuecor'][$unico_id][$indice]);
								$dt = mysql_fetch_array($dts);
									$cuecor_nom=$dt['tb_cuentacorriente_nom'];
								mysql_free_result($dts);
							}
							if($_SESSION['venpag_mod'][$unico_id][$indice]==2)echo 'DEPOSITO '.$cuecor_nom.' N° Oper: '.$_SESSION['venpag_numope'][$unico_id][$indice];

							//TARJETA
							$tar_nom="";
							if($_SESSION['venpag_tar'][$unico_id][$indice]>0)
							{
								$dts=$oTarjeta->mostrarUno($_SESSION['venpag_tar'][$unico_id][$indice]);
								$dt = mysql_fetch_array($dts);
									$tar_nom=$dt['tb_tarjeta_nom'];
								mysql_free_result($dts);
							}
							if($_SESSION['venpag_mod'][$unico_id][$indice]==3)echo 'TARJETA '.$tar_nom.' N° Oper: '.$_SESSION['venpag_numope'][$unico_id][$indice];
							?></td>
                            <td align="right"><?php echo formato_money($valor)?></td>
                            <td align="right"><a class="btn_quitar" href="#" onClick="venta_pago_car('quitar','<?php echo $indice?>')">Quitar</a></td>
                        </tr>
                        <?php						
                	}
                ?>
                </tbody>
        </table>
</div>
<div style="float:left">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><a class="btn_rest_car_pag" href="#" onClick="venta_pago_car('restablecer')">Vaciar</a>
  <a class="btn_rest_act" href="#" onClick="venta_pago_car('actualizar')">Actualizar</a></td>
    <td width="120" align="right">MONTO TOTAL : S/.</td>
    <td width="70" align="right"><?php echo formato_money($total).""?></td>
    <td align="right"><input name="hdd_venpag_tot" id="hdd_venpag_tot" type="hidden" value="<?php echo formato_money($total)?>"></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <?php 
	$ven_tot=moneda_mysql($_POST['ven_tot']);
	$diferencia=$ven_tot-$total;
	?>
    <td align="right"><?php if(formato_money($diferencia)!='0.00') echo 'DIFERENCIA: S/.'?></td>
    <td align="right"><?php if(formato_money($diferencia)!='0.00') echo formato_money($diferencia)?></td>
    <td align="right"><input name="hdd_venpag_dif" id="hdd_venpag_dif" type="hidden" value="<?php echo formato_money($diferencia)?>"></td>
    </tr>
</table>

</div>
<?php 
}
if(isset($_SESSION['venpag_mon'][$unico_id])){
?>
<script type="text/javascript">
$(function() {
	//lenar monto de pagos
	var dif= $('#hdd_venpag_dif').autoNumericGet();
	$('#txt_venpag_mon').autoNumericSet(dif);
}); 
</script>
<?php }?>