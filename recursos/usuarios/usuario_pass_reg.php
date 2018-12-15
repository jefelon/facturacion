<?php
require_once ("../../config/Cado.php");
require_once("cUsuario.php");
$oUsuario = new cUsuario();

if(!empty($_POST['hdd_usu_id'])){		
	if($_POST['txt_usu_newpas'] == $_POST['txt_usu_newpasrep']){
        if($_POST['txt_usu_pas']){
            $result = $oUsuario->verificaClave($_POST['hdd_usu_id'], $_POST['txt_usu_pas']);
            $fila = mysql_fetch_array($result);
            if($fila[1] != ""){
                $oUsuario->modificar_clave($_POST['hdd_usu_id'], $_POST['txt_usu_newpas']);
                echo 'Se cambió contraseña correctamente.';
            }else{
                echo 'No se pudo modificar. Contraseña anterior incorrecta!.';
            }
        }else{
            $oUsuario->modificar_clave($_POST['hdd_usu_id'], $_POST['txt_usu_newpas']);
            echo 'Se cambió contraseña correctamente.';
        }
	}else{
		echo 'Las contraseñas ingresadas no coinciden.';	
	}
}	
?>