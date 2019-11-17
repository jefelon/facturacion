<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

include_once ("cabecera_html.php");
?>

<script type="text/javascript">

function producto_mas_vendido_form(act,idf)
{
	$.ajax({
		type: "POST",
		url: "producto_mas_vendido_form.php",
		async:true,
		dataType: "html",                      
		data: ({

		}),
		beforeSend: function() {
			$('#div_producto_mas_vendido_form').dialog("open");
			$('#div_producto_mas_vendido_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
        },
		success: function(html){
			$('#div_producto_mas_vendido_form').html(html);
		}
	});
}

$(function() {
	$( "#div_producto_mas_vendido_form" ).dialog({
		title:'Productos más vendidos',
		autoOpen: false,
		resizable: false,
		height: 200,
		width: 280,
		modal: false,
		buttons: {
            Imprimir: function() {
                $("#for_mas_ven").submit();
            },
			Cancelar: function() {
				$('#for_mas_ven').each (function(){this.reset();});
				$( this ).dialog( "close" );
			}
		}
	});

    producto_mas_vendido_form();
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
            <div class="contenido_des">
                <table align="center" class="tabla_cont">
                    <tr>
                        <td class="caption_cont">PRODUCTOS MÁS VENDIDOS</td>
                    </tr>
                    <tr>
                        <td align="right" class="cont_emp"><?php echo $_SESSION['empresa_nombre']?></td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                    </tr>
                </table>
			</div>
      	</div>
    </article>
    <div id="div_producto_mas_vendido_form">
    </div>
</div>
<footer>
    <?php echo $oContenido->print_footer()?>
</footer>
</body>
</html>