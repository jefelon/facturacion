<?php
require_once ("../../config/Cado.php");
require_once ("cCatalogo.php");
$oCatalogo = new cCatalogo();

$igv_dato=0.18;
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");


if(isset($_POST['pro_cat']) and $_POST['pro_cat']>0)
{
	$dc=$_POST['pro_cat'].'';
	
	$dts2=$oCategoria->mostrar_por_idp($_POST['pro_cat']);
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

$dts1=$oCatalogo->catalogo_compra_filtro($_POST['pro_nom'],$_POST['pro_cod'],$dc,$_POST['pro_mar'],$_POST['pro_est']);
$num_rows= mysql_num_rows($dts1);
?>
<script type="text/javascript">

$('.moneda').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.00',
	vMax: '9999.99'
});
$('.cantidad').autoNumeric({
	aSep: ',',
	aDec: '.',
	vMin: '1',
	vMax: '999'
});

function cantidad(act,idf)
{
	var can=($('#txt_cat_can_'+idf).val())*1;
	//var sto=($('#hdd_cat_stouni_'+idf).val())*1;
	var valor=0;
	var sum=1;
	
	if(act=='mas')
	{
		valor=can+sum;
		if(valor<=999)$('#txt_cat_can_'+idf).val(valor);
	}
	
	if(act=='menos')
	{
		valor=can-sum;
		if(valor>=1)$('#txt_cat_can_'+idf).val(valor);
	}
}

$('.btn_agregar').button({
	icons: {
		//primary: "ui-icon-plusthick",
		secondary:"ui-icon-cart"
	},
	text: true
});

$('.btn_mas').button({
	icons: {
		primary: "ui-icon-plus"
	},
	text: false
});
$('.btn_menos').button({
	icons: {
		primary: "ui-icon-minus"
	},
	text: false
});

$(".btn_mas").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });
$(".btn_menos").css({width: "16px", height: "14px", 'vertical-align':"buttom", padding: "0 0 3px 0" });

$(document).ready(function() {	
	$("#tabla_producto").tablesorter({
		widgets: ['zebra', 'zebraHover'] ,
		widthFixed: true,
		headers: {
			7: {sorter: false }, 
			8: { sorter: false}
			},
		//sortForce: [[0,0]],
		sortList: [[1,0]]
    });

}); 
</script>

        <table cellspacing="1" id="tabla_producto" class="tablesorter">
            <thead>
                <tr>
                  <th>CODIGO</th>
                  <th>NOMBRE</th>
                    
                  <th width="110" align="center">CANTIDAD</th>                  
                    <th width="50">&nbsp;</th>
                </tr>
            </thead>
			<?php
            if($num_rows>=1){
            ?>
            <tbody>
                <?php
					while($dt1 = mysql_fetch_array($dts1)){?>
                        <tr>
                            <td><?php echo $dt1['tb_presentacion_cod']?></td>
                            <td>
							<?php 
							echo '<strong>'.$dt1['tb_producto_nom'].'</strong>';
							?></td>                            
                                                     
                            <td align="center">
                            <input name="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" type="text" id="txt_cat_can_<?php echo $dt1['tb_catalogo_id']?>" class="cantidad" value="1" size="5" maxlength="6" style="text-align:right">
                            <a class="btn_mas" href="#mas" onClick="cantidad('mas','<?php echo $dt1['tb_catalogo_id']?>')">Aumentar</a>
                            <a class="btn_menos" href="#menos" onClick="cantidad('menos','<?php echo $dt1['tb_catalogo_id']?>')">Disminuir</a>
                            </td>                           
                            <td align="center"><a class="btn_agregar" href="#" onClick="guia_car('agregar','<?php echo $dt1['tb_catalogo_id']?>')">Agregar</a></td>
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
                  <td colspan="8"><?php echo $num_rows.' registros'?></td>
                </tr>
        </table>
