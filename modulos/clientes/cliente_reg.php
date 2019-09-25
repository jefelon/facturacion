<?php
require_once ("../../config/Cado.php");
require_once("../clientes/cCliente.php");
$oCliente = new cCliente();
require_once("../formatos/formato.php");

if($_POST['action_cliente']=="insertar")
{
	if(!empty($_POST['txt_cli_doc']))
	{
		$cst1 = $oCliente->verifica_cliente_doc($_POST['txt_cli_doc'],0);
		$rst1= mysql_num_rows($cst1);

        if($rst1>0)
        {
            $dt = mysql_fetch_array($cst1);
            $cli_id=$dt['tb_cliente_id'];
            mysql_free_result($cst1);

            $cst2 = $oCliente->verifica_cliente_nombre($_POST['txt_cli_doc'],0);
            $dt = mysql_fetch_array($cst2);
            $cli_nom=$dt['tb_cliente_nom'];
            if($cli_nom=="")// cliente con nombre vacio
            {
                $oCliente->actualizar_nombre(
                    $cli_id,
                    strip_tags(limpia_espacios($_POST['txt_cli_nom'])));
            }

            $data['cli_id']=$cli_id;

            $data['cli_msj']='Existe cliente con el mismo número de documento '.$_POST['txt_cli_doc'].'.';
        }
		else
		{
			$oCliente->insertar(
				$_POST['rad_cli_tip'],
                addslashes(strip_tags(limpia_espacios($_POST['txt_cli_nom']))),
				$_POST['txt_cli_doc'],
                strip_tags($_POST['txt_cli_dir']),
                strip_tags(limpia_espacios($_POST['txt_cli_con'])),
				$_POST['txt_cli_tel'], 
				$_POST['txt_cli_ema'],
				$_POST['txt_cli_est'],
                $_SESSION['empresa_id'],
                $_POST['cmb_precio_id'],
                $_POST['cmb_cli_retiene'],
                $_POST['txt_cli_cui']
				);
			
				$dts=$oCliente->ultimoInsert();
				$dt = mysql_fetch_array($dts);
			$cli_id=$dt['last_insert_id()'];
				mysql_free_result($dts);
			
			$data['cli_id']=$cli_id;
			$data['cli_msj']='Se registró cliente correctamente.';
		}
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_cliente']=="editar")
{
	if(!empty($_POST['txt_cli_doc']))
	{
		$cst1 = $oCliente->verifica_cliente_doc($_POST['txt_cli_doc'],$_POST['hdd_cli_id']);
		$rst1= mysql_num_rows($cst1);
		
		if($rst1>0)
		{
			$dt = mysql_fetch_array($cst1);
			$cli_id=$dt['tb_cliente_id'];
			mysql_free_result($cst1);
			
			$data['cli_id']=$cli_id;
			$data['cli_msj']='Existe cliente con el mismo número de documento '.$_POST['txt_cli_doc'].'.';
		}
		else
		{
			$oCliente->modificar(
				$_POST['hdd_cli_id'], 
				$_POST['rad_cli_tip'],
                strip_tags(limpia_espacios($_POST['txt_cli_nom'])),
				$_POST['txt_cli_doc'],
                strip_tags($_POST['txt_cli_dir']),
                strip_tags(limpia_espacios($_POST['txt_cli_con'])),
				$_POST['txt_cli_tel'], 
				$_POST['txt_cli_ema'],
				$_POST['txt_cli_est'],
                $_SESSION['empresa_id'],
                $_POST['cmb_precio_id'],
                $_POST['cmb_cli_retiene'],
                $_POST['txt_cli_cui']


				);
			
			$data['cli_msj']='Se registró cliente correctamente.';
			$data['cli_id']=$_POST['hdd_cli_id'];
		}
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_cliente']=="editarSunat")
{
	if(!empty($_POST['txt_cli_doc']))
	{
		$cst1 = $oCliente->verifica_cliente_doc($_POST['txt_cli_doc'],$_POST['hdd_cli_id']);
		$rst1= mysql_num_rows($cst1);
		
		if($rst1>0)
		{
			$dt = mysql_fetch_array($cst1);
			$cli_id=$dt['tb_cliente_id'];
			mysql_free_result($cst1);
			
			$data['cli_id']=$cli_id;
			$data['cli_msj']='Existe cliente con el mismo número de documento '.$_POST['txt_cli_doc'].'.';
		}
		else
		{
			$oCliente->modificar(
				$_POST['hdd_cli_id'], 
				$_POST['rad_cli_tip'],
                strip_tags(limpia_espacios($_POST['txt_cli_nom'])),
				$_POST['txt_cli_doc'],
                strip_tags($_POST['txt_cli_dir']),
                strip_tags(limpia_espacios($_POST['txt_cli_con'])),
				$_POST['txt_cli_tel'], 
				$_POST['txt_cli_ema'],
				$_POST['txt_cli_est']
				);
			
			$data['cli_msj']='Se registró cliente correctamente.';
			$data['cli_id']=$_POST['hdd_cli_id'];
		}
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['cli_id']))
	{
		$cst1 = $oCliente->verifica_cliente_tabla($_POST['cli_id'],'tb_venta');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' Venta';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oCliente->eliminar($_POST['cli_id']);
			echo 'Se eliminó cliente correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action'] == "obtener_datos"){
	if($_POST['cli_id']>0)
	{
		$rs = $oCliente->mostrarUno($_POST['cli_id']);		
		$fila = mysql_fetch_array($rs);
			$data['direccion'] = $fila['tb_cliente_dir'];
			$data['documento'] = $fila['tb_cliente_doc'];			
			$data['nombre'] = $fila['tb_cliente_nom'];
			$data['tipo'] = $fila['tb_cliente_tip'];
			$data['estado'] = $fila['tb_cliente_est'];
			$data['retiene'] = $fila['tb_cliente_retiene'];
            $data['precio_id'] = $fila['tb_precio_id'];
		mysql_free_result($rs);
	}
	else
	{
		$data['msj']="Error en la obtención de datos del Cliente!";	
	}
	echo json_encode($data);
}


if($_POST['action'] == "obtener_nombre"){
    $cst1 = $oCliente->verifica_cliente_doc($_POST['txt_cli_doc'],0);
    $rst1= mysql_num_rows($cst1);

    if($rst1>0)
    {
        $dt = mysql_fetch_array($cst1);
        $cli_id=$dt['tb_cliente_id'];
        mysql_free_result($cst1);

        $cst2 = $oCliente->verifica_cliente_nombre($_POST['txt_cli_doc'],0);
        $dt = mysql_fetch_array($cst2);
        $cli_nom=$dt['tb_cliente_nom'];


        $data['cli_nom']=$cli_nom;
        $data['cli_msj']='Existe cliente';
    }
    else
    {
        $data['cli_nom']=$cli_nom;
        $data['cli_msj']='No existe cliente.';
    }
    echo json_encode($data);
}
?>