<?php
function datatoarray($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr = array();

    $arr['certificado'] = $empresa[0]->certificado;
    $arr['clave_certificado'] = $empresa[0]->clave_certificado;
    $arr['usuario_sunat'] = $empresa[0]->usuario_sunat;
    $arr['clave_sunat'] = $empresa[0]->clave_sunat;
    if ($tipodoc == 'VoidedDocuments'){
        $arr['filename'] = $empresa[0]->idempresa .'-'. $header[0]->id;
    }
    elseif ($tipodoc == 'SummaryDocuments'){
        $arr['filename'] = $empresa[0]->idempresa .'-'. $header[0]->id;
    }
    else{//Invoice DespatchAdvice CreditNote DebitNote SummaryDocuments
        arr_Signature($header, $detalle, $empresa, $tipodoc);
        $arr['filename'] = $empresa[0]->idempresa .'-'. str_pad($header[0]->idcomprobante, 2, '0', STR_PAD_LEFT) .'-'. $header[0]->serie .'-'. $header[0]->numero;
    }
    $arr['empresa']=$empresa[0];
    $arr['header']=$header[0];
    $arr['detalle']=$detalle;
    return $arr;
}

//cac:Signature
function arr_Signature($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['Signature']['ID'] = $empresa[0]->signature_id;
    $arr['Signature']['ID2'] = $empresa[0]->signature_id2;
    $arr['doc'][$tipodoc]['child']['Signature']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['Signature']['child']['ID'][0] = $empresa[0]->signature_id;
    $arr['doc'][$tipodoc]['child']['Signature']['child']['ID']['tag'] = 'cbc';

    $arr['doc'][$tipodoc]['child']['Signature']['child']['SignatoryParty']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['Signature']['child']['SignatoryParty']['child']['PartyIdentification']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['Signature']['child']['SignatoryParty']['child']['PartyIdentification']['child']['ID'][0] = $empresa[0]->idempresa;
    $arr['doc'][$tipodoc]['child']['Signature']['child']['SignatoryParty']['child']['PartyIdentification']['child']['ID']['tag'] = 'cbc';

    $arr['doc'][$tipodoc]['child']['Signature']['child']['SignatoryParty']['child']['PartyName']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['Signature']['child']['SignatoryParty']['child']['PartyName']['child']['Name'][0] = '*'.$empresa[0]->razon;
    $arr['doc'][$tipodoc]['child']['Signature']['child']['SignatoryParty']['child']['PartyName']['child']['Name']['tag'] = 'cbc';

    $arr['doc'][$tipodoc]['child']['Signature']['child']['DigitalSignatureAttachment']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['Signature']['child']['DigitalSignatureAttachment']['child']['ExternalReference']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['Signature']['child']['DigitalSignatureAttachment']['child']['ExternalReference']['child']['URI'][0] = '#' .$empresa[0]->signature_id;
    $arr['doc'][$tipodoc]['child']['Signature']['child']['DigitalSignatureAttachment']['child']['ExternalReference']['child']['URI']['tag'] = 'cbc';
}
?>
