<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("cCompra.php");
$oCompra = new cCompra();
require_once ("../proveedor/cProveedor.php");
$oProveedor = new cProveedor();

require_once("../formatos/formato.php");
require_once ("../formatos/operaciones.php");

$fecha_actual=$d=date('d-m-Y');
$titulo='REPORTE DE COMPRAS';

//empresa
$dts=$oEmpresa->mostrarUno(1);
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
if($_POST['cmb_fil_pro_id']>0)
{
	$dts=$oProveedor->mostrarUno($_POST['cmb_fil_pro_id']);
	$dt = mysql_fetch_array($dts);
		$pro_tip=$dt['tb_proveedor_tip'];
		$pro_nom=$dt['tb_proveedor_nom'];
		$pro_doc=$dt['tb_proveedor_doc'];
		$pro_dir=$dt['tb_proveedor_dir'];
		$pro_con=$dt['tb_proveedor_con'];
		$pro_tel=$dt['tb_proveedor_tel'];
		$pro_ema=$dt['tb_proveedor_ema'];
	mysql_free_result($dts);
	
	$texto_proveedor=$pro_nom.' / '.$pro_doc;
}

if($_POST['cmb_fil_com_mon']==1)$texto_moneda='NUEVO SOL S/.';
if($_POST['cmb_fil_com_mon']==2)$texto_moneda='DOLAR AME US$';

$dts1=$oCompra->mostrar_filtro(fecha_mysql($_POST['txt_fil_com_fec1']),fecha_mysql($_POST['txt_fil_com_fec2']),$_POST['cmb_fil_com_mon'],$_POST['hdd_fil_pro_id'],$_POST['cmb_fil_com_est'],$_SESSION['empresa_id']);

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
			
			$this->Cell(120,4,utf8_decode("Impresión: $fecha_actual"),0,0,'L');
			
			//$this->Cell(70,4,'www.inticap.com',0,0,'L');
			
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
    $pdf->SetMargins(20, 20, 20);
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
	$pdf->Cell(256,1,'','T',1,'L');
	//font
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'FECHA ENTRE:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($_POST['txt_fil_com_fec1']." y ".$_POST['txt_fil_com_fec2']),0,1,'L');
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'MONEDA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_moneda),0,1,'L');
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'PROVEEDOR:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_proveedor),0,1,'L');
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'ESTADO:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($_POST['cmb_fil_com_est']),0,1,'L');

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
				'T_SIZE' => 6,						//font size
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
	$aSimpleHeader[0]['TEXT'] = "FECHA";
	$aSimpleHeader[0]['WIDTH'] = 15;
	
	$aSimpleHeader[1] = $table_default_header_type;
	$aSimpleHeader[1]['TEXT'] = "FEC VCTO";
	$aSimpleHeader[1]['WIDTH'] = 15;
	
	$aSimpleHeader[2] = $table_default_header_type;
	$aSimpleHeader[2]['TEXT'] = "DOC";
	$aSimpleHeader[2]['WIDTH'] = 10;
	
	$aSimpleHeader[3] = $table_default_header_type;
	$aSimpleHeader[3]['TEXT'] = "NUM DOC";
	$aSimpleHeader[3]['WIDTH'] = 21;
	
	$aSimpleHeader[4] = $table_default_header_type;
	$aSimpleHeader[4]['TEXT'] = "PROVEEDOR";
	$aSimpleHeader[4]['WIDTH'] = 77;
	
	$aSimpleHeader[5] = $table_default_header_type;
	$aSimpleHeader[5]['TEXT'] = "RUC/DNI";
	$aSimpleHeader[5]['WIDTH'] = 17;
	
	$aSimpleHeader[6] = $table_default_header_type;
	$aSimpleHeader[6]['TEXT'] = "ALMACEN";
	$aSimpleHeader[6]['WIDTH'] = 17;
	
	$aSimpleHeader[7] = $table_default_header_type;
	$aSimpleHeader[7]['TEXT'] = "VALOR VENTA";
	$aSimpleHeader[7]['WIDTH'] = 22;
	//$aSimpleHeader[5]['T_ALIGN'] = 'R';
	
	$aSimpleHeader[8] = $table_default_header_type;
	$aSimpleHeader[8]['TEXT'] = "IGV";
	$aSimpleHeader[8]['WIDTH'] = 22;
	
	$aSimpleHeader[9] = $table_default_header_type;
	$aSimpleHeader[9]['TEXT'] = "TOTAL";
	$aSimpleHeader[9]['WIDTH'] = 23;
	
	$aSimpleHeader[10] = $table_default_header_type;
	$aSimpleHeader[10]['TEXT'] = "ESTADO";
	$aSimpleHeader[10]['WIDTH'] = 17;
	
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
			$total_valven+=$dt1['tb_compra_valven'];
			$total_igv+=$dt1['tb_compra_igv'];
			$total_compras+=$dt1['tb_compra_tot'];
			
		//for ($j=1; $j<=500; $j++)
		//{
			$data = Array();
			$data[0]['TEXT'] = mostrarFecha($dt1['tb_compra_fec']);
			$data[1]['TEXT'] = mostrarFecha($dt1['tb_compra_fecven']);
			$data[2]['TEXT'] = utf8_decode($dt1['tb_documento_abr']);
			$data[3]['TEXT'] = utf8_decode($dt1['tb_compra_numdoc']);
			$data[4]['TEXT'] = utf8_decode($dt1['tb_proveedor_nom']);
			$data[5]['TEXT'] = utf8_decode($dt1['tb_proveedor_doc']);
			
			$data[6]['TEXT'] = utf8_decode($dt1['tb_almacen_nom']);
			
			$data[7]['TEXT'] = $dt1['tb_compra_valven'];
			$data[7]['T_ALIGN'] = 'R';
			
			$data[8]['TEXT'] = $dt1['tb_compra_igv'];
			$data[8]['T_ALIGN'] = 'R';
			
			$data[9]['TEXT'] = $dt1['tb_compra_tot'];
			$data[9]['T_ALIGN'] = 'R';
			
			$data[10]['TEXT'] = $dt1['tb_compra_est'];
			$data[10]['T_ALIGN'] = 'R';
			
			$pdf->tbDrawData($data);
		//}
		}//fin while
		mysql_free_result($dts1);
	}//fin nunm_rows
	
	
		$data = Array();
			$data[0]['TEXT'] = '';
			$data[0]['COLSPAN'] = $columns;
			
		$pdf->tbDrawData($data);
		//ocultar cuando no se selecciona moneda
		if($_POST['cmb_fil_com_mon']>0){
		$data = Array();
			$data[0]['TEXT'] = 'TOTAL';
			$data[0]['COLSPAN'] = 7;
			$data[0]['LN_SIZE'] = 7;
			$data[0]['T_COLOR'] = array(118,0,3);
			$data[0]['T_SIZE'] = 7;
			$data[0]['V_ALIGN'] = "M";
			
			$data[7]['TEXT'] = formato_money($total_valven);
			$data[7]['T_SIZE'] = 7;
			$data[7]['T_ALIGN'] = 'R';
			$data[7]['V_ALIGN'] = "M";
			
			$data[8]['TEXT'] = formato_money($total_igv);
			$data[8]['T_SIZE'] = 7;
			$data[8]['T_ALIGN'] = 'R';
			$data[8]['V_ALIGN'] = "M";
			
			$data[9]['TEXT'] = formato_money($total_compras);
			$data[9]['T_SIZE'] = 7;
			$data[9]['T_ALIGN'] = 'R';
			$data[9]['V_ALIGN'] = "M";
			
			$data[10]['TEXT'] = '';
			$data[10]['T_ALIGN'] = 'R';
			
		$pdf->tbDrawData($data);
		}
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	$sTxt = utf8_decode("<s1>N° REGISTROS: </s1><s3> $num_rows</s3>");
	$pdf->MultiCellTag(100, 8, $sTxt,0,'L');
	
	//draw the Table Border
	$pdf->tbDrawBorder();
	
	//fin tabla datos
	
	$nombre_archivo='rep_compras_'.$fecha_actual.'.pdf';
	$pdf->Output($nombre_archivo,'I');

?>