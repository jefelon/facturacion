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
                        $dist = "item_3_a;item_7_a;item_11_a;item_15_a;item_19_a;item_23_a;item_27_a;item_31_a;item_35_a;item_39_a;item_43_a;item_47_a;item_51_a";
                    } elseif ($i == 2) {
                        $dist = "item_4_a;item_8_a;item_12_a;item_16_a;item_20_a;item_24_a;item_28_a;item_32_a;item_36_a;item_40_a;item_44_a;item_48_a;item_52_a";
                    } elseif ($i == 3) {
                        $dist = "item_01_d;item_02_d;item_03_d;item_04_d;item_05_d;item_06_d;item_07_d;item_08_d;item_09_d;item_010_d;item_011_d;item_012_d";
                    } elseif ($i == 4) {
                        $dist = "item_2_a;item_6_a;item_10_a;item_14_a;item_18_a;item_22_a;item_26_a;item_30_a;item_34_a;item_38_a;item_42_a;item_46_a;item_50_a;item_54_a;item_56_a";
                    } elseif ($i == 5) {
                        $dist = "item_1_a;item_5_a;item_9_a;item_13_a;item_17_a;item_21_a;item_25_a;item_29_a;item_33_a;item_37_a;item_41_a;item_45_a;item_49_a;item_53_a;item_55_a";
                    }
                    $oCroquis->insertarCroquis(
                        $dist,
                        $i,
                        $_POST['cmb_vehiculo'],
                        $pisos,
                        $cro_id,
                        $_POST['cmb_estado']
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
                    if($i==1){$dist="item_4_a;item_8_a;item_12_a;item_16_a;item_20_a;item_24_a;item_28_a;item_32_a;item_36_a;item_40_a;item_44_a;item_48_a";}
                    elseif($i==2){$dist="item_3_a;item_7_a;item_11_a;item_15_a;item_19_a;item_23_a;item_27_a;item_31_a;item_35_a;item_39_a;item_43_a;item_47_a";}
                    elseif($i==3){$dist="item_01_d;item_02_d;item_03_d;item_04_d;item_05_d;item_06_d;item_07_d;item_08_d;item_09_d;item_010_d;item_011_d;item_49_a";}
                    elseif($i==4){$dist="item_2_a;item_6_a;item_10_a;item_14_a;item_18_a;item_22_a;item_26_a;item_30_a;item_34_a;item_38_a;item_42_a;item_46_a";}
                    elseif($i==5){$dist="item_1_a;item_5_a;item_9_a;item_13_a;item_17_a;item_21_a;item_25_a;item_29_a;item_33_a;item_37_a;item_41_a;item_45_a";}
                    $oCroquis->insertarCroquis(
                        $dist,
                        $i,
                        $_POST['cmb_vehiculo'],
                        $pisos,
                        $cro_id,
                        $_POST['cmb_estado']
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

    if(!empty($_POST['hdd_veh_id']))
    {
        $oCroquis->editarCroquis($_POST['distribucion'],$_POST['hdd_fila'],$_POST['hdd_veh_id'],$_POST['hdd_piso']);

        echo "Las ubicaciones del croquis se editaron correctamente.";
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