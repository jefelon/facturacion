<?php
//redirec p�gina principal
function ir_principal($usergrupo_id)
{

    switch ($usergrupo_id) {
        case 1:
            $url = '../super/';
            break;
        case 2:
            //$url='../administrador/';
            $url = '../administrador/administrador_validar.php';
            break;
        case 3:
            $url = '../vendedor/vendedor_validar.php';
            break;
        case 4:
            $url = '../ejecutor/';
            break;
        case 5:
            $url = '../almacenador/almacenador_validar.php';
            break;
        /*default:
               $url='inicioEjec.php';*/
    }

    return $url;
}

?>