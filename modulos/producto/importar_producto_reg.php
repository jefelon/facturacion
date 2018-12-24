<?php
session_start();
require_once("../../config/Cado.php");
require_once("cProducto.php");
$oProducto = new cProducto();
require_once("cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../categoria/cCategoria.php");
$oCategoria = new cCategoria();
require_once("../marca/cMarca.php");
$oMarca = new cMarca();
require_once("../unidad/cUnidad.php");
$oUnidad = new cUnidad();
require_once("../stock/cStock.php");
$oStock = new cStock();

require_once ("../notalmacen/cNotalmacen.php");
$oNotalmacen = new cNotalmacen();
require_once ("../talonario/cTalonariointerno.php");
$oTalonariointerno= new cTalonariointerno();
require_once("../kardex/cKardex.php");
$oKardex = new cKardex();
require_once("../formatos/formato.php");
require_once ("../catalogo/cst_producto.php");



require_once('../../libreriasphp/excel/excel_reader2.php');
require_once('../../libreriasphp/excel/SpreadsheetReader.php');



if (isset($_FILES["file_xls"])) {


    $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/csv', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    if (in_array($_FILES["file_xls"]["type"], $allowedFileType)) {

        $data['type'] = "error";
        $data['message'] = "Hubo un problema al importar registros";

        try {
            $Reader = new SpreadsheetReader($_FILES["file_xls"]["tmp_name"], $_FILES['file_xls']['name'], $_FILES['file_xls']['type']);
        } catch (Exception $e) {
            print $e;
        }


        $sheetCount = count($Reader->sheets());
        for ($i = 0; $i < $sheetCount; $i++) {
            $startAt = 1;
            $Reader->ChangeSheet($i);
            $number = 0;
            foreach ($Reader as $Row) {
                if ($number >= $startAt) {
                    $nombre = "";
                    if (isset($Row[0])) {
                        $nombre = $Row[0];
                    }

                    $descripcion = "";
                    if (isset($Row[0])) {
                        $descripcion = $Row[0];
                    }

                    $estado = "Activo";

                    $categoria = "";
                    if (isset($Row[1])) {
                        $categoria = $Row[1];
                    }

                    $marca = "";
                    if (isset($Row[2])) {
                        $marca = $Row[2];
                    }

                    $afecto = "";
                    if (isset($Row[3])) {
                        $afecto = $Row[3];
                    }

                    $lote = "";
                    if (isset($Row[4])) {
                        $lote = $Row[4];
                    }

                    $codigo = "";
                    if (isset($Row[5])) {
                        $codigo = $Row[5];
                    }

                    $stock_minimo = "";
                    if (isset($Row[6])) {
                        $stock_minimo = $Row[6];
                    }

                    $unidad = "";
                    if (isset($Row[7])) {
                        $unidad = $Row[7];
                    }

                    $cat_pre_cos = "";
                    if (isset($Row[8])) {
                        $cat_pre_cos = $Row[8];
                    }


                    $cat_pre_ven = "";
                    if (isset($Row[9])) {
                        $cat_pre_ven = $Row[9];
                    }

                    $stock_num = "";
                    if (isset($Row[10])) {
                        $stock_num = $Row[10];
                    }


                    if (!empty($nombre) && !empty($descripcion) && !empty($estado) && !empty($categoria) && !empty($marca) && !empty($afecto) && !empty($lote) && !empty($unidad) && !empty($cat_pre_cos) && !empty($cat_pre_ven) && !empty($stock_num)) {

                        $cts = $oCategoria->mostrar_filtro_nombre($categoria);
                        $ct_rows = mysql_num_rows($cts);
                        if ($ct_rows > 0) {
                            $ct = mysql_fetch_array($cts);
                            $cat_id = $ct['tb_categoria_id'];
                        } else {
                            $data['type'] = "error";
                            $data['message'] = "No existe categoría \"".$categoria."\"";
                            break;
                        }

                        $mrs = $oMarca->mostrar_filtro_nombre($marca);
                        $mr_rows = mysql_num_rows($mrs);
                        if ($mr_rows > 0) {
                            $mr = mysql_fetch_array($mrs);
                            $mar_id = $mr['tb_marca_id'];
                        } else {
                            $data['type'] = "error";
                            $data['message'] = "No existe marca \"".$marca."\"";
                            break;
                        }

                        if ($afecto == 'GRAVADO') {
                            $cmb_afec_id = 1;
                        } elseif ($afecto == 'EXONERADO') {
                            $cmb_afec_id = 9;
                        } elseif ($afecto == 'INAFECTO') {
                            $cmb_afec_id = 11;
                        } else {
                            $data['type'] = "error";
                            $data['message'] = "No existe tipo de afectación \"".$afecto."\"";
                            break;
                        }

                        if ($lote == 'SI') {
                            $lote_id = 1;
                        } elseif ($lote == 'NO') {
                            $lote_id = 0;
                        } else {
                            $data['type'] = "error";
                            $data['message'] = "No existe opcion para lote \"".$lote."\"";
                            break;
                        }

                        $uns = $oUnidad->mostrar_filtro_nombre($unidad);
                        $un_rows = mysql_num_rows($uns);
                        if ($un_rows > 0) {
                            $un = mysql_fetch_array($uns);
                            $un_id = $un['tb_unidad_id'];
                        } else {
                            $data['type'] = "error";
                            $data['message'] = "No existe unidad \"".$unidad."\"";
                            break;
                        }

                        if (is_numeric($cat_pre_cos)){
                            $cat_pre_cos = number_format((float)$cat_pre_cos, 2, '.', '');
                        }

                        if(!preg_match('/^\d+\.\d+$/',$cat_pre_cos)){
                            $data['type'] = "error";
                            $data['message'] = "Error en precio de costo \"".$cat_pre_cos."\"";
                            break;
                        }

                        if (is_numeric($cat_pre_ven)){
                            $cat_pre_ven = number_format((float)$cat_pre_ven, 2, '.', '');
                        }

                        if(!preg_match('/^\d+\.\d+$/',$cat_pre_ven)){
                            $data['type'] = "error";
                            $data['message'] = "Error en precio de venta \"".$cat_pre_ven."\"";
                            break;
                        }

                        if($cat_pre_cos > $cat_pre_ven) {
                            $data['type'] = "error";
                            $data['message'] = "Error, precio de venta (\"".$cat_pre_ven."\") debe ser menor al costo \"".$cat_pre_cos."\"";
                            break;
                        }

                        if(!preg_match('/^\d+$/',$stock_minimo)) {
                            $data['type'] = "error";
                            $data['message'] = "Error en stock minimo \"".$stock_minimo."\"";
                            break;
                        }

                        if(!preg_match('/^\d+$/',$stock_num)) {
                            $data['type'] = "error";
                            $data['message'] = "Error en stock \"".$stock_num."\"";
                            break;
                        }



                        $oProducto->insertar(
                            strip_tags(limpia_espacios($nombre)),
                            strip_tags(limpia_espacios($descripcion)),
                            $estado,
                            $cat_id,
                            $mar_id,
                            $cmb_afec_id,
                            $_SESSION['usuario_id'],
                            '',
                            $lote_id,
                            $_SESSION['empresa_id']
                        );



                        //id producto
                        $dts = $oProducto->ultimoInsert();
                        $dt = mysql_fetch_array($dts);
                        $pro_id = $dt['last_insert_id()'];
                        mysql_free_result($dts);


                        //insertamos presentacion
                        $oPresentacion->insertar(
                            strip_tags(limpia_espacios($nombre)),
                            strip_tags($codigo),
                            $stock_minimo,
                            $estado,
                            $pro_id
                        );

                        //id presentacion
                        $dts = $oPresentacion->ultimoInsert();
                        $dt = mysql_fetch_array($dts);
                        $pre_id = $dt['last_insert_id()'];
                        mysql_free_result($dts);

                        $mul = '1';
                        $unibas = '1';
                        $preunicom = 0;

                        $uti = 100 * ($cat_pre_ven / 1.18 - $cat_pre_cos) / ($cat_pre_cos);

                        $oCatalogoproducto->insertar(
                            $un_id,
                            $un_id,
                            $mul,
                            moneda_mysql(0),
                            moneda_mysql(0),
                            $preunicom,
                            moneda_mysql($cat_pre_cos),
                            $uti,
                            moneda_mysql($cat_pre_ven),
                            1,
                            1,
                            0,
                            0,
                            $estado,
                            $unibas,
                            $pre_id
                        );


                        //////Insertat Stock
                        $rs = $oCatalogoproducto->presentacion_unidad_base($pre_id);
                        $dt = mysql_fetch_array($rs);
                        $cat_id = $dt['tb_catalogo_id'];
                        mysql_free_result($rs);

                        $dts= $oNotalmacen->consultar_existencia_saldo_inicial($cat_id, $_SESSION['almacen_id']);
                        $dt = mysql_fetch_array($dts);
                        $notalm_id=$dt['tb_notalmacen_id'];
                        $notalmdet_id=$dt['tb_notalmacendetalle_id'];
                        mysql_free_result($dts);

                        if($notalm_id>0)
                        {
                            echo "Ya existe Dato.";
                        }
                        else
                        {
                            $oStock->insertar(
                                $_SESSION['almacen_id'],
                                $pre_id,
                                $stock_num
                            );

                            //Nota de Almacen
                            $doc_id=3;//nota de almacen

                            $dts= $oTalonariointerno->correlativo_tra($_SESSION['almacen_id'],$doc_id);
                            $dt = mysql_fetch_array($dts);

                            $tal_id=$dt['tb_talonario_id'];
                            $tal_ser=$dt['tb_talonario_ser'];
                            $tal_num=$dt['tb_talonario_num'];
                            $tal_fin=$dt['tb_talonario_fin'];
                            mysql_free_result($dts);
                            $numero=$tal_num+1;
                            $largo=strlen($tal_fin);
                            $correlativo=str_pad($numero,$largo, "0", STR_PAD_LEFT);
                            $serie=$tal_ser;

                            if($tal_ser!="")$numdoc=$serie.'-'.$correlativo;

                            //Registro del Stock Inicial en las Notas de Almacen
                            //1. Registro de Nota de Almacen
                            $fec=date('Y-m-d');
                            $tipo=1;
                            $doc_id=5;
                            $tipope_id=1;//saldo inicial
                            $des="STOCK INICIAL";
                            //insertamos nota almacen
                            $oNotalmacen->insertar(
                                $fec,
                                $tipo,
                                $doc_id,
                                $numdoc,
                                $tipope_id,
                                $des,
                                $_SESSION['almacen_id'],
                                $_SESSION['usuario_id'],
                                $_SESSION['empresa_id']
                            );

                            //2. ultimo nota de almacen
                            $rs_na =$oNotalmacen->ultimoInsert();
                            $dt_na = mysql_fetch_array($rs_na);
                            $notalm_id=$dt_na['last_insert_id()'];
                            mysql_free_result($rs_na);
                            //Fin Nota de Almacen

                            //actualizamos talonario de nota de almacen
                            $estado='ACTIVO';
                            if($tal_numero==$tal_fin)$tal_estado='INACTIVO';
                            $rs= $oTalonariointerno->actualizar_correlativo($tal_id,$numero,$estado);

                            //3. Consultar catalogo_Id
                            $rs = $oCatalogoproducto->presentacion_unidad_base($pre_id);
                            $dt = mysql_fetch_array($rs);
                            $cat_id = $dt['tb_catalogo_id'];
                            $precos = $dt['tb_catalogo_precos'];
                            $preuni = $dt['tb_catalogo_preunicom'];
                            mysql_free_result($rs);

                            //4. registro detalle de notalmacen
                            $oNotalmacen->insertar_detalle(
                                $cat_id,
                                $stock_num,
                                $precos,
                                $preuni,
                                $notalm_id
                            );
                            //Fin Registro del Stock Inicial en las Notas de Almacen

                            //KARDEX
                            //registro de kardex
                            $xac=1;
                            $tipo_registro=1;//1 automatico 2 manual
                            $kar_tip=$tipo;//1 entrada 2 salida
                            $tipope_id=9;//9 nota de almacen
                            $kar_des='NOTA DE ALMACEN - STOCK INICIAL';
                            $operacion_id=$notalm_id;//id de la operacion(modulo compras, ventas, etc)
                            $emp_id=$_SESSION['empresa_id'];



                            //insertamos kardex
                            $oKardex->insertar(
                                $xac,
                                $tipo_registro,
                                $cod,
                                $fec,
                                $kar_tip,
                                $doc_id,
                                $numdoc,
                                $tipope_id,
                                $kar_des,
                                $operacion_id,
                                $_SESSION['almacen_id'],
                                $_SESSION['usuario_id'],
                                $_SESSION['empresa_id']
                            );
                            //ultimo kardex
                            $dts=$oKardex->ultimoInsert();
                            $dt = mysql_fetch_array($dts);
                            $kar_id=$dt['last_insert_id()'];
                            mysql_free_result($dts);

                            $oKardex->modificar_codigo($kar_id,$kar_id);

                            //registro detalle de kardex
                            $oKardex->insertar_detalle(
                                $cat_id,
                                $stock_num,
                                $precos,
                                $preuni,
                                $kar_id
                            );

                            //actualizar stock si es necesario con el kardex
                            $fecini='01-01-2015';
                            $fecfin=date('d-m-Y');
                            $stock=stock_kardex($cat_id,$_SESSION['almacen_id'],fecha_mysql($fecini),fecha_mysql($fecfin),$_SESSION['empresa_id']);

                            $dts=$oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id,$_SESSION['almacen_id']);
                            $dt = mysql_fetch_array($dts);
                            $pre_id		=$dt['tb_presentacion_id'];
                            $sto_id		=$dt['tb_stock_id'];
                            $sto_num	=$dt['tb_stock_num'];
                            $mul		=$dt['tb_catalogo_mul'];
                            mysql_free_result($dts);

                            $oStock->modificar(
                                $sto_id,
                                $stock
                            );

                        }

                        $data['type'] = "success";
                        $data['message'] = "Excel importado correctamente";
                    }
                }
                $number++;
            }
        }
    } else {
        $data['type'] = "error";
        $data['message'] = "El archivo enviado es invalido. Por favor vuelva a intentarlo";
    }
    echo json_encode($data);
}
?>