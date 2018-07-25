<?php
require_once ("../../config/Cado.php");
require_once ("../guiapagocontrol/cGuiapago.php");
$oGuiapago = new cGuiapago();
require_once ("../guiapagotipo/cGuiapagotipo.php");
$oGuiapagotipo = new cGuiapagotipo();
require_once ("../guiapagonota/cGuiapagonota.php");
$oGuiapagonota = new cGuiapagonota();

require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();

//require_once ("../guiapagocontrol/guiapagocontrol_fecha.php");

require_once ("../formatos/formato.php");
require_once ("../formatos/fechas.php");

/*$fecha_hoy=date('d-m-Y');
list($day,$mon,$year) = explode('-',$fecha_hoy);
$fecha_ayer=date('d-m-Y',mktime(0,0,0,$mon,$day-1,$year)); 
$fecha_mañana=date('d-m-Y',mktime(0,0,0,$mon,$day+1,$year)); 
$fecha_pasado=date('d-m-Y',mktime(0,0,0,$mon,$day+2,$year)); 
$fecha_pasado_mañana=date('d-m-Y',mktime(0,0,0,$mon,$day+3,$year));*/


$celeste_oscuro ="#A9D0F5";//celeste oscuro
$blanco         ="#FFFFFF";//blanco
$celeste_claro  ="#CEE3F6";//celeste claro
$celeste        ="#AFDCF8";
$gris_claro     ="#E6E6E6";//gris claro
$rosado         ="#FBEFF2";//rosado
$verde          ="#A9F5A9";//verde
$naranja        ="#F7BE81";//naranja
$azul           ="#81BEF7";//azul
$plomo          ="#BDBDBD";//plomo
$rojo           ="#F78181";
$amarillo       ="#F5DA81";
$rojo_oscuro    ="#FA5858";

$color11="#F5A9A9";
$color22="#F5D0A9";
$color33="#F2F5A9";
$color44="#D0F5A9";
?>
<script type="text/javascript">
$(function() {	
	$('.btn_editar').button({
		icons: {primary: "ui-icon-pencil"},
		text: false
	});
	
	$('.btn_eliminar').button({
		icons: {primary: "ui-icon-trash"},
		text: false
	});
	
	$('.btn_accion').button({
		//icons: {primary: "ui-icon-info"},
		text: true
	});
    $('.btn_email').button({
        //icons: {primary: "ui-icon-email"},
        text: true
    });

    $(".btn_accion").css({height: "18px", 'vertical-align':"middle", padding: "0 0 0 0" });
    $(".btn_accion .ui-button-text").css({padding: ".3em 1em"});

	$.tablesorter.defaults.widgets = ['zebra','zebraHover'];
	$("#tabla_probalance").tablesorter({ 
		headers: {
			0: {sorter: false }, 
			1: {sorter: false},
            2: {sorter: false}
        },
		//sortForce: [[0,0]],
    });
}); 
</script>
<?php 
//consulta para mostrar tabla
if($_POST['hdd_fil_cli_id']>0 and $_POST['cmb_fil_eje_id']>0 and $_POST['cmb_fil_per_id']>0){?>
<table cellspacing="1" id="tabla_probalance" class="tablesorter">
    <thead>
        <tr>
            <th>DETALLE</th>               
            <th colspan="5">ACCION</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $nottip=2;
        $probalite_id=0;
        
        $rws=$oGuiapagonota->listar($_POST['hdd_fil_cli_id'],$_POST['cmb_fil_per_id'],$_POST['cmb_fil_eje_id'],$nottip);
        $correos= mysql_num_rows($rws);
        $rw = mysql_fetch_array($rws);
        mysql_free_result($rws);
        
    ?>

    <tr>
        <td style="font-size:9pt; font-weight:bold; background:<?php echo $gris_claro?>; ">
            <?php echo $dt0['tb_probalanceitemtipo_nom']?>
            <a name="<?php echo $dt0['tb_digito_val']?>"></a>
        </td>
        <td colspan="5" style="font-size:8pt; font-weight:normal; background:<?php echo $gris_claro?>; ">
            <?php 
            if($correos>0){
                $tipo=2;//correos?>
                <a class="btn_accion2" href="#correo" onClick="guiapagocontrol_nota(
                '<?php echo $_POST['hdd_fil_cli_id']?>',
                '<?php echo $_POST['cmb_fil_per_id']?>',
                '<?php echo $_POST['cmb_fil_eje_id']?>',
                '<?php echo $tipo?>'
                )"><?php echo "Correos enviados ($correos)";?></a>
            <?php }?>
            <?php
            //if($probalcon_xac!=1 or $dt0['tb_probalanceitemtipo_id']==1){
                ?>
                <a class="btn_accion" id="btn_accion" href="#correo" title="Enviar correo" onClick="correo_form('enviar',
                '',
                '<?php echo $_POST['hdd_fil_cli_id']?>',
                '<?php echo $_POST['cmb_fil_per_id']?>',
                '<?php echo $_POST['cmb_fil_eje_id']?>'
                )">Enviar Correo</a>
            <?php //}?>
            <?php
            //if($probalcon_xac!=1 or $dt0['tb_probalanceitemtipo_id']==1){
                ?>
                <a class="btn_accion" id="btn_accion" href="#guia" title="Registrar Guía de Pago" onClick="guiapago_form('insertar',
                '',
                '<?php echo $_POST['hdd_fil_cli_id']?>',
                '<?php echo $_POST['cmb_fil_per_id']?>',
                '<?php echo $_POST['cmb_fil_eje_id']?>',
                '<?php echo $guipagtip_id?>'
                )">Nueva Guía de Pago</a>
            <?php //}?>
        </td>
    </tr>
    <tr class="even">
        <td style="font-size:9pt; font-weight:bold; background:<?php ?>; ">
            <?php echo $dt0['tb_probalanceitemtipo_nom']?>
        </td>
        <td colspan="5" style="font-size:8pt; font-weight:normal; background:<?php ?>; ">
        <?php ?>
        </td>
    </tr>

    <?php
    $dts0=$oGuiapagotipo->mostrarTodos();
    $num_rows0= mysql_num_rows($dts0);
    while($dt0 = mysql_fetch_array($dts0)){

        $color_digito_estado=$celeste_oscuro;
        
        //CONSULTA CONTROL
        $dts1=$oGuiapago->guiapago_control($_POST['hdd_fil_cli_id'],$dt0['tb_guiapagotipo_id'],$_POST['cmb_fil_per_id'],$_POST['cmb_fil_eje_id']);
        $num_rows1= mysql_num_rows($dts1);
        
        if($num_rows1>0)
        {
            
    ?>
    <tr>
        <td colspan="2" style="font-size:9pt; font-weight:bold; background:<?php echo $celeste_oscuro?>; ">
            <?php
                echo $dt0['tb_guiapagotipo_nom'];
            ?>
        </td>
        <td colspan="4" style="font-size:8pt; font-weight:normal; background:<?php echo $color_digito_estado?>; ">
        <?php echo '';?>
        </td>
    </tr>
    <?php
            while($dt1 = mysql_fetch_array($dts1)){
                if($dt1['tb_guiapago_xac']==1){
    ?>

    <tr>
        <td>
            <?php 
                $nombre="";
                $guiapago="";
                //if($dt1['tb_guiapago_des']!="")$guiapago=": ".$dt1['tb_guiapago_des'];
                if($dt1['tb_guiapago_des']!="")$guiapago="".$dt1['tb_guiapago_des'];
                //$nombre="<strong>GUIA DE PAGO$guiapago</strong>"; 
                $nombre="<strong>$guiapago</strong>"; 
                echo $nombre;
            ?>
        </td>
        <td>
            <?php if($dt0['tb_guiapagotipo_id']=='1'){?>
            <table style="border-collapse: collapse;">
                <tr>
                    <td><strong>FECHA DE PAGO:</strong></td>
                    <td><strong><?php echo mostrarFecha($dt1['tb_guiapago_fecpag'])?></strong></td>
                </tr>
                <tr>
                    <td width="300">COD. TRIBUTO:</td>
                    <td width="150"><?php echo $dt1['tb_guiapago_codtri']?></td>
                </tr>
                <tr>
                    <td>IMPORTE A PAGAR: S/.</td>
                    <td><?php echo formato_money($dt1['tb_guiapago_imppag'])?></td>
                </tr>
                <?php if($dt1['tb_guiapago_codtriaso']!=""){?>
                <tr>
                    <td>COD. ASOCIADO:</td>
                    <td><?php echo $dt1['tb_guiapago_codtriaso']?></td>
                </tr>
                <?php }?>
                <?php if($dt1['tb_guiapago_numdoc']!=""){?>
                <tr>
                    <td>NUM. DOCUMENTO:</td>
                    <td><?php echo $dt1['tb_guiapago_numdoc']?></td>
                </tr>
                <?php }?>
            </table>
            <?php }?>

            <?php if($dt0['tb_guiapagotipo_id']=='2'){?>
            <table style="border-collapse: collapse;">
                <tr>
                    <td><strong>FECHA DE PAGO:</strong></td>
                    <td><strong><?php echo mostrarFecha($dt1['tb_guiapago_fecpag'])?></strong></td>
                </tr>
                <tr>
                    <td width="300">RUC ARRENDADOR:</td>
                    <td width="150"><?php echo $dt1['tb_cliente_doc']?></td>
                </tr>
                <tr>
                    <td width="300">COD. TIPO DOC.:</td>
                    <td width="150"><?php echo $dt1['tb_guiapago_tipdocinq']?></td>
                </tr>
                <tr>
                    <td>RUC INQUILINO:</td>
                    <td><?php echo $dt1['tb_guiapago_numdocinq']?></td>
                </tr>
                <tr>
                    <td>MONTO ALQUILER: S/.</td>
                    <td><?php echo formato_money($dt1['tb_guiapago_monalq'])?></td>
                </tr>
                <?php if($dt1['tb_guiapago_arrrec']=='2'){?>
                <tr>
                    <td>NUM. ORD:</td>
                    <td><?php echo $dt1['tb_guiapago_numordope']?></td>
                </tr>
                <tr>
                    <td>IMP. PAGAR SER EL CASO: S/.</td>
                    <td><?php echo formato_money($dt1['tb_guiapago_imppagser'])?></td>
                </tr>
                <?php }?>
                <tr>
                    <td>IMPORTE A PAGAR: S/.</td>
                    <td><?php echo formato_money($dt1['tb_guiapago_arrimppag'])?></td>
                </tr>
            </table>
            <?php }?>

            <?php if($dt0['tb_guiapagotipo_id']=='3'){?>
            <table style="border-collapse: collapse;">
                <tr>
                    <td><strong>FECHA DE PAGO:</strong></td>
                    <td><strong><?php echo mostrarFecha($dt1['tb_guiapago_fecpag'])?></strong></td>
                </tr>
                <tr>
                    <td width="300">TOTAL INGRESOS B. MES: S/.</td>
                    <td width="150"><?php echo formato_money($dt1['tb_guiapago_toting'])?></td>
                </tr>
                <tr>
                    <td>CATEGORÍA:</td>
                    <td><?php echo $dt1['tb_guiapago_cat']?></td>
                </tr>
                <tr>
                    <td>MONTO A COMPENSAR: S/.</td>
                    <td><?php echo formato_money($dt1['tb_guiapago_moncom'])?></td>
                </tr>
                <tr>
                    <td>IMPORTE A PAGAR: S/.</td>
                    <td><?php echo formato_money($dt1['tb_guiapago_rusimppag'])?></td>
                </tr>
                <?php if($dt1['tb_guiapago_privez']=='2'){?>
                <tr>
                    <td>COMPENSACIÓN Y/O PAGOS EFECT.: S/.</td>
                    <td><?php echo formato_money($dt1['tb_guiapago_compag'])?></td>
                </tr>
                <?php }?>
            </table>
            <?php }?>

            <?php if($dt0['tb_guiapagotipo_id']=='4'){?>
            <table style="border-collapse: collapse;">
                <tr>
                    <td><strong>FECHA DE PAGO:</strong></td>
                    <td><strong><?php echo mostrarFecha($dt1['tb_guiapago_fecpag'])?></strong></td>
                </tr>
                <tr>
                    <td width="300">RUC ARRENDADOR:</td>
                    <td width="150"><?php echo $dt1['tb_guiapago_numrucarr']?></td>
                </tr>
                <tr>
                    <td width="300">COD. TIPO DOC.:</td>
                    <td width="150"><?php echo $dt1['tb_guiapago_tipdocinq']?></td>
                </tr>
                <tr>
                    <td>RUC INQUILINO:</td>
                    <td><?php echo $dt1['tb_cliente_doc']?></td>
                </tr>
                <tr>
                    <td>MONTO ALQUILER: S/.</td>
                    <td><?php echo formato_money($dt1['tb_guiapago_monalq'])?></td>
                </tr>
                <?php if($dt1['tb_guiapago_arrrec']=='2'){?>
                <tr>
                    <td>NUM. ORD:</td>
                    <td><?php echo $dt1['tb_guiapago_numordope']?></td>
                </tr>
                <tr>
                    <td>IMP. PAGAR SER EL CASO: S/.</td>
                    <td><?php echo formato_money($dt1['tb_guiapago_imppagser'])?></td>
                </tr>
                <?php }?>
                <tr>
                    <td>IMPORTE A PAGAR: S/.</td>
                    <td><?php echo formato_money($dt1['tb_guiapago_arrimppag'])?></td>
                </tr>
            </table>
            <?php }?>


        </td>
        <td valign="top">
            <?php echo "FECHA: ".mostrarFechaHora($dt1['tb_guiapago_fecmod']);?>
            <br>
            <?php echo "ID: ".$dt1['tb_guiapago_id'];?>
            <br>
            <?php 
                if($dt1['tb_guiapago_envcor']=='0')
                {
                    echo "ENVÍO DE CORREO: <span class='alerta_g'>INACTIVO</span>";
            ?>
            <br><a class="btn_accion" href="#act" onClick="guiapago_envcor('1','<?php echo $dt1['tb_guiapago_id']?>')">Activar</a>
            <?php }?>
            <?php 
                if($dt1['tb_guiapago_envcor']=='1')
                {
                    echo "ENVÍO DE CORREO: <span class='alerta_v'><strong>ACTIVO</strong></span>";
            ?>
            <br><a class="btn_accion" href="#des" onClick="guiapago_envcor('0','<?php echo $dt1['tb_guiapago_id']?>')">Desactivar</a>
            <?php }?>
        </td>                         
        <td align="center">
            <?php $documento="Imprimir"?>
            <?php /*?><a style="color: blue;" title="Imprimir Guía de Pago" href="#imprimir" onClick="guiapago_impresion('<?php echo $dt1['tb_guiapago_id']?>')"><?php echo $documento?></a><?php */?>

            <?php if($dt0['tb_guiapagotipo_id']=='1'){?>
            <a class="btn_accion" style="color: blues;" target="_blank" title="Imprimir Guía de Pago" href="<?php echo 'guiapago_impresion_formato1.php?d1='.$dt1['tb_guiapago_id'].'&d2='.$dt1['tb_cliente_id'];?>"><?php echo $documento?>
            </a>
            <?php }?>

            <?php if($dt0['tb_guiapagotipo_id']=='2'){?>
            <a class="btn_accion" style="color: blues;" target="_blank" title="Imprimir Guía de Pago" href="<?php echo 'guiapago_impresion_formato2.php?d1='.$dt1['tb_guiapago_id'].'&d2='.$dt1['tb_cliente_id'];?>"><?php echo $documento?>
            </a>
            <?php }?>

            <?php if($dt0['tb_guiapagotipo_id']=='3'){?>
            <a class="btn_accion" style="color: blues;" target="_blank" title="Imprimir Guía de Pago" href="<?php echo 'guiapago_impresion_formato3.php?d1='.$dt1['tb_guiapago_id'].'&d2='.$dt1['tb_cliente_id'];?>"><?php echo $documento?>
            </a>
            <?php }?>

            <?php if($dt0['tb_guiapagotipo_id']=='4'){?>
            <a class="btn_accion" style="color: blues;" target="_blank" title="Imprimir Guía de Pago" href="<?php echo 'guiapago_impresion_formato4.php?d1='.$dt1['tb_guiapago_id'].'&d2='.$dt1['tb_cliente_id'];?>"><?php echo $documento?>
            </a>
            <?php }?>
            
            <a class="btn_accion" id="btn_accion" href="#guia" title="Actualizar Guía de Pago" onClick="guiapago_form('insertar_actualizacion',
                '<?php echo $dt1['tb_guiapago_id']?>',
                '<?php echo $_POST['hdd_fil_cli_id']?>',
                '<?php echo $_POST['cmb_fil_per_id']?>',
                '<?php echo $_POST['cmb_fil_eje_id']?>',
                '<?php echo $guipagtip_id?>'
                )">Actualizar Guía</a>
            <br><br>
            <a class="btn_accion" href="#eliminar" onClick="guiapago_eliminar('<?php echo $dt1['tb_guiapago_id']?>')">Eliminar</a>
        </td>
    </tr>
 
    <?php
                }//if
            }
            mysql_free_result($dts1);
        }
    }
    mysql_free_result($dts0);
    ?>
    </tbody>
</table>
<?php 
}
else
{
    echo "Seleccione Cliente, Ejercicio y Periodo.";
}//consulta para mostrar tabla?>