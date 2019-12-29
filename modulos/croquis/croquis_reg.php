<?php
require_once ("../../config/Cado.php");
require_once("cCroquis.php");
$oCroquis = new cCroquis();
require_once("../vehiculo/cVehiculo.php");
$oVehiculo = new cVehiculo();

if($_POST['action_croquis']=="insertar")
{
    $dts=$oVehiculo->mostrarUno($_POST['cmb_vehiculo']);
    $dt = mysql_fetch_array($dts);
    $veh_num_asi=$dt['tb_vehiculo_numasi'];
    $veh_pis=$dt['tb_vehiculo_pisos'];
    mysql_free_result($dts);

	if(!empty($_POST['cmb_vehiculo']))
	{
        $oCroquis->insertar(strip_tags($_POST['cmb_vehiculo']),$_POST['cmb_estado'],$_POST['txt_croquis_fondo'],$_POST['cmb_croquis_def']);

        if (!file_exists('fondos')) {
            mkdir('fondos', 0777);
        }

        move_uploaded_file($_FILES['file']['tmp_name'], 'fondos/' . $_POST['hdd_cro_id'] . '_'. $_FILES['file']['name'] );

			$dts=$oCroquis->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		    $cro_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

			$pisos=1;

			if($_POST['cmb_croquis_def']==56)
            {
                while ($pisos<=$veh_pis) {
                    //distribucion asiento 56 asientos 1 piso
                    // $i = fila, son 5 porque tiene un pasadizo
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i == 1) {
                            $dist = "item_3;item_7;item_11;item_15;item_19;item_23;item_27;item_31;item_35;item_39;item_43;item_47;item_51";
                        } elseif ($i == 2) {
                            $dist = "item_4;item_8;item_12;item_16;item_20;item_24;item_28;item_32;item_36;item_40;item_44;item_48;item_52";
                        } elseif ($i == 3) {
                            $dist = "";
                        } elseif ($i == 4) {
                            $dist = "item_2;item_6;item_10;item_14;item_18;item_22;item_26;item_30;item_34;item_38;item_42;item_46;item_50;item_54;item_56";
                        } elseif ($i == 5) {
                            $dist = "item_1;item_5;item_9;item_13;item_17;item_21;item_25;item_29;item_33;item_37;item_41;item_45;item_49;item_53;item_55";
                        }
                        $oCroquis->insertarCroquis(
                            $dist,
                            $i,
                            $_POST['cmb_vehiculo'],
                            $pisos,
                            $cro_id
                        );
                    }
                    $pisos++;
                }
            }
            elseif($_POST['cmb_croquis_def']==49)
            {
                while ($pisos<=$veh_pis){
                    //distribucion asiento 49 asientos 1 piso
                    // $i = fila, son 5 porque tiene un pasadizo
                    for ($i=1;$i<=5;$i++)
                    {
                        if($i==1){$dist="item_4;item_8;item_12;item_16;item_20;item_24;item_28;item_32;item_36;item_40;item_44;item_48";}
                        elseif($i==2){$dist="item_3;item_7;item_11;item_15;item_19;item_23;item_27;item_31;item_35;item_39;item_43;item_47";}
                        elseif($i==3){$dist="item_00;item_00;item_00;item_00;item_00;item_00;item_00;item_00;item_00;item_00;item_00;item_49";}
                        elseif($i==4){$dist="item_2;item_6;item_10;item_14;item_18;item_22;item_26;item_30;item_34;item_38;item_42;item_46";}
                        elseif($i==5){$dist="item_1;item_5;item_9;item_13;item_17;item_21;item_25;item_29;item_33;item_37;item_41;item_45";}
                        $oCroquis->insertarCroquis(
                            $dist,
                            $i,
                            $_POST['cmb_vehiculo'],
                            $pisos,
                            $cro_id
                        );
                    }
                    $pisos++;
                }

            }


        echo "Se registró croquis correctamente.";
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_croquis']=="editar")
{

    if(!empty($_POST['cmb_vehiculo']))
	{
        $oCroquis->modificar($_POST['hdd_cro_id'], $_POST['cmb_vehiculo'],$_POST['cmb_estado'],$_POST['txt_croquis_fondo'],$_POST['cmb_croquis_def']);

        if (!file_exists('fondos')) {
            mkdir('fondos', 0777);
        }

        move_uploaded_file($_FILES['file']['tmp_name'], 'fondos/' . $_POST['hdd_cro_id'] . '_'. $_FILES['file']['name'] );

        echo "Se registró croquis correctamente.";
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['id']))
	{
        $oCroquis->eliminar($_POST['id']);
        $oCroquis->eliminarCroquis($_POST['id']);
        echo 'Se eliminó croquis correctamente.';
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>