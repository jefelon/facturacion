<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
$_SESSION["pro_nom_tab"]=$_POST["pro_nom_tab"];
?>
<script>
    $(function() {
        $( "#div_venta_tab" ).tabs();
		
		/*$("#productos").click(function(){
			catalogo_venta();
		});*/
		
		/*$("#servicios").click(function(){
			catalogo_servicio();
		});*/
    });
</script>
<div id="div_venta_tab">
    <ul>
        <li class="ui-state-default ui-corner-top ui-state-hover ui-tabs-selected ui-state-active"><a id="productos" href="#div_tab_producto">Productos</a></li>

    </ul>
    <div id="div_tab_producto">
        Productos
    </div>
<!--    <div id="div_tab_servicio">-->
<!--        Servicios-->
<!--    </div>-->
</div>