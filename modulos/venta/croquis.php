<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");

require_once ("../contenido/contenido.php");
$oContenido = new cContenido();

if($_SESSION['usuariogrupo_id']==2)$titulo='Registrar Ventas - Administrador';
if($_SESSION['usuariogrupo_id']==3)$titulo='Registrar Ventas - Vendedor';
require_once ("../../config/Cado.php");
require_once ("../producto/cProducto.php");
$oProducto = new cProducto();

require_once ("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();

require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();

require_once ("../formatos/formato.php");


$dts1=$oProducto->mostrar_filtro2('Activo');
$num_rows= mysql_num_rows($dts1);

//orden
if($_POST['ordby']=='tb_producto_mod DESC')$sort='[5,1]';
if($_POST['ordby']=='tb_producto_nom')$sort='[0,0]';
?>


<style>
    #contenedor{
        height: auto;
    }
    #contenedor .asiento {
        margin: 0.5em;
        padding: 0.5em;
        border: 1px solid black;
        border-radius: 5px;
        width: 100px;
        cursor: move;
        position: relative;
    }

    #cart {
        margin-top:auto;
        height: 400px;
        width: 1000px;
        border: 2px solid black;
        text-align: center;
        padding-top: 20px;
        line-height: 10px;
        box-sizing: border-box;
    }

    #cart.active {
        border: 2px dotted black;
    }

    #cart.hover {
        opacity: 0.5;
    }

</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('.btn_presentacion').button({
            icons: {primary: "ui-icon-clipboard"},
            text: false
        });
        $('.btn_editar').button({
            icons: {primary: "ui-icon-pencil"},
            text: false
        });

        $('.btn_eliminar').button({
            icons: {primary: "ui-icon-trash"},
            text: false
        });

        $("#contenedor .asiento").draggable({
            cursor: "move"
        });
        $("#cart").droppable({
            activeClass: "active",
            hoverClass: "hover",
            drop: function (event, ui) {
                var count = parseInt($("#count").text(), 10);
                $("#count").text(++count);
            },
            tolerance: "touch"
        });

    });
</script>

<?php
if($num_rows>=1){
    ?>
    <div id="contenedor">
        <?php
        while($dt1 = mysql_fetch_array($dts1)){?>
            <div class="asiento" id="<?php echo 'item_'.$dt1['tb_producto_id'] ?>" style="width: 70px;height:50px;background: green;float: left;border:1px solid #000011">
                <span><?php echo $dt1['tb_producto_nom']?></span> <span style="display: none"><?php echo $dt1['tb_producto_id'] ?></span>
            </div>
            <?php
        }
        mysql_free_result($dts1);
        ?>
        <!--            --><?php //for ($cont=0;$cont<=60; $cont++){?>
        <!--            <div class="asiento" id="--><?php //echo 'item_'.$cont ?><!--" style="width: 70px;height:50px;background: #F2EFE9;float: left;border:1px solid #000011">-->
        <!--            </div>-->
        <!--            --><?php //}?>
    </div>

    <div id="cart" class="ui-widget-content">
        Cart - <span id="count">0</span> Item(s)
    </div>
<?php } ?>

