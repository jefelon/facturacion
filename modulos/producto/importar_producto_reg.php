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
require_once("../formatos/formato.php");

require_once("../unidad/cUnidad.php");
$oUnidad = new cUnidad();


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

                    $stock = "";
                    if (isset($Row[10])) {
                        $stock = $Row[10];
                    }


                    if (!empty($nombre) && !empty($descripcion) && !empty($estado) && !empty($categoria) && !empty($marca) && !empty($afecto) && !empty($lote) && !empty($unidad) && !empty($cat_pre_cos) && !empty($cat_pre_ven) && !empty($stock)) {

                        $cts = $oCategoria->mostrar_filtro_nombre($categoria);
                        $ct_rows = mysql_num_rows($cts);
                        if ($ct_rows > 0) {
                            $ct = mysql_fetch_array($cts);
                            $cat_id = $ct['tb_categoria_id'];
                        } else {
                            $data['type'] = "error";
                            $data['message'] = "No existe categoría";
                            break;
                        }

                        $mrs = $oMarca->mostrar_filtro_nombre($marca);
                        $mr_rows = mysql_num_rows($cts);
                        if ($mr_rows > 0) {
                            $mr = mysql_fetch_array($cts);
                            $mar_id = $ct['tb_categoria_id'];
                        } else {
                            $data['type'] = "error";
                            $data['message'] = "No existe marca";
                            break;
                        }

                        if ($afecto = 'GRAVADO') {
                            $cmb_afec_id = 1;
                        } elseif ($afecto = 'EXONERADO') {
                            $cmb_afec_id = 9;
                        } elseif ($afecto = 'INAFECTO') {
                            $cmb_afec_id = 11;
                        } else {
                            $data['type'] = "error";
                            $data['message'] = "No existe tipo de afectación";
                            break;
                        }

                        if ($lote = 'SI') {
                            $lote_id = 1;
                        } elseif ($lote = 'NO') {
                            $lote_id = 0;
                        } else {
                            $data['type'] = "error";
                            $data['message'] = "No existe opcion para lote";
                            break;
                        }

                        $uns = $oUnidad->mostrar_filtro_nombre($unidad);
                        $un_rows = mysql_num_rows($uns);
                        if ($un_rows > 0) {
                            $un = mysql_fetch_array($uns);
                            $un_id = $un['tb_unidad_id'];
                        } else {
                            $data['type'] = "error";
                            $data['message'] = "No existe unidad";
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


                        $cat_pre_ven = $cat_pre_ven / 1.18;
                        $uti = 100 * ($cat_pre_ven - $cat_pre_cos) / ($cat_pre_cos);

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