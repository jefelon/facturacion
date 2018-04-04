<?php
session_start();
require_once ("Cado.php");
require_once ("Clases/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("Clases/cGasto.php");
$oGasto = new cGasto();
require_once("Clases/cCuenta.php");
$oCuenta = new cCuenta();
require_once("Clases/cSubcuenta.php");
$oSubcuenta = new cSubcuenta();
require_once ("Clases/cProveedor.php");
$oProveedor = new cProveedor();
require_once ("Clases/cEntfinanciera.php");
$oEntfinanciera = new cEntfinanciera();

require_once("Libreria/formato.php");
require_once("Libreria/date.php");

$fecha_actual=date('d-m-Y');
$titulo='REPORTE DE GASTOS';

$nombre_mes=nombre_mes($_POST['cmb_fil_gas_m']);

if($nombre_mes=="")$nombre_mes="Ene - Dic";

//empresa
$dts=$oEmpresa->mostrarUno($_SESSION['empresa']);
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

//CUENTA
if($_POST['cmb_fil_cue_id']>0)
{
	$dts=$oCuenta->mostrarUno($_POST['cmb_fil_cue_id']);
	$dt = mysql_fetch_array($dts);
	$cue_nom=$dt['tb_cuenta_des'];
	mysql_free_result($dts);
}
//SUB CUENTA
if($_POST['cmb_fil_subcue_id']>0)
{
	$dts=$oSubcuenta->mostrarUno($_POST['cmb_fil_subcue_id']);
	$dt = mysql_fetch_array($dts);
	$subcue_nom=$dt['tb_subcuenta_des'];
	mysql_free_result($dts);
}
//proveedor
if($_POST['cmb_fil_pro_id']>0)
{
	$dts=$oProveedor->mostrarUno($_POST['cmb_fil_pro_id']);
	$dt = mysql_fetch_array($dts);
		$pro_tip	=$dt['tb_proveedor_tip'];
		$pro_nom	=$dt['tb_proveedor_nom'];
		$pro_doc	=$dt['tb_proveedor_doc'];
		$pro_dir	=$dt['tb_proveedor_dir'];
		//$ubigeo	=$dt['tb_ubigeo_cod'];
		$pro_con	=$dt['tb_proveedor_con'];
		$pro_tel	=$dt['tb_proveedor_tel'];
		$pro_ema	=$dt['tb_proveedor_ema'];
		$pro_not	=$dt['tb_proveedor_not'];
		$pro_est	=$dt['tb_proveedor_est'];
	mysql_free_result($dts);
	
	$texto_proveedor=$pro_nom.' / '.$pro_doc;
}

//ENTIDAD FINANCIERA
if($_POST['cmb_fil_entfin_id']>0)
{
	$dts=$oEntfinanciera->mostrarUno($_POST['cmb_fil_entfin_id']);
	$dt = mysql_fetch_array($dts);
	$entfin_nom=$dt['tb_entfinanciera_nom'];
	mysql_free_result($dts);
}

$dts1=$oGasto->mostrar_filtro($_SESSION['empresa'],$_POST['cmb_fil_gas_y'],$_POST['cmb_fil_gas_m'],$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_pro_id'],$_POST['cmb_fil_entfin_id'],$_POST['cmb_fil_gas_est']);

$num_rows= mysql_num_rows($dts1);

//____
	//Table Base Classs
	require_once("fpdf_table/class.fpdf_table.php");
	
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
			
			$this->Cell(117,4,utf8_decode("Impresión: $fecha_actual"),0,0,'L');
			
			$this->Cell(70,4,'www.a-zetasoft.com',0,0,'L');
			
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
	$pdf->Cell(25,4,'FECHA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($_POST['cmb_fil_gas_y']." / ".$nombre_mes),0,1,'L');
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'CUENTA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($cue_nom),0,1,'L');
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'SUB CUENTA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($subcue_nom),0,1,'L');
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'PROVEEDOR:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_proveedor),0,1,'L');
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'ENT. FINANC:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($entfin_nom),0,1,'L');
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'ESTADO:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($_POST['cmb_fil_gas_est']),0,1,'L');

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
				'BRD_TYPE' => 'TB',					//border type, can be: 0, 1 or a combination of: "LRTB"
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
	$aSimpleHeader[0]['WIDTH'] = 14;
	
	$aSimpleHeader[1] = $table_default_header_type;
	$aSimpleHeader[1]['TEXT'] = "DOC";
	$aSimpleHeader[1]['WIDTH'] = 20;
	
	$aSimpleHeader[2] = $table_default_header_type;
	$aSimpleHeader[2]['TEXT'] = "DESCRIPCION";
	$aSimpleHeader[2]['WIDTH'] = 55;
	
	$aSimpleHeader[3] = $table_default_header_type;
	$aSimpleHeader[3]['TEXT'] = "PROVEEDOR";
	$aSimpleHeader[3]['WIDTH'] = 40;
	
	$aSimpleHeader[4] = $table_default_header_type;
	$aSimpleHeader[4]['TEXT'] = "CUENTA";
	$aSimpleHeader[4]['WIDTH'] = 28;
	
	$aSimpleHeader[5] = $table_default_header_type;
	$aSimpleHeader[5]['TEXT'] = "SUB CUENTA";
	$aSimpleHeader[5]['WIDTH'] = 28;
	
	$aSimpleHeader[6] = $table_default_header_type;
	$aSimpleHeader[6]['TEXT'] = "BANCO";
	$aSimpleHeader[6]['WIDTH'] = 14;
	
	$aSimpleHeader[7] = $table_default_header_type;
	$aSimpleHeader[7]['TEXT'] = utf8_decode("M PAGO");
	$aSimpleHeader[7]['WIDTH'] = 17;
	
	$aSimpleHeader[8] = $table_default_header_type;
	$aSimpleHeader[8]['TEXT'] = utf8_decode("N° OPER");
	$aSimpleHeader[8]['WIDTH'] = 17;
	
	$aSimpleHeader[9] = $table_default_header_type;
	$aSimpleHeader[9]['TEXT'] = "IMPORTE";
	$aSimpleHeader[9]['WIDTH'] = 17;
	
	$aSimpleHeader[10] = $table_default_header_type;
	$aSimpleHeader[10]['TEXT'] = "ESTADO";
	$aSimpleHeader[10]['WIDTH'] = 16;
	
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
			$sum_imp+=$dt1['tb_gasto_imp'];
			
		//for ($j=1; $j<=500; $j++)
		//{
			$data = Array();
			$data[0]['TEXT'] = mostrarFecha($dt1['tb_gasto_fec']);
			$data[1]['TEXT'] = utf8_decode($dt1['tb_gasto_doc']);
			$data[2]['TEXT'] = utf8_decode($dt1['tb_gasto_des']);
			$data[3]['TEXT'] = utf8_decode($dt1['tb_proveedor_nom']);
		
			$data[4]['TEXT'] = $dt1['tb_cuenta_des'];
			$data[4]['T_ALIGN'] = 'L';
			
			$data[5]['TEXT'] = $dt1['tb_subcuenta_des'];
			$data[5]['T_ALIGN'] = 'L';
			
			$data[6]['TEXT'] = $dt1['tb_entfinanciera_nom'];
			$data[6]['T_ALIGN'] = 'L';
			
			$data[7]['TEXT'] = $dt1['tb_gasto_modpag'];
			$data[7]['T_ALIGN'] = 'L';
			
			$data[8]['TEXT'] = $dt1['tb_gasto_numope'];
			$data[8]['T_ALIGN'] = 'L';
			
			$data[9]['TEXT'] = formato_money($dt1['tb_gasto_imp']);
			$data[9]['T_ALIGN'] = 'R';
			
			$data[10]['TEXT'] = $dt1['tb_gasto_est'];
			$data[10]['T_ALIGN'] = 'L';
			
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
			$data[0]['COLSPAN'] = 9;
			$data[0]['LN_SIZE'] = 7;
			$data[0]['T_COLOR'] = array(118,0,3);
			$data[0]['T_SIZE'] = 7;
			$data[0]['V_ALIGN'] = "M";
			
			$data[9]['TEXT'] = formato_money($sum_imp);
			$data[9]['T_SIZE'] = 7;
			$data[9]['T_ALIGN'] = 'R';
			$data[9]['V_ALIGN'] = "M";
			
			$data[10]['TEXT'] = '';
			$data[10]['T_ALIGN'] = 'R';
			
		$pdf->tbDrawData($data);
	
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	$sTxt = utf8_decode("<s1>N° REGISTROS: </s1><s3> $num_rows</s3>");
	$pdf->MultiCellTag(100, 8, $sTxt,0,'L');
	
	//draw the Table Border
	$pdf->tbDrawBorder();
	
	//fin tabla datos
	
	$nombre_archivo='rep_gastos_'.$fecha_actual.'.pdf';
	$pdf->Output($nombre_archivo,'I');

?>