<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();

require_once ("../formatos/formato.php");

require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();

$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa = $dt['tb_empresa_ruc'];


$dts1=$oVenta->mostrar_filtro_cliente($_POST['ven_des_nom'],$_POST['puntoventa_id']);
$num_rows= mysql_num_rows($dts1);
?>

<script type="text/javascript">
    $(function() {
        $('.btn_accion').button({
            icons: {primary: "ui-icon-mail-closed"},
            text: false
        });
        $('.btn_editar').button({
            icons: {primary: "ui-icon-pencil"},
            text: false
        });
        $('.btn_sunat').button({
            text: true
        });
        $('.btn_eliminar').button({
            icons: {primary: "ui-icon-trash"},
            text: false
        });

        $('.btn_anular').button({
            icons: {primary: "ui-icon-cancel"},
            text: false
        });
        $('.btn_pdf,#btn_cobrar').button({
            //icons: {primary: "ui-icon-document"},
            //text: false
        });
        $('.btn_xml,.btn_cdr').button({
            //icons: {primary: "ui-icon-document"},
            //text: false
        });

        $("#tabla_encomienda_venta").tablesorter({
            widgets: ['zebra', 'zebraHover'] ,
            headers: {
                0: {sorter: 'shortDate' }
            },
            //sortForce: [[0,0]],
            sortList: [[0,0],[1,1]]
        });

        $('#cmb_ven_doc').change( function(){

            if($('#cmb_ven_doc').val()=='11')//factura->ruc
            {
                $("#txt_dni").attr('maxlength','11');
            }
            else{//boleta->dni
                $("#txt_dni").attr('maxlength','8');
            }
            $('#txt_dni').val('');
            $('#txt_cli_nom').val('');
            $('#txt_dni').focus();
        });

        $( "#txt_dni" ).keypress(function( event ) {
            if ( event.which == 13) {
                buscar();
            }
        });

    });

    function venta_clientereserva_reg() {
        var cli_id='';
        var cli_tip;
        $('#cmb_ven_doc').val()
        if ($('#cmb_ven_doc').val()=='11'){
            cli_tip = 2;
        }else if($('#cmb_ven_doc').val()=='12'){
            cli_tip = 1;
        }
        console.log(cli_tip);
        $.ajax({
            type: "POST",
            url: "../clientes/cliente_reg.php",
            async: false,
            dataType: "json",
            data: ({
                action_cliente: 'insertar',
                txt_cli_nom: $('#txt_cli_nom').val(),
                txt_cli_doc: $('#txt_dni').val(),
                rad_cli_tip: cli_tip
            }),
            beforeSend: function () {
                $('#msj_cliente').html("Guardando...");
                $('#msj_cliente').show(100);
            },
            success: function (data) {
                $('#msj_cliente').html(data.cli_msj);
                cli_id = data.cli_id;

            },
            complete: function () {
            }
        });
        return cli_id;
    }

    function pedir_clave(enc_id) {
        var clave = prompt("Ingresa la clave");
        if (clave !== '') {

                $.ajax({
                    type: "POST",
                    url: "../venta/encomienda_estado_reg.php",
                    async:true,
                    dataType: "json",
                    data: ({
                        action: 'actualizar_estado',
                        enc_id: enc_id,
                        clave: clave
                    }),
                    beforeSend: function() {
                        $('#msj_encomienda').html("Guardando...");
                        $('#msj_encomienda').show(100);
                    },
                    success: function(data){
                        $('#msj_encomienda').html(data.enc_msj);
                    },
                    complete: function(){
                        venta_encomienda_tabla();
                    }
                });

        }else{
            pedir_clave(enc_id);
        }
    }
    function pagar_encomienda(act,idf) {

        if ($('#txt_dni').val()=="" || $('#txt_cli_nom').val()=="") {
            alert("DNI o Nombre Vacío, Escriba el DNI del cliente y presione la tecla ENTER para obtener sus datos...");
            $('#txt_dni').focus();
        }
        else{
            var cli_id = venta_clientereserva_reg();
            $.ajax({
                type: "POST",
                url: "../venta/venta_reg2.php",
                async: true,
                dataType: "json",
                data: ({
                    action_venta: act,
                    ven_id: idf,
                    cmb_ven_doc: $('#cmb_ven_doc').val(),
                    cli_id: cli_id,
                    chk_imprimir: 1
                }),
                beforeSend: function () {
                    $('#msj_venta').html("Cargando...");
                    $('#msj_venta').show(100);
                },
                success: function (data) {
                    $('#msj_venta').html(data.ven_msj);
                    $('#msj_venta').show();

                    if (data.ven_sun == 'enviar') {
                        enviar_sunat(data.ven_id, data.ven_act);
                    }
                    else {
                        if (data.ven_act == 'imprime') {
                            venta_impresion(data.ven_id);
                        }
                    }

                },
                complete: function () {
                    venta_encomienda_tabla();
                }
            });
        }
    }


</script>
<table cellspacing="1" id="tabla_encomienda_venta" class="tablesorter">
    <thead>
    <tr>
        <th align="center">FECHA</th>
        <th align="center">TIPO DE DOCUMENTO</th>
        <th align="center">SERIE-NUMERO</th>
        <th align="center">ESTADO</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <?php
    if($num_rows>0){
        ?>
        <tbody>
        <?php
        while($dt1 = mysql_fetch_array($dts1)){
            ?>
            <tr>
                <td nowrap="nowrap" align="center"><?php echo mostrarFecha($dt1['tb_venta_fec'])?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_documento_nom'];?></td>
                <td nowrap="nowrap"><?php echo $dt1['tb_venta_ser'].'-'.$dt1['tb_venta_num']?></td>
                <td nowrap="nowrap"><?php
                    if ($dt1['tb_estado']=='1'){
                        echo 'Entregado';
                    }else{
                        echo '<span style="color: red">Pendiente</span>';
                    }
                    ?>
                </td>
                <td align="left" nowrap="nowrap">
                    <a class="btn_pdf" id="btn_pdf" href="#print" title="Descargar pdf" onClick="venta_impresion('<?php echo $dt1['tb_venta_id']?>')">PDF</a>

                    <?php if ($dt1['tb_estado']=='0') {
                        if ($dt1['tb_encomiendaventa_pagado']=='1') {?>
                            <a class="btn_pdf" id = "btn_pdf" title = "Entregar" onclick = "pedir_clave(<?php echo $dt1['tb_encomiendaventa_id'];?>)" > Entregar</a>
                        <?php }else{ ?>
                            <select name="cmb_ven_doc" id="cmb_ven_doc" class="valid">	<option value="">-</option>
                                <option value="11">FE | FACTURA ELECTRONICA</option>
                                <option value="12" selected="">BE | BOLETA ELECTRONICA</option>
                            </select>
                            <input name="txt_dni" type="text" id="txt_dni" value="" size="10" maxlength="11">
                            <input name="txt_cli_nom" type="text" id="txt_cli_nom" value="" size="60">

                            <a id = "btn_cobrar" title = "Cobrar" onclick = "pagar_encomienda('insertar', <?php echo $dt1['tb_venta_id'];?>)" >Pagar</a>
                        <?php }
                    } ?>
                </td>

            </tr>
            <?php
        }
        mysql_free_result($dts1);
        ?>
        </tbody>
        <?php
    }
    ?>

    <tr class="even">
        <td colspan="13"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>