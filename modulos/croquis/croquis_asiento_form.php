<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once("../../config/Cado.php");

require_once("../contenido/contenido.php");
$oContenido = new cContenido();

if($_SESSION['usuariogrupo_id']==2)$titulo='Registrar Ventas - Administrador';
if($_SESSION['usuariogrupo_id']==3)$titulo='Registrar Ventas - Vendedor';
require_once("../../config/Cado.php");
require_once("../asiento/cAsiento.php");
$oAsiento = new cAsiento();
require_once("../vehiculo/cVehiculo.php");
$oVehiculo= new cVehiculo();
require_once("../formatos/formato.php");
$vehiculo_id=$_POST["veh_id"];
if($_POST['action']=="editar_croquis")
{
    $dts=$oVehiculo->mostrarUno($vehiculo_id);
    $dt = mysql_fetch_array($dts);
    $veh_nombre= $dt['tb_vehiculo_id']. ' '.$dt['tb_vehiculo_marca']. ' - '.$dt['tb_vehiculo_placa'].' de '.$dt['tb_vehiculo_numasi'].' Asientos.';
    mysql_free_result($dts);
}

echo  "Modificando vehiculo: ". $veh_nombre;
?>
<script type="text/javascript">
    function croquis_filtro(veh_id,piso)
    {
        $.ajax({
            type: "POST",
            url: "croquis_asiento_filtro.php",
            async:true,
            dataType: "html",
            data: ({
                veh_id:veh_id,
                piso:piso
            }),
            beforeSend: function() {
                $('#div_croquis_filtro').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_croquis_filtro').html(html);
            },
            complete: function(){
                $('#div_croquis_filtro').removeClass("ui-state-disabled");
            }
        });
    }
    function click_derecho(event,selector,cli_id){
        //o=opaco inabilitado a=activo asiento normal
        var id_selector = selector.attr('id');
        var position = $("#"+id_selector).position();
        if($(selector).hasClass('a')){
            $("#menu-click").css({'display': 'block', 'left': position.left+40, 'top': position.top+40 });
            $("#reservar").css({'display': 'none'});
            $("#vender").css({'display': 'none'});
            $("#eliminar").css({'display': 'none'});
            $("#postergar").css({'display': 'block'});
            $("#detalle").css({'display': 'block'});
            seleccionar(selector);

        }else if($(selector).hasClass('d')) {
            $("#menu-click").css({'display': 'block', 'left': position.left + 40, 'top': position.top + 40});
            $("#reservar").css({'display': 'none'});
            $("#eliminar").css({'display': 'block'});
            $("#vender").css({'display': 'block'});
            $("#postergar").css({'display': 'none'});
            $("#detalle").css({'display': 'block'});
            $("#hdd_act_res").val(cli_id);
            seleccionar(selector);
        }
        else if($(selector).hasClass('tv')){
                $("#menu-click").css({'display': 'block', 'left': position.left+40, 'top': position.top+40 });
                $("#reservar").css({'display': 'none'});
                $("#eliminar").css({'display': 'block'});
                $("#vender").css({'display': 'block'});
                $("#postergar").css({'display': 'none'});
                $("#detalle").css({'display': 'block'});
                $("#hdd_act_res").val(cli_id);
                seleccionar(selector);
        }
        else {
            seleccionar(selector);
            $("#menu-click").css({'display': 'block', 'left': position.left+40, 'top': position.top+40 });
            $("#reservar").css({'display': 'block'});
            $("#vender").css({'display': 'none'});
            $("#eliminar").css({'display': 'none'});
            $("#postergar").css({'display': 'none'});
            $("#detalle").css({'display': 'none'});
        }
    }
    $(function() {
        croquis_filtro(<?php echo $vehiculo_id ?>,$("#cmb_piso").val());

        $('#cmb_piso').change(function(){
            croquis_filtro(<?php echo $vehiculo_id ?>,$("#cmb_piso").val());
        });

        //Ocultamos el menú al cargar la página
        $("#menu-click").hide();

        //cuando hagamos click, el menú desaparecerá
        $(document).click(function(e){
            if(e.button == 0){
                $("#menu-click").css("display", "none");
            }
        });

        //si pulsamos escape, el menú desaparecerá
        $(document).keydown(function(e){
            if(e.keyCode == 27){
                $("#menu-click").css("display", "none");
            }
        });

        //controlamos los botones del menú
        $("#menu-click").click(function(e){

            // El switch utiliza los IDs de los <li> del menú
            switch(e.target.id){
                case "d":
                    var nuevoId=($('.seleccionado').attr("id")).split('_');
                    $('.seleccionado').attr("id",nuevoId[0]+'_'+nuevoId[1]+'_'+'d');
                    $('#sortable3').trigger('sortupdate'); // Trigger the update event manually
                    $('#sortable3').sortable( "refreshPositions" );
                    croquis_filtro(<?php echo $vehiculo_id ?>,$("#cmb_piso").val());
                    break;
                case "a":
                    var nuevoId=($('.seleccionado').attr("id")).split('_');
                    $('.seleccionado').attr("id",nuevoId[0]+'_'+nuevoId[1]+'_'+'a');
                    $('#sortable3').trigger('sortupdate'); // Trigger the update event manually
                    $('#sortable3').sortable( "refreshPositions" );
                    croquis_filtro(<?php echo $vehiculo_id ?>,$("#cmb_piso").val());
                    break;
                case "tv":
                    var nuevoId=($('.seleccionado').attr("id")).split('_');
                    $('.seleccionado').attr("id",nuevoId[0]+'_'+nuevoId[1]+'_'+'tv');
                    $('#sortable3').trigger('sortupdate'); // Trigger the update event manually
                    $('#sortable3').sortable( "refreshPositions" );
                    croquis_filtro(<?php echo $vehiculo_id ?>,$("#cmb_piso").val());
                    break;
                case "grada":
                    var nuevoId=($('.seleccionado').attr("id")).split('_');
                    $('.seleccionado').attr("id",nuevoId[0]+'_'+nuevoId[1]+'_'+'g');
                    $('#sortable3').trigger('sortupdate'); // Trigger the update event manually
                    $('#sortable3').sortable( "refreshPositions" );
                    croquis_filtro(<?php echo $vehiculo_id ?>,$("#cmb_piso").val());
                    break;
            }

        });
    });
</script>
<input type="hidden" id="hdd_veh_id" value="<?php echo $vehiculo_id;?>">
<p>PISO:
    <select name="cmb_piso" id="cmb_piso">
        <option value="1">1</option>
        <option value="2">2</option>
    </select>
</p>

<div id="div_croquis_filtro">

</div>

<div id="menu-click">
    <ul>
        <li id="tv">Convertir en TV</li>
        <li id="grada">Convertir en Gradas</li>
        <li id="d">Desactivar</li>
        <li id="a">Convertir en Asiento</li>
    </ul>
</div>