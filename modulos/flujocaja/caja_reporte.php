<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../empresa/cEmpresa.php");
$oEmpresa = new cEmpresa();
require_once ("../ingreso/cIngreso.php");
$oIngreso = new cIngreso();
require_once ("../egreso/cEgreso.php");
$oEgreso = new cEgreso();
require_once ("../producto/cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once ("../catalogo/cst_producto.php");
require_once ("../usuarios/cUsuario.php");
$oUsuario = new cUsuario();
require_once ("../caja/cCaja.php");
$oCaja = new cCaja();
require_once("../formatos/formato.php");
require_once("../formatos/mysql.php");
$oMysql = new cMysql();

$fecha_actual=$d=date('d-m-Y');
$titulo='REPORTE DE CAJA';

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

//vendedor
if($_SESSION['usuario_id']>0)
{
	$dts=$oUsuario->mostrarUno($_SESSION['usuario_id']);
	$dt = mysql_fetch_array($dts);
		$usugru		=$dt['tb_usuariogrupo_id'];
		$usugru_nom	=$dt['tb_usuariogrupo_nom'];
		$usu_nom		=$dt['tb_usuario_nom'];
		$apepat		=$dt['tb_usuario_apepat'];
		$apemat		=$dt['tb_usuario_apemat'];
		$ema		=$dt['tb_usuario_ema'];

	mysql_free_result($dts);

	$texto_usuario="$usu_nom $apepat $apemat";
}

//caja
if($_POST['cmb_fil_caj_id']>0)
{
	$dts=$oCaja->mostrarUno($_POST['cmb_fil_caj_id']);
	$dt = mysql_fetch_array($dts);
		$caj_nom=$dt['tb_caja_nom'];
	mysql_free_result($dts);
	
	$texto_caja=$caj_nom;
}

if($_POST['txt_fil_caj_fec1']==$_POST['txt_fil_caj_fec2'])
{
	$etiqueta_fecha='FECHA:';
	$texto_fecha=$_POST['txt_fil_caj_fec1'];	
}
else
{
	$etiqueta_fecha='FECHA:';
	$texto_fecha=$_POST['txt_fil_caj_fec1'].' | '.$_POST['txt_fil_caj_fec2'];
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

	
	$pdf = new pdf_usage('L','mm','A4');		
	$pdf->Open();
	$pdf->SetDisplayMode('real');
	$pdf->SetAutoPageBreak(true, 23);
    $pdf->SetMargins(12, 20, 15);
	$pdf->AddPage();
	$pdf->AliasNbPages(); 
		
	$pdf->SetStyle("s1","arial","",8,"118,0,3");
	$pdf->SetStyle("s2","arial","",10,"0,49,159");
	$pdf->SetStyle("s3","arial","",8,"0,49,159");
	$pdf->SetStyle("s4","arial","",9,"118,0,3");
	
	//default text color
	$pdf->SetTextColor(118, 0, 3);
	
	$sTxt = "<s2>$titulo</s2>";
	
	$pdf->MultiCellTag(100, 3, $sTxt,0,'L');
	$pdf->Ln(3);
	
	//linea
	$pdf->Cell(267,1,'','T',1,'L');
	//font
	$pdf->SetFont('Arial','',8);
	
	/*$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,'EMPRESA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_empresa),0,1,'L');*/
	
	if($_POST['cmb_fil_caj_id']>0)
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,'CAJA:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_caja),0,1,'L');
	}
	
	if($_SESSION['usuario_id']>0)
	{
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,'USUARIO:',0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,utf8_decode($texto_usuario),0,1,'L');
	}
	
	$pdf->SetTextColor(118,0,3);
	$pdf->Cell(27,4,$etiqueta_fecha,0,0,'L');
	$pdf->SetTextColor(0,49,159);
	$pdf->Cell(150,4,$texto_fecha,0,1,'L');

	
	
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
				'BRD_TYPE' => 'T',					//border type, can be: 0, 1 or a combination of: "LRTB"
						);
						
		$table_default_table_type = array(
				'TB_ALIGN' => 'L',					//table align on page
				'L_MARGIN' => 0,					//space to the left margin
				//'BRD_COLOR' => array(0,92,177),		//border color
				'BRD_SIZE' => '0.1',				//border size
				'BRD_TYPE' => '1'
						);
	/*****************************************************
	TABLE DEFAULT DEFINES --- END
	*****************************************************/
	
	$columns = 7; //number of Columns
	
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
	$aSimpleHeader[0]['T_ALIGN'] = 'L';
	$aSimpleHeader[0]['WIDTH'] = 17;
	
	$aSimpleHeader[1] = $table_default_header_type;
	$aSimpleHeader[1]['TEXT'] = "DOCUMENTO";
	$aSimpleHeader[1]['T_ALIGN'] = 'L';
	$aSimpleHeader[1]['WIDTH'] = 23;
	
	$aSimpleHeader[2] = $table_default_header_type;
	$aSimpleHeader[2]['TEXT'] = "DETALLE";
	$aSimpleHeader[2]['T_ALIGN'] = 'L';
	$aSimpleHeader[2]['WIDTH'] = 80;
	
	$aSimpleHeader[3] = $table_default_header_type;
	$aSimpleHeader[3]['TEXT'] = "CLIENTE / ANEXO";
	$aSimpleHeader[3]['T_ALIGN'] = 'L';
	$aSimpleHeader[3]['WIDTH'] = 58;
	
	$aSimpleHeader[4] = $table_default_header_type;
	$aSimpleHeader[4]['TEXT'] = "CUENTA | SUB CUENTA";
	$aSimpleHeader[4]['T_ALIGN'] = 'L';
	$aSimpleHeader[4]['WIDTH'] = 57;
	
	$aSimpleHeader[5] = $table_default_header_type;
	$aSimpleHeader[5]['TEXT'] = "IMPORTE";
	$aSimpleHeader[5]['T_ALIGN'] = 'R';
	$aSimpleHeader[5]['WIDTH'] = 17;
	
	$aSimpleHeader[6] = $table_default_header_type;
	$aSimpleHeader[6]['TEXT'] = "ESTADO";
	$aSimpleHeader[6]['T_ALIGN'] = 'R';
	$aSimpleHeader[6]['WIDTH'] = 18;
	
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

	$data = Array();
		$data[0]['TEXT'] = 'INGRESOS';
		$data[0]['COLSPAN'] = 7;
		$data[0]['LN_SIZE'] = 7;
		$data[0]['T_COLOR'] = array(118,0,3);
		$data[0]['T_SIZE'] = 9;
		$data[0]['V_ALIGN'] = "M";
	$pdf->tbDrawData($data);

$dts1=$oIngreso->mostrar_filtro($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_doc_id'],$_POST['txt_fil_ing_numdoc'],$_POST['hdd_fil_cli_id'],$_POST['cmb_fil_ing_est']);

$num_rows= mysql_num_rows($dts1);

	//llenado datos de contenido de tabla
	if($num_rows>=1)
	{
		while($dt1 = mysql_fetch_array($dts1))
		{
			$sum_ing_imp+=$dt1['tb_ingreso_imp'];
			
			$data = Array();
			$data[0]['TEXT'] = mostrarFecha($dt1['tb_ingreso_fec']);
			//$data[0]['BRD_TYPE'] = '1';

			$documento=$dt1['tb_documento_abr'].' '.$dt1['tb_ingreso_numdoc'];
			$data[1]['TEXT'] = utf8_decode($documento);
			$data[2]['TEXT'] = utf8_decode($dt1['tb_ingreso_det']);

			$cliente=$dt1['tb_cliente_doc'].' '.$dt1['tb_cliente_nom'];
			$data[3]['TEXT'] = utf8_decode($cliente);

			$cuentas=$dt1['tb_cuenta_des'].' '.$dt1['tb_subcuenta_des'];
			$data[4]['TEXT'] = utf8_decode($cuentas);
			$data[5]['TEXT'] = formato_money($dt1['tb_ingreso_imp']);
			$data[5]['T_ALIGN'] = 'R';
			
			if($dt1['tb_ingreso_est']==1)$est='CANCELADO';
            if($dt1['tb_ingreso_est']==2)$est='EMITIDO';
			$data[6]['TEXT'] = $est;
			$data[6]['T_ALIGN'] = 'R';
			$data[6]['T_SIZE'] = 7;
			
			$pdf->tbDrawData($data);

		}//fin while
		mysql_free_result($dts1);
	}//fin nunm_rows
	
	$data = Array();
		$data[0]['TEXT'] = 'TOTAL';
		$data[0]['COLSPAN'] = 5;
		$data[0]['LN_SIZE'] = 6;
		$data[0]['T_SIZE'] = 8;
		
		$texto_total_ingresos=formato_money($sum_ing_imp);
		
		$data[5]['TEXT'] = $texto_total_ingresos;
		$data[5]['COLSPAN'] = 1;
		$data[5]['LN_SIZE'] = 6;
		$data[5]['T_SIZE'] = 8;
		$data[5]['T_ALIGN'] = 'R';
	$pdf->tbDrawData($data);
	
	$data = Array();
		$data[0]['TEXT'] = '';
		$data[0]['COLSPAN'] = 7;
		$data[0]['LN_SIZE'] = 4;
		$data[0]['T_SIZE'] = 8;
		$data[0]['BRD_TYPE']=0;
	$pdf->tbDrawData($data);
	
	$data = Array();
		$data[0]['TEXT'] = 'EGRESOS';
		$data[0]['COLSPAN'] = 7;
		$data[0]['LN_SIZE'] = 7;
		$data[0]['T_COLOR'] = array(118,0,3);
		$data[0]['T_SIZE'] = 9;
		$data[0]['V_ALIGN'] = "M";
		$data[0]['BRD_TYPE']=0;
	$pdf->tbDrawData($data);
	
$dts1=$oEgreso->mostrar_filtro($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['cmb_fil_doc_id'],$_POST['txt_fil_egr_numdoc'],$_POST['hdd_fil_pro_id'],$_POST['cmb_fil_egr_est']);

$num_rows= mysql_num_rows($dts1);

	//llenado datos de contenido de tabla
	if($num_rows>=1)
	{
		while($dt1 = mysql_fetch_array($dts1))
		{
			$sum_egr_imp+=$dt1['tb_egreso_imp'];
			
			$data = Array();
			$data[0]['TEXT'] = mostrarFecha($dt1['tb_egreso_fec']);
			//$data[0]['BRD_TYPE'] = '1';
			
			$documento=$dt1['tb_documento_abr'].' '.$dt1['tb_egreso_numdoc'];
			$data[1]['TEXT'] = utf8_decode($documento);
			$data[2]['TEXT'] = utf8_decode($dt1['tb_egreso_det']);

			$proveedor=$dt1['tb_proveedor_doc'].' '.$dt1['tb_proveedor_nom'];
			$data[3]['TEXT'] = utf8_decode($proveedor);

			$cuentas=$dt1['tb_cuenta_des'].' '.$dt1['tb_subcuenta_des'];
			$data[4]['TEXT'] = utf8_decode($cuentas);

			$data[5]['TEXT'] = formato_money($dt1['tb_egreso_imp']);
			$data[5]['T_ALIGN'] = 'R';
			
			if($dt1['tb_egreso_est']==1)$est='CANCELADO';
            if($dt1['tb_egreso_est']==2)$est='EMITIDO';
			$data[6]['TEXT'] = $est;
			$data[6]['T_ALIGN'] = 'R';
			$data[6]['T_SIZE'] = 7;
			
			$pdf->tbDrawData($data);

		}//fin while
		mysql_free_result($dts1);
	}//fin nunm_rows	
	
	$data = Array();
		$data[0]['TEXT'] = 'TOTAL';
		$data[0]['COLSPAN'] = 5;
		$data[0]['LN_SIZE'] = 6;
		$data[0]['T_SIZE'] = 8;
		
		$texto_total_egresos=formato_money($sum_egr_imp);
		
		$data[5]['TEXT'] = $texto_total_egresos;
		$data[5]['COLSPAN'] = 1;
		$data[5]['LN_SIZE'] = 6;
		$data[5]['T_SIZE'] = 8;
		$data[5]['T_ALIGN'] = 'R';
	$pdf->tbDrawData($data);
	
	/*$data = Array();
		$data[0]['TEXT'] = '';
		$data[0]['COLSPAN'] = 11;
		$data[0]['LN_SIZE'] = 6;
		$data[0]['T_SIZE'] = 8;

	$pdf->tbDrawData($data);
	
	$data = Array();
		$data[0]['TEXT'] = 'SALDO EN CAJA';
		$data[0]['COLSPAN'] = 11;
		$data[0]['LN_SIZE'] = 7;
		$data[0]['T_COLOR'] = array(118,0,3);
		$data[0]['T_SIZE'] = 9;
		$data[0]['V_ALIGN'] = "M";
	$pdf->tbDrawData($data);*/
	
	//output the table data to the pdf
	$pdf->tbOuputData();
	
	//draw the Table Border
	$pdf->tbDrawBorder();
	//fin tabla datos

//SALDO EN CAJA-----------------------------------------
$estado_ingreso='1';
$estado_egreso='1';

//fechas
$fec_ini='01-01-2014';
$fec_fin=$oMysql->DATE_ADD(fecha_mysql($_POST['txt_fil_caj_fec1']),'-1','DAY');

//CAJA SOLES______________
$mon_id=1;

//SALDO ANTERIOR
$dts=$oIngreso->mostrar_suma($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($fec_ini),$fec_fin,$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_ing_numdoc'],$_POST['cmb_fil_cli_id'],$estado_ingreso);
$dt = mysql_fetch_array($dts);
$sa_ingreso_sol	=$dt['total'];
mysql_free_result($dts);

$dts=$oEgreso->mostrar_suma($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($fec_ini),$fec_fin,$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_egr_numdoc'],$_POST['cmb_fil_pro_id'],$estado_egreso);
$dt = mysql_fetch_array($dts);
$sa_egreso_sol	=$dt['total'];
mysql_free_result($dts);

$saldo_anterior_sol=$sa_ingreso_sol-$sa_egreso_sol;


//ENTRADA

$dts=$oIngreso->mostrar_suma($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_egr_numdoc'],$_POST['cmb_fil_pro_id'],$estado_ingreso);
$dt = mysql_fetch_array($dts);
$ingreso_sol	=$dt['total'];
mysql_free_result($dts);

//SALIDA
$dts=$oEgreso->mostrar_suma($_SESSION['empresa_id'],$_POST['cmb_fil_caj_id'],fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),$_POST['cmb_fil_cue_id'],$_POST['cmb_fil_subcue_id'],$_POST['txt_fil_egr_numdoc'],$_POST['cmb_fil_pro_id'],$estado_egreso);
$dt = mysql_fetch_array($dts);
$egreso_sol	=$dt['total'];
mysql_free_result($dts);

$saldo_sol=$saldo_anterior_sol+$ingreso_sol-$egreso_sol;

//Ganancias
$dts1=$oVenta->mostrar_filtro_adm(fecha_mysql($_POST['txt_fil_caj_fec1']),fecha_mysql($_POST['txt_fil_caj_fec2']),0,0,'',0,0,$_SESSION['empresa_id'],0);
$ventas = 0;
$compras = 0;
while($dt1 = mysql_fetch_array($dts1)){
    $ventas =$ventas + $dt1['tb_venta_valven'];
    $dts2=$oVenta->mostrar_venta_detalle($dt1['tb_venta_id']);
    while($dt2 = mysql_fetch_array($dts2)) {
        $cantidad = $dt2['tb_ventadetalle_can'];
        $dts3=$oPresentacion->mostrar_por_producto($dt2['tb_producto_id']);
        while($dt3 = mysql_fetch_array($dts3)){
            $dts4=$oCatalogoproducto->mostrar_unidad_de_presentacion($dt3['tb_presentacion_id']);
            $array_dt4 = array();
            while($dt4 = mysql_fetch_array($dts4)) {
                $array_dt4[] = $dt4;
            }
            // Costo Ponderado
            $costo_ponderado="";
            $stock_kardex=stock_kardex($array_dt4[0]['cat_id'],0,'',date('Y-m-d'),$_SESSION['empresa_id']);
            $costo_ponderado_array=costo_ponderado_empresa($array_dt4[0]['cat_id'],$_SESSION['almacen_id'],'',date('Y-m-d'),$stock_kardex,$array_dt4[0]['precos'],$precosdol,$_SESSION['empresa_id']);
            $costo_ponderado=$costo_ponderado_array['soles'];
            $costo_ponderado=$costo_ponderado*$cantidad;
            $compras = $compras + $costo_ponderado;
        }
    }
}
$compras = $compras/1.18;

					
	$pdf->Ln(7);
	
	$pdf->SetFont('Arial','',9);
	$pdf->SetTextColor(0, 0, 0);
	//$sTxt = utf8_decode("<s4>SALDO EN CAJA</s4>");
	//$pdf->MultiCellTag(100, 4, $sTxt,1,'L');

	$pdf->Cell(35,4,'SALDO EN CAJA',0,0,'L');$pdf->Cell(25,4,'SOLES',0,0,'R');
	$pdf->Cell(30,4,'',0,0,'R');$pdf->Cell(30,4,'',0,0,'L');$pdf->Cell(50,4,'',0,1,'L');
	$pdf->Cell(95,1,'','T',1,'R');
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetTextColor(0, 0, 0);
	

	$pdf->Cell(35,4,'SALDO ANTERIOR',0,0,'L');$pdf->Cell(25,4,formato_money($saldo_anterior_sol),0,0,'R');$pdf->Cell(5,4,'',0,0,'L');$pdf->Cell(25,4,'',0,1,'R');
	$pdf->Cell(35,4,'INGRESOS',0,0,'L');$pdf->Cell(25,4,formato_money($ingreso_sol),0,0,'R');$pdf->Cell(5,4,'',0,0,'L');$pdf->Cell(25,4,'',0,1,'R');
	$pdf->Cell(35,4,'EGRESOS',0,0,'L');$pdf->Cell(25,4,formato_money($egreso_sol),0,0,'R');$pdf->Cell(5,4,'',0,0,'L');$pdf->Cell(25,4,'',0,1,'R');
	$pdf->Cell(90,1,'','T',1,'R');
	$pdf->Cell(35,4,'SALDO',0,0,'L');$pdf->Cell(25,4,formato_money($saldo_sol),0,0,'R');$pdf->Cell(5,4,'',0,0,'L');$pdf->Cell(25,4,'',0,1,'R');

    $pdf->Ln(7);

    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(0, 0, 0);
    //$sTxt = utf8_decode("<s4>SALDO EN CAJA</s4>");
    //$pdf->MultiCellTag(100, 4, $sTxt,1,'L');

    $pdf->Cell(35, 4, 'GANANCIA', 0, 0, 'L');
    $pdf->Cell(25, 4, 'SOLES', 0, 0, 'R');
    $pdf->Cell(30, 4, '', 0, 0, 'R');
    $pdf->Cell(30, 4, '', 0, 0, 'L');
    $pdf->Cell(50, 4, '', 0, 1, 'L');
    $pdf->Cell(95, 1, '', 'T', 1, 'R');

    $pdf->SetFont('Arial', '', 8);
    $pdf->SetTextColor(0, 0, 0);


    $pdf->Cell(35, 4, 'VENTAS', 0, 0, 'L');
    $pdf->Cell(25, 4, formato_money($ventas), 0, 0, 'R');
    $pdf->Cell(5, 4, '', 0, 0, 'L');
    $pdf->Cell(25, 4, '', 0, 1, 'R');
    $pdf->Cell(35, 4, 'COMPRAS', 0, 0, 'L');
    $pdf->Cell(25, 4, formato_money($compras), 0, 0, 'R');
    $pdf->Cell(5, 4, '', 0, 0, 'L');
    $pdf->Cell(25, 4, '', 0, 1, 'R');
    $pdf->Cell(90, 1, '', 'T', 1, 'R');
    $pdf->Cell(35, 4, 'TOTAL', 0, 0, 'L');
    $pdf->Cell(25, 4, formato_money($ventas-$compras), 0, 0, 'R');
    $pdf->Cell(5, 4, '', 0, 0, 'L');
    $pdf->Cell(25, 4, '', 0, 1, 'R');


	//texto

	//$sTxt = utf8_decode("<s1>N° VENTAS REGISTRADAS: </s1><s3> $num_rows</s3>");
	//$pdf->MultiCellTag(100, 8, $sTxt,0,'L');
	
	
	$nombre_archivo='rep_caja_'.$fecha_actual.'.pdf';
	$pdf->Output($nombre_archivo,'I');

?>