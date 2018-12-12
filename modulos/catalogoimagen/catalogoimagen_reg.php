<?php
require_once ("../../config/Cado.php");
require_once("cCatalogoimagen.php");
$oCatalogoimg = new cCatalogoimagen();


// Acciones para la tabla tb_catalogoimagen
if ($_POST['action_catalogoimagen']=="insertar") {

	if (!empty($_POST['txt_catimg_tit'])) 
	{		
		$oCatalogoimg->insertar(
            strip_tags($_POST['txt_catimg_tit']),
            strip_tags($_POST['txt_catimg_des'])
		);

			//ultimo insert
			$dts=$oCatalogoimg->ultimoInsert();
			$dt = mysql_fetch_array($dts);
			$catimg_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

			$data['catimg_id']=$catimg_id;
		
		$data['catimg_msj']='Se registró correctamente.';
		echo json_encode($data);

	}
	else
	{		
		$data['catimg_msj']='Intentelo nuevamente.';
		echo json_encode($data);
	}
	
}

// if ($_POST['action_catalogoimagen']=="editar") {

// 	if (!empty($_POST['txt_catimg_tit'])) 
// 	{		
// 		$oCatalogoimg->modificar_catalogoimg(		
// 			$_POST['hdd_catimg_id'],
// 			$_POST['txt_catimg_tit'],
// 			$_POST['txt_catimg_des']
// 			);			
		
// 		$data['catimg_msj']='Se modificó Catalogo Imagen correctamente.';
// 		echo json_encode($data);

// 	}
// 	else
// 	{		
// 		$data['catimg_msj']='Intentelo nuevamente.';
// 		echo json_encode($data);
// 	}
	
// }



if ($_POST['action']=="eliminar") {

	if (!empty($_POST['id'])) 
	{		
		$oCatalogoimg->eliminar($_POST['id']);			
		echo "Se eliminó correctamente.";
	}
	else
	{		
		echo "Intentelo nuevamente.";
	}
	
}


// Acciones para la tabla tb_catalogoimagendetalle

if ($_POST['action_det']=="eliminar") {

	if (!empty($_POST['id'])) 
	{		
		$oCatalogoimg->eliminar_det($_POST['id']);			
		echo "Se eliminó Catalogo Imagen detalle correctamente.";
	}
	else
	{		
		echo "Intentelo nuevamente.";
	}
	
}

?>