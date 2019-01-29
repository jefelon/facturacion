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


$dts1=$oVenta->mostrar_filtro_cliente($_POST['ven_des_nom']);
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
        $('.btn_pdf').button({
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

    });

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
                    <?php if ($dt1['tb_estado']=='0') {?>
                        <a class="btn_pdf" id = "btn_pdf" title = "Entregar" onclick = "pedir_clave(<?php echo $dt1['tb_encomiendaventa_id'];?>)" > Entregar</a>
                    <?php } ?>
                    <?php if ($dt1['tb_encomiendaventa_pagado']=='0') {?>
                        <a class="btn_pdf" id = "btn_pdf" title = "Entregar" onclick = "pagar_encomienda(<?php echo $dt1['tb_encomiendaventa_id'];?>)" >Pagar</a>
                    <?php } ?>
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