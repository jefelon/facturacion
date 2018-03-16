<?php
//redirec p�gina principal
function ir_principal($usergrupo_id){

	switch ($usergrupo_id) {
    case 1:
        $url='../super/';
        break;
	case 2:
        //$url='../puntoventa/';
		$url='../puntoventa/puntoventa_seleccionar.php';
        break;
  case 3:
        $url='../vendedor/vendedor_validar.php';
        break;
	case 4:
        $url='../ejecutor/';
        break;
	/*default:
       	$url='inicioEjec.php';*/
	}
	
	return $url;
}	
?>