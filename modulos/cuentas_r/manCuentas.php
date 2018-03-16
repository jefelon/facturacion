<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

require_once ("../../config/Cado.php");
require_once("cElemento.php");
$oElemento = new cElemento();
require_once("cCuenta.php");
$oCuenta = new cCuenta();
require_once("cSubcuenta.php");
$oSubcuenta = new cSubcuenta();

//alertas
$alerta1=0;
$alerta1=$_GET['alerta1'];
$alerta2=0;
$alerta2=$_GET['alerta2'];

//ordenar por
if(isset($_GET['oby']))
{
	$oby=$_GET['oby'];
	$_SESSION['oby']=$oby;
}

if(isset($_SESSION['oby']))
{
	$oby=$_SESSION['oby'];
}
else{
	$oby='ord';
}

//editar, consulatas para mostrar los datos

if($_GET['action']=="editar1")
{
	$dts=$oCuenta->mostrarUno($_GET['id1']);
	$dt = mysql_fetch_array($dts);
	$e1=$dt['tb_cuenta_cod'];
	$e2=$dt['tb_cuenta_des'];
	$e3=$dt['tb_cuenta_ord'];
	mysql_free_result($dts);
}
if($_GET['action']=="editar2")
{
	$dts=$oSubcuenta->mostrarUno($_GET['id2']);
	$dt = mysql_fetch_array($dts);
	$e1=$dt['tb_subcuenta_cod'];
	$e2=$dt['tb_subcuenta_des'];
	$e3=$dt['tb_subcuenta_ord'];
	mysql_free_result($dts);
}

//eliminar 


if($_GET['action']=="eliminar1")
{	
	$r= $oCuenta->verificaE($_GET['id1']);
	$fila = mysql_fetch_array($r);
	
	$r2= $oCuenta->verificaE2($_GET['id1']);
	$fila2 = mysql_fetch_array($r2);
	
	$r3= $oCuenta->verificaE3($_GET['id1']);
	$fila3 = mysql_fetch_array($r3);
	
	if($fila[1] !="" or $fila2[1] !="" or $fila3[1] !="")
	{
		?><script language="javascript" type="text/javascript">
		alert("No se puede eliminar. Dato utilizado. Cuenta esta relacionada con Sub Cuentas, Ingresos y Gastos.");
		</script><?php
		echo '<meta http-equiv="Refresh" content="0;url=manCuentas.php">';
	}
	else
	{
		$oCuenta->eliminar($_GET['id1']);
		unset($_SESSION['cue'],$_SESSION['subcue']);
		echo '<meta http-equiv="Refresh" content="0;url=manCuentas.php">';
	}
}

if($_GET['action']=="eliminar2")
{	
	$r= $oSubcuenta->verificaE($_GET['id2']);
	$fila = mysql_fetch_array($r);
	
	$r2= $oSubcuenta->verificaE2($_GET['id2']);
	$fila2 = mysql_fetch_array($r2);
	
	if($fila[1] !="" or $fila2[1] !="")
	{
		?><script language="javascript" type="text/javascript">
		alert("No se puede eliminar. Dato utilizado. Sub Cuenta esta relacionada con Ingresos y Gastos.");
		</script><?php
		echo '<meta http-equiv="Refresh" content="0;url=manCuentas.php">';
	}
	else
	{
		$oSubcuenta->eliminar($_GET['id2']);
		unset($_SESSION['subcue']);
		echo '<meta http-equiv="Refresh" content="0;url=manCuentas.php">';
	}
}

if($_GET['action']=="refrescar")
{
	unset($_SESSION['cue'],$_SESSION['subcue'],$_SESSION['oby']);
}

//ELEMENTO
if(isset($_GET['id_ele'])){
	unset($_SESSION['cue'],$_SESSION['subcue']);
	$_SESSION['ele'] = $_GET['id_ele'];
}

if(isset($_SESSION['ele']))
{
	$ele=$_SESSION['ele'];
}
else{
	$ele=1;
}


//cuenta
if(isset($_GET['ge1'])){
	unset($_SESSION['subcue']);
	$_SESSION['cue'] = $_GET['ge1'];
}
if(isset($_SESSION['cue'])){
	$d1=$_SESSION['cue'];
	$mts1=$oCuenta->mostrarUno($d1);
	while($mt1 = mysql_fetch_array($mts1)){
		$codcue=$mt1['tb_cuenta_cod'];
		$descue=$mt1['tb_cuenta_des'];
		$ordcue=$mt1['tb_cuenta_ord'];
	}
}

//subcuenta
if(isset($_GET['ge2'])){
	$_SESSION['subcue'] = $_GET['ge2'];
}
if(isset($_SESSION['subcue'])){	
	$d2=$_SESSION['subcue'];
	$mts1=$oSubcuenta->mostrarUno($d2);
	while($mt1 = mysql_fetch_array($mts1)){
		$codsubcue=$mt1['tb_subcuenta_cod'];
		$dessubcue=$mt1['tb_subcuenta_des'];
		$ordsubcue=$mt1['tb_subcuenta_ord'];
	}
}

//muestra las listas

if(isset($ele))$dts1=$oCuenta->mostrarTodos_oby($ele,$oby);

if(isset($d1))$dts2=$oSubcuenta->mostrarTodos_cue_oby($d1,$oby);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Cuentas</title>
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

<script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/additional-methods.js" type="text/javascript"></script>
<script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>

<script type="text/javascript" id="js">
$(document).ready(function() {
	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_sorter").tablesorter({ 
        headers: {10: {sorter: false }, 11: { sorter: false}} 
    });
}); 
</script>

<script language="javascript" type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
</head>
<body>
<div class="container">
<?php if($_GET['vista']!='form'){?>
	<header>
    	<?php echo $oContenido->print_header()?>
	</header>
<?php }?>
    <article class="content">
    	<div class="contenido">
		<section>
            <div class="contenido_des">
            <table align="center" class="tabla_cont">
                  <tr>
                    <td class="caption_cont">CUENTAS - CAJA INDIVIDUAL</td>
                  </tr>
                  <tr>
                    <td class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    </td>
                  </tr>
              </table>
			</div>
		</section>
        <section>
        	<div>
            <table width="95%" border="0" align="center">
                        <tr>
                          <td height="20"><form name="form2" id="form2">
                            Elemento: 
                            <select name="jumpMenu2" id="jumpMenu2" onChange="MM_jumpMenu('parent',this,0)">
                              <option value="../cuentas_r/manCuentas.php?id_ele=1" <?php if($ele==1)echo 'selected'?>>ENTRADAS</option>
                              <option value="../cuentas_r/manCuentas.php?id_ele=2" <?php if($ele==2)echo 'selected'?>>SALIDAS</option>
                            </select>
                          </form></td>
                      </tr>
                        <tr>
                          <td height="20" align="center" valign="top">
                          <table width="100%" border="0">
                        <tr>
                          <td align="center" bgcolor="#F2F2F2"><strong>CUENTA</strong></td>     
                          <td height="21" align="center" bgcolor="#CEE3F6"><strong>SUBCUENTA</strong></td>
                          </tr>
                        <tr>
                          <td align="left">
                          <table width="300" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="20" align="left" valign="middle"><a href="../cuentas_r/manCuentas.php?action=insertar1" title="Agregar"><img src="../../images/iconos/add.png" alt="Agregar" width="20" height="20" border="0"></a></td>
                              <td width="20" align="left" valign="middle"><a href="../cuentas_r/manCuentas.php?action=refrescar"><img src="../../images/iconos/refresh.png" alt="Refrescar" width="20" height="20" border="0"></a></td>
                              <td width="359" align="right" valign="middle"><div id="div_alertas2" style="display:<?php if($alerta1!=0){echo "block";} else{ echo "none";}?>">
                                <table width="270" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="200" align="right"><input name="btn_cerrar1" type="submit" class="BtnT" id="btn_cerrar1" value="X" onClick="location='manCuentas.php'">
                                      <?php
                        if($alerta1==1){echo '<span style="color:#088A08; font-size: 10px;">Se agregó correctamente.</span>';}
                        if($alerta1==2){echo '<span style="color:#088A08; font-size: 10px;">Se modificó correctamente.</span>';}
                        if($alerta1==3){echo '<span style="color:#FF0000; font-size: 10px;">Se eliminó correctamente.</span>';}
                        if($alerta1==4){echo '<span style="color:#FF0000; font-size: 10px;">No se pudo registrar, intentelo nuevamente.</span>';}
                    ?></td>
                                  </tr>
                                </table>
                              </div></td>
                            </tr>
                          </table></td>
                          <td height="10" align="left">
                            <table width="300" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="left" valign="middle"><?php if (isset($_SESSION['cue'])){?>
                                  <a href="../cuentas_r/manCuentas.php?action=insertar2">Agregar</a>
                                  <?php }else{echo "Seleccione Cuenta";}?></td>
                                <td width="100" align="right" valign="middle">
                                  <div id="div_alertas2" style="display:<?php if($alerta2!=0){echo "block";} else{ echo "none";}?>">
                                    <table width="170" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td align="right"><input name="btn_cerrar2" type="submit" class="BtnT" id="btn_cerrar2" value="X" onClick="location='manCuentas.php'">
                                          <?php
                        if($alerta2==1){echo '<span style="color:#088A08; font-size: 10px;">Se agregó correctamente.</span>';}
                        if($alerta2==2){echo '<span style="color:#088A08; font-size: 10px;">Se modificó correctamente.</span>';}
                        if($alerta2==3){echo '<span style="color:#FF0000; font-size: 10px;">Se eliminó correctamente.</span>';}
                        if($alerta2==4){echo '<span style="color:#FF0000; font-size: 10px;">No se pudo registrar, intentelo nuevamente.</span>';}
                    ?></td>
                                        </tr>
                                      </table>
                                    </div></td>
                                </tr>
                            </table></td>
                          </tr>
                        <tr>
                          <td align="left" valign="top">
                        <div id="div_editar1" style="display:<?php if($_GET['action']=="insertar1"){echo "none";} else{ echo "block";}?>">
                        <table width="320" border="0">
                              <?php
                         if(isset($d1)){
                         ?>
                              <tr>
                                <td width="50"><?php echo $codcue?></td>
                                <td width="308"><?php echo $descue?></td>
                                <td width="21" align="center"><?php echo $ordcue?></td>
                                <td width="21" align="center"><a href="../cuentas_r/manCuentas.php?action=editar1&id1=<?php echo $d1?>"><img src="../../images/iconos/edit.png" alt="Editar" width="14" height="14" border="0"></a></td>
                                <td width="20" align="center"><a href="../cuentas_r/manCuentas.php?action=eliminar1&id1=<?php echo $d1?>" onClick="return mensaje('Realmente Desea Eliminar?')"><img src="../../images/iconos/delete.png" alt="Eliminar" width="14" height="14" border="0"></a></td>
                              </tr>
                              <?php
                         }
                         ?>
                            </table>
                        </div>
                        <div id="div_insertar1" style="display:<?php if($_GET['action']=="insertar1" or $_GET['action']=="editar1"){echo "block";} else{ echo "none";}?>">
                          <table width="320" id="tab_insertar2">
                    <form name="form1" action="../cuentas_r/rCuenta.php?action=<?php echo $_GET['action']?>" method="post">
                    <input name="hdd_id" type="hidden" value="<?php echo $_GET['id1']?>">
                    <input name="hdd_ele" type="hidden" value="<?php echo $ele?>">
                            <tr>
                              <td width="82" align="right">Código:</td>
                              <td width="321"><label>
                                <input name="txt_cod" type="text" id="txt_cod" value="<?php echo $e1?>" size="10" maxlength="10">
                              </label>
                                <span id="spa_ruc2" class="txtval">Ingrese Código</span></td>
                            </tr>
                            <tr>
                              <td align="right">Descripción:</td>
                              <td><label>
                                <input name="txt_des" type="text" id="txt_des" value="<?php echo $e2?>" size="30">
                              </label>
                                <span id="spa_razsoc2" class="txtval">Ingrese Descripción</span></td>
                            </tr>
                            <tr>
                              <td height="5" colspan="0" align="right">Orden:</td>
                              <td colspan="0" height="5"><label>
                                <input name="txt_ord" type="text" id="txt_ord" value="<?php echo $e3?>" size="4" maxlength="2">
                              </label></td>
                            </tr>
                            <tr>
                              <td colspan="0" height="5">&nbsp;</td>
                              <td colspan="0" height="5">&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="right">&nbsp;</td>
                              <td><label>
                                <input name="btn_enviar1" type="submit" class="ButtonT" id="btn_enviar1" value="Guardar" onClick="return Validar()">
                              </label>
                                <label>
                                  <input name="btn_cancelar2" type="button" class="ButtonT" onClick="location='manCuentas.php'" value="Cancelar">
                                </label></td>
                            </tr>
                            </form>
                          </table>
                    </div>
                            </td>
                          <td align="left" valign="top">
                            <div id="div_editar2" style="display:<?php if($_GET['action']=="insertar2"){echo "none";} else{ echo "block";}?>">
                              <table width="320" border="0">
                                <?php
                         if(isset($d2)){
                         ?>        
                                <tr>
                                  <td width="50"><?php echo $codsubcue?></td>
                                  <td width="308"><?php echo $dessubcue?></td>
                                  <td width="21" align="center"><?php echo $ordsubcue?></td>
                                  <td width="21" align="center"><a href="../cuentas_r/manCuentas.php?action=editar2&id2=<?php echo $d2?>"><img src="../../images/iconos/edit.png" alt="Editar" width="14" height="14" border="0"></a></td>
                                  <td width="20" align="center"><a href="../cuentas_r/manCuentas.php?action=eliminar2&id2=<?php echo $d2?>" onClick="return mensaje('Realmente Desea Eliminar?')"><img src="../../images/iconos/delete.png" alt="Eliminar" width="14" height="14" border="0"></a></td>
                                  </tr>
                                <?php
                         }
                         ?>
                                </table>
                              </div>
                            <div id="div_insertar2" style="display:<?php if($_GET['action']=="insertar2" or $_GET['action']=="editar2"){echo "block";} else{ echo "none";}?>">
                              <table width="320" id="tab_insertar3">
                                <form name="form1" action="../cuentas_r/rSubcuenta.php?action=<?php echo $_GET['action']?>" method="post">
                                  <input name="hdd_id" type="hidden" value="<?php echo $_GET['id2']?>">
                                  <input name="hdd_cue" type="hidden" value="<?php echo $d1?>">
                                  <tr>
                                    <td width="82" align="right">Código:</td>
                                    <td width="321"><label>
                                      <input name="txt_cod" type="text" id="txt_cod" value="<?php echo $e1?>" size="10" maxlength="10">
                                      </label>
                                      <span id="spa_ruc3" class="txtval">Ingrese Código</span></td>
                                    </tr>
                                  <tr>
                                    <td align="right">Descripción:</td>
                                    <td><label>
                                      <input name="txt_des" type="text" id="txt_des" value="<?php echo $e2?>" size="30">
                                      </label>
                                      <span id="spa_razsoc3" class="txtval">Ingrese Descripción</span></td>
                                    </tr>
                                  <tr>
                                    <td height="5" colspan="0" align="right">Orden:</td>
                                    <td colspan="0" height="5"><input name="txt_ord" type="text" id="txt_ord" value="<?php echo $e3?>" size="4" maxlength="2"></td>
                                    </tr>
                                  <tr>
                                    <td colspan="0" height="5">&nbsp;</td>
                                    <td colspan="0" height="5">&nbsp;</td>
                                    </tr>
                                  <tr>
                                    <td align="right">&nbsp;</td>
                                    <td><label>
                                      <input name="btn_enviar2" type="submit" class="ButtonT" id="btn_enviar2" value="Guardar" onClick="return Validar()">
                                      </label>
                                      <label>
                                        <input name="btn_cancelar3" type="button" class="ButtonT" onClick="location='manCuentas.php'" value="Cancelar">
                                        </label></td>
                                    </tr>
                                  </form>
                                </table>
                              </div>
                          </td>
                          </tr>
                        <tr>
                          <td height="20" colspan="2" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="20" align="left" valign="middle">
                            <form name="form" id="form">
                              Ordenar por: <select name="jumpMenu" id="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
                                <option value="../cuentas_r/manCuentas.php?oby=des" <?php if($oby=='des')echo 'selected'?>>Descripción</option>
                                <option value="../cuentas_r/manCuentas.php?oby=ord" <?php if($oby=='ord')echo 'selected'?>>N° Orden</option>
                                </select>
                            </form></td>
                          <td valign="top">&nbsp;</td>
                          </tr>
                        <tr>
                          <td valign="top">
                            <table width="100%" border="0">
                              <tr>
                                <td valign="top" bgcolor="#F1F1F1">CODIGO</td>
                                <td valign="top" bgcolor="#F1F1F1">DESCRIPCION</td>
                                <td align="center" valign="top" bgcolor="#F1F1F1">Orden</td>
                                </tr>
                              <tr>
                                <td colspan="3" valign="top">&nbsp;</td>
                                </tr>
                              <?php
                         if(isset($dts1)){
                         while($dt1 = mysql_fetch_array($dts1)){	  
                         ?>
                              <tr>
                                <?php
                                if($dt1['tb_cuenta_ord']==0 and $dt1['tb_cuenta_id']==$d1)
                                {
                                    $color1="#F8E0E0";
                                }
                                else
                                {
                                    if($dt1['tb_cuenta_ord']==0)
                                    {
                                        $color1="#FBEFEF";
                                    }
                                    else
                                    {
                                        if($dt1['tb_cuenta_id']==$d1)
                                        {
                                            $color1="#EFF5FB";
                                        }
                                        else
                                        {
                                            $color1="";				
                                        }
                                    }
                                }
                                ?>
                                <td width="15%" valign="top" bgcolor="<?php echo $color1?>"><a href="../cuentas_r/manCuentas.php?ge1=<?php echo $dt1['tb_cuenta_id']?>"><?php echo $dt1['tb_cuenta_cod'];?></a></td>
                                <td width="70%" valign="top" bgcolor="<?php echo $color1?>" title="<?php echo $dt1['tb_cuenta_id']?>"><a href="../cuentas_r/manCuentas.php?ge1=<?php echo $dt1['tb_cuenta_id']?>"><?php echo $dt1['tb_cuenta_des'];?></a></td>
                                <td width="15%" align="center" valign="top" bgcolor="<?php echo $color1?>"><a href="../cuentas_r/manCuentas.php?ge1=<?php echo $dt1['tb_cuenta_id']?>"><?php echo $dt1['tb_cuenta_ord'];?></a></td>
                                </tr>
                              <?php
                         }
                         mysql_free_result($dts1);
                         }
                         else {
                        // echo "Seleccione una Cuenta";
                         }
                         ?>
                              </table></td>
                          <td height="16" valign="top">
                            <table width="100%" border="0">
                              <tr>
                                <td valign="top" bgcolor="#CEE3F6">CODIGO</td>
                                <td valign="top" bgcolor="#CEE3F6">DESCRIPCION</td>
                                <td align="center" valign="top" bgcolor="#CEE3F6">Orden</td>
                                </tr>
                              <tr>
                                <td colspan="3" valign="top">&nbsp;</td>
                                </tr>
                              <?php
                         if(isset($dts2)){
                         while($dt2 = mysql_fetch_array($dts2)){	  
                         ?>
                              <tr>
                                <?php
                                if($dt2['tb_subcuenta_ord']==0 and $dt2['tb_subcuenta_id']==$d2)
                                {
                                    $color1="#F8E0E0";
                                }
                                else
                                {
                                    if($dt2['tb_subcuenta_ord']==0)
                                    {
                                        $color1="#FBEFEF";
                                    }
                                    else
                                    {
                                        if($dt2['tb_subcuenta_id']==$d2)
                                        {
                                            $color1="#EFF5FB";
                                        }
                                        else
                                        {
                                            $color1="";				
                                        }
                                    }
                                }
                                ?>
                                <td width="15%" valign="top" bgcolor="<?php echo $color1?>"><a href="../cuentas_r/manCuentas.php?ge2=<?php echo $dt2['tb_subcuenta_id']?>"><?php echo $dt2['tb_subcuenta_cod'];?></a></td>
                                <td width="70%" valign="top" bgcolor="<?php echo $color1?>" title="<?php echo $dt2['tb_subcuenta_id']?>"><a href="../cuentas_r/manCuentas.php?ge2=<?php echo $dt2['tb_subcuenta_id']?>"><?php echo $dt2['tb_subcuenta_des'];?></a></td>
                                <td width="15%" align="center" valign="top" bgcolor="<?php echo $color1?>"><a href="../cuentas_r/manCuentas.php?ge2=<?php echo $dt2['tb_subcuenta_id']?>"><?php echo $dt2['tb_subcuenta_ord'];?></a></td>
                                </tr>
                              <?php
                         }
                         mysql_free_result($dts2);
                         }
                         else {
                        // echo "Seleccione una Cuenta";
                         }
                         ?> 
                              </table>
                          </td>
                          </tr>
                      </table>
                          </td>
                        </tr>
                      </table>
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