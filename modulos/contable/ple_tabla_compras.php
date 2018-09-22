<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 08/09/2018
 * Time: 19:17
 */
//
require_once ("../../config/Cado.php");
require_once ("cPle.php");
$oPle = new cPle();
//
if($_POST['libro']="080100")//compras
{
    $dts1=$oPle->mostrar_compras($_POST['anio'],$_POST['mes']);
    $num_rows= mysql_num_rows($dts1);
    $libro="080100";
}


echo $libro;
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

	$('.btn_info').button({
		icons: {primary: "ui-icon-info"},
		text: false
	});

	$.tablesorter.defaults.widgets = ['zebra'];
	$("#tabla_ple").tablesorter({
		headers: {
			6: {sorter: false },
			7: { sorter: false}},
		//sortForce: [[0,0]],
		sortList: [[0,0]]
    });
});
</script>
<table cellspacing="1" id="tabla_ple" class="tablesorter">
    <thead>
    <tr>
        <th>1 PERIODO</th>
        <th>2 CUO</th>
        <th>3 CUO AMC</th>
        <th>4 FECHA</th>
        <th>5 FECHA VENCE</th>
        <th>6 TIPO COMPROBANTE</th>
        <th>7 SERIE</th>
        <th>8 AÑO DUA</th>
        <th>9 NUM COMPROBANTE</th>
        <th>10 N FINAL CONSOLID</th>
        <th>11 TIPO DOC PROVEE</th>
        <th>12 RUC PROV</th>
        <th>13 PROVEEDOR</th>
        <th>14 OP GRAVADA</th>
        <th>15 IGV</th>
        <th>16 BI2</th>
        <th>17 IGV2</th>
        <th>18 BI3</th>
        <th>19 IGV3</th>
        <th>20 NO GRA</th>
        <th>21 ISC</th>
        <th>22 OTROS CARGOS</th>
        <th>23 TOTAL</th>
        <th>24 MON</th>
        <th>25 TC</th>
        <th>26 FECHA DOC MOD</th>
        <th>27 TIPO DOC MOD</th>
        <th>28 N SERIE DOC MD</th>
        <th>29 DUA </th>
        <th>30 N DOC MOD</th>
        <th>31 FECHA DETRACCION</th>
        <th>32 N DETRACCION</th>
        <th>33 MARCA COMP RET</th>
        <th>34 CLAS BIENES > 1500UIT</th>
        <th>35 ID CONTRA</th>
        <th>36 ERROR 1</th>
        <th>37 ERROR 2</th>
        <th>38 ERROR 3</th>
        <th>39 ERROR 4</th>
        <th>40 MEDIO PAGO</th>
        <th>41 ESTADO</th>
        <th></th>
    </tr>
    </thead>
    <?php
    if($num_rows>0){
        ?>
        <tbody>
        <?php
        $lineas=0;
        while($dt1 = mysql_fetch_array($dts1)){ $lineas++;?>
            <tr>
                    <?php
                    $amc="";
                    $fecha=$dt1['tb_compra_fec'];
                    $periodo=explode("/",$fecha);
                    ?>
                <!--1--><td><?php echo $periodo[2].$periodo[1]."00"; ?></td>
                <!--2--><td><?php echo $periodo[2].$periodo[1].$lineas;?></td>
                    <?php
                    if($periodo[1]=="01"){$amc="A";}
                    if($periodo[1]=="13"){$amc="C";}
                    else{$amc="M";}
                    ?>
                <!--3--><td><?php echo $amc.$periodo[2].$periodo[1].$lineas;?></td>
                <!--4--><td><?php echo $fecha ?></td>
               <!-- 5--><td><?php echo $fecha ?></td>

                    <?php if(strlen($dt1['cs_tipodocumento_cod'])==1)
                    {$coddoc = '0' . $dt1['cs_tipodocumento_cod'];}
                    else{$coddoc=$dt1['cs_tipodocumento_cod'];}
                    ?>
                <!--6--><td><?php echo $coddoc; ?></td>

                <?php
                    $numero =$dt1['tb_compra_numdoc'];
                    $serie_numero=explode("-",$numero);
                ?>
                <!--7--><td><?php echo $serie_numero[0]; ?></td>
                <!--8--><td></td>
                <!--9--><td><?php echo $serie_numero[1]; ?></td>
                <!--10--><td></td>
                    <?php
                    $ctipo="";
                    if($dt1['tb_proveedor_tip']==1){
                        $ctipo=1;
                    } elseif($dt1['tb_proveedor_tip']==2){
                        $ctipo=6;
                    }
                    ?>
                <!--11--><td><?php echo $ctipo ?></td>
                <!--12--><td><?php echo $dt1['tb_proveedor_doc']; ?></td>
                <!--13--><td><?php echo $dt1['tb_proveedor_nom']; ?></td>
                <!--14--><td><?php echo $dt1['tb_compra_gra']; ?></td>
                <!--15--><td><?php echo $dt1['tb_compra_igv']; ?></td>
                <!--16--><td></td>
                <!--17--><td></td>
                <!--18--><td></td>
                <!--19--><td></td>
                <!--20--><td><?php echo $dt1['tb_compra_exo']; ?></td>
                <!--21--><td><?php echo $dt1['tb_compra_isc']; ?></td>
                <!--22--><td></td>
                <!--23--><td><?php echo $dt1['tb_compra_tot']; ?></td>
                <!--24--><td><?php echo $dt1['cs_tipomoneda_cod']; ?></td>
                <!--25--><td><?php echo $dt1['tb_compra_tipcam']; ?></td>

                <?php
                $fec_nota="";
                $tip_doc_mod="";
                $tip_doc_modserie="";
                $tip_doc_modnum="";
                if($coddoc =="07"||$coddoc =="08"||$coddoc =="87"||$coddoc =="88"||$coddoc =="97"||$coddoc =="98")
                {
                    $fec_nota= $dt1['tb_compra_fec_nota'];
                    $tip_doc_modserie= $dt1['tb_compra_ser_nota'];
                    $tip_doc_modnum= $dt1['tb_compra_num_nota'];
                    $dtst=$oPle->mostrar_tipo_doc($tip_doc_modserie."-".$tip_doc_modnum);
                    $dtt = mysql_fetch_array($dtst);

                    if(strlen($dtt['cs_tipodocumento_cod'])==1)
                    {$tip_doc_mod = '0' . $dtt['cs_tipodocumento_cod'];}
                    else{$tip_doc_mod=$dtt['cs_tipodocumento_cod'];}

                }
                ?>
                <!--26--><td><?php echo $fec_nota; ?></td>
                <!--27--><td><?php echo $tip_doc_mod; ?></td>
                <!--28--><td><?php echo $tip_doc_modserie; ?></td>
                <!--29--><td></td>
                <!--30--><td><?php echo $tip_doc_modnum; ?></td>
                <!--31--><td></td>
                <!--32--><td></td>
                <!--33--><td></td>
                <!--34--><td></td>
                <!--35--><td></td>
                <!--36--><td></td>
                <!--37--><td></td>
                <!--38--><td></td>
                <!--39--><td></td>
                <!--40--><td></td>
                <!--41--><td>1</td>
                <td></td>
            </tr>
            <?php
        }
        mysql_free_result($dts1);
        ?>
        </tbody>
    <?php }?>
    <tr class="even">
        <td colspan="41"><?php echo $num_rows.' registros'?></td>
    </tr>
</table>
?>

