<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../formatos/formato.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();

if($_POST['action']=="editar"){
	//consulta de datos			
	$dts1=$oCatalogoproducto->presentacion_catalogo($_POST['cat_id']);
	$dt1 = mysql_fetch_array($dts1);
	
	$cos		=$_SESSION['encarte_cos'][$_POST['cat_id']];
	$uti1		=$_SESSION['encarte_uti1'][$_POST['cat_id']];
	$preven1=$_SESSION['encarte_preven1'][$_POST['cat_id']];
	
	$despor	=$_SESSION['encarte_despor'][$_POST['cat_id']];
	$uti2		=$_SESSION['encarte_uti2'][$_POST['cat_id']];
	$preven2=$_SESSION['encarte_preven2'][$_POST['cat_id']];
	
	mysql_free_result($dts1);
}
?>

<script type="text/javascript">
$('.moneda_i').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9999.99'
});
$('.porcentaje_i').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99.99'
});

function calculo_precioventa_uti2(idf)
{
	var precos	=parseFloat($("#txt_item_precos").autoNumericGet());
	var uti2		=parseFloat($("#txt_item_uti2" ).autoNumericGet());
	var preven1	=parseFloat($("#txt_item_preven").autoNumericGet());
	
	if(uti2>=0)
	{
		var utilidad=uti2/100;
		var preven2=precos/(1-utilidad);
		$( "#txt_item_preven2").autoNumericSet(preven2.toFixed(1));
		
		//porcentaje
		var descuento=(1-preven2/preven1)*100;
		$( "#txt_item_despor").autoNumericSet(descuento.toFixed(2));
	}
	else
	{
		alert('Utilidad negativa.');
		$( "#txt_item_uti2").autoNumericSet(0);
		var utilidad=0/100;
		var calculo=precos/(1-utilidad);
		$( "#txt_item_preven2").autoNumericSet(calculo.toFixed(1));
	}
	
}

function calculo_precioventa_preven2(idf)
{
	var precos	=parseFloat($("#txt_item_precos").autoNumericGet());
	var preven2	=parseFloat($("#txt_item_preven2").autoNumericGet());
	var preven1	=parseFloat($("#txt_item_preven").autoNumericGet());
	
	if(preven2>0 && preven2>=precos)
	{
		//utilidad
		var calculo=(1-precos/preven2)*100;
		$( "#txt_item_uti2").autoNumericSet(calculo.toFixed(2));
		
		//porcentaje
		var descuento=(1-preven2/preven1)*100;
		$( "#txt_item_despor").autoNumericSet(descuento.toFixed(2));
	}
	else
	{
		alert('Precio de Venta Calculado debe ser mayor que Precio Costo.');
		
		$( "#txt_item_uti2").autoNumericSet(0);
		var utilidad=0/100;
		
		var preven2=precos/(1-utilidad);
		$("#txt_item_preven2").autoNumericSet(preven2.toFixed(1));
		
		//porcentaje
		var descuento=(1-preven2/preven1)*100;
		$( "#txt_item_despor").autoNumericSet(descuento.toFixed(2));
	}
	
}

function calculo_precioventa_despor(idf)
{
	var precos	=parseFloat($("#txt_item_precos").autoNumericGet());
	var preven1	=parseFloat($("#txt_item_preven").autoNumericGet());
	var uti1		=parseFloat($("#txt_item_uti" ).autoNumericGet());
	var despor	=parseFloat($("#txt_item_despor" ).autoNumericGet());
	
	if(despor>=0 && despor<=uti1)
	{
		//precioventa
		var preven2=(1-despor/100)*preven1;
		$( "#txt_item_preven2").autoNumericSet(preven2.toFixed(2));
		
		//utilidad
		var calculo=(1-precos/preven2)*100;
		$( "#txt_item_uti2").autoNumericSet(calculo.toFixed(2));

	}
	else
	{
		alert('Precio de Venta Calculado debe ser mayor que Precio Costo.');
		
		$( "#txt_item_uti2").autoNumericSet(0);
		var utilidad=0/100;
		
		var preven2=precos/(1-utilidad);
		$("#txt_item_preven2").autoNumericSet(preven2.toFixed(1));
		
		//porcentaje
		var descuento=(1-preven2/preven1)*100;
		$( "#txt_item_despor").autoNumericSet(descuento.toFixed(2));
	}
	
}

$(function() {
	$("#for_item").validate({
		submitHandler: function() {
			$.ajax({
				type: "POST",
				url: "../encarte/encarte_car_item_reg.php",
				async:true,
				dataType: "json",
				data: $("#for_item").serialize(),
				beforeSend: function(){
					$('#div_item_form').dialog("close");
					$('#msj_encarte_car_item').html("Cargando...");
					$('#msj_encarte_car_item').show(100);				
				},
				success: function(data){
					$('#msj_encarte_car_item').html(data.ite_msj);
				},
				complete: function(){
					encarte_car('actualizar');			
				}
			});			
		},
		rules: {
			txt_item_preven2: {
				required: true
			}
		},
		messages: {
			txt_item_preven2: {
				required: '*'
			}
		}
	});		
});
</script>
<div>
<?php echo $_POST['pro_nom']?>
</div>
<hr>
<form id="for_item">
<input name="action_item" id="action_item" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_catalogo_id" id="hdd_catalogo_id" type="hidden" value="<?php echo $_POST['cat_id']?>">

    <table>
    	<tr>
    	  <td>COSTO S/.</td>
    	  <td><input name="txt_item_precos" type="text" id="txt_item_precos" value="<?php if($cos!=0)echo formato_money($cos)?>" size="7" maxlength="8" style="text-align:right" readonly></td>
  	  </tr>
    	<tr>
    	  <td>UTI% | P.  VENTA S/.</td>
    	  <td><input name="txt_item_uti" type="text" id="txt_item_uti" style="text-align:right" onChange="calculo_precioventa_uti('<?php echo $_POST['cat_id']?>')" value="<?php if($uti1!=0) echo $uti1?>" size="6" maxlength="5" readonly>
        <input name="txt_item_preven" type="text" id="txt_item_preven" style="text-align:right" onChange="calculo_precioventa_preven('<?php echo $_POST['cat_id']?>')" value="<?php if($preven1!=0) echo formato_money($preven1)?>" size="7" maxlength="8" readonly></td>
  	  </tr>
    	<tr>
    	  <td>DSCTO %</td>
    	  <td><input type="text" name="txt_item_despor" id="txt_item_despor" class="porcentaje_i" value="<?php echo $despor?>" size="6" maxlength="5" style="text-align:right" onChange="calculo_precioventa_despor('<?php echo $_POST['cat_id']?>')"></td>
  	  </tr>
    	<tr>
            <td>UTI% | P.  VENTA. S/.</td>
          <td><input name="txt_item_uti2" type="text" id="txt_item_uti2" class="porcentaje_i" value="<?php echo formato_money($uti2)?>" size="6" maxlength="5" style="text-align:right" onChange="calculo_precioventa_uti2('<?php echo $_POST['cat_id']?>')">
          <input name="txt_item_preven2" type="text" id="txt_item_preven2" class="moneda_i" value="<?php echo formato_money($preven2)?>" size="7" maxlength="8" style="text-align:right" onChange="calculo_precioventa_preven2('<?php echo $_POST['cat_id']?>')"></td>
        </tr>
        
       
    </table>
</form>