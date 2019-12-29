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
    function croquis_filtro()
    {
        $.ajax({
            type: "POST",
            url: "croquis_asiento_filtro.php",
            async:true,
            dataType: "html",
            data: ({

            }),
            beforeSend: function() {
                $('#div_croquis_tabla').addClass("ui-state-disabled");
            },
            success: function(html){
                $('#div_croquis_tabla').html(html);
            },
            complete: function(){
                $('#div_croquis_tabla').removeClass("ui-state-disabled");
            }
        });
    }
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