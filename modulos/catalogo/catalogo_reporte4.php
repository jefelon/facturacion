<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("cCatalogo.php");
$oCatalogo = new cCatalogo();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
require_once ("../almacen/cAlmacen.php");
$oAlmacen = new cAlmacen();
require_once ("../marca/cMarca.php");
$oMarca = new cMarca();
require_once ("../kardex/cKardex.php");
$oKardex = new cKardex();

require_once("../formatos/formato.php");

$fecha_actual=$d=date('d-m-Y');
$titulo='REPORTE DE PRODUCTOS - STOCK VALORIZADO SALDO INICIAL';

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

$texto_empresa=$emp_razsoc.' | '.$emp_ruc;

//almacen
if($_POST['cmb_fil_pro_alm']>0)
{
	$dts=$oAlmacen->mostrarUno($_POST['cmb_fil_pro_alm']);
	$dt = mysql_fetch_array($dts);
		$alm_nom=$dt['tb_almacen_nom'];
		$alm_ven=$dt['tb_almacen_ven'];
	mysql_free_result($dts);
}

//categoria
if($_POST['cmb_fil_pro_cat']>0)
{
	$dts=$oCategoria->mostrarUno($_POST['cmb_fil_pro_cat']);
	$dt = mysql_fetch_array($dts);
		$cat_nom=$dt['tb_categoria_nom'];
		$cat_idp=$dt['tb_categoria_idp'];
	mysql_free_result($dts);
}

//marca
if($_POST['cmb_fil_pro_mar']>0)
{
	$dts=$oMarca->mostrarUno($_POST['cmb_fil_pro_mar']);
	$dt = mysql_fetch_array($dts);
		$mar_nom=$dt['tb_marca_nom'];
	mysql_free_result($dts);
}

//vista y unidad base
if($_POST['chk_fil_catven']==1)$texto_vista='Catálogo de Ventas';
if($_POST['chk_fil_catcom']==1)$texto_vista='Catálogo de Compras';
if($_POST['chk_fil_catven']==1 and $_POST['chk_fil_catcom']==1)$texto_vista='Catálogo de Compras y Ventas';

if($_POST['chk_fil_unibas']==1)$texto_unibas='SI';


//prepara consulta categoria
if(isset($_POST['cmb_fil_pro_cat']) and $_POST['cmb_fil_pro_cat']>0)
{
	$dc=$_POST['cmb_fil_pro_cat'].'';
	
	$dts2=$oCategoria->mostrar_por_idp($_POST['cmb_fil_pro_cat']);
	$num_rows2= mysql_num_rows($dts2);
	if($num_rows2>0){
		while($dt2 = mysql_fetch_array($dts2)){
			
			$dc.=', '.$dt2['tb_categoria_id'];
			
			$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
			$num_rows3= mysql_num_rows($dts3);
			if($num_rows3>0){
				while($dt3 = mysql_fetch_array($dts3)){
					$dc.=', '.$dt3['tb_categoria_id'];			
				}
			mysql_free_result($dts3);
			}//fin nivel 3
					
		}
	mysql_free_result($dts2);
	}//fin nivel 2

//echo $dc;			
}

//seleccion de los atributos
$atr_array=$_POST['cmb_fil_pro_atr'];
if(is_array($atr_array)){
	$cadena_atr = implode(',',$atr_array);
}

if($_POST['cmb_fil_pro_alm']>0)
{
	$dts1=$oCatalogo->catalogo_filtro($_POST['txt_fil_pro_nom'],$_POST['txt_fil_pro_cod'],$dc,$_POST['cmb_fil_pro_mar'],$_POST['cmb_fil_pro_est'],$_POST['cmb_fil_pro_alm'],$cadena_atr,$_POST['chk_fil_catven'],$_POST['chk_fil_catcom'],$_POST['chk_fil_unibas']);
	$num_rows= mysql_num_rows($dts1);
}
else
{
	$num_rows=0;
}

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
    $pdf->SetMargins(13, 20, 13);
	$pdf->AddPage();
	$pdf->AliasNbPages(); 
		
	$pdf->SetStyle("s1","arial","",8,"118,0,3");
	$pdf->SetStyle("s2","arial","",10,"0,49,159");
	$pdf->SetStyle("s3","arial","",8,"0,49,159");
	
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	
	$sTxt = "<s2>$titulo</s2>";
	
	$pdf->MultiCellTag(250, 3, $sTxt,0,'L');
	$pdf->Ln(3);
	
	//linea
	$pdf->Cell(269,1,'','T',1,'L');
	//font
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'EMPRESA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_empresa),0,1,'L');
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'ALMACEN:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($alm_nom),0,1,'L');
	
	if($_POST['cmb_fil_pro_cat']>0)
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'CATEGORIA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($cat_nom),0,1,'L');
	}
	
	if($_POST['cmb_fil_pro_mar']>0)
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'MARCA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($mar_nom),0,1,'L');
	}
	
	if($_POST['txt_fil_pro_nom']!="")
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'NOMBRE:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($_POST['txt_fil_pro_nom']),0,1,'L');
	}
	
	if($_POST['cmb_fil_pro_est']!="")
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'ESTADO:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($_POST['cmb_fil_pro_est']),0,1,'L');
	}
	
	/*
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'VISTA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_vista),0,1,'L');
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(25,4,'UNIDAD BASE:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_unibas),0,1,'L');
	*/
	
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
				'LN_SIZE' => 4,						//line size for one row
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
	
	$columns = 12; //number of Columns
	
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
	
	/*$aSimpleHeader[0] = $table_default_header_type;
	$aSimpleHeader[0]['TEXT'] = "CODIGO";
	$aSimpleHeader[0]['WIDTH'] = 20;*/
	
	$aSimpleHeader[0] = $table_default_header_type;
	$aSimpleHeader[0]['TEXT'] = "NOMBRE";
	$aSimpleHeader[0]['WIDTH'] = 65;
	
	$aSimpleHeader[1] = $table_default_header_type;
	$aSimpleHeader[1]['TEXT'] = "PRES";
	$aSimpleHeader[1]['WIDTH'] = 10;
	
	$aSimpleHeader[2] = $table_default_header_type;
	$aSimpleHeader[2]['TEXT'] = "MARCA";
	$aSimpleHeader[2]['WIDTH'] = 27;
	
	$aSimpleHeader[3] = $table_default_header_type;
	$aSimpleHeader[3]['TEXT'] = "CATEGORIA";
	$aSimpleHeader[3]['WIDTH'] = 60;
	
	$aSimpleHeader[4] = $table_default_header_type;
	$aSimpleHeader[4]['TEXT'] = "UN";
	$aSimpleHeader[4]['WIDTH'] = 6;
	
	$aSimpleHeader[5] = $table_default_header_type;
	$aSimpleHeader[5]['TEXT'] = "P COSTO US$";
	$aSimpleHeader[5]['WIDTH'] = 15;
	//$aSimpleHeader[5]['T_ALIGN'] = 'R';
	
	$aSimpleHeader[6] = $table_default_header_type;
	$aSimpleHeader[6]['TEXT'] = "P COSTO S/.";
	$aSimpleHeader[6]['WIDTH'] = 15;
	//$aSimpleHeader[6]['T_ALIGN'] = 'R';
	
	$aSimpleHeader[7] = $table_default_header_type;
	$aSimpleHeader[7]['TEXT'] = "UTI %";
	$aSimpleHeader[7]['WIDTH'] = 8;
	//$aSimpleHeader[6]['T_ALIGN'] = 'R';
	
	$aSimpleHeader[8] = $table_default_header_type;
	$aSimpleHeader[8]['TEXT'] = "PRECIO VENTA S/.";
	$aSimpleHeader[8]['WIDTH'] = 15;
	
	$aSimpleHeader[9] = $table_default_header_type;
	$aSimpleHeader[9]['TEXT'] = "STOCK INICIAL";
	$aSimpleHeader[9]['WIDTH'] = 11;
	
	$aSimpleHeader[10] = $table_default_header_type;
	$aSimpleHeader[10]['TEXT'] = "VALORIZADO US$";
	$aSimpleHeader[10]['WIDTH'] = 19;
	
	$aSimpleHeader[11] = $table_default_header_type;
	$aSimpleHeader[11]['TEXT'] = "VALORIZADO S/.";
	$aSimpleHeader[11]['WIDTH'] = 19;
	
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
			$precos=0;
			if($dt1['tb_catalogo_precos']!=0)$precos=$dt1['tb_catalogo_precos'];
			
			$precosdol=0;
			if($dt1['tb_catalogo_precosdol']!=0)$precosdol=$dt1['tb_catalogo_precosdol'];
			
			$preven=0;
			if($dt1['tb_catalogo_preven']!=0)$preven=$dt1['tb_catalogo_preven'];
			
			$stock=$dt1['tb_stock_num'];
			
			//stock unidad
			$stock_unidad=0;
						
			$st_uni=floor($stock/$dt1['tb_catalogo_mul']);
			$st_res=$stock%$dt1['tb_catalogo_mul'];
			
			if($st_res!=0){
				//$stock_unidad="$st_uni + r$st_res";
				$stock_unidad="$st_uni";
			} else{
				$stock_unidad="$st_uni";
			}
			
			$stock_unidad=0;
						
			$rws1 = $oKardex->mostrar_kardex_tipoperacion_por_producto($dt1['tb_catalogo_id'],$_POST['cmb_fil_pro_alm'],'1');
			$rw1 = mysql_fetch_array($rws1);
			$stock_unidad=$rw1['tb_notalmacendetalle_can'];
			mysql_free_result($rws1);
			
			$valorizado_dol=0;
			$valorizado=0;
			
			if($dt1['tb_catalogo_unibas']=='1')
			{
				if($dt1['tb_catalogo_precosdol']>0)
				{
					$valorizado_dol=$stock_unidad*$dt1['tb_catalogo_precosdol'];
								
					$total_valorizado_dol+=$valorizado_dol;
				}
				else
				{
					$valorizado=$stock_unidad*$dt1['tb_catalogo_precos'];
					$total_valorizado+=$valorizado;
				}
			}

	
		//for ($j=1; $j<=500; $j++)
		//{
			$data = Array();
			/*$data[0]['TEXT'] = utf8_decode($dt1['tb_presentacion_cod']);*/
			
			$data[0]['TEXT'] = utf8_decode($dt1['tb_producto_nom']);
			$data[1]['TEXT'] = utf8_decode($dt1['tb_presentacion_nom']);
			$data[2]['TEXT'] = utf8_decode($dt1['tb_marca_nom']);
			$data[3]['TEXT'] = utf8_decode($dt1['tb_categoria_nom']);
			$data[4]['TEXT'] = utf8_decode($dt1['tb_unidad_abr']);
			
			$data[5]['TEXT'] = formato_money($precosdol);
			$data[5]['T_ALIGN'] = 'R';
			
			$data[6]['TEXT'] = formato_money($precos);
			$data[6]['T_ALIGN'] = 'R';
			
			$data[7]['TEXT'] = $dt1['tb_catalogo_uti'];
			$data[7]['T_ALIGN'] = 'R';
			
			$data[8]['TEXT'] = formato_money($preven);
			$data[8]['T_ALIGN'] = 'R';
			
			$data[9]['TEXT'] = $stock_unidad;
			$data[9]['T_ALIGN'] = 'R';
			
			$data[10]['TEXT'] = formato_money($valorizado_dol);
			$data[10]['T_ALIGN'] = 'R';
			
			$data[11]['TEXT'] = formato_money($valorizado);
			$data[11]['T_ALIGN'] = 'R';
			
			$pdf->tbDrawData($data);
		//}
		}//fin while
		mysql_free_result($dts1);
	}//fin nunm_rows
	
		$data = Array();
			$data[0]['TEXT'] = '';
			$data[0]['COLSPAN'] = $columns;
			
		$pdf->tbDrawData($data);
		
		$data = Array();
			$data[0]['TEXT'] = 'TOTAL';
			$data[0]['COLSPAN'] = 10;
			$data[0]['LN_SIZE'] = 7;
			$data[0]['T_COLOR'] = array(118,0,3);
			$data[0]['T_SIZE'] = 7;
			$data[0]['V_ALIGN'] = "M";
			
			$data[10]['TEXT'] = formato_money($total_valorizado_dol);
			$data[10]['T_SIZE'] = 7;
			$data[10]['T_ALIGN'] = 'R';
			$data[10]['V_ALIGN'] = "M";
			
			$data[11]['TEXT'] = formato_money($total_valorizado);
			$data[11]['T_SIZE'] = 7;
			$data[11]['T_ALIGN'] = 'R';
			$data[11]['V_ALIGN'] = "M";
			
		$pdf->tbDrawData($data);
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	$sTxt = utf8_decode("<s1>N° REGISTROS: </s1><s3> $num_rows</s3>");
	$pdf->MultiCellTag(100, 8, $sTxt,0,'L');
	
	//draw the Table Border
	$pdf->tbDrawBorder();
	
	//fin tabla datos
	
	$nombre_archivo='rep_productos_'.$fecha_actual.'.pdf';
	$pdf->Output($nombre_archivo,'I');

?>