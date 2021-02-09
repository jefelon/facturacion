<?php
require_once('funciones.php');
function run($arr, $dirxml, $dircdr, $nodo="", $tipodoc="", $enviar=false) {
    global $xml, $cadena_original, $sello, $texto, $ret;
    $arrRe = array();
    $file = $dirxml .$arr['filename'];
    error_reporting(E_ALL & ~(E_WARNING | E_NOTICE));
    if(file_exists($file.'.xml')){
    	@unlink($file.'.xml');
    }
    if(file_exists($file.'.zip')){
        @unlink($file.'.zip');
    }

    genera_xml($arr, $nodo, $tipodoc);
    $ok=true;
    if($tipodoc=='DespatchAdvice' || $tipodoc=='SummaryDocuments'){
        $xml = save($arr, $dirxml);
        $xml = firmar($xml, $dirxml, $arr);
        $signvalue = get_signaturevalue($xml);
        $digvalue = get_DigestValue($xml);
    }else{
        $xml = save($arr, $dirxml);
        $xml = firmar($xml, $dirxml, $arr);

        $ok = valida($tipodoc);
        if ($ok) {
            //$xml = save($arr, $dirxml);
            //$xml = firmar($xml, $dirxml, $arr);

            $signvalue = get_signaturevalue($xml);
            $digvalue = get_DigestValue($xml);
        }
    }
    if($tipodoc!='SummaryDocuments'){
        $ok = valida($tipodoc);
    }

    if (!$ok) {
        $arrRe = array('valid' => (($ok) ? '1' : '0'), 'faultcode' => '', 'signvalue' => '', 'digvalue' => '');
        display_xml_errors();
        die("Error al validar XSD\n");
    }else{
        if($enviar){
            $nomfuncion = "sendBill";
            if($tipodoc == "VoidedDocuments" || $tipodoc == "SummaryDocuments"){
                $nomfuncion = "sendSummary";
            }
            $faultcode = send_sunat($dirxml .$arr['filename']. ".zip", $arr['filename'] .".zip", $arr, $dircdr, $nomfuncion, $tipodoc);
        }else{
            $faultcode = '-1';
        }
        if(is_array($faultcode)){
            $arrRe = array('valid' => '1', 'faultcode' => $faultcode['faultcode'], 'signvalue' => $signvalue, 'digvalue' => $digvalue, 'ticket' => $faultcode['ticket']);
        }else{
            $arrRe = array('valid' => '1', 'faultcode' => $faultcode, 'signvalue' => $signvalue, 'digvalue' => $digvalue);
        }

    }
    return $arrRe;
}
function genera_xml($arr, $nodo, $tipodoc) {

    global $xml, $ret;
    $xml = new DOMdocument('1.0', 'ISO-8859-1');
    $xml->standalone=false;
    switch ($tipodoc) {
        case 'Invoice':
            include_once('../../cpegeneracion/sunat/plantillas/XML_FACTURA_2.1.php');
            $xml->loadXML($xml_factura);
            //$xml->load('../../cpegeneracion/sunat/plantillas/20602321208-01-FFF1-4.xml');
            // code...
            break;
        case 'CreditNote':

            // code...
            break;
    }
}

function save($arr, $dirxml) {
    global $xml;
    $todo = null;

    if ($dirxml != "/dev/null") {
        $file = $dirxml .$arr['filename']. '.xml';
        $xml->save($file);
        $todo = new DOMDocument();
        $todo->formatOutput = FALSE;
        $todo->preserveWhiteSpace = TRUE;
        $todo->encoding = "ISO-8859-1";
        $todo->load($file);

    }
    return($todo);
}

?>
