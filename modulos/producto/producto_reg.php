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
require_once("cProductoproveedor.php");
$oProductoproveedor = new cProductoproveedor();
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
            $_POST['hdd_prod_img'],
            $_POST['cmb_lote']
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


        $provedores = $_POST['proveedor'];
        $cont=0;
        foreach ($provedores as $proveedor) {
            $oProductoproveedor->insertar_producto_proveedor($pro_id, $_POST['hdd_com_prov_id'][$cont],  moneda_mysql($_POST['catmin'][$cont]),  moneda_mysql($_POST['desc'][$cont]), fecha_mysql($_POST['desde'][$cont]), fecha_mysql($_POST['hasta'][$cont]));
            $cont++;
        }

		//insertamos presentacion
		$oPresentacion->insertar(
            strip_tags(limpia_espacios($_POST['txt_pro_nom'])),
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
            $_POST['hdd_prod_img'],
            $_POST['cmb_lote']

		);
        $oPresentacion->modificar2(
            $_POST['hdd_pro_id'],
            limpia_espacios($_POST['txt_pro_nom'])
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
		$cst1 = $oProducto->verifica_producto_tabla($_POST['pro_id'],'tb_presentacion');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' Presentación de producto';
		
		if($rst1>0)
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