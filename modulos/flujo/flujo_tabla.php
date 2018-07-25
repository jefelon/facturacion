<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once("../../config/Cado.php");
require_once ("../cuadromi/cCuadromi.php");
$oCuadromi = new cCuadromi();
require_once ("../formatos/formato.php");

//require_once ("../form/cForm.php");
//$oForm = new cForm();

//empresa 
$emp=$_POST['emp'];

//año
$anio=$_POST['anio'];

//meses
$m1='01';
$m2='02';
$m3='03';
$m4='04';
$m5='05';
$m6='06';
$m7='07';
$m8='08';
$m9='09';
$m10='10';
$m11='11';
$m12='12';
$m='0';

//Suma_Flujo
/*
//ingresos
	$rws=$oForm->mostrarTodos_des('Ingresos','Suma_Flujo');
	$rw = mysql_fetch_array($rws);
$est_ing=$rw['tb_form_des'];
	mysql_free_result($rws);

//gastos
	$rws=$oForm->mostrarTodos_des('Gastos','Suma_Flujo');
	$rw = mysql_fetch_array($rws);
$est_gas=$rw['tb_form_des'];
	mysql_free_result($rws);*/

$compra_estado='CANCELADA';
$venta_estado='CANCELADA';

?>

<script type="text/javascript">
//botones
	$('#btn_mostrar').button({
		//icons: {primary: "ui-icon-pencil"},
		text: true
	});

function detalle_ingresos(cuenta,subcuenta,empresa,anio,mes,estado)
{
	$.ajax({
		type: "POST",
		url: "ingresos_detalle_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			cue:	cuenta,
			subcue:	subcuenta,
			emp:	empresa,
			a:		anio,
			m:		mes,
			est:	estado
		}),
		beforeSend: function() {
			$( "#div_ingresos_detalle_tabla" ).html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
			$( "#div_ingresos_detalle_tabla" ).dialog( "open" );
        },
		success: function(html){
			$('#div_ingresos_detalle_tabla').html(html);
		},
		complete: function(){			
			$( "#div_ingresos_detalle_tabla" ).dialog( "open" );
		}
	});
}

function detalle_gastos(cuenta,subcuenta,empresa,anio,mes,estado)
{
	$.ajax({
		type: "POST",
		url: "gastos_detalle_tabla.php",
		async:true,
		dataType: "html",                      
		data: ({
			cue:	cuenta,
			subcue:	subcuenta,
			emp:	empresa,
			a:		anio,
			m:		mes,
			est:	estado
		}),
		beforeSend: function() {
			$( "#div_gastos_detalle_tabla" ).html('Cargando <img src="images/loadingf11.gif" align="absmiddle"/>');
			$( "#div_gastos_detalle_tabla" ).dialog( "open" );
        },
		success: function(html){
			$('#div_gastos_detalle_tabla').html(html);
		},
		complete: function(){			
			$( "#div_gastos_detalle_tabla" ).dialog( "open" );
		}
	});
}
	

//
$(function() {
	
	$('.tip-ingresos').cluetip({
		attribute: 'id',
		//cluetipClass: 'jtip',
		cluetipClass: 'rounded',
		arrows: true,
		dropShadow: false,
		sticky: true,
		mouseOutClose: true,
		hoverClass: 'ui-state-highlight',
		showTitle: false,
		//closePosition: 'title',
		closeText: '<div align="right"><img src="cluetip/demo/cross.png" alt="close" /></div>'
	});
	
	$('.tip-gastos').cluetip({
		attribute: 'id',
		//cluetipClass: 'jtip',
		cluetipClass: 'rounded',
		arrows: true,
		dropShadow: false,
		sticky: true,
		mouseOutClose: true,
		hoverClass: 'ui-state-highlight',
		showTitle: false,
		//closePosition: 'title',
		closeText: '<div align="right"><img src="cluetip/demo/cross.png" alt="close" /></div>'
	});
	
	$( "#btn_mostrar" ).button().click(function() {
		//insertar_inventario();
	});
	
	$( "#div_ingresos_detalle_tabla" ).dialog({
		title:'DETALLE INGRESOS',
		autoOpen: false,
		resizable: false,
		height: 650,
		width: 940,
		//position: 'top',
		modal: true,
		buttons: {
			/*Filtrar: function() {
				$("#for_fil").submit();
				cargar_tabla_inventario();
			},*/
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}/*,
		close: function() {
			//cargar_tabla_inventario();
		}*/
	});
	
	$( "#div_gastos_detalle_tabla" ).dialog({
		title:'DETALLE GASTOS',
		autoOpen: false,
		resizable: false,
		height: 650,
		width: 940,
		//position: 'top',
		modal: true,
		buttons: {
			/*Filtrar: function() {
				$("#for_fil").submit();
				cargar_tabla_inventario();
			},*/
			Cerrar: function() {
				$( this ).dialog( "close" );
			}
		}/*,
		close: function() {
			//cargar_tabla_inventario();
		}*/
	});

});

</script>
<div>
        	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
      <tr class="flujo_enc">
        <td align="right"><span class="flujo_enc1"><?php echo $anio?></span></td>
        <td align="center"><span class="flujo_enc1">ENE</span></td>
        <td align="center"><span class="flujo_enc1">FEB</span></td>
        <td align="center"><span class="flujo_enc1">MAR</span></td>
        <td align="center"><span class="flujo_enc1">ABR</span></td>
        <td align="center"><span class="flujo_enc1">MAY</span></td>
        <td align="center"><span class="flujo_enc1">JUN</span></td>
        <td align="center"><span class="flujo_enc1">JUL</span></td>
        <td align="center"><span class="flujo_enc1">AGO</span></td>
        <td align="center"><span class="flujo_enc1">SET</span></td>
        <td align="center"><span class="flujo_enc1">OCT</span></td>
        <td align="center"><span class="flujo_enc1">NOV</span></td>
        <td align="center"><span class="flujo_enc1">DIC</span></td>
        <td align="center"><span class="flujo_enc1">RESULTADO</span></td>
      </tr>
      <tr>
        <td colspan="14">&nbsp;</td>
      </tr>
        <tr class="entrada_5">
         <td><span class="flujo_cat5">TOTAL VENTAS</span></td>
         <td align="right">
           <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m1.'&est='.ereg_replace("'","",$est_ing)?>">
             <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m1-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas1=$dt1['total'];
				}else{
					$entradas1=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
             </span>
           </td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m2-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas2=$dt1['total'];
				}else{
					$entradas2=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m3-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas3=$dt1['total'];
				}else{
					$entradas3=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m4-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas4=$dt1['total'];
				}else{
					$entradas4=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m5-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas5=$dt1['total'];
				}else{
					$entradas5=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m6-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas6=$dt1['total'];
				}else{
					$entradas6=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m7-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas7=$dt1['total'];
				}else{
					$entradas7=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m8-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas8=$dt1['total'];
				}else{
					$entradas8=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m9-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas9=$dt1['total'];
				}else{
					$entradas9=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m10-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas10=$dt1['total'];
				}else{
					$entradas10=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m11-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas11=$dt1['total'];
				}else{
					$entradas11=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-$m12-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas12=$dt1['total'];
				}else{
					$entradas12=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-ingresos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_venta_tot','tb_venta','tb_venta_fec',"$anio-%",'tb_venta_est',$venta_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $entradas=$dt1['total'];
				}else{
					$entradas=0;
				echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
       </tr>
      <tr>
        <td colspan="14">&nbsp;</td>
      </tr>
       <tr class="salida_5">
         <td><span class="flujo_cat5">TOTAL COMPRAS</span></td>
         <td align="right">
		 	<?php /*?><span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m1.'&est='.ereg_replace("'","",$est_gas)?>"><?php */?>
			<?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m1-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas1=$dt1['total'];
				}else{
					$salidas1=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
            </span>
            </td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m2-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas2=$dt1['total'];
				}else{
					$salidas2=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m3-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas3=$dt1['total'];
				}else{
					$salidas3=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m4-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas4=$dt1['total'];
				}else{
					$salidas4=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m5-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas5=$dt1['total'];
				}else{
					$salidas5=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m6-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas6=$dt1['total'];
				}else{
					$salidas6=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m7-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas7=$dt1['total'];
				}else{
					$salidas7=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m8-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas8=$dt1['total'];
				}else{
					$salidas8=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m9-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas9=$dt1['total'];
				}else{
					$salidas9=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m10-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas10=$dt1['total'];
				}else{
					$salidas10=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m11-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas11=$dt1['total'];
				}else{
					$salidas11=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-$m12-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas12=$dt1['total'];
				}else{
					$salidas12=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
         <td align="right"><span class="tip-gastos">
           <?php
			$dts1=$oCuadromi->total_ope('tb_compra_tot','tb_compra','tb_compra_fec',"$anio-%",'tb_compra_est',$compra_estado);
			$dt1 = mysql_fetch_array($dts1);
				if($dt1['total']!=""){
					echo $salidas=$dt1['total'];
				}else{
					$salidas=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts1);
			?>
         </span></td>
       </tr>
       <tr>
         <td colspan="14">&nbsp;</td>
       </tr>
       <tr>
        <td colspan="14">&nbsp;</td>
        </tr>
      <tr class="saldo_1">
        <td><span class="flujo_cat1">SALDO</span></td>
        <td align="right"><?php 
		$saldo1=moneda_mysql($entradas1)-moneda_mysql($salidas1);
				if($saldo1!=0) {
					echo formato_money($saldo1);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo2=moneda_mysql($entradas2)-moneda_mysql($salidas2);
				if($saldo2!=0) {
					echo formato_money($saldo2);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo3=moneda_mysql($entradas3)-moneda_mysql($salidas3);
				if($saldo3!=0) {
					echo formato_money($saldo3);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo4=moneda_mysql($entradas4)-moneda_mysql($salidas4);
				if($saldo4!=0) {
					echo formato_money($saldo4);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo5=moneda_mysql($entradas5)-moneda_mysql($salidas5);
				if($saldo5!=0) {
					echo formato_money($saldo5);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo6=moneda_mysql($entradas6)-moneda_mysql($salidas6);
				if($saldo6!=0) {
					echo formato_money($saldo6);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo7=moneda_mysql($entradas7)-moneda_mysql($salidas7);
				if($saldo7!=0) {
					echo formato_money($saldo7);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo8=moneda_mysql($entradas8)-moneda_mysql($salidas8);
				if($saldo8!=0) {
					echo formato_money($saldo8);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo9=moneda_mysql($entradas9)-moneda_mysql($salidas9);
				if($saldo9!=0) {
					echo formato_money($saldo9);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo10=moneda_mysql($entradas10)-moneda_mysql($salidas10);
				if($saldo10!=0) {
					echo formato_money($saldo10);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo11=moneda_mysql($entradas11)-moneda_mysql($salidas11);
				if($saldo11!=0) {
					echo formato_money($saldo11);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo12=moneda_mysql($entradas12)-moneda_mysql($salidas12);
				if($saldo12!=0) {
					echo formato_money($saldo12);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$saldo=moneda_mysql($entradas)-moneda_mysql($salidas);
				if($saldo!=0) {
					echo formato_money($saldo);
				}else{
					echo '&nbsp;';
				}
		?></td>
      </tr>
      <tr>
        <td colspan="14">&nbsp;</td>
        </tr>
      <tr class="salida_2">
        <td><span class="flujo_cat1">ACUMULADO</span></td>
        <td align="right"><?php 
		$acumulado1=$saldo1;
				if($acumulado1!=0) {
					echo formato_money($acumulado1);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado2=$acumulado1+$saldo2;
				if($acumulado2!=0) {
					echo formato_money($acumulado2);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado3=$acumulado2+$saldo3;
				if($acumulado3!=0) {
					echo formato_money($acumulado3);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado4=$acumulado3+$saldo4;
				if($acumulado4!=0) {
					echo formato_money($acumulado4);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado5=$acumulado4+$saldo5;
				if($acumulado5!=0) {
					echo formato_money($acumulado5);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado6=$acumulado5+$saldo6;
				if($acumulado6!=0) {
					echo formato_money($acumulado6);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado7=$acumulado6+$saldo7;
				if($acumulado7!=0) {
					echo formato_money($acumulado7);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado8=$acumulado7+$saldo8;
				if($acumulado8!=0) {
					echo formato_money($acumulado8);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado9=$acumulado8+$saldo9;
				if($acumulado9!=0) {
					echo formato_money($acumulado9);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado10=$acumulado9+$saldo10;
				if($acumulado10!=0) {
					echo formato_money($acumulado10);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado11=$acumulado10+$saldo11;
				if($acumulado11!=0) {
					echo formato_money($acumulado11);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado12=$acumulado11+$saldo12;
				if($acumulado12!=0) {
					echo formato_money($acumulado12);
				}else{
					echo '&nbsp;';
				}
		?></td>
        <td align="right"><?php 
		$acumulado=$acumulado12;
				if($acumulado!=0) {
					echo formato_money($acumulado);
				}else{
					echo '&nbsp;';
				}
		?></td>
      </tr>
      <tr>
        <td colspan="14">&nbsp;</td>
        </tr>
    </table>
    </td>
  </tr>
</table>
        </div>