<?php
session_start();
require_once ("../../config/Cado.php");
require_once('../../libreriasphp/html2pdf/_tcpdf_5.9.206/tcpdf.php');
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../compra/cCompra.php");
$oCompra = new cCompra();
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once("../formatos/formato.php");
require_once("../formatos/fechas.php");

$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$ruc_empresa=$dt['tb_empresa_ruc'];
$razon_defecto = $dt['tb_empresa_razsoc'];
$direccion_defecto = $dt['tb_empresa_dir'];

$mes = strtoupper(nombre_mes($_POST['cmb_fil_mes']));

$fecha_actual=$d=date('d/m/Y');
$titulo='REPORTE DE COMPRAS';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
</head>
<style type="text/css">
    body {
        color: black;
        font-family: Verdana, Arial, Consolas;
        margin: 0px;
        padding-top: 0px;
        font-size: 5pt;
    }

    .header_major_row th {
        border: 0.9px solid #000000;
        background-color: #d6d6d6;
        color: black;
        text-transform:uppercase;
        vertical-align: middle;
    }
    .header_minor_row th {
        border-bottom: 0.9px solid #000000;
        border-right: 0.9px solid #000000;
        border-left: 0.9px solid #000000;
        background-color: #FFF;
        color: black;
        text-transform:uppercase;
    }
</style>

<style media="print">
    .oculto{
        display: none;
    }

</style>
<body>
<table id="tabla_producto" style="width: 100%; border-collapse:collapse;">
        <thead>
            <tr><td colspan="27" style="font-size: 15px; text-align: left;"><b><?php echo $razon_defecto ?></b><br>
                    <?php echo $direccion_defecto ?><br>
                    RUC:<?php echo $ruc_empresa ?><br>
                </td>
            </tr>
            <tr><td colspan="27" style="font-size: 30px; text-align: center;"><b>*** REGISTRO DE COMPRAS DEL MES DE <?php echo $mes ?> DEL <?php echo $_POST['cmb_fil_anio'] ?> *** </b></td></tr>
            <tr><td colspan="27" style="font-size: 30px; text-align: center;"><b>SOLES</b></td></tr>
            <tr><td colspan="27" style="font-size: 15px; text-align: right;"><b><?php echo $fecha_actual ?></b></td></tr>
            <tr><td colspan="27"><b></td></tr>
            <tr class="header_major_row">
            <th rowspan="2" style="text-align: center; width: 2%;"><br><br><b>O.</b></th>
            <th rowspan="2" style="text-align: center; width: 3%;"><br><br><b>N° VOU</b></th>
            <th rowspan="2" style="text-align: center; width: 5%;"><br><br><b>F. Emisión</b></th>
            <th rowspan="2" style="text-align: center; width: 5%;"><br><br><b>F. Venc.</b></th>
            <th colspan="3" scope="colgroup"  style="text-align: center;"><br><br>Datos del Documento</th>
            <th colspan="4" scope="colgroup"  style="text-align: center;"><br><br>Referencia del Documento</th>
            <th colspan="3" scope="colgroup"  style="text-align: center; width: 15%"><br><br>Datos del Proveedor</th>
            <th rowspan="2" style="text-align: center;"><b>Base Imp. Adq Grav. y de Exp. A</b></th>
            <th rowspan="2" style="text-align: center;"><b>Base Imp. Adq Grav.  y de Exp. y no Grav. B</b></th>
            <th rowspan="2" style="text-align: center;"><b>Base Imp. Adq Grav. sin Der. Credito Fiscal C</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>Adq. no Gravadas</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>I.S.C.</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>I.G.V. A</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>I.G.V. B</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>I.G.V. C</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>Otros Tributos</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>Total</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>T/C</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>Spot Fecha</b></th>
            <th rowspan="2" style="text-align: center;"><br><br><b>Spot Numero</b></th>
        </tr>
        <tr class="header_minor_row">
            <th style="text-align: center;"><br><br><b>T/D</b></th>
            <th style="text-align: center;"><br><br><b>Serie</b></th>
            <th style="text-align: center;"><br><br><b>Número</b></th>
            
            <th style="text-align: center;"><br><br><b>Fecha</b></th>
            <th style="text-align: center;"><br><br><b>T/D</b></th>
            <th style="text-align: center;;"><br><br><b>Serie</b></th>
            <th style="text-align: center;;"><br><br><b>Número</b></th>
            
            <th style="text-align: center;"><br><br><b>Doc</b></th>
            <th style="text-align: center;"><br><br><b>Número</b></th>
            <th style="text-align: center;"><br><br><b>Razón Social</b></th>  
        </tr><thead>
<?php
$dts1=$oCompra->mostrar_filtro_por_mes_anio($_POST['cmb_fil_mes'],$_POST['cmb_fil_anio'],$_SESSION['empresa_id']);
$num_rows= mysql_num_rows($dts1);
$base = 0;
$igv = 0;
$total = 0;
?>
<tbody>
        <tr><td colspan="25"></td></tr>
        <tr><td colspan="25"></td></tr>
        <tr><td colspan="25"></td></tr>
        <tr><td colspan="25"></td></tr>
<?php
    while ($dt = mysql_fetch_array($dts1)) {
        $base+=$dt['tb_compra_valven'];
        $igv+=$dt['tb_compra_igv'];
        $total+=$dt['tb_compra_tot'];
        $numdoc = split('-', $dt['tb_compra_numdoc']);
    ?>
            <tr>

                        <td style="text-align: center">1</td>
                        <td style="text-align: center"><?php echo $dt['tb_compra_id'] ?></td>
                        <td style="text-align: center"><?php echo $dt['tb_compra_fec'] ?></td>
                        <td style="text-align: center"><?php echo $dt['tb_compra_fec'] ?></td>
                        <td style="text-align: center"><?php echo $dt["tb_documento_id"] ?></td>
                        <td style="text-align: center"><?php echo $numdoc[0] ?></td>
                        <td style="text-align: center"><?php echo $numdoc[1] ?></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"><?php echo $dt['tb_proveedor_tip'] ?></td>
                        <td style="text-align: center"><?php echo $dt['tb_proveedor_doc'] ?></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"><?php echo $dt['tb_compra_valven'] ?></td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center"><?php echo $dt['tb_compra_igv'] ?></td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center">0.00</td>
                        <td style="text-align: center"><?php echo $dt['tb_compra_tot'] ?></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                </tr>
<?php } ?>
<tr><td colspan="22"></td></tr><tr><td colspan="22"></td></tr>
                <tr class="row_total">
                    <td colspan="13" style="text-align: right;">TOTALES:</td>       
                    <td style="text-align: center; border-top: 1px black solid;"></td>
                    <td style="text-align: center; border-top: 1px black solid;"><?php echo $base?></td>
                    <td style="text-align: center; border-top: 1px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 1px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 1px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 1px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 1px black solid;"><?php echo $igv ?></td>
                    <td style="text-align: center; border-top: 1px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 1px black solid;"general">0.00</td>
                    <td style="text-align: center; border-top: 1px black solid;"general">0.00</td>
                    <td style="text-align: center; border-top: 1px black solid;"><?php echo $total ?></td>
                </tr>
                    <td colspan="13" style="text-align: right;">TOTAL GENERAL:</td> 
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;"></td>
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;"><?php echo $base ?></td>
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;"><?php echo $igv ?></td>
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;">0.00</td>
                    <td style="text-align: center; border-top: 2px black solid; border-bottom: 2px black solid;"><?php echo $total ?></td>
                </tr></tbody></table>
        <br/>
        <br/>


<?php
    $style = array(
        'border' => 2,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );
?>
</body>
</html>


