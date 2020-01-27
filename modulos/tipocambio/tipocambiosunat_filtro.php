<?php

session_start();

?>
<script type="text/javascript">
	$('#btn_cargartablaple_txt').button({
		icons: {primary: "ui-icon-search"},
	});
	$('#btn_resfil').button({
        icons: {primary: "ui-icon-arrowrefresh-1-w"},

    });

    function ComboAno(){

        var d = new Date();
        var n = d.getFullYear();
        var select = document.getElementById("cmb_fil_anio");
        for(var i = n; i >= 2015; i--) {
            var opc = document.createElement("option");
            opc.text = i;
            opc.value = i;
            select.add(opc);
        }
    }

$(function() {
    ComboAno();
    $('#cmb_fil_anio').change(function(e) {
        tipocambiosunat_tabla();
    });
    $('#cmb_fil_mes').change(function(e) {
        tipocambiosunat_tabla();
    });
});
</script>

<style>
    #for_fil_ple{
        width: 60%;
        margin: 0 auto;
    }
    .center{
        width: 50%;
        text-align: center;
        margin: 0 auto;
    }
    #for_fil_ple label {
        display:inline-block;
        width: 140px;
        padding: 5px;
    }
    #for_fil_ple input[type="text"]{
        width: 180px;
    }
    #for_fil_ple select{
        width: 180px;
    }
</style>

<form name="for_fil_tc" id="for_fil_tc" target="_blank" action="" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="tipocambiosunat_tabla.php">

    <input name="hdd_action" id="hdd_action" type="hidden" value="">
    <input type="hidden" id="hdd_tabla" name="hdd_tabla" />
<div style="width: 100%;margin: 0 auto">

    <fieldset style="width: 100%;float: left"><legend>Descargar PLE</legend>
        <label for="cmb_fil_anio" align="right">Año:</label>
        <select name="cmb_fil_anio" id="cmb_fil_anio">
        </select>

        <label for="cmb_fil_mes" align="right">Mes:</label>
        <select name="cmb_fil_mes" id="cmb_fil_mes">
            <option value="01">Enero</option>
            <option value="02">Febrero</option>
            <option value="03">Marzo</option>
            <option value="04">Abril</option>
            <option value="05">Mayo</option>
            <option value="06">Junio</option>
            <option value="07">Julio</option>
            <option value="08">Agosto</option>
            <option value="09">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
        </select>
<!--        <a href="#" onClick="tipocambiosunat_tabla();" id="btn_cargartablaple_txt" class="center">CARGAR</a>-->
    </fieldset>
</div>


</form>