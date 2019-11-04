<?php
require_once ("../../config/Cado.php");
require_once("cEmpresa.php");
$oEmpresa = new cEmpresa();

if($_POST['action']=="insertar")
{
	if(!empty($_POST['txt_emp_razsoc']))
	{
		$oEmpresa->insertar(
		    $_POST['txt_emp_ruc'],
            strip_tags($_POST['txt_emp_nomcom']),
            strip_tags($_POST['txt_emp_razsoc']),
            strip_tags($_POST['txt_emp_dir']),
            strip_tags($_POST['txt_emp_dir2']),
            $_POST['txt_emp_tel'],
            $_POST['txt_emp_ema'],
            strip_tags($_POST['txt_emp_rep']),
            $_POST['txt_emp_logo'],
            $_POST['cmb_regimen_id'],
            $_POST['txt_cel'],
            $_POST['txt_cer'],
            $_POST['txt_clacer'],
            $_POST['txt_ususun'],
            $_POST['txt_clasun'],
            $_POST['txt_iddis'],
            $_POST['txt_sub'],
            $_POST['txt_dep'],
            $_POST['txt_pro'],
            $_POST['txt_dis'],
            $_POST['tb_webser'],
            $_POST['txt_texto_impresion']
        );
        if (!file_exists('logos')) {
            mkdir('logos', 0777);
        }

        $imgh = icreate($_FILES['file']['tmp_name']);
        $imgr = resizeMax($imgh, 180, 130);

        header('Content-type: image/jpeg');
        imagejpeg($imgr,'logos/' . $_POST['hdd_emp_id'] . '_'. $_FILES['file']['name']);

        echo 'Se registró empresa correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

/**
 * Opens new image
 *
 * @param $filename
 */
function icreate($filename)
{
    $isize = getimagesize($filename);
    if ($isize['mime']=='image/jpeg')
        return imagecreatefromjpeg($filename);
    elseif ($isize['mime']=='image/png')
//        $imagen = imagecreatefrompng($filename);
//        return imagecreatefromjpeg($imagen);

    $image = imagecreatefrompng($filename);
    $bg = imagecreatetruecolor(imagesx($image), imagesy($image)); imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
    imagealphablending($bg, TRUE);

   imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
    //imagedestroy($image);
    //$quality = 50;
    // 0 = worst / smaller file, 100 = better / bigger file imagejpeg($bg, $filePath . ".jpg", $quality); imagedestroy($bg);

    return $bg;
}

/**
 * Resize image maintaining aspect ratio, occuping
 * as much as possible with width and height inside
 * params.
 *
 * @param $image
 * @param $width
 * @param $height
 */
function resizeMax($image, $width, $height)
{
    /* Original dimensions */
    $origw = imagesx($image);
    $origh = imagesy($image);

    $ratiow = $width / $origw;
    $ratioh = $height / $origh;
    $ratio = min($ratioh, $ratiow);

    $neww = $origw * $ratio;
    $newh = $origh * $ratio;

    $new = imageCreateTrueColor($neww, $newh);

    imagecopyresampled($new, $image, 0, 0, 0, 0, $neww, $newh, $origw, $origh);
    return $new;
}


if($_POST['action']=="editar")
{
	if(!empty($_POST['txt_emp_razsoc']))
	{
		$oEmpresa->modificar(
		    $_POST['hdd_emp_id'],
            $_POST['txt_emp_ruc'],
            strip_tags($_POST['txt_emp_nomcom']),
            strip_tags($_POST['txt_emp_razsoc']),
            strip_tags($_POST['txt_emp_dir']),
            strip_tags($_POST['txt_emp_dir2']),
            $_POST['txt_emp_tel'],
            $_POST['txt_emp_ema'],
            strip_tags($_POST['txt_emp_rep']),
            $_POST['txt_emp_logo'],
            $_POST['cmb_regimen_id'],
            $_POST['txt_cel'],
            $_POST['txt_cer'],
            $_POST['txt_clacer'],
            $_POST['txt_ususun'],
            $_POST['txt_clasun'],
            $_POST['txt_iddis'],
            $_POST['txt_sub'],
            $_POST['txt_dep'],
            $_POST['txt_pro'],
            $_POST['txt_dis'],
            $_POST['txt_webser'],
            $_POST['txt_texto_impresion']
        );
		if (!file_exists('logos')) {
            mkdir('logos', 0777);
        }

        $imgh = icreate($_FILES['file']['tmp_name']);
        $imgr = resizeMax($imgh, 180, 130);

        header('Content-type: image/jpeg');
        imagejpeg($imgr,'logos/' . $_POST['hdd_emp_id'] . '_'. $_FILES['file']['name']);

        if($_FILES['file_cer']['tmp_name']){
            move_uploaded_file($_FILES['file_cer']['tmp_name'],'../../cpegeneracion/sunat/certificado/'. $_POST['hdd_emp_id'].'_'.$_FILES['file_cer']['name']);
        }


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