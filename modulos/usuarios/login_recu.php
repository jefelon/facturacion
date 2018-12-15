<?php
   require_once ("../../config/datos.php");
   $numero=rand(1,3);
?>
<!DOCTYPE HTML>
<html lang="es">
   <head>
      <!--<link href="images/favicon.ico" type="image/x-icon" rel="shortcut icon">-->
      <title>Sistema - Iniciar Sesión</title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <link href="../../css/Estilo/miestilo_login.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="../../js/jquery-ui/development-bundle/themes/start/jquery.ui.all.css">
      <script src="../../js/jquery-ui/development-bundle/jquery-1.6.2.js"></script>
      <script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
      <script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
      <script src="../../js/jquery-ui/development-bundle/ui/jquery.ui.button.js"></script>
      <script src="../../js/jquery-validation/jquery.validate.js" type="text/javascript"></script>
      <script src="../../js/jquery-validation/localization/messages_es.js" type="text/javascript"></script>

      <script type="text/javascript">
         $(function() {
          /*$('#btn_ingresar').button({
            icons: {primary: "ui-icon-check"}
          });*/
         
          $("#form").validate({
            rules: {
              txt_use: {
                      required: true
                     },
              txt_pas: {
                required: true
                     }
            },
            messages: {
              txt_use: "Escriba su nombre de Usuario",
              txt_pas: "Escriba su Contraseña"
            }
          });             
         });
      </script>
   </head>

   <body style="background: url(../../images/bg<?php echo $numero;?>.jpg) no-repeat center fixed; background-color: #e9e8ec;">

      <?php echo $_GET['mm']?>
      <?php /*?><header id="main-header">
            <h1 class="site-name">PLATAFORMA DE GESTIÓN</h1>
      </header><?php */?>

<div class="container_general">

   <form action="ctaInicio_recu.php" method="post" name="form" id="form">
      <div id="main-header">
            <h1 class="site-name">AQPFACT 5.0  - FACTURACIÓN ELECTRÓNICA</h1>
      </div>
     <div class="imgcontainer">
       <img src="../../images/logo.jpg" alt="Logo" class="avatar">
     </div>

     <div class="container">
       <label><b>Usuario</b></label>
       <input type="text" name="txt_use" id="txt_use" placeholder="Nombre de Usuario" value="admin" required>
      <br>
       <label><b>Clave</b></label>
       <input type="password" placeholder="Contraseña" name="txt_pas" id="txt_pas" required value="admin">

       <button type="submit" id="btn_ingresar">Ingresar</button>
     </div>

     <div style="text-align:center">
         <?php if ($_GET["erroracceso"]==1){?>
         <strong class="alerta_r">Nombre de Usuario o Contraseña son incorrectas.</strong>
         <script language="JavaScript" type="text/javascript">
            document.form.txt_pas.focus();
         </script>
         <?php }?>
         <?php if ($_GET["errorbloqueo"]==1){?>
         <p class="alerta_r">Acceso denegado! Su cuenta ha sido bloqueada o sera que no se activado todavía.</p>
         <script language="JavaScript" type="text/javascript">
            document.form.txt_pas.focus();
         </script>
         <?php }?>
     </div>

     <?php /*?><div class="container" style="background-color:#f1f1f1">
       <button type="button" class="cancelbtn">Cancelar</button>
       <span class="psw">Olvidaste tu <a href="#">clave?</a></span>
     </div><?php */?>

     <?php /*?><div>
            <a href="http://<?php echo $d_dominio?>"><?php echo $d_dominio?></a>
         </div>
         <?php */?>

   </form>
<div>

<!--       <footer>
         <div>
            <p>Nombre de la Empresa</p>
         </div>
      </footer> -->
   </body>
</html>