<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

require_once ("./cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();

require_once ("../menu/acceso.php");

if(isset($_POST['cmb_emp_id']) and $_POST['cmb_emp_id']>0)
{
	$_SESSION['empresa_id']=$_POST['cmb_emp_id'];
	
	$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
	$dt = mysql_fetch_array($dts);
		$_SESSION['empresa_nombre']=$dt['tb_empresa_razsoc'];
	mysql_free_result($dts);

	//seleccionar primer almacen
	$rws=$oAlmacen->mostrarTodos($_SESSION['empresa_id']);
	$rw = mysql_fetch_array($rw);
		$alm_id=$rw['tb_almacen_id'];
	mysql_free_result($rws);

	$url=ir_principal($_SESSION['usuariogrupo_id']);
	header("Location: $url");
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Seleccionar Empresa</title>
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
function cmb_emp_id(idf)
{	
	$.ajax({
		type: "POST",
		url: "../empresa/cmb_emp_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			emp_id: idf
		}),
		beforeSend: function() {
			$('#cmb_emp_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_emp_id').html(html);
		}, 
	});
}
		
$(function() {	

	cmb_emp_id('<?php echo $_SESSION['empresa_id']?>');
	
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
                    <td class="caption_cont">SELECCIONAR EMPRESA</td>
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
			<form id="form1" name="form1" method="post" action="empresa_seleccionar.php">
        <table border="0" align="center">
          <tr>
            <td align="right">Mostrar Información de la Empresa:</td>
            <td><select name="cmb_emp_id" id="cmb_emp_id">
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