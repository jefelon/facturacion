<?php
require_once ("../../config/Cado.php");
require_once("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("../formatos/formato.php");

if($_POST['action_catalogo']=="insertar"){
	if(!empty($_POST['cmb_cat_uni_alt']))
	{
		$preunicom=0;
		
		$oCatalogoproducto->insertar(
			$_POST['hdd_cat_uni_bas'],
			$_POST['cmb_cat_uni_alt'],
			$_POST['txt_cat_mul'],
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
			$_POST['cmb_cat_est'],
			$unibas,
			$_POST['hdd_cat_pre_id']
		);

		echo 'Se registró correctamente.';
	}
	else{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_catalogo']=="editar")
{
	if(!empty($_POST['hdd_cat_uni_bas']))
	{
		if($_POST['hdd_cat_unibas']==1)
		{
			$mul=1;
			$oCatalogoproducto->modificar(
				$_POST['hdd_cat_id'],
				$_POST['cmb_cat_uni_id_bas'],
				$_POST['cmb_cat_uni_id_bas'],
				$mul,
				moneda_mysql($_POST['txt_cat_tipcam']),
				moneda_mysql($_POST['txt_cat_precosdol']),
				moneda_mysql($_POST['txt_cat_precos']),
				$_POST['txt_cat_uti'],
				moneda_mysql($_POST['txt_cat_preven']),
				$_POST['chk_cat_vercom'],
				$_POST['chk_cat_verven'],
				$_POST['chk_cat_igvcom'],
				$_POST['chk_cat_igvven'],
				$_POST['cmb_cat_est'],
				$_POST['hdd_cat_unibas']
			);
			echo 'Se registró Unidad Base correctamente.';
		}
		else{
			$oCatalogoproducto->modificar(
				$_POST['hdd_cat_id'],
				$_POST['hdd_cat_uni_bas'],
				$_POST['cmb_cat_uni_alt'],
				$_POST['txt_cat_mul'],
				moneda_mysql($_POST['txt_cat_tipcam']),
				moneda_mysql($_POST['txt_cat_precosdol']),
				moneda_mysql($_POST['txt_cat_precos']),
				$_POST['txt_cat_uti'],
				moneda_mysql($_POST['txt_cat_preven']),
				$_POST['chk_cat_vercom'],
				$_POST['chk_cat_verven'],
				$_POST['chk_cat_igvcom'],
				$_POST['chk_cat_igvven'],
				$_POST['cmb_cat_est'],
				$_POST['hdd_cat_unibas']
			);
			echo 'Se registró Unidad Alternativa correctamente.';
		}
		
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['cat_id']))
	{
		$cst1 = $oCatalogoproducto->verifica_catalogo_tabla($_POST['cat_id'],'tb_compradetalle');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Compras';
		
		$cst2 = $oCatalogoproducto->verifica_catalogo_tabla($_POST['cat_id'],'tb_ventadetalle');
		$rst2= mysql_num_rows($cst2);
		if($rst2>0)$msj2=' - Ventas';
		
		$cst3 = $oCatalogoproducto->verifica_catalogo_tabla($_POST['cat_id'],'tb_traspasodetalle');
		$rst3= mysql_num_rows($cst3);
		if($rst3>0)$ms3=' - Transferencias';
		
		if($rst1>0 or $rst2>0 or $rst3>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.$msj2.$msj3.".";
		}
		else
		{
			$oCatalogoproducto->eliminar($_POST['cat_id']);
			echo 'Se eliminó correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>