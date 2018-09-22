<?php
require_once ("../../config/Cado.php");
require_once ("../lote/cLote.php");
$oLote = new cLote();

if($_POST['action']=="editar")
{
//	$dts=$oMarca->mostrarUno($_POST['lot_id']);
//	$dt = mysql_fetch_array($dts);
//		$mar_nom=$dt['tb_lote_nom'];
//	mysql_free_result($dts);
}
?>
<script type="text/javascript">
    $(function() {

        $('.btn_agregar_lote').button({
            text: true
        });
        $('.btn_editar').button({
            icons: {primary: "ui-icon-pencil"},
            text: false
        });

        $('.btn_eliminar').button({
            icons: {primary: "ui-icon-trash"},
            text: false
        });

        $.tablesorter.defaults.widgets = ['zebra'];
        $("#tabla_lote").tablesorter({
            headers: {
                1: {sorter: false },
                2: { sorter: false}},
            //sortForce: [[0,0]],
            sortList: [[0,0]]
        });

        $( "#div_agregar_lote_form" ).dialog({
            title:'Agregar Lote',
            autoOpen: false,
            resizable: false,
            height: 'auto',
            width: 550,
            modal: true,
            buttons: {
                Guardar: function() {
                    $("#for_agregar_lote").submit();
                },
                Cancelar: function() {
                    $('#for_agregar_lote').each (function(){this.reset();});
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                $("#div_agregar_lote_form").html('Cargando...');
            }
        });
    });

    function agregar_lote_form(act,preid,almid, stoid){
        $.ajax({
            type: "POST",
            url: "../producto/agregar_lote_form.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                pre_id: preid,
                alm_id: almid,
                sto_id: stoid,
                pro_id: <?php echo $_POST['pro_id']?>
            }),
            beforeSend: function() {
                $('#msj_presentacion_lote').hide();
                $('#div_agregar_lote_form').dialog("open");
                $('#div_agregar_lote_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_agregar_lote_form').html(html);
            }
        });
    }

</script>
<form id="for_mar">
<input name="action_marca" id="action_marca" type="hidden" value="<?php echo $_POST['action']?>">
<input name="hdd_mar_id" id="hdd_mar_id" type="hidden" value="<?php echo $_POST['mar_id']?>">
    <input name="hdd_sto_id" id="hdd_sto_id" type="hidden" value="<?php echo $_POST['sto_id']?>">
    <table cellspacing="1" id="tabla_lote" class="tablesorter">
        <thead>
        <tr>
            <th>LOTE</th>
            <th>FECHA FABRICACION</th>
            <th>FECHA VENCIMIENTO</th>
            <th>STOCK INICIAL</th>
            <th>STOCK ACTUAL</th>
            <th align="center">ESTADO</th>
            <th align="center">&nbsp;</th>
        </tr>
        </thead>
        <?php
        $dts1=$oLote->mostrarLoteProducto($_POST['pre_id'],$_POST['alm_id'],$_POST['sto_id']);
        $num_rows= mysql_num_rows($dts1);
        if($num_rows>=1)
        {
            ?>
            <tbody>
            <?php while($dt1 = mysql_fetch_array($dts1)){?>
                <tr>
                    <td><strong><?php echo $dt1['tb_lote_numero']?></strong></td>
                    <td><strong><?php echo $dt1['tb_lote_fechafab']?></strong></td>
                    <td align="right"><?php echo $dt1['tb_lote_fechavence']?></td>
                    <td align="center"><?php echo $dt1['tb_lote_exisini']?></td>
                    <td align="center"><?php echo $dt1['tb_lote_exisact']?></td>
                    <td align="center"><a class="btn_editar" onClick="lote_form('editar','<?php echo $dt1['tb_lote_id']?>')">Editar Lote</a><a class="btn_eliminar" onClick="eliminar_lote('<?php echo $dt1['tb_lote_id']?>')"> Eliminar Lote</a></td>
                </tr>
                <?php
            }
            mysql_free_result($dts1);
            ?>
            </tbody>
            <?php
        }
        else
        {
            ?>
            <tr>
                <!--<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>-->
            </tr>
        <?php }?>
    </table>
    <br>
    <div style="text-align: center;">
        <a class="btn_agregar_lote" onClick="agregar_lote_form('insertar', <?php echo $_POST['pre_id'] ?>, <?php echo $_POST['alm_id'] ?>, <?php echo $_POST['sto_id'] ?>)">
            Agregar Lote
        </a>
    </div>
    <div id="msj_lote" class="ui-state-highlight ui-corner-all" style="width:auto; float:right; padding:2px; display:none"></div>
    <div id="div_agregar_lote_form" class="">

    </div>
</form>
