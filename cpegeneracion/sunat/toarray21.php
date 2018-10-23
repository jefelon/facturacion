<?php
function datatoarray($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr = array();

    $arr['certificado'] = $empresa[0]->certificado;
    $arr['clave_certificado'] = $empresa[0]->clave_certificado;
    $arr['usuario_sunat'] = $empresa[0]->usuario_sunat;
    $arr['clave_sunat'] = $empresa[0]->clave_sunat;
    if($tipodoc == 'Invoice'){
        //arr_UBLExtensions($header, $detalle, $empresa, $tipodoc);
        arr_doc($header, $detalle, $empresa, $tipodoc);
        arr_UBLExtensions($header, $detalle, $empresa, $tipodoc);
        arr_UBLVersionID($header, $detalle, $empresa, $tipodoc);
        arr_CustomizationID($header, $detalle, $empresa, $tipodoc);
        arr_ProfileID($header, $detalle, $empresa, $tipodoc);
        arr_ID($header, $detalle, $empresa, $tipodoc);
        arr_IssueDate($header, $detalle, $empresa, $tipodoc);
        arr_IssueTime($header, $detalle, $empresa, $tipodoc);
        arr_DueDate($header, $detalle, $empresa, $tipodoc);
        arr_InvoiceTypeCode($header, $detalle, $empresa, $tipodoc);
        arr_Note($header, $detalle, $empresa, $tipodoc);
        arr_DocumentCurrencyCode($header, $detalle, $empresa, $tipodoc);
        arr_LineCountNumeric($header, $detalle, $empresa, $tipodoc);
        arr_DespatchDocumentReference($header, $detalle, $empresa, $tipodoc);
        arr_Signature($header, $detalle, $empresa, $tipodoc);
        arr_AccountingSupplierParty($header, $detalle, $empresa, $tipodoc);
        arr_AccountingCustomerParty($header, $detalle, $empresa, $tipodoc);
        arr_PrepaidPayment($header, $detalle, $empresa, $tipodoc);
        arr_TaxTotal($header, $detalle, $empresa, $tipodoc);
        arr_LegalMonetaryTotal($header, $detalle, $empresa, $tipodoc);
        arr_InvoiceLine($header, $detalle, $empresa, $tipodoc);
        $arr['filename'] = $empresa[0]->idempresa .'-'. str_pad($header[0]->idcomprobante, 2, '0', STR_PAD_LEFT) .'-'. $header[0]->serie .'-'. $header[0]->numero;
    }elseif ($tipodoc == 'DespatchAdvice'){
        arr_UBLExtensions($header, $detalle, $empresa, $tipodoc);
        arr_UBLVersionID($header, $detalle, $empresa, $tipodoc);
        arr_CustomizationID($header, $detalle, $empresa, $tipodoc);
        arr_ID($header, $detalle, $empresa, $tipodoc);
        arr_IssueDate($header, $detalle, $empresa, $tipodoc);
        arr_DespatchAdviceTypeCode($header, $detalle, $empresa, $tipodoc);
        arr_Signature($header, $detalle, $empresa, $tipodoc);
        arr_Note($header, $detalle, $empresa, $tipodoc);
        arr_DespatchSupplierParty($header, $detalle, $empresa, $tipodoc);
        arr_DeliveryCustomerParty($header, $detalle, $empresa, $tipodoc);
        arr_Shipment($header, $detalle, $empresa, $tipodoc);
        arr_DespatchLine($header, $detalle, $empresa, $tipodoc);
        $arr['filename'] = $empresa[0]->idempresa .'-'. str_pad($header[0]->idcomprobante, 2, '0', STR_PAD_LEFT) .'-'. $header[0]->serie .'-'. $header[0]->numero;
    }elseif ($tipodoc == 'CreditNote'){
        arr_UBLExtensions($header, $detalle, $empresa, $tipodoc);
        arr_UBLVersionID($header, $detalle, $empresa, $tipodoc);
        arr_CustomizationID($header, $detalle, $empresa, $tipodoc);
        arr_ID($header, $detalle, $empresa, $tipodoc);
        arr_IssueDate($header, $detalle, $empresa, $tipodoc);
        arr_DocumentCurrencyCode($header, $detalle, $empresa, $tipodoc);
        arr_DiscrepancyResponse($header, $detalle, $empresa, $tipodoc);
        arr_BillingReference($header, $detalle, $empresa, $tipodoc);
        arr_Signature($header, $detalle, $empresa, $tipodoc);
        arr_AccountingSupplierParty($header, $detalle, $empresa, $tipodoc);
        arr_AccountingCustomerParty($header, $detalle, $empresa, $tipodoc);
        arr_TaxTotal($header, $detalle, $empresa, $tipodoc);
        arr_LegalMonetaryTotal($header, $detalle, $empresa, $tipodoc);
        arr_CreditNoteLine($header, $detalle, $empresa, $tipodoc);
        $arr['filename'] = $empresa[0]->idempresa .'-'. str_pad($header[0]->idcomprobante, 2, '0', STR_PAD_LEFT) .'-'. $header[0]->serie .'-'. $header[0]->numero;
    }elseif ($tipodoc == 'DebitNote'){
        arr_UBLExtensions($header, $detalle, $empresa, $tipodoc);
        arr_UBLVersionID($header, $detalle, $empresa, $tipodoc);
        arr_CustomizationID($header, $detalle, $empresa, $tipodoc);
        arr_ID($header, $detalle, $empresa, $tipodoc);
        arr_IssueDate($header, $detalle, $empresa, $tipodoc);
        arr_DocumentCurrencyCode($header, $detalle, $empresa, $tipodoc);
        arr_DiscrepancyResponse($header, $detalle, $empresa, $tipodoc);
        arr_BillingReference($header, $detalle, $empresa, $tipodoc);
        arr_Signature($header, $detalle, $empresa, $tipodoc);
        arr_AccountingSupplierParty($header, $detalle, $empresa, $tipodoc);
        arr_AccountingCustomerParty($header, $detalle, $empresa, $tipodoc);
        arr_TaxTotal($header, $detalle, $empresa, $tipodoc);
        arr_RequestedMonetaryTotal($header, $detalle, $empresa, $tipodoc);
        arr_DebitNoteLine($header, $detalle, $empresa, $tipodoc);
        $arr['filename'] = $empresa[0]->idempresa .'-'. str_pad($header[0]->idcomprobante, 2, '0', STR_PAD_LEFT) .'-'. $header[0]->serie .'-'. $header[0]->numero;
    }elseif ($tipodoc == 'SummaryDocuments'){
        arr_UBLVersionID($header, $detalle, $empresa, $tipodoc);
        arr_CustomizationID($header, $detalle, $empresa, $tipodoc);
        arr_ID($header, $detalle, $empresa, $tipodoc);
        arr_IssueDate($header, $detalle, $empresa, $tipodoc);
        arr_ReferenceDate($header, $detalle, $empresa, $tipodoc);
        arr_Signature($header, $detalle, $empresa, $tipodoc);
        arr_AccountingSupplierParty($header, $detalle, $empresa, $tipodoc);
        arr_SummaryDocumentsLine($header, $detalle, $empresa, $tipodoc);
        $arr['filename'] = $empresa[0]->idempresa .'-'. $header[0]->id;
    }elseif ($tipodoc == 'VoidedDocuments'){
        arr_UBLVersionID($header, $detalle, $empresa, $tipodoc);
        arr_CustomizationID($header, $detalle, $empresa, $tipodoc);
        arr_ID($header, $detalle, $empresa, $tipodoc);
        arr_ReferenceDate($header, $detalle, $empresa, $tipodoc);
        arr_IssueDate($header, $detalle, $empresa, $tipodoc);
        arr_Signature($header, $detalle, $empresa, $tipodoc);
        arr_AccountingSupplierParty($header, $detalle, $empresa, $tipodoc);
        arr_VoidedDocumentsLine($header, $detalle, $empresa, $tipodoc);
        $arr['filename'] = $empresa[0]->idempresa .'-'. $header[0]->id;
    }
    return $arr;
}
function arr_doc($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if($tipodoc == 'Invoice'){
        $arr['doc'][$tipodoc]['atr']['xmlns'] = 'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2';
        $arr['doc'][$tipodoc]['atr']['xmlns:cac'] = 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2';
        $arr['doc'][$tipodoc]['atr']['xmlns:cbc'] = 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2';
        $arr['doc'][$tipodoc]['atr']['xmlns:ccts'] = 'urn:un:unece:uncefact:documentation:2';
        $arr['doc'][$tipodoc]['atr']['xmlns:ds' ]= 'http://www.w3.org/2000/09/xmldsig#';
        $arr['doc'][$tipodoc]['atr']['xmlns:ext'] = 'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2';
        $arr['doc'][$tipodoc]['atr']['xmlns:qdt'] = 'urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2';
        $arr['doc'][$tipodoc]['atr']['xmlns:sac'] = 'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1';
        $arr['doc'][$tipodoc]['atr']['xmlns:udt'] = 'urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2';
        $arr['doc'][$tipodoc]['atr']['xmlns:xsi'] = 'http://www.w3.org/2001/XMLSchema-instance';

    }
}
function arr_UBLExtensions($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if($tipodoc=='DespatchAdvice'){
        $arr['doc'][$tipodoc]['child']['UBLExtensions']['tag'] = 'ext';
        $arr['doc'][$tipodoc]['child']['UBLExtensions']['child']['UBLExtension']['tag'] = 'ext';
        $arr['doc'][$tipodoc]['child']['UBLExtensions']['child']['UBLExtension']['child']['ExtensionContent']['tag'] = 'ext';
    }else{
        $arr['doc'][$tipodoc]['child']['UBLExtensions']['tag'] = 'ext';
        $arr['doc'][$tipodoc]['child']['UBLExtensions']['child']['UBLExtension']['tag'] = 'ext';
        $arr['doc'][$tipodoc]['child']['UBLExtensions']['child']['UBLExtension']['child']['ExtensionContent']['tag'] = 'ext';
    }

}
function arr_UBLVersionID($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if($tipodoc=='DespatchAdvice'){
        $arr['doc'][$tipodoc]['child']['UBLVersionID'][0] = '2.1';
        $arr['doc'][$tipodoc]['child']['UBLVersionID']['tag'] = 'cbc';
    }else{
        $arr['doc'][$tipodoc]['child']['UBLVersionID'][0] = '2.1';
        $arr['doc'][$tipodoc]['child']['UBLVersionID']['tag'] = 'cbc';
    }

}
function arr_CustomizationID($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if($tipodoc=='SummaryDocuments'){
        $arr['doc'][$tipodoc]['child']['CustomizationID'][0] = '1.1';
        $arr['doc'][$tipodoc]['child']['CustomizationID']['tag'] = 'cbc';

    }else{
        $arr['doc'][$tipodoc]['child']['CustomizationID'][0] = '2.0';
        $arr['doc'][$tipodoc]['child']['CustomizationID']['tag'] = 'cbc';
    }
}

function arr_ProfileID($header, $detalle, $empresa, $tipodoc){

    global $arr;
    // <cbc:ProfileID schemeName="SUNAT:Identificador de Tipo de Operación" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17">0101</cbc:ProfileID>
    $arr['doc'][$tipodoc]['child']['ProfileID'][0] = str_pad($header[0]->idtoperacion, 4, '0', STR_PAD_LEFT);
    $arr['doc'][$tipodoc]['child']['ProfileID']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['ProfileID']['atr']['schemeName'] = 'SUNAT:Identificador de Tipo de Operación';
    $arr['doc'][$tipodoc]['child']['ProfileID']['atr']['schemeAgencyName'] = 'PE:SUNAT';
    $arr['doc'][$tipodoc]['child']['ProfileID']['atr']['schemeURI'] = 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo17';
}

function arr_ID($header, $detalle, $empresa, $tipodoc){
    global $arr;

    if($tipodoc=='VoidedDocuments' || $tipodoc=='SummaryDocuments' ){
        $arr['doc'][$tipodoc]['child']['ID'][0] = $header[0]->id;
        $arr['doc'][$tipodoc]['child']['ID']['tag'] = 'cbc';
    }else{
        $arr['doc'][$tipodoc]['child']['ID'][0] = $header[0]->serie .'-'. $header[0]->numero; //'$header[0]->serie .'-' 'F001-10';
        $arr['doc'][$tipodoc]['child']['ID']['tag'] = 'cbc';
    }
}
function arr_ReferenceDate($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['ReferenceDate'][0] = $header[0]->referencedate;
}
function arr_IssueDate($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if($tipodoc=='Invoice' || $tipodoc=='DespatchAdvice'){
        $arr['doc'][$tipodoc]['child']['IssueDate'][0] = date_format(date_create($header[0]->fechadoc), 'Y-m-d');
        $arr['doc'][$tipodoc]['child']['IssueDate']['tag'] = 'cbc';
    }else{
        $arr['doc'][$tipodoc]['child']['IssueDate'][0] = $header[0]->issuedate;
        $arr['doc'][$tipodoc]['child']['IssueDate']['tag'] = 'cbc';
    }
}
function arr_IssueTime($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if($tipodoc=='Invoice' || $tipodoc=='DespatchAdvice'){
        $arr['doc'][$tipodoc]['child']['IssueTime'][0] = date_format(date_create($header[0]->fechadoc), 'H:i:s');
        //$arr['doc'][$tipodoc]['child']['IssueTime'][0] = date_format(date_create($header[0]->fechareg), 'H:i:s');
        $arr['doc'][$tipodoc]['child']['IssueTime']['tag'] = 'cbc';
    }else{
        $arr['doc'][$tipodoc]['child']['IssueTime'][0] = $header[0]->issuedate;
        $arr['doc'][$tipodoc]['child']['IssueTime']['tag'] = 'cbc';
    }
}

function arr_DueDate($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if($tipodoc=='Invoice' || $tipodoc=='DespatchAdvice'){
        $arr['doc'][$tipodoc]['child']['DueDate'][0] = date_format(date_create($header[0]->fechavence), 'Y-m-d');
        $arr['doc'][$tipodoc]['child']['DueDate']['tag'] = 'cbc';
    }else{
        $arr['doc'][$tipodoc]['child']['DueDate'][0] = $header[0]->fechavence;
        $arr['doc'][$tipodoc]['child']['DueDate']['tag'] = 'cbc';
    }
}

function arr_InvoiceTypeCode($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['InvoiceTypeCode'][0] = str_pad($header[0]->idcomprobante, 2, '0', STR_PAD_LEFT); //'01';
    $arr['doc'][$tipodoc]['child']['InvoiceTypeCode']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['InvoiceTypeCode']['atr']['listID'] = str_pad($header[0]->idtoperacion, 4, '0', STR_PAD_LEFT);
    $arr['doc'][$tipodoc]['child']['InvoiceTypeCode']['atr']['listAgencyName'] = "PE:SUNAT";
    $arr['doc'][$tipodoc]['child']['InvoiceTypeCode']['atr']['listName'] = "SUNAT:Identificador de Tipo de Documento";
    $arr['doc'][$tipodoc]['child']['InvoiceTypeCode']['atr']['listURI'] = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01";

}
function arr_Note($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['Note'][0] = $header[0]->AdditionalProperty_Value;
    $arr['doc'][$tipodoc]['child']['Note']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['Note']['atr']['languageLocaleID'] = '1000';
}

function arr_DocumentCurrencyCode($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['DocumentCurrencyCode'][0] = $header[0]->isomoneda;
    $arr['doc'][$tipodoc]['child']['DocumentCurrencyCode']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['DocumentCurrencyCode']['atr']['listID'] = 'ISO 4217 Alpha';
    $arr['doc'][$tipodoc]['child']['DocumentCurrencyCode']['atr']['listName'] = "Currency";
    $arr['doc'][$tipodoc]['child']['DocumentCurrencyCode']['atr']['listAgencyName'] = "United Nations Economic Commission for Europe";
}

function arr_DespatchDocumentReference($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $DespatchDocument = (isset($header[0]->DespatchDocument) ? $header[0]->DespatchDocument: []);
    foreach ($DespatchDocument as $row => $item) {
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['ID'] = $item['ID'];
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['ID']['tag'] = 'cbc';

        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['DocumentTypeCode'][0] = $item['DocumentTypeCode'];
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['DocumentTypeCode']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['DocumentTypeCode']['atr']['listAgencyName'] = 'PE:SUNAT';
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['DocumentTypeCode']['atr']['listName'] = 'SUNAT:Identificador de guía relacionada';
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['DocumentTypeCode']['atr']['listURI'] = 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01';
    }
}

function arr_AdditionalDocumentReference($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $AdditionalDocumentReference = (isset($header[0]->AdditionalDocumentReference) ? $header[0]->AdditionalDocumentReference: []);
    foreach ($DespatchDocument as $row => $item) {
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['ID'] = $item['ID'];
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['ID']['tag'] = 'cbc';

        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['DocumentTypeCode'][0] = $item['DocumentTypeCode'];
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['DocumentTypeCode']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['DocumentTypeCode']['atr']['listAgencyName'] = 'PE:SUNAT';
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['DocumentTypeCode']['atr']['listName'] = 'SUNAT:Identificador de guía relacionada';
        $arr['doc'][$tipodoc]['child']['DespatchDocumentReference']['child']['DocumentTypeCode']['atr']['listURI'] = 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo12';
    }
}

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
    $arr['doc'][$tipodoc]['child']['Signature']['child']['SignatoryParty']['child']['PartyName']['child']['Name'][0] = $empresa[0]->razon;
    $arr['doc'][$tipodoc]['child']['Signature']['child']['SignatoryParty']['child']['PartyName']['child']['Name']['tag'] = 'cbc';

    $arr['doc'][$tipodoc]['child']['Signature']['child']['DigitalSignatureAttachment']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['Signature']['child']['DigitalSignatureAttachment']['child']['ExternalReference']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['Signature']['child']['DigitalSignatureAttachment']['child']['ExternalReference']['child']['URI'][0] = '#' .$empresa[0]->signature_id;
    $arr['doc'][$tipodoc]['child']['Signature']['child']['DigitalSignatureAttachment']['child']['ExternalReference']['child']['URI']['tag'] = 'cbc';
}

function arr_AccountingSupplierParty($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyIdentification']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyIdentification']['child']['ID'][0] = $empresa[0]->idempresa;
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyIdentification']['child']['ID']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyIdentification']['child']['ID']['atr']['schemeID'] = $empresa[0]->idtipodni;
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyIdentification']['child']['ID']['atr']['schemeName'] = 'SUNAT:Identificador de Documento de Identidad';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyIdentification']['child']['ID']['atr']['schemeAgencyName'] = 'PE:SUNAT';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyIdentification']['child']['ID']['atr']['schemeURI']="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";

    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyName']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyName']['child']['Name'][0] = '*'.$empresa[0]->nomcomercial;
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyName']['child']['Name']['tag'] = 'cbc';

    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyLegalEntity']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyLegalEntity']['child']['RegistrationName'][0] = '*'.$empresa[0]->razon;
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyLegalEntity']['child']['RegistrationName']['tag'] = 'cbc';

    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyLegalEntity']['child']['RegistrationAddress']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyLegalEntity']['child']['RegistrationAddress']['child']['AddressTypeCode'][0] = isset($empresa[0]->AddressTypeCode) ? strtoupper($empresa[0]->AddressTypeCode) : '0000';
    $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyLegalEntity']['child']['RegistrationAddress']['child']['AddressTypeCode']['tag'] = 'cbc';


    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['tag'] = 'cac';
    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['RegistrationName'][0] = '*'.$empresa[0]->razon;
    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['RegistrationName']['tag'] = 'cbc';

    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID'][0] = $empresa[0]->idempresa;
    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID']['tag'] = 'cbc';

    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID']['atr']['schemeID'] = $empresa[0]->idtipodni;
    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID']['atr']['schemeName'] = 'SUNAT:Identificador de Documento de Identidad';
    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID']['atr']['schemeAgencyName'] = 'PE:SUNAT';
    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID']['atr']['schemeURI']="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";

    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['RegistrationAddress']['tag'] = 'cac';
    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['RegistrationAddress']['child']['AddressTypeCode'][0] = isset($empresa[0]->AddressTypeCode) ? strtoupper($empresa[0]->AddressTypeCode) : '0000';
    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['RegistrationAddress']['child']['AddressTypeCode']['tag'] = 'cbc';

    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['TaxScheme']['tag'] = 'cac';
    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['TaxScheme']['child']['ID'][0] = '-';
    // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['child']['Party']['child']['PartyTaxScheme']['child']['TaxScheme']['child']['ID']['tag'] = 'cbc';

    if($tipodoc != 'VoidedDocuments'){
        // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['Party']['PostalAddress']['ID'] = $empresa[0]->iddistrito;
        // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['Party']['PostalAddress']['StreetName'] = $empresa[0]->direccion;
        // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['Party']['PostalAddress']['CitySubdivisionName'] = $empresa[0]->subdivision;
        // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['Party']['PostalAddress']['CityName'] = strtoupper($empresa[0]->departamento);
        // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['Party']['PostalAddress']['CountrySubentity'] = strtoupper($empresa[0]->provincia);
        // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['Party']['PostalAddress']['District'] = strtoupper($empresa[0]->distrito);
        // $arr['doc'][$tipodoc]['child']['AccountingSupplierParty']['Party']['PostalAddress']['Country']['IdentificationCode'] = 'PE';
    }
}

function arr_AccountingCustomerParty($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyIdentification']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyIdentification']['child']['ID'][0] = $header[0]->identidad;
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyIdentification']['child']['ID']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyIdentification']['child']['ID']['atr']['schemeID'] = $header[0]->idtipodni;
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyIdentification']['child']['ID']['atr']['schemeName'] = 'SUNAT:Identificador de Documento de Identidad';
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyIdentification']['child']['ID']['atr']['schemeAgencyName'] = 'PE:SUNAT';
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyIdentification']['child']['ID']['atr']['schemeURI']="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";

    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyLegalEntity']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyLegalEntity']['child']['RegistrationName'][0] = '*'.$header[0]->razon;
    $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyLegalEntity']['child']['RegistrationName']['tag'] = 'cbc';

    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['tag'] = 'cac';
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['tag']='cac';
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['tag'] = 'cac';
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['RegistrationName'][0] = '*'.$header[0]->razon;
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['RegistrationName']['tag'] = 'cbc';

    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID'][0] = $header[0]->identidad;
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID']['tag'] = 'cbc';
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID']['atr']['schemeID'] = $header[0]->idtipodni;
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID']['atr']['schemeName'] = "SUNAT:Identificador de Documento de Identidad";
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID']['atr']['schemeAgencyName'] = "PE:SUNAT";
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['CompanyID']['atr']['schemeURI'] = "urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06";

    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['TaxScheme']['tag'] = 'cac';
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['TaxScheme']['child']['ID'][0] = '-';
    // $arr['doc'][$tipodoc]['child']['AccountingCustomerParty']['child']['Party']['child']['PartyTaxScheme']['child']['TaxScheme']['child']['ID']['tag'] = 'cbc';
}

function arr_AllowanceCharge($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if($header[0]->desctoglobal>0){
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['tag'] = 'cac';

        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['ChargeIndicator'][0] = 'false';
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['ChargeIndicator']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['AllowanceChargeReasonCode'][0] = '00';
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['AllowanceChargeReasonCode']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['MultiplierFactorNumeric'][0] = 0.05;//porcentaje
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['MultiplierFactorNumeric']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['Amount'][0] = round($header[0]->desctoglobal,2);
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['Amount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['Amount']['atr']['currencyID'] = $header[0]->isomoneda;
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['BaseAmount'][0] = round($header[0]->tvalorventa,2);
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['BaseAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['AllowanceCharge']['child']['BaseAmount']['atr']['currencyID'] = $header[0]->isomoneda;
    }
}

function arr_TaxTotal($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $xnr = 0;
    $arr['doc'][$tipodoc]['child']['TaxTotal']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['TaxAmount'][0] = round($header[0]->totigv,2) + round($header[0]->totisc,2);
    $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['TaxAmount']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

    if($header[0]->totopgra>0){
        $xnr++;
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount'][0] = round($header[0]->totopgra,2);
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount'][0] = round($header[0]->totigv,2);
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID'][0] = 'S';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5305';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeName'] = 'Tax Category Identifier';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeAgencyName'] = 'United Nations Economic Commission for Europe';

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID'][0] = '1000';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5153';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeAgencyID'] = '6';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name'][0] = 'IGV';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode'][0] = 'VAT';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode']['tag'] = 'cbc';
    }
    if($header[0]->totopexo>0){
        $xnr++;
//        if($xnr<2)
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['tag'] = 'cac';

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount'][0] = round($header[0]->totopexo,2);
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount'][0] = '0.00';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID'][0] = 'E';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5305';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeName'] = 'Tax Category Identifier';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeAgencyName'] = 'United Nations Economic Commission for Europe';

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID'][0] = '9997';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5153';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeAgencyID'] = '6';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name'][0] = 'EXONERADO';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode'][0] = 'VAT';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode']['tag'] = 'cbc';
    }

    if($header[0]->totopina>0){
        $xnr++;
        if($xnr<2)
            $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount'][0] = round($header[0]->totopina,2);
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount'][0] = 0.00;
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID'][0] = 'O';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5305';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeName'] = 'Tax Category Identifier';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeAgencyName'] = 'United Nations Economic Commission for Europe';

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID'][0] = '9998';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5153';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeAgencyID'] = '6';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name'][0] = 'INAFECTO';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode'][0] = 'FRE';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode']['tag'] = 'cbc';
    }

    if($header[0]->totopgrat>0){
        $xnr++;
        if($xnr<2)
            $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount'][0] = round($header[0]->totopgrat,2);
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount'][0] = 0.00;
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID'][0] = 'O';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5305';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeName'] = 'Tax Category Identifier';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeAgencyName'] = 'United Nations Economic Commission for Europe';

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID'][0] = '9996';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5153';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeAgencyID'] = '6';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name'][0] = 'GRATUITO';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode'][0] = 'FRE';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode']['tag'] = 'cbc';
    }

    if($header[0]->totisc>0){
        $xnr++;
        if($xnr<2)
            $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount'][0] = round($header[0]->totopgra,2);
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount'][0] = round($header[0]->totisc,2);;
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID'][0] = 'S';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5305';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeName'] = 'Tax Category Identifier';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeAgencyName'] = 'United Nations Economic Commission for Europe';

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID'][0] = '2000';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5153';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeAgencyID'] = '6';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name'][0] = 'ISC';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode'][0] = 'EXC';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode']['tag'] = 'cbc';
    }
    if($header[0]->tototh>0){
        $xnr++;
        if($xnr<2)
            $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount'][0] = round($header[0]->totopgra,2);
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxableAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount'][0] = round($header[0]->tototh,2);;
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID'][0] = 'S';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5305';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeName'] = 'Tax Category Identifier';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeAgencyName'] = 'United Nations Economic Commission for Europe';

        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['tag'] = 'cac';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID'][0] = '9999';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5153';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeAgencyID'] = '6';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name'][0] = 'OTROS CONCEPTOS DE PAGO';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name']['tag'] = 'cbc';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode'][0] = 'OTH';
        $arr['doc'][$tipodoc]['child']['TaxTotal']['child']['childs'][$xnr]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode']['tag'] = 'cbc';
    }
}

function arr_LegalMonetaryTotal($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['tag'] = 'cac';
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['LineExtensionAmount'][0] = round($header[0]->tvalorventa,2);
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['LineExtensionAmount']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['LineExtensionAmount']['atr']['currencyID'] = $header[0]->isomoneda;

    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['TaxInclusiveAmount'][0] = round($header[0]->importetotal,2);
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['TaxInclusiveAmount']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['TaxInclusiveAmount']['atr']['currencyID'] = $header[0]->isomoneda;

    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['AllowanceTotalAmount'][0] = round($header[0]->totdescto,2);
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['AllowanceTotalAmount']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['AllowanceTotalAmount']['atr']['currencyID'] = $header[0]->isomoneda;

    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['ChargeTotalAmount'][0] = round($header[0]->tototroca,2);
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['ChargeTotalAmount']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['ChargeTotalAmount']['atr']['currencyID'] = $header[0]->isomoneda;

    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['PayableAmount'][0] = round($header[0]->importetotal,2);
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['PayableAmount']['tag'] = 'cbc';
    $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['child']['PayableAmount']['atr']['currencyID'] = $header[0]->isomoneda;
}

function arr_InvoiceLine($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if(count($detalle)>0){
        foreach ($detalle as $row => $item) {
            if($item->idafectaciond == '10' || $item->idafectaciond == '20' || $item->idafectaciond == '30'){
                $arr['doc'][$tipodoc]['child']['UBLExtensions']['UBLExtension']['ExtensionContent']['AdditionalInformation']['AdditionalProperty'][1]['ID'] = '1000';
                $arr['doc'][$tipodoc]['child']['UBLExtensions']['UBLExtension']['ExtensionContent']['AdditionalInformation']['AdditionalProperty'][1]['Value'] = $header[0]->AdditionalProperty_Value;
            }
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['tag'] = 'cac';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['ID'][0] = $item->nro;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['ID']['tag'] = 'cbc';

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['InvoicedQuantity'][0] = round($item->cantidad,10);;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['InvoicedQuantity']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['InvoicedQuantity']['atr']['unitCode'] = $item->idmedida;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['InvoicedQuantity']['atr']['unitCodeListID'] = "UN/ECE rec 20";
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['InvoicedQuantity']['atr']['unitCodeListAgencyName'] = 'United Nations Economic Commission for Europe';

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['LineExtensionAmount'][0] = round($item->valorventa,10);;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['LineExtensionAmount']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['LineExtensionAmount']['atr']['currencyID'] = $header[0]->isomoneda;

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][1]['PricingReference']['tag'] = 'cac';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][1]['PricingReference']['child']['AlternativeConditionPrice']['tag']='cac';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][1]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceAmount'][0] = round($item->preciounitario, 2);
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][1]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceAmount']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][1]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceAmount']['atr']['currencyID'] = $header[0]->isomoneda;

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][1]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceTypeCode'][0] = '01';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][1]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceTypeCode']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][1]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceTypeCode']['atr']['listName'] = 'SUNAT:Indicador de Tipo de Precio';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][1]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceTypeCode']['atr']['listAgencyName'] = 'PE:SUNAT';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][1]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceTypeCode']['atr']['listURI'] = 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16';
            //
            // if ($item->valorrefunitario>0){
            //     $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][2]['PricingReference']['tag'] = 'cac';
            //     $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][2]['PricingReference']['child']['AlternativeConditionPrice']['tag']='cac';
            //     $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][2]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceAmount'][0] = round($item->valorrefunitario, 2);
            //     $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][2]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceAmount']['tag'] = 'cbc';
            //     $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][2]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceAmount']['atr']['currencyID'] = $header[0]->isomoneda;
            //
            //     $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][2]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceTypeCode'][0] = '02';
            //     $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][2]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceTypeCode']['tag'] = 'cbc';
            //     $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][2]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceTypeCode']['atr']['listName'] = 'SUNAT:Indicador de Tipo de Precio';
            //     $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][2]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceTypeCode']['atr']['listAgencyName'] = 'PE:SUNAT';
            //     $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['childs'][2]['PricingReference']['child']['AlternativeConditionPrice']['child']['PriceTypeCode']['atr']['listURI'] = 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16';
            // }
            if($item->descto>0){
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['tag'] = 'cac';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['ChargeIndicator'][0] = 'false';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['ChargeIndicator']['tag'] = 'cbc';

                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['AllowanceChargeReasonCode'][0] = '00';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['AllowanceChargeReasonCode']['tag'] = 'cbc';

                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['MultiplierFactorNumeric'][0] = number_format(round($item->descto / ($item->valorventa+$item->descto),2), 2);
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['MultiplierFactorNumeric']['tag'] = 'cbc';

                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['Amount'][0] = round($item->descto,2);
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['Amount']['tag'] = 'cbc';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['Amount']['atr']['currencyID'] = $header[0]->isomoneda;

                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['BaseAmount'][0] = round($item->valorventa+$item->descto,2);
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['BaseAmount']['tag'] = 'cbc';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['AllowanceCharge']['child']['BaseAmount']['atr']['currencyID'] = $header[0]->isomoneda;
            }
            $TaxExemptionReasonCode = $item->idafectaciond;
            if($item->idafectaciond == 10){
                $impuestos = round(($item->igv + $item->isc),2);
                $basecalculo = round(($item->igv / 0.18), 2);
                $impuesto = round($item->igv,2);
                $TaxCategoryID = 'S';
                $Percent = '18.00';
                $TaxSchemeID = 1000;
                $TaxSchemeName = 'IGV';
                $TaxSchemeTaxTypeCode = 'VAT';
            }elseif ($item->idafectaciond>=11 && $item->idafectaciond<=17) {
                $impuestos = '0.00';
                $impuesto = '0.00';
                $basecalculo = '0.00';
                $TaxCategoryID = 'Z';
                $Percent = '18.00';
                $TaxSchemeID = 9996;
                $TaxSchemeName = 'GRA';
                $TaxSchemeTaxTypeCode = 'FRE';

            }elseif ($item->idafectaciond==20) {
                $impuestos = "0.00";
                $basecalculo = "0.00";
                $impuesto = round($item->valorventa,2);
                $TaxCategoryID = 'E';
                $Percent = '18.00';
                $TaxSchemeID = 9997;
                $TaxSchemeName = 'EXONERADO';
                $TaxSchemeTaxTypeCode = 'VAT';

            }elseif ($item->idafectaciond==21) {
                $impuestos = '0.00';
                $basecalculo = '0.00';
                $impuesto = '0.00';
                $TaxCategoryID = 'E';
                $Percent = '18.00';
                $TaxSchemeID = 9996;
                $TaxSchemeName = 'GRA';
                $TaxSchemeTaxTypeCode = 'FRE';

            }elseif ($item->idafectaciond==30) {
                $impuestos = '0.00';
                $basecalculo = '0.00';
                $impuesto = round($item->valorventa,2);
                $TaxCategoryID = 'O';
                $Percent = '18.00';
                $TaxSchemeID = 9998;
                $TaxSchemeName = 'INA';
                $TaxSchemeTaxTypeCode = 'FRE';

            }elseif ($item->idafectaciond>=31 && $item->idafectaciond<=36) {
                $impuestos = '0.00';
                $basecalculo = '0.00';
                $impuesto = '0.00';
                $TaxCategoryID = 'E';
                $Percent = '18.00';
                $TaxSchemeID = 9996;
                $TaxSchemeName = 'GRA';
                $TaxSchemeTaxTypeCode = 'FRE';
            }


            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['tag'] = 'cac';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['TaxAmount'][0] = $impuestos;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['TaxAmount']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['tag'] = 'cac';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxableAmount'][0] = $basecalculo;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxableAmount']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxableAmount']['atr']['currencyID'] = $header[0]->isomoneda;

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxAmount'][0] = $impuesto;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxAmount']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['tag'] = 'cac';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['ID'][0] = $TaxCategoryID;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5305';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeName'] = 'Tax Category Identifier';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeAgencyName'] = 'United Nations Economic Commission for Europe';

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['Percent'][0] = $Percent;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['Percent']['tag'] = 'cbc';

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxExemptionReasonCode'][0] = $item->idafectaciond;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxExemptionReasonCode']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxExemptionReasonCode']['atr']['listAgencyName'] = 'PE:SUNAT';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxExemptionReasonCode']['atr']['listName'] = 'SUNAT:Codigo de Tipo de Afectación del IGV';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxExemptionReasonCode']['atr']['listURI'] = 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07';

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['tag'] = 'cac';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID'][0] = $TaxSchemeID;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5153';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeAgencyID'] = '6';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name'][0] = $TaxSchemeName;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode'][0] = $TaxSchemeTaxTypeCode;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][1]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode']['tag'] = 'cbc';

            if($item->isc>0){
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['tag'] = 'cac';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['TaxAmount'][0] = round($item->isc,2);
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['TaxAmount']['tag'] = 'cbc';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['tag'] = 'cac';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxableAmount'][0] = round(($item->isc / ($item->porisc/100)), 2);
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxableAmount']['tag'] = 'cbc';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxableAmount']['atr']['currencyID'] = $header[0]->isomoneda;

                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxAmount'][0] = round($item->isc,2);
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxAmount']['tag'] = 'cbc';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxAmount']['atr']['currencyID'] = $header[0]->isomoneda;

                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['tag'] = 'cac';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['ID'][0] = 'S';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['tag'] = 'cbc';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5305';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeName'] = 'Tax Category Identifier';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['ID']['atr']['schemeAgencyName'] = 'United Nations Economic Commission for Europe';

                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['Percent'][0] = $item->porisc;
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['Percent']['tag'] = 'cbc';

                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxExemptionReasonCode'][0] = '10';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxExemptionReasonCode']['tag'] = 'cbc';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxExemptionReasonCode']['atr']['listAgencyName'] = 'PE:SUNAT';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxExemptionReasonCode']['atr']['listName'] = 'SUNAT:Codigo de Tipo de Afectación del IGV';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxExemptionReasonCode']['atr']['listURI'] = 'urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07';

                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['tag'] = 'cac';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID'][0] = '1000';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['tag'] = 'cbc';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeID'] = 'UN/ECE 5153';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['ID']['atr']['schemeAgencyID'] = '6';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name'][0] = 'IGV';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['Name']['tag'] = 'cbc';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode'][0] = 'VAT';
                $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['TaxTotal']['child']['childs'][2]['TaxSubtotal']['child']['TaxCategory']['child']['TaxScheme']['child']['TaxTypeCode']['tag'] = 'cbc';
            }
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Item']['tag'] = 'cac';
            //$arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Item']['child']['Description'][0] = '*'.format_description((($item->detalle==null) ? $item->cdsc : $item->detalle));
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Item']['child']['Description'][0] = '*'.format_description($item->detalle);
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Item']['child']['Description']['tag'] = 'cbc';

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Item']['child']['SellersItemIdentification']['tag'] = 'cac';
            //$arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Item']['child']['SellersItemIdentification']['child']['ID'][0] = (($item->idproducto=='0') ? $item->nro : $item->codigo);
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Item']['child']['SellersItemIdentification']['child']['ID'][0] = $item->codigo;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Item']['child']['SellersItemIdentification']['child']['ID']['tag'] = 'cbc';

            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Price']['tag'] = 'cac';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Price']['child']['PriceAmount'][0] = $item->valorunitario;
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Price']['child']['PriceAmount']['tag'] = 'cbc';
            $arr['doc'][$tipodoc]['child']['childs'][$row+1]['InvoiceLine']['child']['Price']['child']['PriceAmount']['atr']['currencyID'] = $header[0]->isomoneda;
        }
    }
}

function arr_DespatchAdviceTypeCode($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['DespatchAdviceTypeCode'] = str_pad($header[0]->idcomprobante, 2, '0', STR_PAD_LEFT); //'01';
}

function arr_OrderReference($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['OrderReference']['child']['ID'][0] = $header[0]->orderreference;
}

function arr_LineCountNumeric($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['LineCountNumeric'][0] = count($detalle);
    $arr['doc'][$tipodoc]['child']['LineCountNumeric']['tag'] = 'cbc';
}

function arr_DespatchSupplierParty($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['DespatchSupplierParty']['CustomerAssignedAccountID']['AccountID'] = $empresa[0]->idempresa;
    $arr['doc'][$tipodoc]['child']['DespatchSupplierParty']['CustomerAssignedAccountID']['schemeID'] = $empresa[0]->idtipodni;
    $arr['doc'][$tipodoc]['child']['DespatchSupplierParty']['Party']['PartyName']['Name'] = $empresa[0]->nomcomercial;
    $arr['doc'][$tipodoc]['child']['DespatchSupplierParty']['Party']['PartyLegalEntity']['RegistrationName'] = $empresa[0]->razon;
}


function arr_DeliveryCustomerParty($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['DeliveryCustomerParty']['CustomerAssignedAccountID']['AccountID'] = $header[0]->identidad;
    $arr['doc'][$tipodoc]['child']['DeliveryCustomerParty']['CustomerAssignedAccountID']['schemeID'] = $header[0]->idtipodni;
    $arr['doc'][$tipodoc]['child']['DeliveryCustomerParty']['Party']['PartyLegalEntity']['RegistrationName'] = $header[0]->razon;
}
function arr_Shipment($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['Shipment']['HandlingCode'] = str_pad($header[0]->idmotivo, 2, '0', STR_PAD_LEFT);
    $arr['doc'][$tipodoc]['child']['Shipment']['Information'] = $header[0]->motivo;
    $arr['doc'][$tipodoc]['child']['Shipment']['SplitConsignmentIndicator'] = (($header[0]->programado=='1') ? 'true' : 'false');
    $arr['doc'][$tipodoc]['child']['Shipment']['GrossWeightMeasure']['Measure'] = $header[0]->pesobruto;
    $arr['doc'][$tipodoc]['child']['Shipment']['GrossWeightMeasure']['unitCode'] = 'KGM';
    $arr['doc'][$tipodoc]['child']['Shipment']['TotalTransportHandlingUnitQuantity'] = $header[0]->bultos;

    $arr['doc'][$tipodoc]['child']['Shipment']['ShipmentStage']['TransportModeCode'] = str_pad($header[0]->idmodetra, 2, '0', STR_PAD_LEFT);
    $arr['doc'][$tipodoc]['child']['Shipment']['ShipmentStage']['TransitPeriod']['StartDate'] = $header[0]->fectra;

    /*transporte publico*/
    $arr['doc'][$tipodoc]['child']['Shipment']['ShipmentStage']['CarrierParty']['PartyIdentification']['ID']['ID'] = $header[0]->idtransporte;
    $arr['doc'][$tipodoc]['child']['Shipment']['ShipmentStage']['CarrierParty']['PartyIdentification']['ID']['schemeID'] = $header[0]->idtipodnit;
    $arr['doc'][$tipodoc]['child']['Shipment']['ShipmentStage']['CarrierParty']['PartyName']['Name'] = $header[0]->transporte;

    /*transporte privado*/
    $arr['doc'][$tipodoc]['child']['Shipment']['ShipmentStage']['DriverPerson']['ID']['ID'] = $header[0]->idconductor;
    $arr['doc'][$tipodoc]['child']['Shipment']['ShipmentStage']['DriverPerson']['ID']['schemeID'] = $header[0]->idtipodnic;
    /*solo si es privado*/
    /*placa vehiculo*/
    $arr['doc'][$tipodoc]['child']['Shipment']['ShipmentStage']['TransportMeans']['RoadTransport']['LicensePlateID'] = $header[0]->placa;
    $arr['doc'][$tipodoc]['child']['Shipment']['ShipmentStage']['DriverPerson']['ID']['schemeID'] = $header[0]->idtipodnic;
    /*Punto de llegada*/
    $arr['doc'][$tipodoc]['child']['Shipment']['Delivery']['DeliveryAddress']['ID'] = $header[0]->iddistritod;
    $arr['doc'][$tipodoc]['child']['Shipment']['Delivery']['DeliveryAddress']['StreetName'] = $header[0]->direcciond;

    /*Punto de partida*/
    $arr['doc'][$tipodoc]['child']['Shipment']['OriginAddress']['ID'] = $header[0]->iddistritop;
    $arr['doc'][$tipodoc]['child']['Shipment']['OriginAddress']['StreetName'] = $header[0]->direccionp;

}




function arr_PrepaidPayment($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if($header[0]->totanti>0){
        if($tipodoc == 'DebitNote'){
            $arr['doc'][$tipodoc]['child']['RequestedMonetaryTotal']['PrepaidAmount']['currencyID'] = $header[0]->isomoneda;
            $arr['doc'][$tipodoc]['child']['RequestedMonetaryTotal']['PrepaidAmount']['Amount'] = round($header[0]->totanti,2);
        }else{
            $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['PrepaidAmount']['currencyID'] = $header[0]->isomoneda;
            $arr['doc'][$tipodoc]['child']['LegalMonetaryTotal']['PrepaidAmount']['Amount'] = round($header[0]->totanti,2);
        }

        $arr['doc'][$tipodoc]['child']['PrepaidPayment']['ID']['schemeID'] = str_pad($header[0]->iddoctributario, 2, '0', STR_PAD_LEFT);
        $arr['doc'][$tipodoc]['child']['PrepaidPayment']['ID']['ID'] = $header[0]->iddoctriref;
        $arr['doc'][$tipodoc]['child']['PrepaidPayment']['PaidAmount']['Amount'] = round($header[0]->totanti,2);
        $arr['doc'][$tipodoc]['child']['PrepaidPayment']['PaidAmount']['currencyID'] = $header[0]->isomoneda;
        $arr['doc'][$tipodoc]['child']['PrepaidPayment']['InstructionID']['schemeID'] = $empresa[0]->idtipodni;
        $arr['doc'][$tipodoc]['child']['PrepaidPayment']['InstructionID']['InstructionID'] = $empresa[0]->idempresa;
    }
}




function arr_VoidedDocumentsLine($header, $detalle, $empresa, $tipodoc){
    global $arr;
    foreach ($detalle as $row => $item) {
        $arr['doc'][$tipodoc]['child']['VoidedDocumentsLine'][$row+1]['LineID'] = $item->lineid;
        $arr['doc'][$tipodoc]['child']['VoidedDocumentsLine'][$row+1]['DocumentTypeCode'] = str_pad($item->idcomprobante, 2, '0', STR_PAD_LEFT); //'01';
        $arr['doc'][$tipodoc]['child']['VoidedDocumentsLine'][$row+1]['DocumentSerialID'] = $item->serie;
        $arr['doc'][$tipodoc]['child']['VoidedDocumentsLine'][$row+1]['DocumentNumberID'] = $item->numdoc;
        $arr['doc'][$tipodoc]['child']['VoidedDocumentsLine'][$row+1]['VoidReasonDescription'] = $item->voidreasondescription;
    }
}

function arr_DespatchLine($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if(count($detalle)>0){
        foreach ($detalle as $row => $item) {
            $arr['doc'][$tipodoc]['child']['DespatchLine'][$row+1]['ID'] = $item->nro;
            $arr['doc'][$tipodoc]['child']['DespatchLine'][$row+1]['OrderLineReference']['LineID'] = $item->nro;
            $arr['doc'][$tipodoc]['child']['DespatchLine'][$row+1]['DeliveredQuantity']['unitCode'] = $item->idmedida;
            $arr['doc'][$tipodoc]['child']['DespatchLine'][$row+1]['DeliveredQuantity']['Quantity'] = round($item->cantidad,10);
            $arr['doc'][$tipodoc]['child']['DespatchLine'][$row+1]['Item']['Name'] = $item->cdsc;
            $arr['doc'][$tipodoc]['child']['DespatchLine'][$row+1]['Item']['SellersItemIdentification']['ID'] = (($item->idproducto=='0') ? $item->nro : $item->codigo);
        }
    }
}
function arr_DiscrepancyResponse($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['DiscrepancyResponse']['ReferenceID'] = $header[0]->referenceid;
    $arr['doc'][$tipodoc]['child']['DiscrepancyResponse']['ResponseCode'] = str_pad($header[0]->idtiponotacredito, 2, '0', STR_PAD_LEFT);
    $arr['doc'][$tipodoc]['child']['DiscrepancyResponse']['Description'] = $header[0]->description;
}
function arr_BillingReference($header, $detalle, $empresa, $tipodoc){
    global $arr;
    $arr['doc'][$tipodoc]['child']['BillingReference']['InvoiceDocumentReference']['ID'] = $header[0]->referenceid;
    $arr['doc'][$tipodoc]['child']['BillingReference']['InvoiceDocumentReference']['DocumentTypeCode'] = str_pad($header[0]->referencedocumenttypecode, 2, '0', STR_PAD_LEFT);
}
function arr_CreditNoteLine($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if(count($detalle)>0){
        foreach ($detalle as $row => $item) {
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['ID'] = $item->nro;
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['CreditedQuantity']['unitCode'] = $item->idmedida;
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['CreditedQuantity']['Quantity'] = round($item->cantidad,10);
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['Item']['SellersItemIdentification']['ID'] = (($item->idproducto=='0') ? $item->nro : $item->codigo);
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['Item']['Description'] = format_description((($item->detalle==null) ? $item->cdsc : $item->detalle));
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['Price']['PriceAmount']['Price'] = round($item->precio, 2);
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['Price']['PriceAmount']['currencyID'] = $header[0]->isomoneda;
            if($item->idafectaciond == 10){
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';
            }elseif ($item->idafectaciond>=11 && $item->idafectaciond<=17) {
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = '0.00';
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';

                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceTypeCode'] = '02';

            }elseif ($item->idafectaciond==20) {
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';
            }elseif ($item->idafectaciond==21) {
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = '0.00';
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';

                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceTypeCode'] = '02';
            }elseif ($item->idafectaciond==30) {
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';
            }elseif ($item->idafectaciond>=31 && $item->idafectaciond<=36) {
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = '0.00';
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';

                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceTypeCode'] = '02';
            }
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][1]['TaxAmount']['currencyID'] = $header[0]->isomoneda;
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][1]['TaxAmount']['Amount'] = round($item->igv,2);
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxAmount']['currencyID'] = $header[0]->isomoneda;
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxAmount']['Amount'] = round($item->igv,2);;

            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxExemptionReasonCode'] = $item->idafectaciond;
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxScheme']['ID'] = '1000';
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxScheme']['Name'] = 'IGV';
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxScheme']['TaxTypeCode'] = 'VAT';

            if($item->idtiposcisc !=0){
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][2]['TaxAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][2]['TaxAmount']['Amount'] = round($item->isc,2);
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxAmount']['Amount'] = round($item->isc,2);
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TierRange'] = $item->idtiposcisc;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TaxScheme']['ID'] = '200';
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TaxScheme']['Name'] = 'ISC';
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TaxScheme']['TaxTypeCode'] = 'EXC';
            }
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['LineExtensionAmount']['currencyID'] = $header[0]->isomoneda;
            $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['LineExtensionAmount']['Amount'] = round($item->valorventa,2);
            if($item->descto > 0){
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['AllowanceCharge']['ChargeIndicator'] = 'false';
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['AllowanceCharge']['Amount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['CreditNoteLine'][$row+1]['AllowanceCharge']['Amount']['Amount'] = round($item->descto,2);
            }
        }
    }
}
function arr_DebitNoteLine($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if(count($detalle)>0){
        foreach ($detalle as $row => $item) {
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['ID'] = $item->nro;
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['DebitedQuantity']['unitCode'] = $item->idmedida;
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['DebitedQuantity']['Quantity'] = round($item->cantidad,10);
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['Item']['SellersItemIdentification']['ID'] = (($item->idproducto=='0') ? $item->nro : $item->codigo);
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['Item']['Description'] = format_description((($item->detalle==null) ? $item->cdsc : $item->detalle));
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['Price']['PriceAmount']['Price'] = round($item->precio, 2);
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['Price']['PriceAmount']['currencyID'] = $header[0]->isomoneda;
            if($item->idafectaciond == 10){
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';
            }elseif ($item->idafectaciond>=11 && $item->idafectaciond<=17) {
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = '0.00';
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';

                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceTypeCode'] = '02';

            }elseif ($item->idafectaciond==20) {
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';
            }elseif ($item->idafectaciond==21) {
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = '0.00';
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';

                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceTypeCode'] = '02';
            }elseif ($item->idafectaciond==30) {
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';
            }elseif ($item->idafectaciond>=31 && $item->idafectaciond<=36) {
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceAmount']['Price'] = '0.00';
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][1]['PriceTypeCode'] = '01';

                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceAmount']['Price'] = round($item->valorref,2);
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['PricingReference']['AlternativeConditionPrice'][2]['PriceTypeCode'] = '02';
            }
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][1]['TaxAmount']['currencyID'] = $header[0]->isomoneda;
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][1]['TaxAmount']['Amount'] = round($item->igv,2);
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxAmount']['currencyID'] = $header[0]->isomoneda;
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxAmount']['Amount'] = round($item->igv,2);;

            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxExemptionReasonCode'] = $item->idafectaciond;
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxScheme']['ID'] = '1000';
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxScheme']['Name'] = 'IGV';
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxScheme']['TaxTypeCode'] = 'VAT';

            if($item->idtiposcisc !=0){
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][2]['TaxAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][2]['TaxAmount']['Amount'] = round($item->isc,2);
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxAmount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxAmount']['Amount'] = round($item->isc,2);
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TierRange'] = $item->idtiposcisc;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TaxScheme']['ID'] = '200';
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TaxScheme']['Name'] = 'ISC';
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TaxScheme']['TaxTypeCode'] = 'EXC';
            }
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['LineExtensionAmount']['currencyID'] = $header[0]->isomoneda;
            $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['LineExtensionAmount']['Amount'] = round($item->valorventa,2);
            if($item->descto > 0){
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['AllowanceCharge']['ChargeIndicator'] = 'false';
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['AllowanceCharge']['Amount']['currencyID'] = $header[0]->isomoneda;
                $arr['doc'][$tipodoc]['child']['DebitNoteLine'][$row+1]['AllowanceCharge']['Amount']['Amount'] = round($item->descto,2);
            }
        }
    }
}
function arr_RequestedMonetaryTotal($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if($header[0]->desctoglobal>0){
        $arr['doc'][$tipodoc]['child']['RequestedMonetaryTotal']['AllowanceTotalAmount']['currencyID'] = $header[0]->isomoneda;
        $arr['doc'][$tipodoc]['child']['RequestedMonetaryTotal']['AllowanceTotalAmount']['TotalAmount'] = round($header[0]->desctoglobal,2);
    }
    if($header[0]->tototroca>0){
        $arr['doc'][$tipodoc]['child']['RequestedMonetaryTotal']['ChargeTotalAmount']['currencyID'] = $header[0]->isomoneda;
        $arr['doc'][$tipodoc]['child']['RequestedMonetaryTotal']['ChargeTotalAmount']['TotalAmount'] = round($header[0]->tototroca,2);
    }

    $arr['doc'][$tipodoc]['child']['RequestedMonetaryTotal']['PayableAmount']['currencyID'] = $header[0]->isomoneda;
    $arr['doc'][$tipodoc]['child']['RequestedMonetaryTotal']['PayableAmount']['TotalAmount'] = round($header[0]->importetotal,2);

    if($header[0]->totanti>0){
        $arr['doc'][$tipodoc]['child']['RequestedMonetaryTotal']['PrepaidAmount']['currencyID'] = $header[0]->isomoneda;
        $arr['doc'][$tipodoc]['child']['RequestedMonetaryTotal']['PrepaidAmount']['Amount'] = round($header[0]->totanti,2);
    }
}
function arr_SummaryDocumentsLine($header, $detalle, $empresa, $tipodoc){
    global $arr;
    if(count($detalle)>0){
        foreach ($detalle as $row => $item) {
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['LineID'] = $item->nro;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['DocumentTypeCode'] = str_pad($item->idcomprobante, 2, '0', STR_PAD_LEFT);
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['ID'] = $item->serie.'-'.$item->numero;
            /*$arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['DocumentSerialID'] = $item->serie;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['StartDocumentNumberID'] = $item->startdocumentnumberid;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['EndDocumentNumberID'] = $item->enddocumentnumberid;*/
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['AccountingCustomerParty']['CustomerAssignedAccountID'] = $item->identidad;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['AccountingCustomerParty']['AdditionalAccountID'] = $item->idtipodni;

            if($item->idcomprobante == '7' || $item->idcomprobante == '8' ){
                //sac:SummaryDocumentsLine/cac:BillingReference/cac:InvoiceDocumentReference/cbc:ID
                $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingReference']['InvoiceDocumentReference']['ID']  = $item->invoicedocumentreference;
                //sac:SummaryDocumentsLine/cac:BillingReference/cac:InvoiceDocumentReference/cbc:DocumentTypeCode
                $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingReference']['InvoiceDocumentReference']['documenttypecode']  = $item->documenttypecode;
            }

            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['Status']['ConditionCode'] = $item->conditioncode;

            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TotalAmount']['Amount'] = round($item->importetotal,2);
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TotalAmount']['currencyID'] = $item->isomoneda;
            $nBi=0;
            if($item->totopgra>0){
            $nBi++;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingPayment'][$nBi]['PaidAmount']['Amount'] = round($item->totopgra,2);
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingPayment'][$nBi]['PaidAmount']['currencyID'] = $item->isomoneda;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingPayment'][$nBi]['InstructionID'] = '01';
            }
            if($item->totopexo>0){
                $nBi++;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingPayment'][$nBi]['PaidAmount']['Amount'] = round($item->totopexo,2);
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingPayment'][$nBi]['PaidAmount']['currencyID'] = $item->isomoneda;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingPayment'][$nBi]['InstructionID'] = '02';
            }
            if($item->totopina>0){
                $nBi++;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingPayment'][$nBi]['PaidAmount']['Amount'] = round($item->totopina,2);
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingPayment'][$nBi]['PaidAmount']['currencyID'] = $item->isomoneda;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['BillingPayment'][$nBi]['InstructionID'] = '03';
            }
            if($item->tototroca>0){
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['AllowanceCharge']['ChargeIndicator'] = 'true';
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['AllowanceCharge']['Amount']['Amount'] = round($item->tototroca,2);
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['AllowanceCharge']['Amount']['currencyID'] = $item->isomoneda;
            }
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][1]['TaxAmount']['currencyID'] = $item->isomoneda;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][1]['TaxAmount']['Amount'] = round($item->totisc,2);

            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxAmount']['currencyID'] = $item->isomoneda;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxAmount']['Amount'] = round($item->totisc,2);
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxScheme']['ID'] = '2000';
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxScheme']['Name'] = 'ISC';
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][1]['TaxSubtotal']['TaxCategory']['TaxScheme']['TaxTypeCode'] = 'EXC';

            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][2]['TaxAmount']['currencyID'] = $item->isomoneda;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][2]['TaxAmount']['Amount'] = round($item->totigv,2);
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxAmount']['currencyID'] = $item->isomoneda;
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxAmount']['Amount'] = round($item->totigv,2);;

            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TaxScheme']['ID'] = '1000';
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TaxScheme']['Name'] = 'IGV';
            $arr['doc'][$tipodoc]['child']['SummaryDocumentsLine'][$row+1]['TaxTotal'][2]['TaxSubtotal']['TaxCategory']['TaxScheme']['TaxTypeCode'] = 'VAT';
        }
    }
}
function format_description($cadena){
    $description = preg_replace('/\s+/', ' ', $cadena);
    return $description;
}
?>
