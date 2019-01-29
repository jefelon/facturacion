<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

require_once ("./cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once ("../caja/cCaja.php");
$oCaja = new cCaja();

require_once ("../menu/acceso.php");

if(isset($_POST['cmb_punven_id']) and $_POST['cmb_punven_id']>0)
{
	//punto de venta
	$dts=$oPuntoventa->mostrar_puntoventa_por_usuario($_SESSION['usuario_id'],$_POST['cmb_punven_id']);
	$dt = mysql_fetch_array($dts);
		$_SESSION['empresa_id']		=$dt['tb_empresa_id'];
		$_SESSION['empresa_nombre']	=$dt['tb_empresa_razsoc'];

		$_SESSION['puntoventa_id']	=$dt['tb_puntoventa_id'];
		$_SESSION['puntoventa_nom']	=$dt['tb_puntoventa_nom'];
	
		$alm_id	=$dt['tb_almacen_id'];
    $cjs=$oCaja->mostrarUno($dt['tb_caja_id']);
    $cj = mysql_fetch_array($cjs);
    $_SESSION['caja_estado']=$cj['tb_caja_estado'];
    $_SESSION['caja_id']=$cj['tb_caja_id'];
	mysql_free_result($cjs);
    mysql_free_result($dts);

	//almacen
	$dts=$oAlmacen->mostrarUno($alm_id);
	$dt = mysql_fetch_array($dts);
		$alm_nom=$dt['tb_almacen_nom'];
		$alm_ven=$dt['tb_almacen_ven'];
	mysql_free_result($dts);
	$_SESSION['almacen_id']=$alm_id;
	$_SESSION['almacen_nom']=$alm_nom;

	//$url=ir_principal($_SESSION['usuariogrupo_id']);
	//$url='../vendedor/';
	if($_SESSION['usuariogrupo_id']==2)$url='../administrador/';
	if($_SESSION['usuariogrupo_id']==3)$url='../vendedor/';
	
	header("Location: $url");
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Seleccionar Punto de Venta</title>
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

<script type="text/javascript">
function cmb_punven_id(idf)
{	
	$.ajax({
		type: "POST",
		url: "../puntoventa/cmb_usu_punven_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			punven_id: idf
		}),
		beforeSend: function() {
			$('#cmb_punven_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_punven_id').html(html);
		}, 
	});
}
		
$(function() {	

	cmb_punven_id('<?php echo $_SESSION['puntoventa_id']?>');
	
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
            <table  align="center" class="tabla_cont">
                  <tr>
                    <td class="caption_cont">SELECCIONAR PUNTO DE VENTA</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><span title="Está Visualizando la Información de:"><?php echo $_SESSION['empresa_nombre']?></span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
              </table>
			</div>
		</section>
        <section>
        	<div align="center">
			<form id="form1" name="form1" method="post" action="puntoventa_seleccionar.php">
        <table border="0" align="center">
          <tr>
            <td align="right"><label for="cmb_punven_id">Vender desde Punto de Venta:</label></td>
            <td><select name="cmb_punven_id" id="cmb_punven_id">
             </select></td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input name="btn_enviar" type="submit" class="ButtonT" id="btn_enviar" value="Seleccionar" />
              <label><input name="btn_cancelar" type="button" class="ButtonT" id="btn_cancelar" onclick="location='<?php echo ir_principal($_SESSION['usuariogrupo_id'])?>'" value="Cancelar" /></label></td>
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