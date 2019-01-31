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

    function pagar_encomienda(act,idf){
        $.ajax({
            type: "POST",
            url: "../venta/venta_encomienda_form.php",
            async:true,
            dataType: "html",
            data: ({
                action: act,
                ven_id:	idf
            }),
            beforeSend: function() {
                $('#msj_venta').hide();
                $('#msj_venta_sunat').hide();
                $('#div_venta_form').dialog("open");
                $('#div_venta_form').html('Cargando <img src="../../images/loadingf11.gif" align="absmiddle"/>');
            },
            success: function(html){
                $('#div_venta_form').html(html);
            },
            complete: function(){
                if(act=='insertar')
                {
                    $( "#div_venta_form" ).dialog({
                        title:'Información de Venta | <?php echo $_SESSION['empresa_nombre']?> | Agregar',
                        height: 650,
                        width: 980,
                        buttons: {
                            Guardar: function(){
                                txt_ven_numdoc();
                                if($('#hdd_ven_doc').val()==1){
                                    if($('#hdd_ven_numite').val()>0)
                                    {
                                        venta_check();
                                    }
                                    else{
                                        $("#for_ven").submit();
                                    }
                                }
                                else
                                {
                                    $("#for_ven").submit();
                                }
                            },
                            Cancelar: function() {
                                $('#for_ven').each (function(){this.reset();});
                                $( this ).dialog( "close" );
                            }
                        }
                    });
                }

                if(act=='editar')
                {
                    $( "#div_venta_form" ).dialog({
                        title:'Información de Venta | <?php echo $_SESSION['empresa_nombre']?> | Editar',
                        buttons: {
                            Cancelar: function() {
                                $('#for_ven').each (function(){this.reset();});
                                $( this ).dialog( "close" );
                            }
                        }
                    });
                }
            }
        });
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
                        <a class="btn_pdf" id = "btn_pdf" title = "Pagar" onclick = "pagar_encomienda('insertar', <?php echo $dt1['tb_venta_id'];?>)" >Pagar</a>
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