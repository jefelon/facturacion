<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}
require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

require_once ("../../config/Cado.php");
require_once ("cEntfinanciera.php");
$oEntfinanciera = new cEntfinanciera();

if($_GET['action']=="editar")
{
	$dts=$oEntfinanciera->mostrarUno($_GET['id']);
	$dt = mysql_fetch_array($dts);
	$e1=$dt['tb_entfinanciera_nom'];
	mysql_free_result($dts);
}

$dts1=$oEntfinanciera->mostrarTodos();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Entidad Financiera</title>
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
        headers: {1: {sorter: false }, 2: { sorter: false}} 
    });
}); 
</script>
<script language="javascript" type="text/javascript">
function Validar(){
	if(vacio(document.form1.txt_des.value) == false){
		document.getElementById("spa_des").style.display="inline";
		document.form1.txt_des.focus();
		return false;
	}
	return true;
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
                    <td class="caption_cont">ENTIDAD FINANCIERA</td>
                  </tr>
                  <tr>
                    <td class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a href="manEntfinanciera.php?action=insertar&vista=<?php echo $_GET['vista']?>"><img src="../../images/iconos/add.png" alt="Agregar" width="20" height="20" border="0" /></a></td>
                      <td width="25" align="left" valign="middle"><a href="manEntfinanciera.php?action=refrescar&vista=<?php echo $_GET['vista']?>"><img src="../../images/iconos/refresh.png" alt="Refrescar" width="20" height="20" border="0" /></a></td>
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
                    </td>
                  </tr>
              </table>
			</div>
		</section>
        <section>
			<div id="div_insertar" style="display:<?php if($_GET['action']=="insertar" or $_GET['action']=="editar"){echo "block";} else{ echo "none";}?>">
            <form action="rEntfinanciera.php?action=<?php echo $_GET['action']?>&vista=<?php echo $_GET['vista']?>" method="post" name="form1">
            <input name="hdd_id" type="hidden" value="<?php echo $_GET['id']?>">
            <table class="tabla_form">
                  <tr>
                    <td colspan="2" class="caption_form">Form Entidad Financiera</td>
                  </tr>
                    <tr>
                      <td colspan="2" align="right">&nbsp;</td>
                      </tr>
                    <tr>
                      <td align="right">Descripción:</td>
                      <td><label>
                        <input name="txt_des" type="text" id="txt_des" value="<?php echo $e1?>" size="50">
                      </label><span id="spa_des" class="txtval">Ingrese Descripción</span></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="right">&nbsp;</td>
                      </tr>
                    <tr>
                      <td colspan="2" align="center"><label>
                        <input name="btn_enviar" type="submit" class="ButtonT" id="btn_enviar" value="Guardar" onClick="return Validar()">
                      </label><label><input name="btn_cancelar" type="button" class="ButtonT" onClick="location='manEntFinanciera.php?vista=<?php echo $_GET['vista']?>'" value="Cancelar"></label></td>
                      </tr>
                  </table>
                  </form>
			</div>
		</section>
        <section>
        	<div class="contenido_tabla">
            <table cellspacing="1" id="tabla_sorter" class="tablesorter" align="center">
            <thead>
        		<tr>
                  <th>Descripción</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                </tr>
           </thead>
           <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){
        ?>
                <tr>
                  <td height="18"><?php echo $dt1['tb_entfinanciera_nom']?></td>
                  <td align="center"><a href="manEntfinanciera.php?action=editar&id=<?php echo $dt1['tb_entfinanciera_id']?>&vista=<?php echo $_GET['vista']?>"><img src="../../images/iconos/edit.png" alt="Editar" width="14" height="14" border="0"></a></td>
                  <td align="center">
                  <form action="rEntfinanciera.php?action=eliminar&vista=<?php echo $_GET['vista']?>" method="post">
                  <input name="hdd_ide" type="hidden" value="<?php echo $dt1['tb_entfinanciera_id']?>" /><input name="btn_eliminar" type="image" src="../../images/iconos/delete.png" width="14" height="14" border="0" onclick="return mensaje('Realmente Desea Eliminar?')" />
                  </form>
                  </td>
                </tr>
        <?php
        }
        mysql_free_result($dts1);
        ?>
        		</tbody>
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