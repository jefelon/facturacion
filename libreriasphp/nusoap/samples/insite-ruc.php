<?php
error_reporting(E_ALL);
//ini_set('display_errors', 1);
require_once('../lib/nusoap.php');
$wsdl="http://ws.insite.pe/sunat/trial.php?wsdl";
$client = new nusoap_client($wsdl, true);
$param=array('ruc'      => '20488140001',
                'username' => 'correo@dominio.com',
                'hash'     => 'XXX-XXX-XXX',
                'tracking' => '');
$result = $client->call('consultaRUC', $param);
$ruc = array();
$lines = explode("|", $result);
foreach ($lines as $line) {
  $li = explode('=', $line);
  if (isset ($li[0])) {
    $key = $li[0];
  }
  else {
    $key = '';
  }
  if (isset ($li[1])) {
    $val = $li[1];
  }
  else {
    $val = '';
  }
  $ruc[$key] = $val;
}
// Recopilando las ACTIVIDADES ECONOMICAS
$html = '<table border>';
$html .= '<thead>';
$html .= '<th><strong>ID</strong></th>';
$html .= '<th><strong>CIUU</strong></th>';
$html .= '<th><strong>ACTIVIDAD ECONOMICA</strong></th>';
for ($i = 1; $i <= $ruc['n2_actv_econ']; $i++) {
  $ciuu = explode('-', $ruc['n2_actv_econ_' . $i]);
  $html .= '<tr>';
  $html .= "<td>{$i}</td>";
  $html .= "<td>{$ciuu[1]}</td>";
  $html .= "<td>{$ciuu[2]}</td>";
  $html .= '</tr>';
}
$html .= '</table>';
// Recopilando las ACTIVIDADES ECONOMICAS
$cp = '<ul>';
$cpa = explode('+', $ruc['n2_cp_auto']);
foreach ($cpa as $ca) {
  $cp .= "<li>{$ca}</li>";
}
$cp .= '</ul>';
?>
<!DOCTYPE html>
<html>
<head>
  <title>test <?php echo date("DMY H:i:s");?></title>
  <meta http-equiv="Content-Type" content="text/plain;charset=UTF-8">
</head>
<body>
<form>
<table>
    <tr>
        <td>Tipo Contribuyente </td>
        <td><?=$ruc['n2_tipo_contr'] ?></td>
    </tr>
    <tr>
        <td>RUC </td>
        <td><?=$ruc['n1_ruc'] ?></td>
    </tr>
    <tr>
        <td>Razon Social </td>
        <td><?=$ruc['n1_alias'] ?></td>
    </tr>
    <tr>
        <td>Nombre Comercial </td>
        <td><?=$ruc['n2_nom_comer'] ?></td>
    </tr>
    <tr>
        <td>Direccion</td>
        <td><?=$ruc['n2_dir_fiscal'] ?></td>
    </tr>
    <tr>
        <td valign=top>Actividad Economica</td>
        <td><?=$html;?></td>
    </tr>
    <tr>
        <td valign=top>Documentos Autorizados</td>
        <td><?=$cp;?></td>
    </tr>
    <tr>
        <td colspan="2"><hr></td>
    </tr>
    <tr>
        <td>Tipo contribuyente: </td>
        <td><input name='ruc' value='<?=$ruc['n1_ruc'] ?>' size=30 disabled="disabled"></td>
    </tr>
    <tr>
        <td>Tipo contribuyente: </td>
        <td><input name='alias' value='<?=$ruc['n1_alias'] ?>' size=60></td>
    </tr>
 
</table>
<!--
<br>Tipo contribuyente: <input name='tipo_contribuyente' value='<?=$ruc['n2_tipo_contr'] ?>' size=30>
<br><input name='ruc' value='<?=$ruc['n1_ruc'] ?>' size=15>
<br><input name='alias' value='<?=$ruc['n1_alias'] ?>'  size=60>
<br><input name='nombre_comercial' value='<?=$ruc['n2_nom_comer'] ?>'  size=60>
<br><input name='estado' value='<?=$ruc['n1_estado'] ?>'  size=60>
<br><input name='condicion' value='<?=$ruc['n1_condicion'] ?>'  size=60>
<br><input name='direccion' value='<?=$ruc['n1_direccion'] ?>'  size=60>
<br><input name='direccion' value='<?=$ruc['n2_dir_fiscal'] ?>'  size=80>
-->
</form>
</body>
</html>