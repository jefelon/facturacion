<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../formatos/formatos.php");

require_once("../cuentas/cCuenta.php");
$oCuenta = new cCuenta();
require_once("../cuentas/cSubcuenta.php");
$oSubcuenta = new cSubcuenta();
require_once ("cFlujo.php");
$oFlujo = new cFlujo();
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../gasto/cGasto.php");
$oGasto = new cGasto();
require_once ("../form/cForm.php");
$oForm = new cForm();

//para la consulta de elementos y cuentas order by por orden
$oby='ord';

//empresa 
$emp=$_POST['emp'];

//año
$anio=$_POST['anio'];

//meses
$m1='1';
$m2='2';
$m3='3';
$m4='4';
$m5='5';
$m6='6';
$m7='7';
$m8='8';
$m9='9';
$m10='10';
$m11='11';
$m12='12';
$m='0';

//Suma_Flujo

//ingresos
	$rws=$oForm->mostrarTodos_des('Ingresos','Suma_Flujo');
	$rw = mysql_fetch_array($rws);
$est_ing=$rw['tb_form_des'];
	mysql_free_result($rws);

//gastos
	$rws=$oForm->mostrarTodos_des('Gastos','Suma_Flujo');
	$rw = mysql_fetch_array($rws);
$est_gas=$rw['tb_form_des'];
	mysql_free_result($rws);

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
		closeText: '<div align="right"><img src="../../js/cluetip/demo/cross.png" alt="close" /></div>'
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
		closeText: '<div align="right"><img src="../../js/cluetip/demo/cross.png" alt="close" /></div>'
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
      <tr class="entrada_1">
        <td colspan="14"><span class="flujo_cat1">ENTRADAS</span></td>
        </tr>
      <tr>
        <td colspan="14">&nbsp;</td>
        </tr>
        <?php
		//consulta de cuenta
		$ele=1;
		$dts1=$oCuenta->mostrarTodos_oby($ele,$oby);
        while($dt1 = mysql_fetch_array($dts1)){
			
			//consulta de subcuenta
        	$dts2=$oSubcuenta->mostrarTodos_cue_oby($dt1['tb_cuenta_id'],$oby);
			$num_filas_cuenta=mysql_num_rows($dts2);
			
			if($num_filas_cuenta>0){
		?>
      <tr class="salida_2">
        <td colspan="14"><span class="flujo_cat2"><?php echo $dt1['tb_cuenta_des']?></span></td>
        </tr>
		<?php
			}
        while($dt2 = mysql_fetch_array($dts2)){	  
        ?>    
      <tr class="salida_3">
        <td><span class="flujo_cat3"><?php echo $dt2['tb_subcuenta_des']?></span></td>
        <td align="right">
        	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m1.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m1,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
           	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m2.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m2,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m3.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m3,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m4.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m4,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m5.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m5,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m6.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m6,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m7.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m7,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m8.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m8,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m9.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m9,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m10.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m10,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m11.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m11,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m12.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m12,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m.'&est='.ereg_replace("'","",$est_ing)?>">
        	<?php
            $dts3=$oFlujo->ingreso_suma_subcue($emp,$anio,$m,$dt2['tb_subcuenta_id'],$est_ing);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['ingreso_suma_subcue']!="") {
					echo $dt3['ingreso_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
      </tr>
         <?php
		 //fin de la consulta cuenta
		 }
		 mysql_free_result($dts2);
		 ?>      
      <tr class="<?php 
		if($num_filas_cuenta>0){
			echo 'salida_4';
		}else{
			echo 'salida_2';
		}
		?>">
        <td><span class="<?php 
		if($num_filas_cuenta>0){
			echo 'flujo_cat4';
		}else{
			echo 'flujo_cat2';
		}
		?>">
		<?php 
		if($num_filas_cuenta>0){
			echo 'TOTAL';
		}else{
			echo $dt1['tb_cuenta_des'];
		}
		?></span>
        </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m1.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m1,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m2.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m2,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m3.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m3,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m4.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m4,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m5.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m5,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m6.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m6,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m7.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m7,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m8.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m8,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m9.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m9,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m10.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m10,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m11.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m11,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m12.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m12,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
			<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts4=$oFlujo->ingreso_suma_cue($emp,$anio,$m,$dt1['tb_cuenta_id'],$est_ing);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['ingreso_suma_cue']!="") {
					echo $dt4['ingreso_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
      </tr>
      <tr>
        <td colspan="14">&nbsp;</td>
        </tr>
       <?php
	   // fin de la consulta de elemento
	   }
	   mysql_free_result($dts1);
	   ?>
       <tr class="entrada_5">
        <td><span class="flujo_cat5">TOTAL ENTRADAS</span></td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m1.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m1,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas1=$dt5['ingreso_suma_mes'];
				}else{
					$entradas1=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m2.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m2,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas2=$dt5['ingreso_suma_mes'];
				}else{
					$entradas2=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m3.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m3,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas3=$dt5['ingreso_suma_mes'];
				}else{
					$entradas3=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m4.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m4,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas4=$dt5['ingreso_suma_mes'];
				}else{
					$entradas4=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m5.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m5,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas5=$dt5['ingreso_suma_mes'];
				}else{
					$entradas5=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m6.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m6,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas6=$dt5['ingreso_suma_mes'];
				}else{
					$entradas6=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m7.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m7,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas7=$dt5['ingreso_suma_mes'];
				}else{
					$entradas7=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m8.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m8,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas8=$dt5['ingreso_suma_mes'];
				}else{
					$entradas8=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m9.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m9,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas9=$dt5['ingreso_suma_mes'];
				}else{
					$entradas9=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m10.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m10,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas10=$dt5['ingreso_suma_mes'];
				}else{
					$entradas10=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m11.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m11,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas11=$dt5['ingreso_suma_mes'];
				}else{
					$entradas11=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m12.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m12,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas12=$dt5['ingreso_suma_mes'];
				}else{
					$entradas12=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-ingresos" id="ingresos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m.'&est='.ereg_replace("'","",$est_ing)?>">
			<?php
            $dts5=$oFlujo->ingreso_suma_mes($emp,$anio,$m,$est_ing);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['ingreso_suma_mes']!="") {
					echo $entradas=$dt5['ingreso_suma_mes'];
				}else{
					$entradas=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
       </tr>
      <tr>
        <td colspan="14">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="14">&nbsp;</td>
      </tr>
      <tr class="salida_1">
        <td colspan="14"><span class="flujo_cat1">SALIDAS</span></td>
        </tr>
      <tr>
        <td colspan="14">&nbsp;</td>
        </tr>
        <?php
		//consulta de cuenta
		$ele=2;
		$dts1=$oCuenta->mostrarTodos_oby($ele,$oby);
        while($dt1 = mysql_fetch_array($dts1)){
		?>
      <tr class="salida_2">
        <td colspan="14"><span class="flujo_cat2"><?php echo $dt1['tb_cuenta_des']?></span></td>
        </tr>
		<?php
		//consulta de subcuenta
        $dts2=$oSubcuenta->mostrarTodos_cue_oby($dt1['tb_cuenta_id'],$oby);
        while($dt2 = mysql_fetch_array($dts2)){	  
        ?>    
      <tr class="salida_3">
        <td><span class="flujo_cat3"><?php echo $dt2['tb_subcuenta_des']?></span></td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m1.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m1,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
           	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m2.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m2,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m3.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m3,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m4.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m4,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m5.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m5,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m6.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m6,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m7.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m7,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m8.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m8,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m9.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m9,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m10.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m10,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m11.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m11,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m12.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m12,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
        <td align="right">
            <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue='.$dt2['tb_subcuenta_id'].'&emp='.$emp.'&a='.$anio.'&m='.$m.'&est='.ereg_replace("'","",$est_gas)?>">
        	<?php
            $dts3=$oFlujo->gasto_suma_subcue($emp,$anio,$m,$dt2['tb_subcuenta_id'],$est_gas);
			$dt3 = mysql_fetch_array($dts3);
				if($dt3['gasto_suma_subcue']!="") {
					echo $dt3['gasto_suma_subcue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts3);
			?>
            </span>
        </td>
      </tr>
         <?php
		 //fin de la consulta cuenta
		 }
		 mysql_free_result($dts2);
		 ?>      
      <tr class="salida_4">
        <td><span class="flujo_cat4">TOTAL</span></td>
        <td align="right">
			<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m1.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m1,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m2.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m2,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m3.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m3,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m4.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m4,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m5.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m5,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m6.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m6,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m7.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m7,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m8.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m8,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right"><span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m9.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m9,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span></td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m10.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m10,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m11.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m11,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m12.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m12,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
        <td align="right">
        <span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue='.$dt1['tb_cuenta_id'].'&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts4=$oFlujo->gasto_suma_cue($emp,$anio,$m,$dt1['tb_cuenta_id'],$est_gas);
			$dt4 = mysql_fetch_array($dts4);
				if($dt4['gasto_suma_cue']!="") {
					echo $dt4['gasto_suma_cue'];
				}else{
					echo '&nbsp;';
				}
			mysql_free_result($dts4);
			?>
            </span>
            </td>
      </tr>
      <tr>
        <td colspan="14">&nbsp;</td>
        </tr>
       <?php
	   // fin de la consulta de elemento
	   }
	   mysql_free_result($dts1);
	   ?>
       <tr class="salida_5">
         <td><span class="flujo_cat5">TOTAL SALIDAS</span></td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m1.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m1,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas1=$dt5['gasto_suma_mes'];
				}else{
					$salidas1=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m2.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m2,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas2=$dt5['gasto_suma_mes'];
				}else{
					$salidas2=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m3.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m3,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas3=$dt5['gasto_suma_mes'];
				}else{
					$salidas3=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m4.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m4,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas4=$dt5['gasto_suma_mes'];
				}else{
					$salidas4=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m5.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m5,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas5=$dt5['gasto_suma_mes'];
				}else{
					$salidas5=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m6.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m6,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas6=$dt5['gasto_suma_mes'];
				}else{
					$salidas6=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m7.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m7,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas7=$dt5['gasto_suma_mes'];
				}else{
					$salidas7=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m8.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m8,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas8=$dt5['gasto_suma_mes'];
				}else{
					$salidas8=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m9.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m9,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas9=$dt5['gasto_suma_mes'];
				}else{
					$salidas9=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m10.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m10,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas10=$dt5['gasto_suma_mes'];
				}else{
					$salidas10=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m11.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m11,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas11=$dt5['gasto_suma_mes'];
				}else{
					$salidas11=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m12.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m12,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas12=$dt5['gasto_suma_mes'];
				}else{
					$salidas12=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
         <td align="right">
		 	<span class="tip-gastos" id="gastos_detalle.php<?php echo '?cue=0&subcue=0&emp='.$emp.'&a='.$anio.'&m='.$m.'&est='.ereg_replace("'","",$est_gas)?>">
			<?php
            $dts5=$oFlujo->gasto_suma_mes($emp,$anio,$m,$est_gas);
			$dt5 = mysql_fetch_array($dts5);
				if($dt5['gasto_suma_mes']!="") {
					echo $salidas=$dt5['gasto_suma_mes'];
				}else{
					$salidas=0;
					echo '&nbsp;';
				}
			mysql_free_result($dts5);
			?>
            </span>
            </td>
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
      <tr class="acumulado_1">
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