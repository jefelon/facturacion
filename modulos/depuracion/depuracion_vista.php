<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();
require_once ("../formatos/formato.php");

require_once ("cDepuracion.php");
$oDepuracion = new cDepuracion();


if($_POST['btn_eliminar'])
{
	$lista=$_POST['chk_s'];
	if(count($lista)>0)
	{
		foreach($lista as $indice => $valor){
			$oBolpersonal->eliminar($valor);
		}
	}
	else
	{
		$alerta=1;
	}
}
if($_POST['btn_modificar'] and !empty($_POST['txt_fec']))
{
	$lista=$_POST['chk_s'];
	if(count($lista)>0)
	{
		$fec=fecha_mysql($_POST['txt_fec']);
		foreach($lista as $indice => $valor){
			$oBolpersonal->modificarFec($valor,$fec);
		}
	}
	else
	{
		$alerta=1;
	}
}
if($_POST['btn_modificar2'])
{
	echo $_POST['cmb_estb2'];
	$lista=$_POST['chk_s'];
	if(count($lista)>0)
	{
		foreach($lista as $indice => $valor){
			$oBolpersonal->modificarEst($valor,$_POST['cmb_estb2']);
		}
	}
	else
	{
		$alerta=1;
	}
}

//año
if($_POST['anio'])
{
	$_SESSION['bol_anio']=$_POST['anio'];
}

if(!isset($_SESSION['bol_anio']))
{
	$_SESSION['bol_anio']=date('Y');
}


//mes
if($_POST['mes'])
{
	$_SESSION['bol_mes']=$_POST['mes'];
}

if(!isset($_SESSION['bol_mes']))
{
	$_SESSION['bol_mes']=date('m');
}

//estado
if($_POST['cmb_est'])
{
	$_SESSION['bol_estado']=$_POST['cmb_est'];
}

if(!isset($_SESSION['bol_estado']))
{
	$_SESSION['bol_estado']='0';
}
//
if($_POST['cmb_est2'])
{
	$_SESSION['bol_estado2']=$_POST['cmb_est2'];
}

if(!isset($_SESSION['bol_estado2']))
{
	$_SESSION['bol_estado2']='0';
}

//campo
if($_GET['campo'])
{
	$campo=$_GET['campo'];
	if($_GET['ordn']==1)
	{
		$orden='ASC';
		$ordn=2;
	}
	if($_GET['ordn']==2)
	{
		$orden='DESC';
		$ordn=1;
	}

}
else{
	$campo='fec';
	$orden='ASC';
	$ordn=2;
}
$_SESSION['bol_campo']=$campo;
$_SESSION['bol_orden']=$orden;

$empresa=$_SESSION['empresa'];
$anio=$_SESSION['bol_anio'];
$mes=$_SESSION['bol_mes'];
$estado=$_SESSION['bol_estado'];
$estado2=$_SESSION['bol_estado2'];
$campo=$_SESSION['bol_campo'];
$orden=$_SESSION['bol_orden'];

//B1 en personal
$dts=$oDepuracion->mostrarTodos();
$num_reg=mysql_num_rows($dts);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Boletas</title>
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../../js/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
<script src="../../js/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/external/jquery.bgiframe-2.1.2.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.mouse.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.button.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.draggable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.position.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.resizable.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.dialog.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.effects.core.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.autocomplete.js"></script>

<script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="../../js/jquery-ui/development-bundle/ui/i18n/jquery.ui.datepicker-es.js"></script>

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script src="../../js/recursos.js" type="text/javascript"></script>

<script type="text/javascript" id="js">
function seleccionar_todo(){ 
	for (i=0;i<document.formBoletas.elements.length;i++) 
	if(document.formBoletas.elements[i].type == "checkbox")	
	 document.formBoletas.elements[i].checked=1 
}
function deseleccionar_todo(){ 
	for (i=0;i<document.formBoletas.elements.length;i++) 
	if(document.formBoletas.elements[i].type == "checkbox")	
	 document.formBoletas.elements[i].checked=0 
} 

/*function seleccionar_todo(check_box)
{
  for(var x=0;x<document.forms["formBoletas"].elements.length; x++)
  {
	var input=document.forms[0].elements[x];
	if(input.type=="checkbox")
	{
		input.checked=check_box.checked;
	}
  }
}
*/

 $(function() {
	 
	 $("#txt_fecbol").datepicker({
		minDate: "-1M", 
		maxDate:"+0D",
		yearRange: 'c-0:c+0',
		//changeMonth: true,
		//changeYear: true,
		dateFormat: 'dd-mm-yy',
		//altField: fecha,
		//altFormat: 'yy-mm-dd',
		//showOn: "button",
		buttonImage: "images/calendar.gif",
		buttonImageOnly: true
	});
	
	$("#txt_fec").datepicker({
		minDate: "-1M", 
		maxDate:"+0D",
		yearRange: 'c-0:c+0',
		//changeMonth: true,
		//changeYear: true,
		dateFormat: 'dd-mm-yy',
		//altField: fecha,
		//altFormat: 'yy-mm-dd',
		//showOn: "button",
		buttonImage: "images/calendar.gif",
		buttonImageOnly: true
	});
	 
	 
	 
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_sorter").tablesorter({ 
        headers: {0: {sorter: false },1: {sorter: 'text' },9: {sorter: false }, 10: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[2,0]]
    });
});
</script>
</head>

<body>
<div class="container">
	<header>
    	<?php echo $oContenido->print_header()?>
	</header>
    <article class="content">
    	<div class="contenido">
      	<section>
        	<div class="contenido_des">
            <table align="center" class="tabla_cont">
                  <tr>
                    <td colspan="2" class="caption_cont">BOLETAS</td>
                  </tr>
                  <tr>
                    <td colspan="2" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td colspan="2">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a title="Actualizar" href="../../vBoletas.php?action=refrescar"><img src="../../images/iconos/refresh.png" alt="Refrescar" width="20" height="20" border="0" /></a></td>
                      <td width="25" align="left" valign="middle"><a title="Actualizar" href="../../vBoletas.php?action=refrescar"></a></td>
                      <td align="left" valign="middle">&nbsp;</td>
                      <td align="right">
                      <?php
                switch ($_SESSION['alerta']) {
                    case 1:
                        echo '<span class="alerta_v">Se agregó correctamente.</span>';
                        break;
                    case 2:
                        echo '<span class="alerta_v">Se modificó correctamente.</span>';
                        break;
                    case 3:
                        echo '<span class="alerta_r">Se eliminó correctamente.</span>';
                        break;
                    case 4:
                        echo '<span class="alerta_r">No se pudo registrar, intentelo nuevamente.</span>';
                        break;
                    case 5:
                        echo '<span class="alerta_r">No se puede generar boletas, seleccione estado de personal, estado de boleta y fecha de boleta. Datos son obligatorios.</span>';
                        break;
                    case 6:
                        echo '<span class="alerta_v">Se generó boletas correctamente.</span>';
                        break;
					case 7:
                        echo '<span class="alerta_v">Se cargó PLANILLA PATRON correctamente.</span>';
                        break;
                    //default:
                        //echo "i is not equal to 0, 1 or 2";
                }
                unset($_SESSION['alerta']);
                    ?>
                    </td>
                    </tr>
                  </table>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <div>
                    <form id="form1" name="form1" method="post" action="">
                    <fieldset><legend>Mostrar Boletas</legend>
                    <table class="tabla_busqueda">
                    <tr>
                <td><img src="../../images/iconos/search.png" width="16" height="16" border="0" /></td>
                <td><select name="anio" id="anio">
                  <?php
            $rws=$oDepuracion->aniosBoleta();
            while($rw = mysql_fetch_array($rws))
            {
            ?>
                  <option value="<?php echo $rw['anio']?>" <?php if($rw['anio']==$anio)echo 'selected'?>><?php echo $rw['anio']?></option>
                  <?php 
            }
            mysql_free_result($rws);
            ?>
                </select></td>
                <td><label for="mes"></label>
                  <select name="mes" id="mes">
                    <option value="1" <?php if($mes==1)echo 'selected'?>>Enero</option>
                    <option value="2" <?php if($mes==2)echo 'selected'?>>Febrero</option>
                    <option value="3" <?php if($mes==3)echo 'selected'?>>Marzo</option>
                    <option value="4" <?php if($mes==4)echo 'selected'?>>Abril</option>
                    <option value="5" <?php if($mes==5)echo 'selected'?>>Mayo</option>
                    <option value="6" <?php if($mes==6)echo 'selected'?>>Junio</option>
                    <option value="7" <?php if($mes==7)echo 'selected'?>>Julio</option>
                    <option value="8" <?php if($mes==8)echo 'selected'?>>Agosto</option>
                    <option value="9" <?php if($mes==9)echo 'selected'?>>Setiembre</option>
                    <option value="10" <?php if($mes==10)echo 'selected'?>>Octubre</option>
                    <option value="11" <?php if($mes==11)echo 'selected'?>>Noviembre</option>
                    <option value="12" <?php if($mes==12)echo 'selected'?>>Diciembre</option>
                  </select></td>
                <td><select name="cmb_est" id="cmb_est">
                  <option value="00" <?php if($est==0)echo 'selected'?>>-</option>
                  <?php
            $rws=$oForm->mostrarTodos_des('Personal','Estado_Boleta');
            while($rw = mysql_fetch_array($rws))
            {
            ?>
                  <option value="<?php echo $rw['tb_form_des']?>" <?php if($rw['tb_form_des']==$estado)echo 'selected'?>><?php echo $rw['tb_form_des']?></option>
                  <?php 
            }
            mysql_free_result($rws);
            ?>
                </select></td>
                <td><select name="cmb_est2" id="cmb_est2">
                  <option value="00" <?php if($est2==0)echo 'selected'?>>-</option>
                  <?php
            $rws=$oForm->mostrarTodos_des('Personal','Estado');
            while($rw = mysql_fetch_array($rws))
            {
            ?>
                  <option value="<?php echo $rw['tb_form_des']?>" <?php if($rw['tb_form_des']==$estado2)echo 'selected'?>><?php echo $rw['tb_form_des']?></option>
                  <?php 
            }
            mysql_free_result($rws);
            ?>
                </select></td>
                <td>
                  <input name="btn_mostrar" type="submit" class="ButtonT" id="btn_mostrar" value="Mostrar" />
                </td>
              </tr>
              
            </table>
            </fieldset>
            </form>
                    </div>
                    </td>
                    <td align="right">
                    <div>
                    <form id="form2" name="form2" method="post" target="_blank" action="../../repBoletas.php">
                    <input name="btn_reporte" type="submit" class="ButtonT" value="Imprimir Boletas" />
                    </form>
                    </div>
                    </td>
                  </tr>
                  <tr>
                    <td height="20" valign="bottom"><a href="javascript:seleccionar_todo()">Marcar todos</a> | <a href="javascript:deseleccionar_todo()">Desmarcar</a></td>
                    <td align="right" valign="bottom"><?php
                switch ($alerta) {
                    case 1:
                        echo '<span class="alerta_r">Seleccione al menos una.</span>';
                        break;
                    case 2:
                        echo '<span class="alerta_v">Se modificó correctamente.</span>';
                        break;
                    case 3:
                        echo '<span class="alerta_r">Se eliminó correctamente.</span>';
                        break;
                    case 4:
                        echo '<span class="alerta_r">No se pudo registrar, intentelo nuevamente.</span>';
                        break;
                    case 5:
                        echo '<span class="alerta_r">No se puede generar boletas, seleccione estado de personal y estado de boleta.</span>';
                        break;
                    case 6:
                        echo '<span class="alerta_v">Se generó boletas correctamente.</span>';
                        break;
                    //default:
                        //echo "i is not equal to 0, 1 or 2";
                }
                unset($_SESSION['alerta']);
                    ?></td>
                  </tr>
              </table>
        	</div>
        </section>
        <section>
            <div class="contenido_tabla">
            <form action="" method="post" name="formBoletas">
            <fieldset><legend>Modificar</legend>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><input name="btn_eliminar" type="submit" class="ButtonT" id="btn_eliminar" value="Eliminar"></td>
    <td align="left">Modificar a:</td>
    <td align="left">Fecha Boleta: 
      <input name="txt_fec" type="text" id="txt_fec" value="<?php echo $fec?>" size="10" >
      <input name="btn_modificar" type="submit" class="ButtonT" id="btn_modificar" value="Modificar"></td>
    <td align="left">Estado Boleta:
      <select name="cmb_estb2" id="cmb_estb2">
        <option value="00" <?php if($est==0)echo 'selected'?>>-</option>
        <?php
            $rws=$oForm->mostrarTodos_des('Personal','Estado_Boleta');
            while($rw = mysql_fetch_array($rws))
            {
            ?>
        <option value="<?php echo $rw['tb_form_des']?>" <?php if($rw['tb_form_des']==$estbol)echo 'selected'?>><?php echo $rw['tb_form_des']?></option>
        <?php 
            }
            mysql_free_result($rws);
            ?>
        </select>
      <input name="btn_modificar2" type="submit" class="ButtonT" id="btn_modificar2" value="Modificar"></td>
    <td>&nbsp;</td>
  </tr>
  </table>
			</fieldset>
            <?php /*
            <fieldset><legend>Alerta</legend>
            Por error en adelantos, se corrigió boletas de:<br>
            <?php if($empresa==1){
				echo "
            GOICOCHEA MEDRANO JUVENCIO<br>
            NUÑEZ ALCOSER JOSE TANO<br>
			QUIJANO VELASQUEZ GUILLERMO NOLBERTO<br>
			QUIROGA VILLANUEVA JUAN ANTONIO<br>
			";
			}
			if($empresa==3){
				echo "
			GUTIERREZ VILLAR WILLIANS RAFAEL<br>
            PINEDO DE LA CRUZ JOSE EMIGDIO<br>
            ";
			}
			?>
            Si ya imprimió las boletas.
            Puede volver a imprimir individualmente sus boletas siguiendo el linck del <img src="Imagenes/edit.png" alt="Editar" width="14" height="14" border="0" /> de la boleta, luego imprimir.
            </fieldset>
			*/
			?>
            <table cellspacing="1" id="tabla_sorter" class="tablesorter" align="center">
        	<thead>
            <tr>
              <th><!--<label>
                <input type="checkbox" name="checkbox" value="checkbox"  onChange="seleccionar_todo(this);">
                 
              </label>--></th>
                <th>Fecha Bol</th>
                <th>Personal</th>
                <th>Estado</th>
                <th>Total Remuneraciones</th>
                <th>Total Aportes</th>
                <th>Total Descuentos</th>
                <th>NETO RECIBIDO</th>
                <th>Estado</th>
                <th title="Editar">&nbsp;</th>
                <th title="Eliminar">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <?php
                while($dt = mysql_fetch_array($dts)){
                    $suma_totrem=$dt['tb_bolpersonal_totrem']+$suma_totrem;
                    $suma_totapo=$dt['tb_bolpersonal_totapo']+$suma_totapo;
                    $suma_totdes=$dt['tb_bolpersonal_totdes']+$suma_totdes;
                    $suma_netrec=$dt['tb_bolpersonal_netrec']+$suma_netrec;
                
                    $apepat		=$dt['tb_personal_apepat'];
                    $apemat		=$dt['tb_personal_apemat'];
                    $nom		=$dt['tb_personal_nom'];
                ?>
              <tr>
                <td align="center" valign="top"><input name="chk_s[]" type="checkbox" id="chk_s[]" value="<?php echo $dt['tb_bolpersonal_id']?>"></td>
                <td height="18"><?php echo date('d-m-Y', strtotime($dt['tb_bolpersonal_fec']))?></td>
                <td><?php echo $apepat.' '.$apemat.' '.$nom?></td>
                <td><?php echo $dt['tb_personal_est']?></td>
                <td align="right"><?php echo $dt['tb_bolpersonal_totrem']?></td>
                <td align="right"><?php echo $dt['tb_bolpersonal_totapo']?></td>
                <td align="right"><?php echo $dt['tb_bolpersonal_totdes']?></td>
                <td align="right"><?php echo $dt['tb_bolpersonal_netrec']?></td>
                <td align="right"><?php echo $dt['tb_bolpersonal_est']?></td>
                <td align="center"><a href="javascript:popUp('Bolpersonal',800,550,'frmBolpersonal.php?bolpersonal=<?php echo $dt['tb_bolpersonal_id']?>&amp;vista=1&volver=vBoletas')"><img src="../../images/iconos/edit.png" alt="Editar" width="14" height="14" border="0" /></a></td>
                <td align="center"><a href="../../rBolpersonal.php?action=eliminar&idbolpersonal=<?php echo $dt['tb_bolpersonal_id']?>&volver=vbol" onclick="return mensaje('Realmente Desea Eliminar?')"><img src="../../images/iconos/delete.png" alt="Eliminar" width="14" height="14" border="0" /></a></td>
              </tr>
              <?php
            }
            mysql_free_result($dts);
            ?>
              </tbody>
              <tr>
                <td height="18" colspan="11">&nbsp;</td>
              </tr>
              <tr class="total_tabla_datos">
                <td height="18" colspan="4">Total Boletas: <?php echo $num_reg?></td>
                <td height="18" align="right"><strong><?php echo formato_moneda($suma_totrem)?></strong></td>
                <td height="18" align="right"><strong><?php echo formato_moneda($suma_totapo)?></strong></td>
                <td height="18" align="right"><strong><?php echo formato_moneda($suma_totdes)?></strong></td>
                <td height="18" align="right"><strong><?php echo formato_moneda($suma_netrec)?></strong></td>
                <td height="18" colspan="3">&nbsp;</td>
              </tr>
            </table>
            </form>
    		</div>
        </section>
        </div>
    </article>
    <footer>
    	<?php echo $oContenido->print_footer()?>
  	</footer>
</div>
</body>
</html>