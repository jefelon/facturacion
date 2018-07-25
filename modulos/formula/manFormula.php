<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: index.php"); exit();}

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

require_once ("cFormula.php");
$oFormula = new cFormula();

$ele=$_GET['ele'];
$cat=$_GET['cat'];

if($_GET['action']=="editar")
{
	$dts=$oFormula->mostrarUno($_GET['id']);
	$dt = mysql_fetch_array($dts);
	$cat=$dt['tb_formula_cat'];
	$dat=$dt['tb_formula_dat'];
	$des=$dt['tb_formula_des'];
	mysql_free_result($dts);
}

if($_GET['action']=="eliminar")
{
	$vs1=$oFormula->verificaE1($ele);
	$v1 = mysql_fetch_array($vs1);
	$num=$v1['num'];
	mysql_free_result($vs1);
	if($num>=2){
		$oFormula->eliminar($_GET['id']);
		$_SESSION['alerta']=3;
		header("Location: manFormula.php?ele=".$ele."&vista=".$_GET['vista']."");
	}
	else{
		$_SESSION['alerta']=5;
	}
}

$dts=$oFormula->mostrarTodos_cat($ele);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Formula</title>

<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="../../js/tablesorter/themes/blue/style.css" type="text/css" media="print, projection, screen" />
<script language="javascript" src="../../js/recursos.js" type="text/javascript"></script>
<script type="text/javascript" src="../../js/tablesorter/jquery-latest.js"></script>
<script type="text/javascript" src="../../js/tablesorter/jquery.tablesorter.js"></script>
<script type="text/javascript" id="js">
$(document).ready(function() {
	$.tablesorter.defaults.widgets = ['zebra'];
	//$.tablesorter.defaults.sortList = [[0,0]];
	$("#tabla_sorter").tablesorter({ 
        headers: {7: {sorter: false }, 8: { sorter: false}} 
    });
}); 
</script>
<script language="javascript" type="text/javascript">
function Validar(){
	/*if(vacio(document.form.cmb_cat.value) == false){
		document.getElementById("spa_cat").style.display="inline";
		document.form.txt_cat.focus();
		return false;
	}*/
	if(vacio(document.form.txt_des.value) == false){
		document.getElementById("spa_des").style.display="inline";
		document.form.txt_des.focus();
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
                    <td class="caption_cont"> FORMULA - <?php echo strtoupper($_GET['ele'])?></td>
                  </tr>
                  <tr>
                    <td class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                  </tr>
                  <tr>
                    <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left" valign="middle"><a href="manFormula.php?action=insertar&ele=<?php echo $ele?>&vista=<?php echo $_GET['vista']?>"><img src="../../images/iconos/add.png" alt="Agregar" width="20" height="20" border="0" /></a></td>
                      <td width="25" align="left" valign="middle"><a href="manFormula.php?action=refrescar&ele=<?php echo $ele?>&vista=<?php echo $_GET['vista']?>"><img src="../../images/iconos/refresh.png" alt="Refrescar" width="20" height="20" border="0" /></a></td>
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
                        echo '<span class="alerta_r">No se puede eliminar, dato utilizado.</span>';
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
            <form action="rFormula.php?action=<?php echo $_GET['action']?>&vista=<?php echo $_GET['vista']?>" method="post" name="form">
            <input name="hdd_id" type="hidden" value="<?php echo $_GET['id']?>">
            <input name="hdd_ele" type="hidden" value="<?php echo $ele?>">
            <table class="tabla_form">
                  <tr>
                    <td colspan="2" class="caption_form">Form</td>
                  </tr>
                    <tr>
                      <td colspan="2" align="right">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="right">Categoría:</td>
                      <td>
                      <!--<select name="cmb_cat" id="cmb_cat">
                        <option value="0">-</option>
                        <?php
            $rws=$oFormula->mostrarTodos_cat($ele);
            while($rw = mysql_fetch_array($rws))
            {
            ?>
                        <option value="<?php echo $rw['tb_formula_cat']?>" <?php if($rw['tb_formula_cat']==$cat)echo 'selected'?>><?php echo $rw['tb_formula_cat']?></option>
                        <?php 
            }
            mysql_free_result($rws);
            ?>
                      </select> -->
                        <input name="txt_cat" type="text" id="txt_cat" value="<?php echo $cat?>" <?php if(isset($cat))echo 'readonly="readonly"'?> /><span id="spa_cat" class="txtval">Ingrese Categoría</span>
                        </td>
                    </tr>
                    <tr>
                      <td align="right">Dato:</td>
                      <td>
                        <input name="txt_dat" type="text" id="txt_dat" value="<?php echo $dat?>" size="50" /></td>
                    </tr>
                    <tr>
                      <td align="right">Descripción:</td>
                      <td><label>
                        <input name="txt_des" type="text" id="txt_des" value="<?php echo $des?>" size="50">
                        </label><span id="spa_des" class="txtval">Ingrese Descripción</span></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="right">&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"><label>
                        <input name="btn_enviar" type="submit" class="ButtonT" id="btn_enviar" value="Guardar" onClick="return Validar()">
                      </label><label><input name="btn_cancelar" type="button" class="ButtonT" onClick="location='manFormula.php?ele=<?php echo $ele?>&vista=<?php echo $_GET['vista']?>'" value="Cancelar"></label></td>
                      </tr>
                  </table>
                  </form>
			</div>
		</section>
			<div>
<?php
while($dt = mysql_fetch_array($dts)){
?>  
            <table width="500" border="0">
                <tr>
                  <td height="20" colspan="3" bgcolor="#EBEBEB">Categoría: <?php echo $cat=$dt['tb_formula_cat']?></td>
                  <td height="20" align="center" bgcolor="#EBEBEB"><a href="manFormula.php?action=insertar&ele=<?php echo $ele?>&cat=<?php echo $cat?>&vista=<?php echo $_GET['vista']?>"><img src="../../images/iconos/add.png" alt="Agregar" width="14" height="14" border="0"></a></td>
                </tr>
        <?php
        $dts1=$oFormula->mostrarP($ele,$cat);
        while($dt1 = mysql_fetch_array($dts1)){
        ?>
                <tr>
                  <td height="18"><?php echo $dt1['tb_formula_dat']?></td>
                  <td><?php echo $dt1['tb_formula_des']?></td>
                  <td width="20" align="center"><a href="manFormula.php?action=editar&id=<?php echo $dt1['tb_formula_id']?>&ele=<?php echo $ele?>&vista=<?php echo $_GET['vista']?>"><img src="../../images/iconos/edit.png" alt="Editar" width="14" height="14" border="0"></a></td>
                  <td width="20" align="center"><a href="manFormula.php?action=eliminar&id=<?php echo $dt1['tb_formula_id']?>&ele=<?php echo $ele?>&vista=<?php echo $_GET['vista']?>" onClick="return mensaje('Realmente Desea Eliminar?')"><img src="../../images/iconos/delete.png" alt="Eliminar" width="14" height="14" border="0"></a></td>
                </tr>
        <?php
        }
        mysql_free_result($dts1);
        ?>
              </table>
      <br>
<?php
}
mysql_free_result($dts);
?>     
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