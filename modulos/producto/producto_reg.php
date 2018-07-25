<?php
session_start();
require_once("../../config/Cado.php");
require_once("cProducto.php");
$oProducto = new cProducto();
require_once("cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("cTag.php");
$oTag = new cTag();
require_once("../formatos/formato.php");

if($_POST['action_producto']=="insertar")
{
	if(!empty($_POST['txt_pro_nom']))
	{
		//insertamos producto
		$oProducto->insertar(
			strip_tags(limpia_espacios($_POST['txt_pro_nom'])),
            strip_tags(limpia_espacios($_POST['txt_pro_des'])),
			$_POST['cmb_pro_est'],
			$_POST['cmb_cat_id'],
			$_POST['cmb_mar_id'],
            $_POST['cmb_afec_id'],
			$_POST['hdd_usu_id'],
            $_POST['hdd_prod_img']
		);

        if (!file_exists('img_products')) {
            mkdir('img_products', 0777);
        }

        move_uploaded_file($_FILES['file']['tmp_name'], 'img_products/' . $_POST['hdd_pro_id'] . '_'. $_FILES['file']['name'] );
		
		//id producto
			$dts=$oProducto->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$pro_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		//insertamos presentacion
		$oPresentacion->insertar(
			strip_tags(limpia_espacios($_POST['txt_pre_nom'])),
            strip_tags($_POST['txt_pre_cod']),
			$_POST['txt_pre_stomin'],
			$_POST['cmb_pre_est'],
			$pro_id
		);
		
		//id presentacion
			$dts=$oPresentacion->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$pre_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		//insertamos atributos
		if(isset($_SESSION['atributo_car']))
		{
			foreach($_SESSION['atributo_car'] as $indice=>$valor){
				$oTag->insertar(
					$pre_id,
					$valor
				);
			}
			unset($_SESSION['atributo_car']);
		}
		//insertamos catalogo
		$mul='1';
		$unibas='1';		
		$est='Activo';
		$preunicom=0;

		$oCatalogoproducto->insertar(
			$_POST['cmb_cat_uni_bas'],
			$_POST['cmb_cat_uni_bas'],
			$mul,
			moneda_mysql($_POST['txt_cat_tipcam']),
			moneda_mysql($_POST['txt_cat_precosdol']),
			$preunicom,
			moneda_mysql($_POST['txt_cat_precos']),
			$_POST['txt_cat_uti'],
			moneda_mysql($_POST['txt_cat_preven']),
			$_POST['chk_cat_vercom'],
			$_POST['chk_cat_verven'],
			$_POST['chk_cat_igvcom'],
			$_POST['chk_cat_igvven'],
			$est,
			$unibas,
			$pre_id
		);

		$data['pro_id']=$pro_id;
        $data['pre_id']=$pre_id;
        $data['tipo_accion']=$_POST['tipo_accion'];
		if($_POST['editar_presentacion']==1)$data['pro_act']='editar_presentacion';
		$data['pro_msj']='Se registró producto correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_producto']=="editar")
{
	if(!empty($_POST['txt_pro_nom']))
	{
		$oProducto->modificar(
			$_POST['hdd_pro_id'],
			limpia_espacios($_POST['txt_pro_nom']),
			limpia_espacios($_POST['txt_pro_des']),
			$_POST['cmb_pro_est'],
			$_POST['cmb_cat_id'],
			$_POST['cmb_mar_id'],
            $_POST['cmb_afec_id'],
			$_POST['hdd_usu_id'],
            $_POST['hdd_prod_img']
		);

        if (!file_exists('img_products')) {
            mkdir('img_products', 0777);
        }

        move_uploaded_file($_FILES['file']['tmp_name'], 'img_products/' . $_POST['hdd_pro_id'] . '_'. $_FILES['file']['name'] );

		$data['pro_msj']='Se registró producto correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['pro_id']))
	{
//		$cst1 = $oProducto->verifica_producto_tabla($_POST['pro_id'],'tb_presentacion');
        $prs = $oPresentacion->mostrar_por_producto($_POST['pro_id']);
        $pr = mysql_fetch_array($prs);
        $ctgs = $oCatalogoproducto->mostrar_unidad_de_presentacion($pr['tb_presentacion_id']);
        $ctg = mysql_fetch_array($ctgs);

        $msj1 ='';
        $nro_tbs_afect=0;
        $tbs_rels_cat=$oCatalogoproducto->tablas_relacionadas_catalogo();
        while($tb_rel_cat = mysql_fetch_array($tbs_rels_cat)) {
            echo 'ctg';
            echo $ctg['tb_catalogo_id'];
//            $ve_cat_tbs=$oCatalogoproducto->verifica_catalogo_tabla($ctg['tb_catalogo_id'],$tb_rel_cat['TableName']);
//            $ve_cat_tb1 = mysql_num_rows($ve_cat_tbs);
            $ve_cat_tb1=8;
            if($ve_cat_tb1>0) {
                $nro_tbs_afect++;
                $msj1 = $msj1 .'-'.mysql_fetch_array($tb_rel_cat['TableName']);
            }
        }

		
		if($nro_tbs_afect>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oProducto->eliminar($_POST['pro_id']);
			echo 'Se eliminó producto correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>