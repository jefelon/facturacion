<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cPresentacion.php");
$oPresentacion = new cPresentacion();
require_once("cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();
require_once("cTag.php");
$oTag = new cTag();
require_once("cStock.php");
$oStock = new cStock();
require_once("../formatos/formato.php");

if($_POST['action_presentacion']=="insertar"){
	if(!empty($_POST['txt_pre_nom']))
	{
		$oPresentacion->insertar(
			strip_tags(limpia_espacios($_POST['txt_pre_nom'])),
            strip_tags($_POST['txt_pre_cod']),
			$_POST['txt_pre_stomin'],
			$_POST['cmb_pre_est'],
			$_POST['hdd_pre_pro_id']
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
		
		echo 'Se registró presentación correctamente.';
	}
	else{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_presentacion']=="editar")
{
	if(!empty($_POST['txt_pre_nom']))
	{
		$oPresentacion->modificar(
			$_POST['hdd_pre_id'],
			strip_tags(limpia_espacios($_POST['txt_pre_nom'])),
            strip_tags($_POST['txt_pre_cod']),
			$_POST['txt_pre_stomin'],
			$_POST['cmb_pre_est'],
            $_POST['txt_pre_codigemid']
		);
		
		echo 'Se registró presentación correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['id']))
	{
		$cst11 = $oPresentacion->verifica_presentacion_tabla($_POST['id'],'tb_catalogo');
		$rst11= mysql_num_rows($cst11);
		
		if($rst11==1)
		{
			$dts = $oPresentacion->verifica_presentacion_tabla($_POST['id'],'tb_catalogo');
			$dt = mysql_fetch_array($dts);
			$cat_id	=$dt['tb_catalogo_id'];
			mysql_free_result($dts);
			
			if(!empty($cat_id))
			{
				$cst1 = $oCatalogoproducto->verifica_catalogo_tabla($cat_id,'tb_compradetalle');
				$rst1= mysql_num_rows($cst1);
				if($rst1>0)$msj1=' - Compras';
				
				$cst2 = $oCatalogoproducto->verifica_catalogo_tabla($cat_id,'tb_ventadetalle');
				$rst2= mysql_num_rows($cst2);
				if($rst2>0)$msj2=' - Ventas';
				
				$cst3 = $oCatalogoproducto->verifica_catalogo_tabla($cat_id,'tb_traspasodetalle');
				$rst3= mysql_num_rows($cst3);
				if($rst3>0)$ms3=' - Transferencias';
				
				if($rst1>0 or $rst2>0 or $rst3>0)
				{
					echo "No se puede eliminar, afecta información de: ".$msj1.$msj2.$msj3.".";
				}
				else
				{
					$oPresentacion->eliminar($_POST['id']);
					$oCatalogoproducto->eliminar($cat_id);
					$oStock->eliminar($_POST['id']);
					$oTag->eliminar_por_presentacion($_POST['id']);
					echo 'Se eliminó presentación correctamente.';
				}
			}
			else
			{
				echo 'Intentelo nuevamente.';
			}

		}
		if($rst11>1)
		{
			echo "No se puede eliminar, afecta informacion de Unidad Alternativa.";
		}
		if($rst11<1)
		{
			$oPresentacion->eliminar($_POST['id']);
			$oStock->eliminar($_POST['id']);
			$oTag->eliminar($_POST['id']);
			echo 'Se eliminó presentación correctamente.';
		}
		/*else
		{
			$oPresentacion->eliminar($_POST['id']);
			echo 'Se eliminó presentación correctamente.';
		}*/
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>