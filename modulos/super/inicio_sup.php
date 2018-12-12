<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Principal</title>
<link href="../../css/Estilo/miestilo.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="../../css/Estilo/menu_estilo.css" rel="stylesheet" type="text/css">

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
                    <td class="caption_cont">PRINCIPAL</td>
                  </tr>
                  <tr>
                    <td align="right" class="cont_emp"><span title="Está Visualizando la Información de:"><?php echo $_SESSION['empresa_nombre']?></span></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="25" align="left" valign="middle">&nbsp;</td>
                        <td width="25" align="left" valign="middle">&nbsp;</td>
                        <td align="left" valign="middle">&nbsp;</td>
                        <td align="right"><?php
                switch ($_SESSION['alerta']) {
                    case 1:
                        echo '<span class="alerta_v">Se modificó sus datos correctamente.</span>';
                        break;
                    case 2:
                        echo '<span class="alerta_v">Se cambió su clave correctamente.</span>';
                        break;
                    case 3:
                        echo '<span class="alerta_r">Se eliminó correctamente.</span>';
                        break;
                    case 4:
                        echo '<span class="alerta_v">Está visualizando la informacion de '.$_SESSION['empresa_nombre'].'</span>';
                        break;
                    //default:
                        //echo "i is not equal to 0, 1 or 2";
                }
                unset($_SESSION['alerta']);
                    ?></td>
                      </tr>
                    </table>
                    </td>
                  </tr>
                </table>
            </div>
        </section>
        </div>
	</article>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>