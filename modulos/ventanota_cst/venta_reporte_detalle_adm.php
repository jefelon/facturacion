<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("cVentanota.php");
$oVenta = new cVenta();
require_once ("../documento/cDocumento.php");
$oDocumento = new cDocumento();
require_once ("../clientes/cCliente.php");
$oCliente = new cCliente();
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../puntoventa/cPuntoventa.php");
$oPuntoventa = new cPuntoventa();
require_once ("cVentapago.php");
$oVentapago = new cVentapago();
require_once ("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
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

	$texto_empresa=$emp_razsoc;

//documento
if($_POST['cmb_fil_ven_doc']>0)
{
$dts=$oDocumento->mostrarUno($_POST['cmb_fil_ven_doc']);
$dt = mysql_fetch_array($dts);
	$doc_tip=$dt['tb_documento_tip'];
	$doc_abr=$dt['tb_documento_abr'];
	$doc_nom=$dt['tb_documento_nom'];
	$doc_def=$dt['tb_documento_def'];
mysql_free_result($dts);

	$texto_documento=$doc_nom;
}

//cliente
if($_POST['hdd_fil_cli_id']>0)
{
	$dts=$oCliente->mostrarUno($_POST['hdd_fil_cli_id']);
	$dt = mysql_fetch_array($dts);
		$cli_tip=$dt['tb_cliente_tip'];
		$cli_nom=$dt['tb_cliente_nom'];
		$cli_doc=$dt['tb_cliente_doc'];
		$cli_dir=$dt['tb_cliente_dir'];
		$cli_con=$dt['tb_cliente_con'];
		$cli_tel=$dt['tb_cliente_tel'];
		$cli_ema=$dt['tb_cliente_ema'];
	mysql_free_result($dts);
	
	$texto_cliente=$cli_nom.' | '.$cli_doc;
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

if($_POST['txt_fil_ven_fec1']==$_POST['txt_fil_ven_fec2'])
{
	$etiqueta_fecha='FECHA:';
	$texto_fecha=$_POST['txt_fil_ven_fec1'];	
}
else
{
	$etiqueta_fecha='FECHA:';
	$texto_fecha=$_POST['txt_fil_ven_fec1'].' | '.$_POST['txt_fil_ven_fec2'];
}


$dts1=$oVenta->mostrar_filtro_adm(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id']);
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
			
			$this->SetY(-15);
			$this->SetFont('Arial','I',7);
			$this->SetTextColor(170, 170, 170);
			
			$this->Cell(70,4,utf8_decode("Impresión: $fecha_actual"),0,0,'L');
			
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

	
	$pdf = new pdf_usage('P','mm','A4');		
	$pdf->Open();
	$pdf->SetDisplayMode('real');
	$pdf->SetAutoPageBreak(true, 25);
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
	$pdf->Cell(179,1,'','T',1,'L');
	//font
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,'EMPRESA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_empresa),0,1,'L');
	
	if($_POST['cmb_fil_ven_punven']>0)
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,'PUNTO DE VENTA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_puntoventa),0,1,'L');
	}
	
	if($_POST['cmb_fil_ven_ven']>0)
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,'VENDEDOR:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_vendedor),0,1,'L');
	}
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,$etiqueta_fecha,0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,$texto_fecha,0,1,'L');
	
	if($_POST['cmb_fil_ven_doc']>0)
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,'DOCUMENTO:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_documento),0,1,'L');
	}
	
	if($_POST['hdd_fil_cli_id']>0)
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,'CLIENTE:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_cliente),0,1,'L');
	}
	
	if($_POST['cmb_fil_ven_est']!="")
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,'ESTADO:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($_POST['cmb_fil_ven_est']),0,1,'L');
	}
	
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
				//'T_COLOR' => array(255,255,240),	//text color
				'T_SIZE' => 8,						//font size
				'T_FONT' => 'Arial',				//font family
				'T_ALIGN' => 'C',					//horizontal alignment, possible values: LRC (left, right, center)
				'V_ALIGN' => 'M',					//vertical alignment, possible values: TMB(top, middle, bottom)
				'T_TYPE' => 'B',						//font type
				'LN_SIZE' => 5,						//line size for one row
				'BG_COLOR' => array(255, 255, 255),	//background color
				'BRD_COLOR' => array(0,92,177),		//border color
				'BRD_SIZE' => 0.1,					//border size
				'BRD_TYPE' => 'B',					//border type, can be: 0, 1 or a combination of: "LRTB"
				'TEXT' => '',						//text
						);
						
		$table_default_data_type = array(
				'T_COLOR' => array(0,0,0),			//text color
				'T_SIZE' => 8,						//font size
				'T_FONT' => 'Arial',				//font family
				'T_ALIGN' => 'L',					//horizontal alignment, possible values: LRC (left, right, center)
				'V_ALIGN' => 'T',					//vertical alignment, possible values: TMB(top, middle, bottom)
				'T_TYPE' => '',						//font type
				'LN_SIZE' => 5,						//line size for one row
				'BG_COLOR' => array(255,255,255),	//background color
				'BRD_COLOR' => array(0,92,177),		//border color
				'BRD_SIZE' => 0.1,					//border size
				'BRD_TYPE' => '0',					//border type, can be: 0, 1 or a combination of: "LRTB"
						);
						
		$table_default_table_type = array(
				'TB_ALIGN' => 'L',					//table align on page
				'L_MARGIN' => 0,					//space to the left margin
				//'BRD_COLOR' => array(0,92,177),		//border color
				'BRD_SIZE' => '0.1',				//border size
				'BRD_TYPE' => '0'
						);
	/*****************************************************
	TABLE DEFAULT DEFINES --- END
	*****************************************************/
	
	$columns = 8; //number of Columns
	
	//Initialize the table class
	$pdf->tbInitialize($columns, true, false);
	
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
	$aSimpleHeader[0]['WIDTH'] = 17;
	
	$aSimpleHeader[1] = $table_default_header_type;
	$aSimpleHeader[1]['TEXT'] = "DOCUMENTO";
	$aSimpleHeader[1]['WIDTH'] = 22;
	
	$aSimpleHeader[2] = $table_default_header_type;
	$aSimpleHeader[2]['TEXT'] = "CLIENTE";
	$aSimpleHeader[2]['WIDTH'] = 66;
	
	$aSimpleHeader[3] = $table_default_header_type;
	$aSimpleHeader[3]['TEXT'] = "";
	$aSimpleHeader[3]['WIDTH'] = 8;
	
	$aSimpleHeader[4] = $table_default_header_type;
	$aSimpleHeader[4]['TEXT'] = "";
	$aSimpleHeader[4]['T_ALIGN'] = 'R';
	$aSimpleHeader[4]['WIDTH'] = 15;
	//$aSimpleHeader[5]['T_ALIGN'] = 'R';
	
	$aSimpleHeader[5] = $table_default_header_type;
	$aSimpleHeader[5]['TEXT'] = "";
	$aSimpleHeader[5]['T_ALIGN'] = 'R';
	$aSimpleHeader[5]['WIDTH'] = 17;
	
	$aSimpleHeader[6] = $table_default_header_type;
	$aSimpleHeader[6]['TEXT'] = "CAN";
	$aSimpleHeader[6]['T_ALIGN'] = 'R';
	$aSimpleHeader[6]['WIDTH'] = 15;
	
	$aSimpleHeader[7] = $table_default_header_type;
	$aSimpleHeader[7]['TEXT'] = "SUB TOT";
	$aSimpleHeader[7]['T_ALIGN'] = 'R';
	$aSimpleHeader[7]['WIDTH'] = 17;
	
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
				$total_valven	+=$dt1['tb_venta_valven'];
				$total_igv		+=$dt1['tb_venta_igv'];
				$total_des		+=$dt1['tb_venta_des'];
				$total_ventas	+=$dt1['tb_venta_tot'];
			}
			
		//for ($j=1; $j<=500; $j++)
		//{
			$data = Array();
			$data[0]['TEXT'] = '';
			$data[0]['COLSPAN'] = 8;
			$data[0]['LN_SIZE'] = '1';
			$data[0]['BRD_TYPE'] = 'T';
			$pdf->tbDrawData($data);
			
			$data = Array();
			$data[0]['TEXT'] = mostrarFecha($dt1['tb_venta_fec']);
			//$data[0]['BRD_TYPE'] = '1';
			
			$data[1]['TEXT'] = utf8_decode($dt1['tb_documento_abr'].' '.$dt1['tb_venta_numdoc']);
			$data[2]['TEXT'] = utf8_decode($dt1['tb_cliente_nom']);
			$data[3]['TEXT'] = utf8_decode($dt1['tb_cliente_doc']);
			$data[3]['COLSPAN'] = 2;
			
			$data[5]['TEXT'] = ''/*formato_money($dt1['tb_venta_valven'])*/;
			$data[5]['T_ALIGN'] = 'R';
			
			$data[6]['TEXT'] = $dt1['tb_venta_est']/*formato_money($dt1['tb_venta_igv'])*/;
			$data[6]['T_ALIGN'] = 'R';
			$data[6]['COLSPAN'] = 2;
			
			//$data[7]['TEXT'] = ''/*formato_money($dt1['tb_venta_tot'])*/;
			//$data[7]['T_ALIGN'] = 'R';
			
			$pdf->tbDrawData($data);
			
			$data = Array();
			$data[0]['TEXT'] = '';
			$data[0]['COLSPAN'] = 8;
			$data[0]['LN_SIZE'] = '1';
			$data[0]['BRD_TYPE'] = 'T';
			$pdf->tbDrawData($data);
			
			//DETALLE DE VENTA
			$dts2=$oVenta->mostrar_venta_detalle_ps($dt1['tb_venta_id']);
			while($dt2 = mysql_fetch_array($dts2))
			{
				$sub_total=$dt2['tb_ventadetalle_valven']+$dt2['tb_ventadetalle_igv'];
				
				$data = Array();
				if($dt2['tb_ventadetalle_tipven']==1)$articulo=$dt2['tb_producto_nom'];
				if($dt2['tb_ventadetalle_tipven']==2)$articulo=$dt2['tb_servicio_nom'];
				$data[0]['TEXT'] = utf8_decode($articulo);
				$data[0]['COLSPAN'] = 3;
				
				$data[3]['TEXT'] = ''/*$dt2['tb_ventadetalle_can']*/;
				$data[3]['T_ALIGN'] = 'R';
				
				$data[4]['TEXT'] = ''/*formato_money($dt2['tb_ventadetalle_preuni'])*/;
				$data[4]['T_ALIGN'] = 'R';
				
				$data[5]['TEXT'] = ''/*formato_money($dt2['tb_ventadetalle_valven'])*/;
				$data[5]['T_ALIGN'] = 'R';
				
				$data[6]['TEXT'] = $dt2['tb_ventadetalle_can']/*formato_money($dt2['tb_ventadetalle_igv'])*/;
				$data[6]['T_ALIGN'] = 'R';
				
				$data[7]['TEXT'] = formato_money($sub_total);
				$data[7]['T_ALIGN'] = 'R';
				
				$pdf->tbDrawData($data);
			}//fin while 2
			mysql_free_result($dts2);
			
			$data = Array();
			$data[0]['TEXT'] = '';
			$data[0]['COLSPAN'] = 8;
			$data[0]['LN_SIZE'] = '1';
			$data[0]['BRD_TYPE'] = '0';
			$pdf->tbDrawData($data);
			
			//PAGOS POR VENTA
			
			$rws1=$oVentapago->mostrar_pagos($dt1['tb_venta_id']);
			$num_rows_vp= mysql_num_rows($rws1);
			
			$texto_venta_pago="";
			if($num_rows_vp>0){
				$i=0;
				while($rw1 = mysql_fetch_array($rws1)){
					
					$i++;
					
					//forma
					if($rw1['tb_formapago_id']==1)
					{
						//$forma='CONTADO';
						$forma='';
						//modo
						if($rw1['tb_modopago_id']==1)
						{
							$modo='EFECTIVO';
							$suma_pago1+=$rw1['tb_ventapago_mon'];
						}
						if($rw1['tb_modopago_id']==2)
						{
							$modo='DEPOSITO '.$rw1['tb_cuentacorriente_nom'].' N° Oper: '.$rw1['tb_ventapago_numope'];
							$suma_pago2+=$rw1['tb_ventapago_mon'];
						}
						if($rw1['tb_modopago_id']==3)
						{
							$modo='TARJETA '.$rw1['tb_tarjeta_nom'].' N° Oper: '.$rw1['tb_ventapago_numope'];
							$suma_pago3+=$rw1['tb_ventapago_mon'];
						}
					}
					
					if($rw1['tb_formapago_id']==2)
					{
						$forma='CREDITO '.$rw1['tb_ventapago_numdia'].'D, FV: '.mostrarFecha($rw1['tb_ventapago_fecven']);
					
						//modo
						if($rw1['tb_modopago_id']==1)
						{
							$modo='EFECTIVO';
							$suma_pago4+=$rw1['tb_ventapago_mon'];
						}
						if($rw1['tb_modopago_id']==2)
						{
							$modo='DEPOSITO '.$rw1['tb_cuentacorriente_nom'].' N° Oper: '.$rw1['tb_ventapago_numope'];
							$suma_pago5+=$rw1['tb_ventapago_mon'];
						}
						if($rw1['tb_modopago_id']==3)
						{
							$modo='TARJETA '.$rw1['tb_tarjeta_nom'].' N° Oper: '.$rw1['tb_ventapago_numope'];
							$suma_pago6+=$rw1['tb_ventapago_mon'];
						}
					}
				
					$pago_mon=formato_money($rw1['tb_ventapago_mon']);
					
					if($num_rows_vp>1)
					{
						if($i==1)$texto_pago="$forma $modo = $pago_mon";
						
						if($i>1)$texto_pago=" | $forma $modo = $pago_mon";
					}
					else
					{
						if($i==1)$texto_pago="$forma $modo";
						
						if($i>1)$texto_pago=" | $forma $modo";
					}
					
					$texto_venta_pago.=$texto_pago;
				}
                mysql_free_result($rws1);
			}
			
			$data = Array();
			$data[0]['TEXT'] = utf8_decode('-'.$texto_venta_pago);
			$data[0]['COLSPAN'] = 4;
			$data[0]['T_ALIGN'] = 'L';
			$data[0]['T_TYPE'] = '';
			$data[0]['BRD_TYPE'] = '0';
			
			$data[4]['TEXT'] = 'TOTAL';
			$data[4]['T_ALIGN'] = 'R';
			$data[4]['T_TYPE'] = 'B';
			$data[4]['BRD_TYPE'] = '0';
			
			$data[5]['TEXT'] = formato_money($dt1['tb_venta_valven']);
			$data[5]['T_ALIGN'] = 'R';
			$data[5]['T_TYPE'] = 'B';
			$data[5]['BRD_TYPE'] = '0';
			
			$data[6]['TEXT'] = formato_money($dt1['tb_venta_igv']);
			$data[6]['T_ALIGN'] = 'R';
			$data[6]['T_TYPE'] = 'B';
			$data[6]['BRD_TYPE'] = '0';
			
			$data[7]['TEXT'] = formato_money($dt1['tb_venta_tot']);
			$data[7]['T_ALIGN'] = 'R';
			$data[7]['T_TYPE'] = 'B';
			$data[7]['BRD_TYPE'] = '0';
			
			$pdf->tbDrawData($data);
			
			$data = Array();
			$data[0]['TEXT'] = '';
			$data[0]['COLSPAN'] = 8;
			$data[0]['LN_SIZE'] = '6';
			$data[0]['BRD_TYPE'] = '0';
			$pdf->tbDrawData($data);
		//}
		}//fin while
		mysql_free_result($dts1);
	}//fin nunm_rows
	
		$data = Array();
			$data[0]['TEXT'] = '';
			$data[0]['COLSPAN'] = 8;
			$data[0]['LN_SIZE'] = '6';
			$data[0]['BRD_TYPE'] = '0';			
		$pdf->tbDrawData($data);
		
		$data = Array();
			$data[0]['TEXT'] = '';
			$data[0]['COLSPAN'] = 8;
			$data[0]['LN_SIZE'] = '1';
			$data[0]['BRD_TYPE'] = 'T';			
		$pdf->tbDrawData($data);
		
		$data = Array();
			$data[0]['TEXT'] = 'TOTAL VENTAS | '.$num_rows;
			$data[0]['COLSPAN'] = 5;
			$data[0]['LN_SIZE'] = 6;
			$data[0]['T_COLOR'] = array(118,0,3);
			$data[0]['T_SIZE'] = 9;
			$data[0]['V_ALIGN'] = "M";
			
			$data[5]['TEXT'] = formato_money($total_valven);
			$data[5]['T_SIZE'] = 9;
			$data[5]['T_ALIGN'] = 'R';
			$data[5]['V_ALIGN'] = "M";
			
			$data[6]['TEXT'] = formato_money($total_igv);
			$data[6]['T_SIZE'] = 9;
			$data[6]['T_ALIGN'] = 'R';
			$data[6]['V_ALIGN'] = "M";
			
			$data[7]['TEXT'] = formato_money($total_ventas);
			$data[7]['T_SIZE'] = 9;
			$data[7]['T_ALIGN'] = 'R';
			$data[7]['V_ALIGN'] = "M";
			
		$pdf->tbDrawData($data);
		
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();
	//fin tabla datos
	
	//PAGOS
	$pdf->Ln(7);
	
	$sTxt = utf8_decode("<s1>RESUMEN PAGOS</s1>");
	$pdf->MultiCellTag(100, 4, $sTxt,0,'L');
	$pdf->Cell(140,1,'','T',1,'R');
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0, 0, 0);
	
	$texto_res_pago1='CONTADO - EFECTIVO';
	$texto_res_pago2='CONTADO - DEPOSITO';
	$texto_res_pago3='CONTADO - TARJETA';
	$texto_res_pago4='CREDITO - EFECTIVO';
	$texto_res_pago5='CREDITO - DEPOSITO';
	$texto_res_pago6='CREDITO - TARJETA';
	
	if($suma_pago1>0){
	$pdf->Cell(90,4,$texto_res_pago1,0,0,'L');$pdf->Cell(20,4,'',0,0,'R');$pdf->Cell(30,4,formato_money($suma_pago1),0,1,'R');
	}
	if($suma_pago2>0){
	$pdf->Cell(90,4,$texto_res_pago2,0,0,'L');$pdf->Cell(20,4,'',0,0,'R');$pdf->Cell(30,4,formato_money($suma_pago2),0,1,'R');
	}
	if($suma_pago3>0){
	$pdf->Cell(90,4,$texto_res_pago3,0,0,'L');$pdf->Cell(20,4,'',0,0,'R');$pdf->Cell(30,4,formato_money($suma_pago3),0,1,'R');
	}
	if($suma_pago4>0){
	$pdf->Cell(90,4,$texto_res_pago4,0,0,'L');$pdf->Cell(20,4,'',0,0,'R');$pdf->Cell(30,4,formato_money($suma_pago4),0,1,'R');
	}
	if($suma_pago5>0){
	$pdf->Cell(90,4,$texto_res_pago5,0,0,'L');$pdf->Cell(20,4,'',0,0,'R');$pdf->Cell(30,4,formato_money($suma_pago5),0,1,'R');
	}
	if($suma_pago6>0){
	$pdf->Cell(90,4,$texto_res_pago6,0,0,'L');$pdf->Cell(20,4,'',0,0,'R');$pdf->Cell(30,4,formato_money($suma_pago6),0,1,'R');
	}
	
	$pdf->Ln(7);
	
	$sTxt = utf8_decode("<s1>RESUMEN VENTAS</s1>");
	$pdf->MultiCellTag(100, 4, $sTxt,0,'L');
	$pdf->Cell(140,1,'','T',1,'R');
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0, 0, 0);
	
	//RESUMEN
	$categoria[]=1;
	$tipo[]='p';
	$categoria[]=40;
	$tipo[]='p';
	$categoria[]=12;
	$tipo[]='p';
	
	$categoria[]=20;
	$tipo[]='s';
	$categoria[]=57;
	$tipo[]='s';
	$categoria[]=75;
	$tipo[]='s';
	$categoria[]=74;
	$tipo[]='s';

	foreach($categoria as $indice=>$cat_id){
	//prepara consulta categoria
	
	//$cat_id=40;

		if($cat_id>0)
		{
			$rws=$oCategoria->mostrarUno($cat_id);
			$rw = mysql_fetch_array($rws);
				$cat_nom=$rw['tb_categoria_nom'];
			mysql_free_result($rws);
			
			$cat_ids=$cat_id.'';
			
			$dts2=$oCategoria->mostrar_por_idp($cat_id);
			$num_rows2= mysql_num_rows($dts2);
			if($num_rows2>0){
				while($dt2 = mysql_fetch_array($dts2)){
					
					$cat_ids.=', '.$dt2['tb_categoria_id'];
					
					$dts3=$oCategoria->mostrar_por_idp($dt2['tb_categoria_id']);
					$num_rows3= mysql_num_rows($dts3);
					if($num_rows3>0){
						while($dt3 = mysql_fetch_array($dts3)){
							$cat_ids.=', '.$dt3['tb_categoria_id'];			
						}
					mysql_free_result($dts3);
					}//fin nivel 3
							
				}
			mysql_free_result($dts2);
			}//fin nivel 2
		
		//echo $cat_ids;			
		}
	
		$dts1=$oVenta->mostrar_filtro_detalle_adm(fecha_mysql($_POST['txt_fil_ven_fec1']),fecha_mysql($_POST['txt_fil_ven_fec2']),$_POST['cmb_fil_ven_doc'],$tipo[$indice],$cat_ids,$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ven_est'],$_POST['cmb_fil_ven_ven'],$_POST['cmb_fil_ven_punven'],$_SESSION['empresa_id']);
		$num_rows= mysql_num_rows($dts1);

		$res_can=0;
		$res_sub_total=0;
		$res_total_ventas=0;
		
		if($num_rows>0){
			while($dt1 = mysql_fetch_array($dts1)){
		
				if($dt1['tb_venta_est']=='CANCELADA'){
					$res_can+=$dt1['tb_ventadetalle_can'];
					$res_sub_total=$dt1['tb_ventadetalle_valven']+$dt1['tb_ventadetalle_igv'];
					$res_total_ventas	+=$res_sub_total;
				}
			
			}
			mysql_free_result($dts1);
		
			if($tipo[$indice]=='p')
			{
				$res_cantidad=$res_can;
			}
			else
			{
				$res_cantidad="";	
			}
	
	$pdf->Cell(90,4,$cat_nom,0,0,'L');$pdf->Cell(20,4,$res_cantidad,0,0,'R');$pdf->Cell(30,4,formato_money($res_total_ventas),0,1,'R');
	
	}
	
	}//fin foreach
	
	//texto

	//$sTxt = utf8_decode("<s1>N° VENTAS REGISTRADAS: </s1><s3> $num_rows</s3>");
	//$pdf->MultiCellTag(100, 8, $sTxt,0,'L');
	
	
	$nombre_archivo='rep_ventas_'.$fecha_actual.'.pdf';
	$pdf->Output($nombre_archivo,'I');

?>