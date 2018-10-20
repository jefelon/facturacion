<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once ("../servicio/cServicio.php");
$oServicio = new cServicio();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");


if(isset($_POST['ser_cat']) and $_POST['ser_cat']>0)
{
	$dc=$_POST['ser_cat'].'';
	
	$dts2=$oCategoria->mostrar_por_idp($_POST['ser_cat']);
	$num_rows2= mysql_num_rows($dts2);
	if($num_rows2>0){
		while($dt2 = mysql_fetch_array($dts2)){
			
			$dc.=', '.$dt2['tb_categoria_id'];
			
			$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
			$num_rows3= mysql_num_rows($dts3);
			if($num_rows3>0){
				while($dt3 = mysql_fetch_array($dts3)){
					$dc.=', '.$dt3['tb_categoria_id'];			
				}
			mysql_free_result($dts3);
			}//fin nivel 3
					
		}
	mysql_free_result($dts2);
	}//fin nivel 2

//echo $dc;			
}

$dts1=$oServicio->mostrar_filtro($_POST['ser_nom'], $dc, $_POST['ser_est'],$_POST['limit']);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">
$('.cat_ser_moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '99999.9999'
});
$('.cat_ser_cantidad').autoNumeric({
	aSep: ',',
	aDec: '.',
	vMin: '1',
	vMax: '999'
});

function cantidad2(act,idf){	
	var can=($('#txt_ser_can_'+idf).val())*1;
	//var sto=($('#hdd_ser_stouni_'+idf).val())*1;
	var valor=0;
	var sum=1;
	
	if(act=='mas')
	{
		valor=can+sum;
		$('#txt_ser_can_'+idf).val(valor);
	}
	
	if(act=='menos')
	{
		valor=can-sum;
		$('#txt_ser_can_'+idf).val(valor);
	}
}

$('.btn_mas2').button({
	icons: {
		primary: "ui-icon-plus"
	},
	text: false
});
$('.btn_menos2').button({
	icons: {
		primary: "ui-icon-minus"
	},
	text: false
});

$(".btn_mas2").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });
$(".btn_menos2").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$('.btn_presentacion').button({
	icons: {primary: "ui-icon-clipboard"},
	text: false
});
$('.btn_editar').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});

$('.btn_eliminar').button({
	icons: {primary: "ui-icon-trash"},
	text: false
});

$(function() {
	$("#tabla_servicio").tablesorter({
		widgets : ['zebra'],
		headers: {
			4: {sorter: 'shortDate' },
			7: {sorter: false }, 
			8: { sorter: false}
			},
		//sortForce: [[0,0]],
		<?php if($num_rows>0){?>
		sortList: [[0,0]]
		<?php }?>
    });
	
	$( ".rad_tip_des2" ).buttonset();
	
	$('.btn_agregar2').button({
	icons: {
		//primary: "ui-icon-plusthick",
		secondary:"ui-icon-cart"
	},
	text: true
});
}); 
</script>

        <table cellspacing="1" id="tabla_servicio" class="tablesorter">
            <thead>
                <tr>
                    <th>NOMBRE</th>
                    <th>DESCRIPCION</th>
                    <th>CATEGORIA</th>
                    <th align="right">PRECIO S/.</th>                    
                    <th align="center">CANTIDAD</th> 
                    <!--th align="center">DESCUENTO</th-->  
                    <th align="center">TIPO</th>                                                            
                    <th>&nbsp;</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){?>
                        <tr>
                            <td><input type="hidden" id="hdd_ser_nom_<?php echo $dt1['tb_servicio_id']?>" value="<?php echo $dt1['tb_servicio_nom']?>" /><?php echo $dt1['tb_servicio_nom']?></td>
                            <td><?php echo $dt1['tb_servicio_des']?></td>
                            <td><?php echo $dt1['tb_categoria_nom']?></td>
                            <td align="right"><input type="text" name="txt_servicio_pre_<?php echo $dt1['tb_servicio_id']?>" id="txt_servicio_pre_<?php echo $dt1['tb_servicio_id']?>" value="<?php echo formato_money($dt1['tb_servicio_pre'])?>" size="8" maxlength="8" style="text-align:right; font-size:10px; font-weight:bold" class="cat_ser_moneda" /></td>                            
                            <td align="center" style="width:120px">
                            <input name="txt_ser_can_<?php echo $dt1['tb_servicio_id']?>" type="text" id="txt_ser_can_<?php echo $dt1['tb_servicio_id']?>" class="cat_ser_cantidad" value="1" size="5" maxlength="6" style="text-align:right">
                            <a class="btn_mas2" href="#mas" onClick="cantidad2('mas','<?php echo $dt1['tb_servicio_id']?>')">Aumentar</a>
                            <a class="btn_menos2" href="#menos" onClick="cantidad2('menos','<?php echo $dt1['tb_servicio_id']?>')">Disminuir</a>
                            </td>
                            <?php /*
                            <td align="left" style="width:130px">
                            <!--Descuento del servicio (este valor va en el Detalle Venta)-->
                            <div id="rad_ser_tip_des_<?php echo $dt1['tb_servicio_id']?>" class="rad_tip_des2" style="width:75px; float:left">
                              <label for="rad_ser_tip_des_1_<?php echo $dt1['tb_servicio_id']?>">%</label>
                              <input name="rad_ser_tip_des_<?php echo $dt1['tb_servicio_id']?>" type="radio" id="rad_ser_tip_des_1_<?php echo $dt1['tb_servicio_id']?>" value="1" checked />
                              <label for="rad_ser_tip_des_2_<?php echo $dt1['tb_servicio_id']?>">S/.</label>
                              <input name="rad_ser_tip_des_<?php echo $dt1['tb_servicio_id']?>" type="radio" id="rad_ser_tip_des_2_<?php echo $dt1['tb_servicio_id']?>" value="2" />
                            </div>
                            <div style="width:30px; float:left;"><input type="text" name="txt_ser_detven_des_<?php echo $dt1['tb_servicio_id']?>" id="txt_ser_detven_des_<?php echo $dt1['tb_servicio_id']?>" class="moneda" size="6" maxlength="8" style="text-align:right"></div>
                            </td>
							*/ ?>
                            <td align="left">
		                    	<select id="cmb_detven_tip_<?php echo $dt1['tb_servicio_id']?>" style="width:43px">
		                    		<option value="1" selected>Gravado</option>
<!--		                    		<option value="2">Premio</option>-->
<!--		                    		<option value="3">Donación</option>-->
<!--		                    		<option value="4">Retiro</option>-->
<!--		                    		<option value="5">Publicidad</option>-->
<!--		                    		<option value="6">Bonificación</option>-->
<!--		                    		<option value="7">Entrega a trabajadores</option>-->
		                    	</select>
		                    </td>

	                        <td align="center">                         
                            
                            <a class="btn_agregar2" href="#" onClick="compra_car_servicio('agregar_servicio','<?php echo $dt1['tb_servicio_id']?>')">Agregar</a>
                            
                            </td>                                                        
                        </tr>
                <?php
                	}
                mysql_free_result($dts1);
                ?>
                </tbody>
                <tr class="even">
                  <td colspan="7"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
