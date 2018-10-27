<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../formatos/formato.php");

$igv_dato=0.18;

//agregar a cesta
if($_POST['action']=='agregar')
{
//	if($_POST['cat_can']>0)
//	{
			//IDENTIFICADOR CATALOGO Y CANTIDAD			
			$_SESSION['lote_car'][$_POST['cat_id']][$_POST['txt_lote_num']]=$_POST['txt_lote_num'];
            $_SESSION['lote_fecfab'][$_POST['cat_id']][$_POST['txt_lote_num']]=$_POST['txt_lote_fecfab'];
            $_SESSION['lote_fecven'][$_POST['cat_id']][$_POST['txt_lote_num']]=$_POST['txt_lote_fecven'];
            $_SESSION['lote_sto_num'][$_POST['cat_id']][$_POST['txt_lote_num']]=$_POST['txt_lote_sto_num'];
            $_SESSION['lote_estado'][$_POST['cat_id']][$_POST['txt_lote_num']]=1;
            $_SESSION['lote_can'][$_POST['cat_id']][$_POST['txt_lote_num']]=$_POST['txt_lote_cant'];
//	}
}

if($_POST['action']=='editar')
{
//	if($_POST['cat_can']>0)
//	{
    //IDENTIFICADOR CATALOGO Y CANTIDAD
    $_SESSION['lote_car'][$_POST['cat_id']][$_POST['txt_lote_num']]=$_POST['txt_lote_num'];
    $_SESSION['lote_fecfab'][$_POST['cat_id']][$_POST['txt_lote_num']]=$_POST['txt_lote_fecfab'];
    $_SESSION['lote_fecven'][$_POST['cat_id']][$_POST['txt_lote_num']]=$_POST['txt_lote_fecven'];
    $_SESSION['lote_sto_num'][$_POST['cat_id']][$_POST['txt_lote_num']]=$_POST['txt_lote_sto_num'];
    $_SESSION['lote_estado'][$_POST['cat_id']][$_POST['txt_lote_num']]=1;
    $_SESSION['lote_can'][$_POST['cat_id']][$_POST['txt_lote_num']]=$_POST['txt_lote_cant'];
//	}
}

//quitar valores del array
if($_POST['action']=='quitar')
{
    unset($_SESSION['lote_car'][$_POST['cat_id']][$_POST['txt_lote_num']]);
    unset($_SESSION['lote_fecfab'][$_POST['cat_id']][$_POST['txt_lote_num']]);
    unset($_SESSION['lote_fecven'][$_POST['cat_id']][$_POST['txt_lote_num']]);
    unset($_SESSION['lote_sto_num'][$_POST['cat_id']][$_POST['txt_lote_num']]);
    unset($_SESSION['lote_estado'][$_POST['cat_id']][$_POST['txt_lote_num']]);
    unset($_SESSION['lote_can'][$_POST['cat_id']][$_POST['txt_lote_num']]);
}

//restablecer o eliminar array
if($_POST['action']=='restablecer')
{
	unset($_SESSION['lote_car']);
    unset($_SESSION['lote_fecfab']);
    unset($_SESSION['lote_fecven']);
    unset($_SESSION['lote_sto_num']);
    unset($_SESSION['lote_estado']);
    unset($_SESSION['lote_can']);
}

if(isset($_SESSION['lote_car']))
{
	$num_rows=count($_SESSION['lote_car']);
	if($num_rows==0)$num_rows="";
	
	//total de las cantidades
//	foreach($_SESSION['lote_car'][$_POST['cat_id']] as $indice=>$linea_cantidad){
//		$total_cantidad+=$linea_cantidad;
//	}
}
else
{
	$num_rows="";
}
?>
<script type="text/javascript">
$('.moneda2').autoNumeric({
	aSep: ',',
	aDec: '.',
	//aSign: 'S/. ',
	//pSign: 's',
	vMin: '0.0000',
	vMax: '9999.9999'
});

$('.btn_quitar').button({
	icons: {primary: "ui-icon-minus"},
	text: false
});
	
$('.btn_item').button({
	icons: {primary: "ui-icon-pencil"},
	text: false
});


$('.btn_agregar_lote').button({
    text: true
});

$(function() {
	$("#tabla_lote_car").tablesorter({
		widgets : ['zebra']
    });

}); 
</script>
<input name="hdd_com_numite" id="hdd_com_numite" type="hidden" value="<?php echo $num_rows?>">
<table cellspacing="1" id="tabla_lote_car" class="tablesorter">
    <thead>
    <tr>
        <th>LOTE</th>
        <th>FECHA FABRICACION</th>
        <th>FECHA VENCIMIENTO</th>
        <th>STOCK</th>
        <th>CANTIDAD</th>
        <th align="center">ESTADO</th>
        <th align="center">&nbsp;</th>
    </tr>
    </thead>
<?php
if($num_rows>0){
?>
            <tbody>
            <?php
			foreach($_SESSION['lote_car'][$_POST['cat_id']] as $indice=>$linea_cantidad){
				?>
                        <tr>
                            <td align="right"><?php echo $_SESSION['lote_car'][$_POST['cat_id']][$indice]?></td>
                            <td><?php echo mostrarFecha($_SESSION['lote_fecfab'][$_POST['cat_id']][$indice])?></td>
                          	<td><?php echo mostrarFecha($_SESSION['lote_fecven'][$_POST['cat_id']][$indice])?></td>
                            <td><?php echo $_SESSION['lote_sto_num'][$_POST['cat_id']][$indice]?></td>
                            <td align="right"><?php echo $_SESSION['lote_can'][$_POST['cat_id']][$indice]?></td>
                            <td align="right"><?php echo $_SESSION['lote_estado'][$_POST['cat_id']][$indice]?></td>
                            <td align="center" nowrap="nowrap">
                                <a class="btn_item" href="#" onClick="lote_venta_form('editar','<?php echo $_POST['cat_id']?>','<?php echo $_SESSION['lote_car'][$_POST['cat_id']][$indice]?>')">Editar Lote</a>
                                <a class="btn_quitar" href="#" onClick="lote_venta_car('quitar','<?php echo $_POST['cat_id']?>','<?php echo $_SESSION['lote_car'][$_POST['cat_id']][$indice] ?>')">Quitar</a>
                            </td>
                        </tr>
            <?php
			}	
            ?>
            </tbody>
<?php
}
else
{
?>
            <tr>
              <td colspan="6">&nbsp;</td>
              <!--<td>&nbsp;</td>-->
            </tr>
<?php
}
?>
        </table>
<input name="hdd_txt_cant" id="hdd_txt_cant" type="hidden" value="<?php echo $_POST['txt_cant']?>">
<br>
<div style="text-align: center;">
    <a class="btn_agregar_lote" onClick="lote_venta_form('agregar', <?php echo $_POST['cat_id'] ?>)">
        Agregar Lote
    </a>
</div>
<div id="msj_lote" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; <?php echo ($_POST['msj_lote']) ? 'display:block' : 'display:none';  ?> "><?php echo $_POST['msj_lote'] ?></div>

