<?php
require_once ("../../config/Cado.php");
require_once("../tipocambio/cTipoCambio.php");
$oTipoCambio = new cTipoCambio();
require_once("../formatos/formato.php");

if($_POST['action_tipocambio']=="insertar")
{
	if(!empty($_POST['action_tipocambio']))
	{
//		//verificar si existe registro
//		$fechas = $_POST['txt_tipcam_dolsunfecha'];
//        $contador=0;
//        foreach ($fechas as $fecha) {
//		$rs = $oTipoCambio->consultar(fecha_mysql($fecha));
//
//            if(mysql_num_rows($rs)==0)
//            {
                $tipos_fechas_cambio_sunat = $_POST['txt_tipcam_dolsunfecha'];
                $cont=0;
                $mensaje="";
                foreach ($tipos_fechas_cambio_sunat as $tipos_fecha_cambio_sunat) {
                    $rs = $oTipoCambio->consultar(fecha_mysql($tipos_fecha_cambio_sunat));//verificar si existe registro
                    if (mysql_num_rows($rs) == 0){
                        $oTipoCambio->insertar(fecha_mysql($_POST['txt_tipcam_dolsunfecha'][$cont]), $_POST['txt_tipcam_dolsunv'][$cont], $_POST['txt_tipcam_dolsunc'][$cont]);
                    }
                    else
                    {
                        $mensaje='Existía registro de fechas: '.$_POST['txt_tipcam_fec'].'. Solo se inserto faltantes...';
                    }
                    $cont++;

                }
                $data['tipcam_msj']='Se registró tipo de cambio correctamente. '.$mensaje;

                    $dts=$oTipoCambio->ultimoInsert();
                    $dt = mysql_fetch_array($dts);
                $tipcam_id=$dt['last_insert_id()'];
                    mysql_free_result($dts);

                $data['tipcam_id']=$tipcam_id;


//            }
//            else
//            {
//                $data['tipcam_msj']='Existe registro de fecha: '.$_POST['txt_tipcam_fec'].'.';
//            }
//
//            $contador++;
//        }

		
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_tipocambio']=="editar")
{
	if(!empty($_POST['hdd_tipcam_id']))
	{
        $tiposcambio_sunat = $_POST['action_tipocambio'];
        $cont=0;
        foreach ($tiposcambio_sunat as $tipocambio_sunat) {
            $oTipoCambio->modificar($_POST['hdd_tipcam_id'], $_POST['txt_tipcam_dolsunv'][$cont],  $_POST['txt_tipcam_dolsunc'][$cont]);
            $cont++;
        }
		
		$data['tipcam_msj']='Se registró tipo de cambio correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['tipcam_id']))
	{
		
		$oTipoCambio->eliminar($_POST['tipcam_id']);
		echo 'Se eliminó tipocambio correctamente.';
		
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

//Consultar si existen al menos un tipo de cambio registrado el día de hoy
if($_POST['action']=="consultar"){	
	$fechahoy = date('d-m-Y');
	$fechahoy = fecha_mysql($fechahoy);	
		$rs = $oTipoCambio->consultar($fechahoy);
		$dt = mysql_fetch_array($rs);
	$num_tipocambiov = $dt['tb_tipocambio_dolsunv'];
		mysql_free_result($rs);
	echo $num_tipocambiov;
}

if($_POST['action']=="obtener_dato"){
	//soles
	if($_POST['moneda']=='1')
	{
		$tipocambiov=formato_money(1.00);
	}
	//dolares
	if($_POST['moneda']=='2')
	{
		$fecha_buscar=fecha_mysql($_POST['fecha']);
		//$fechahoy = date('d-m-Y');
		//$fechahoy = fecha_mysql($fechahoy);	
		$rs = $oTipoCambio->consultar($fecha_buscar);
		$dt = mysql_fetch_array($rs);
		$tipocambiov = number_format($dt['tb_tipocambio_dolsunv'], 3);
		if($tipocambiov=='0.000')$tipocambiov = "";
		mysql_free_result($rs);
		//$tipocambiov=formato_money(3.00);
	}
	$data['tipcam']=$tipocambiov;
	echo json_encode($data);
}	
?>