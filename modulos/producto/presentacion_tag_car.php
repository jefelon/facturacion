<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../atributo/cAtributo.php");
$oAtributo = new cAtributo();
require_once ("../formatos/formato.php");

//agregar a cesta
if($_POST['action']=='agregar')
{
	if($_POST['cmb_atr_id']>0)
	{
			$dts1=$oAtributo->mostrar_atributo_valor($_POST['cmb_atr_id']);
			$dt1 = mysql_fetch_array($dts1);
		$atr_id	=$dt1['tb_atributo_id'];
		$atr_idp=$dt1['tb_atributo_idp'];
			mysql_free_result($dts1);
		
		//$_SESSION['atributo_car'][$_POST['cmb_atr_id']]=$_POST['cmb_atr_id'];
		$_SESSION['atributo_car'][$atr_idp]=$atr_id;
	}
}

//quitar valores del array
if($_POST['action']=='quitar')
{
	unset($_SESSION['atributo_car'][$_POST['cmb_atr_id']]);
}

//restablecer o eliminar array
if($_POST['action']=='restablecer')
{
	unset($_SESSION['atributo_car']);
}

//numero de filas
if(isset($_SESSION['atributo_car']))
{
	$num_rows=count($_SESSION['atributo_car']);
	if($num_rows==0)$num_rows="";
}
else
{
	$num_rows="";
}
?>
<script type="text/javascript">
$(function() {
	$('.btn_rest_car').button({
		icons: {
			//primary: "ui-icon-cart"//,
            secondary: "ui-icon-cart"
		},
		text: true
	});
	
	$('.btn_agregar').button({
		icons: {
			primary:  "ui-icon-plus"
		},
		text: false
	});
	
	$('.btn_quitar').button({
		icons: {primary: "ui-icon-minus"},
		text: false
	});
	
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_atributo_car").tablesorter({ 
		headers: {
			2: {sorter: false }
			},
		//sortForce: [[0,0]],
		//sortList: [[0,0]]
    });

}); 
</script>
<input name="hdd_tra_numite" id="hdd_tra_numite" type="hidden" value="<?php echo $num_rows?>">
<a id="btn_tag_car_form" class="btn_agregar" href="#" onClick="tag_car_form('agregar')" title="Agregar Atributo">Agregar</a>
<!--<a class="btn_rest_car" href="#" onClick="presentacion_tag_car('restablecer')">Vaciar</a>-->
<div id="msj_atributo_car" class="ui-state-error ui-corner-all" style="width:auto; float:right; padding:2px; display:<?php if($msj!=""){echo 'block';} else{ echo 'none';}?>"><?php echo $msj?></div>
<div id="msj_tag_car_form" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
<?php 
	//if($num_rows=="" or $num_rows==0)echo 'Ningún item agregado.';
//	if($num_rows==1)echo $num_rows.' item agregado.';
//	if($num_rows>=2)echo $num_rows.' items agregados.';
?>
<?php
if($num_rows>=1){
?>
        <table cellspacing="1" id="tabla_atributo_car" class="tablesorter">
            <thead>
                <tr>
                  <th>Atributo</th>
                  <th>Valor</th>
                    <th width="25">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php
			foreach($_SESSION['atributo_car'] as $indice=>$valor){			
				$dts1=$oAtributo->mostrar_atributo_valor($valor);
				$dt1 = mysql_fetch_array($dts1);
			?>
                        <tr>
                          <td><?php echo $dt1['atributo']?></td>
                          <td><?php echo $dt1['valor']?></td>
                            <td align="center"><a class="btn_quitar" href="#" onClick="presentacion_tag_car('quitar','<?php echo $indice?>')">Quitar</a></td>
                        </tr>
            <?php
                mysql_free_result($dts1);
			}	
            ?>
            </tbody>
            <?php
}
else
{
?>
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                        </tr>
        </table>
<?php
}
?>