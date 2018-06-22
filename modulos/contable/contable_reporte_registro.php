<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once("../formatos/formato.php");

$fecha_actual=$d=date('d-m-Y');
$titulo='REPORTE DE VENTAS';

//empresa
$dts=$oEmpresa->mostrarUno($_SESSION['empresa_id']);
$dt = mysql_fetch_array($dts);
$emp_ruc=$dt['tb_empresa_ruc'];
$emp_nomcom=$dt['tb_empresa_nomcom'];
$emp_razsoc=$dt['tb_empresa_razsoc'];
$emp_dir=$dt['tb_empresa_dir'];
$emp_dir2=$dt['tb_empresa_dir2'];
$emp_tel=$dt['tb_empresa_tel'];
$emp_ema=$dt['tb_empresa_ema'];
$emp_fir=$dt['tb_empresa_fir'];
mysql_free_result($dts);

//cliente
if($_POST['cmb_fil_cli_id']>0)
{
    $dts=$oCliente->mostrarUno($_POST['cmb_fil_cli_id']);
    $dt = mysql_fetch_array($dts);
    $cli_tip=$dt['tb_cliente_tip'];
    $cli_nom=$dt['tb_cliente_nom'];
    $cli_doc=$dt['tb_cliente_doc'];
    $cli_dir=$dt['tb_cliente_dir'];
    $cli_con=$dt['tb_cliente_con'];
    $cli_tel=$dt['tb_cliente_tel'];
    $cli_ema=$dt['tb_cliente_ema'];
    mysql_free_result($dts);

    $texto_cliente=$cli_nom.' / '.$cli_doc;
}

//vendedor
if($_POST['cmb_fil_ven_ven']>0)
{
    $dts=$oUsuario->mostrarUno($_POST['cmb_fil_ven_ven']);
    $dt = mysql_fetch_array($dts);
    $usugru		=$dt['tb_usuariogrupo_id'];
    $usugru_nom	=$dt['tb_usuariogrupo_nom'];
    $usu_nom		=$dt['tb_usuario_nom'];
    $apepat		=$dt['tb_usuario_apepat'];
    $apemat		=$dt['tb_usuario_apemat'];
    $ema		=$dt['tb_usuario_ema'];

    mysql_free_result($dts);

    $texto_vendedor="$usu_nom $apepat $apemat";
}

//punto de venta
if($_POST['cmb_fil_ven_punven']>0)
{
    $dts=$oPuntoventa->mostrarUno($_POST['cmb_fil_ven_punven']);
    $dt = mysql_fetch_array($dts);
    $punven_nom=$dt['tb_puntoventa_nom'];
    $alm_id=$dt['tb_almacen_id'];
    mysql_free_result($dts);

    $texto_puntoventa=$punven_nom;
}

$dts1=$oVenta->mostrar_filtro_por_mes_anio($_POST['cmb_fil_mes'],$_POST['cmb_fil_anio'],$_POST['cmb_fil_tipo_doc'],$_POST['cmb_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id'],$_POST['chk_fil_ven_may']);
$num_rows= mysql_num_rows($dts1);

//____
//Table Base Classs
require_once("../../libreriasphp/fpdf_table/class.fpdf_table.php");

//Class Extention for header and footer
class pdf_usage extends fpdf_table
{

    public function Header()
    {
        global $emp_razsoc;
        global $titulo;

        $this->SetStyle("head1","arial","",8,"160,160,160");
        $this->SetStyle("head2","arial","",6,"0,119,220");

        $this->SetFont('Arial','I',8);
        $this->SetTextColor(170, 170, 170);

        $this->SetY(10);

        $this->Cell(70,4,utf8_decode($emp_razsoc),0,0,'L');

        $hTxt=utf8_decode("<head1>$titulo</head1>");
        $this->MultiCellTag(0, 3, $hTxt,0,'R');

        //$this->Cell(20,3,'Title',1,1,'C');

        //$hTxt =utf8_decode("<head1>Parroquia Santa María Catedral</head1><head2></head2>");
        //$this->MultiCellTag(60, 3, $hTxt, 1 );

        $this->SetY($this->tMargin);
    }

    public function Footer()
    {
        global $fecha_actual;

        $this->SetY(-10);
        $this->SetFont('Arial','I',7);
        $this->SetTextColor(170, 170, 170);

        $this->Cell(107,4,utf8_decode("Impresión: $fecha_actual"),0,0,'L');

        $this->Cell(70,4,'',0,0,'L');

        $pagTxt =utf8_decode("Página {$this->PageNo()} / {nb}");
        $this->MultiCell(0, 4, $pagTxt, 0, 'R');
    }
}

/**
 * Background Color Definitions
 */
$bg_color1 = array(234, 255, 218);
$bg_color2 = array(165, 250, 220);
$bg_color3 = array(255, 252, 249);
$bg_color4 = array(86, 155, 225);
$bg_color5 = array(207, 247, 239);
$bg_color6 = array(246, 211, 207);
$bg_color7 = array(216, 243, 228);


$pdf = new pdf_usage('L','mm','A4');
$pdf->Open();
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetMargins(15, 20, 15);
$pdf->AddPage();
$pdf->AliasNbPages();

$pdf->SetStyle("s1","arial","",8,"118,0,3");
$pdf->SetStyle("s2","arial","",10,"0,49,159");
$pdf->SetStyle("s3","arial","",8,"0,49,159");

//default text color
$pdf->SetTextColor(118, 0, 3);

$sTxt = "<s2>$titulo</s2>";

$pdf->MultiCellTag(100, 3, $sTxt,0,'L');
$pdf->Ln(3);

//linea
$pdf->Cell(266,1,'','T',1,'L');
//font
$pdf->SetFont('Arial','',8);

$pdf->SetTextColor(118,0,3);
$pdf->Cell(27,4,'FECHA ENTRE:',0,0,'L');
$pdf->SetTextColor(0,49,159);
$pdf->Cell(150,4,utf8_decode($_POST['txt_fil_ven_fec1']." y ".$_POST['txt_fil_ven_fec2']),0,1,'L');

$pdf->SetTextColor(118,0,3);
$pdf->Cell(27,4,'CLIENTE:',0,0,'L');
$pdf->SetTextColor(0,49,159);
$pdf->Cell(150,4,utf8_decode($texto_cliente),0,1,'L');

$pdf->SetTextColor(118,0,3);
$pdf->Cell(27,4,'ESTADO:',0,0,'L');
$pdf->SetTextColor(0,49,159);
$pdf->Cell(150,4,utf8_decode($_POST['cmb_fil_ven_est']),0,1,'L');

$pdf->SetTextColor(118,0,3);
$pdf->Cell(27,4,'VENDEDOR:',0,0,'L');
$pdf->SetTextColor(0,49,159);
$pdf->Cell(150,4,utf8_decode($texto_vendedor),0,1,'L');

$pdf->SetTextColor(118,0,3);
$pdf->Cell(27,4,'PUNTO DE VENTA:',0,0,'L');
$pdf->SetTextColor(0,49,159);
$pdf->Cell(150,4,utf8_decode($texto_puntoventa),0,1,'L');

$pdf->Ln(3);
//inicio tabla
$bTableSplitMode = false;

//tabla datos reporte
/////////////////////////////////////////////////////

//load the table default definitions
/*****************************************************
TABLE DEFAULT DEFINES
 *****************************************************/

$table_default_header_type = array(
    'WIDTH' => 6,				    	//cell width
    'T_COLOR' => array(255,255,240),	//text color
    'T_SIZE' => 7,						//font size
    'T_FONT' => 'Arial',				//font family
    'T_ALIGN' => 'C',					//horizontal alignment, possible values: LRC (left, right, center)
    'V_ALIGN' => 'M',					//vertical alignment, possible values: TMB(top, middle, bottom)
    'T_TYPE' => 'B',						//font type
    'LN_SIZE' => 5,						//line size for one row
    'BG_COLOR' => array(25, 124, 224),	//background color
    'BRD_COLOR' => array(0,92,177),		//border color
    'BRD_SIZE' => 0.1,					//border size
    'BRD_TYPE' => '1',					//border type, can be: 0, 1 or a combination of: "LRTB"
    'TEXT' => '',						//text
);

$table_default_data_type = array(
    'T_COLOR' => array(0,0,0),			//text color
    'T_SIZE' => 7,						//font size
    'T_FONT' => 'Arial',				//font family
    'T_ALIGN' => 'L',					//horizontal alignment, possible values: LRC (left, right, center)
    'V_ALIGN' => 'T',					//vertical alignment, possible values: TMB(top, middle, bottom)
    'T_TYPE' => '',						//font type
    'LN_SIZE' => 5,						//line size for one row
    'BG_COLOR' => array(255,255,255),	//background color
    'BRD_COLOR' => array(0,92,177),		//border color
    'BRD_SIZE' => 0,					//border size
    'BRD_TYPE' => '1',					//border type, can be: 0, 1 or a combination of: "LRTB"
);

$table_default_table_type = array(
    'TB_ALIGN' => 'L',					//table align on page
    'L_MARGIN' => 0,					//space to the left margin
    'BRD_COLOR' => array(0,92,177),		//border color
    'BRD_SIZE' => '0.1',				//border size
);
/*****************************************************
TABLE DEFAULT DEFINES --- END
 *****************************************************/

$columns = 11; //number of Columns

//Initialize the table class
$pdf->tbInitialize($columns, true, true);

$aSimpleHeader = array();

//Table Header
//for($i=0; $i<$columns; $i++) {
//$aSimpleHeader[$i] = $table_default_header_type;
//$aSimpleHeader[$i]['TEXT'] = "Columna " . ($i + 1) . " text";
//$aSimpleHeader[$i]['WIDTH'] = 32;
//$aSimpleHeader[$i]['BG_COLOR'] = $bg_color4;
//$aSimpleHeader[$i]['T_COLOR'] = array(0,0,0);
//}

$aSimpleHeader[0] = $table_default_header_type;
$aSimpleHeader[0]['TEXT'] = "O.";
$aSimpleHeader[0]['WIDTH'] = 7;

$aSimpleHeader[1] = $table_default_header_type;
$aSimpleHeader[1]['TEXT'] = utf8_decode("N° VOU");
$aSimpleHeader[1]['WIDTH'] = 8;

$aSimpleHeader[2] = $table_default_header_type;
$aSimpleHeader[2]['TEXT'] = utf8_decode("F. Emisión");
$aSimpleHeader[2]['WIDTH'] = 17;

$aSimpleHeader[3] = $table_default_header_type;
$aSimpleHeader[3]['TEXT'] = "F. Venc.";
$aSimpleHeader[3]['WIDTH'] = 17;

$aSimpleHeader[4] = $table_default_header_type;
$aSimpleHeader[4]['TEXT'] = "T/D";
$aSimpleHeader[4]['WIDTH'] = 8;

$aSimpleHeader[5] = $table_default_header_type;
$aSimpleHeader[5]['TEXT'] = "Serie";
$aSimpleHeader[5]['WIDTH'] = 8;
//$aSimpleHeader[5]['T_ALIGN'] = 'R';

$aSimpleHeader[6] = $table_default_header_type;
$aSimpleHeader[6]['TEXT'] = "Numero";
$aSimpleHeader[6]['WIDTH'] = 8;

$aSimpleHeader[7] = $table_default_header_type;
$aSimpleHeader[7]['TEXT'] = "Fecha";
$aSimpleHeader[7]['WIDTH'] = 8;

$aSimpleHeader[8] = $table_default_header_type;
$aSimpleHeader[8]['TEXT'] = "T/D";
$aSimpleHeader[8]['WIDTH'] = 8;

$aSimpleHeader[9] = $table_default_header_type;
$aSimpleHeader[9]['TEXT'] = "Serie";
$aSimpleHeader[9]['WIDTH'] = 13;

$aSimpleHeader[10] = $table_default_header_type;
$aSimpleHeader[10]['TEXT'] = "Número";
$aSimpleHeader[10]['WIDTH'] = 15;

$aSimpleHeader[11] = $table_default_header_type;
$aSimpleHeader[11]['TEXT'] = "Doc";
$aSimpleHeader[11]['WIDTH'] = 12;

$aSimpleHeader[12] = $table_default_header_type;
$aSimpleHeader[12]['TEXT'] = "Número";
$aSimpleHeader[12]['WIDTH'] = 13;

$aSimpleHeader[13] = $table_default_header_type;
$aSimpleHeader[13]['TEXT'] = "Razón Social";
$aSimpleHeader[13]['WIDTH'] = 20;

$aSimpleHeader[14] = $table_default_header_type;
$aSimpleHeader[14]['TEXT'] = "Base Imp. Adq Grav. y de Exp. A";
$aSimpleHeader[14]['WIDTH'] = 5;

$aSimpleHeader[15] = $table_default_header_type;
$aSimpleHeader[15]['TEXT'] = "Base Imp. Adq Total Grav. y de Exp. y no Grav. B";
$aSimpleHeader[15]['WIDTH'] = 5;

$aSimpleHeader[16] = $table_default_header_type;
$aSimpleHeader[16]['TEXT'] = "Base Imp. Adq Grav. sin Der. Credito Fiscal C";
$aSimpleHeader[16]['WIDTH'] = 5;

$aSimpleHeader[17] = $table_default_header_type;
$aSimpleHeader[17]['TEXT'] = "Adq. no Gravadas";
$aSimpleHeader[17]['WIDTH'] = 5;

$aSimpleHeader[18] = $table_default_header_type;
$aSimpleHeader[18]['TEXT'] = "I.S.C.";
$aSimpleHeader[18]['WIDTH'] = 5;

$aSimpleHeader[19] = $table_default_header_type;
$aSimpleHeader[19]['TEXT'] = "I.G.V. A";
$aSimpleHeader[19]['WIDTH'] = 5;

$aSimpleHeader[20] = $table_default_header_type;
$aSimpleHeader[20]['TEXT'] = "I.G.V. B";
$aSimpleHeader[20]['WIDTH'] = 5;

$aSimpleHeader[20] = $table_default_header_type;
$aSimpleHeader[20]['TEXT'] = "I.G.V. C";
$aSimpleHeader[20]['WIDTH'] = 5;

$aSimpleHeader[21] = $table_default_header_type;
$aSimpleHeader[21]['TEXT'] = "Otros Tributos";
$aSimpleHeader[21]['WIDTH'] = 5;

$aSimpleHeader[22] = $table_default_header_type;
$aSimpleHeader[22]['TEXT'] = "Total";
$aSimpleHeader[22]['WIDTH'] = 5;

$aSimpleHeader[23] = $table_default_header_type;
$aSimpleHeader[23]['TEXT'] = "T/C";
$aSimpleHeader[23]['WIDTH'] = 5;

$aSimpleHeader[24] = $table_default_header_type;
$aSimpleHeader[24]['TEXT'] = "Spot Fecha";
$aSimpleHeader[24]['WIDTH'] = 5;

$aSimpleHeader[25] = $table_default_header_type;
$aSimpleHeader[25]['TEXT'] = "Spot Numero";
$aSimpleHeader[25]['WIDTH'] = 5;


$aHeader = array(
    $aSimpleHeader
);

//set the Table Header
$pdf->tbSetHeaderType($aHeader, true);

//set the Table Type
$pdf->tbSetTableType($table_default_table_type);

if (isset($bTableSplitMode))
    $pdf->tbSetSplitMode($bTableSplitMode);

//Draw the Header
$pdf->tbDrawHeader();

//Table Data Settings
$aDataType = Array();
for ($i=0; $i<$columns; $i++)
{
    $aDataType[$i] = $table_default_data_type;
}

$pdf->tbSetDataType($aDataType);

//llenado datos de contenido de tabla
if($num_rows>=1)
{
    while($dt1 = mysql_fetch_array($dts1))
    {
        if($dt1['tb_venta_est']=='CANCELADA'){
            $total_valven+=$dt1['tb_venta_valven'];
            $total_igv+=$dt1['tb_venta_igv'];
            $total_des+=$dt1['tb_venta_des'];
            $total_ventas+=$dt1['tb_venta_tot'];
        }

        //for ($j=1; $j<=500; $j++)
        //{
        $data = Array();
        $data[0]['TEXT'] = $dt1['tb_documento_id'];
        $data[1]['TEXT'] = utf8_decode( $dt1['tb_venta_id']);
        $data[2]['TEXT'] = fecha_mysql($dt1['tb_venta_fec']);
        $data[3]['TEXT'] = fecha_mysql($dt1['tb_venta_fec']);
        $data[4]['TEXT'] = $dt1['tb_documento_id'];

        $data[5]['TEXT'] = $dt1['tb_venta_ser'];
        $data[5]['T_ALIGN'] = 'R';

        $data[6]['TEXT'] = $dt1['tb_venta_num'];
        $data[6]['T_ALIGN'] = 'R';

        $data[7]['TEXT'] = '';
        $data[7]['T_ALIGN'] = 'R';

        $data[8]['TEXT'] = '';
        $data[8]['T_ALIGN'] = 'R';
        $data[8]['T_SIZE'] = 6;

        $data[9]['TEXT'] = '';
        $data[9]['T_ALIGN'] = 'L';
        $data[9]['T_SIZE'] = 6;

        $data[10]['TEXT'] = 'aca';
        $data[10]['T_ALIGN'] = 'L';
        $data[10]['T_SIZE'] = 6;

        $data[11]['TEXT'] = '';
        $data[11]['T_ALIGN'] = 'L';
        $data[11]['T_SIZE'] = 6;

        $data[12]['TEXT'] = '';
        $data[12]['T_ALIGN'] = 'L';
        $data[12]['T_SIZE'] = 6;

        $pdf->tbDrawData($data);
        //}
    }//fin while
    mysql_free_result($dts1);
}//fin nunm_rows

$data = Array();
$data[0]['TEXT'] = '';
$data[0]['COLSPAN'] = 11;

$pdf->tbDrawData($data);

$data = Array();
$data[0]['TEXT'] = 'TOTAL';
$data[0]['COLSPAN'] = 5;
$data[0]['LN_SIZE'] = 7;
$data[0]['T_COLOR'] = array(118,0,3);
$data[0]['T_SIZE'] = 7;
$data[0]['V_ALIGN'] = "M";

$data[5]['TEXT'] = formato_money($total_valven);
$data[5]['T_SIZE'] = 7;
$data[5]['T_ALIGN'] = 'R';
$data[5]['V_ALIGN'] = "M";

$data[6]['TEXT'] = formato_money($total_igv);
$data[6]['T_SIZE'] = 7;
$data[6]['T_ALIGN'] = 'R';
$data[6]['V_ALIGN'] = "M";

$data[7]['TEXT'] = formato_money($total_ventas);
$data[7]['T_SIZE'] = 7;
$data[7]['T_ALIGN'] = 'R';
$data[7]['V_ALIGN'] = "M";

$data[8]['TEXT'] = '';
$data[8]['T_ALIGN'] = 'R';
$data[8]['COLSPAN'] = 3;

$pdf->tbDrawData($data);

//output the table data to the pdf
$pdf->tbOuputData();

$sTxt = utf8_decode("<s1>N° REGISTROS: </s1><s3> $num_rows</s3>");
$pdf->MultiCellTag(100, 8, $sTxt,0,'L');

//draw the Table Border
$pdf->tbDrawBorder();

//fin tabla datos

$nombre_archivo='rep_ventas_'.$fecha_actual.'.pdf';
$pdf->Output($nombre_archivo,'I');

?>