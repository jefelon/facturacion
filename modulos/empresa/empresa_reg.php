<?php
require_once ("../../config/Cado.php");
require_once("cEmpresa.php");
$oEmpresa = new cEmpresa();

if($_POST['action']=="insertar")
{
	if(!empty($_POST['txt_emp_nomcom']))
	{
		$oEmpresa->insertar($_POST['txt_emp_ruc'], strip_tags($_POST['txt_emp_nomcom']), strip_tags($_POST['txt_emp_razsoc']), strip_tags($_POST['txt_emp_dir']), strip_tags($_POST['txt_emp_dir2']), $_POST['txt_emp_tel'], $_POST['txt_emp_ema'], strip_tags($_POST['txt_emp_rep']), $_POST['txt_emp_fir'], $_POST['txt_emp_logo'],$_POST['cmb_regimen_id']);
        if (!file_exists('logos')) {
            mkdir('logos', 0777);
        }

        move_uploaded_file($_FILES['file']['tmp_name'], 'logos/' . $_POST['hdd_emp_id'] . '_'. $_FILES['file']['name'] );
        echo 'Se registró empresa correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="editar")
{
	if(!empty($_POST['txt_emp_nomcom']))
	{
		$oEmpresa->modificar($_POST['hdd_emp_id'], $_POST['txt_emp_ruc'], strip_tags($_POST['txt_emp_nomcom']), strip_tags($_POST['txt_emp_razsoc']), strip_tags($_POST['txt_emp_dir']), strip_tags($_POST['txt_emp_dir2']), $_POST['txt_emp_tel'], $_POST['txt_emp_ema'], strip_tags($_POST['txt_emp_rep']), $_POST['txt_emp_fir'], $_POST['txt_emp_logo'],$_POST['cmb_regimen_id']);
		if (!file_exists('logos')) {
            mkdir('logos', 0777);
        }

        move_uploaded_file($_FILES['file']['tmp_name'], 'logos/' . $_POST['hdd_emp_id'] . '_'. $_FILES['file']['name'] );
		echo 'Se registró empresa correctamente.';
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
		//$oEmpresa->eliminar($_POST['id']);
		//echo 'Se eliminó correctamente.';
		echo 'No es posible eliminar. Consulte a su proveedor del sistema.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>