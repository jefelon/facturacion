<?php
$xml_factura = '<?xml version="1.0" encoding="UTF-8"?>
<Invoice xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ccts="urn:un:unece:uncefact:documentation:2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2" xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2" xmlns:udt="urn:un:unece:uncefact:data:specification:UnqualifiedDataTypesSchemaModule:2" xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2">
  <ext:UBLExtensions>
    <ext:UBLExtension>
      <ext:ExtensionContent>
      </ext:ExtensionContent>
    </ext:UBLExtension>
  </ext:UBLExtensions>
  <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
  <cbc:CustomizationID>2.0</cbc:CustomizationID>
  <cbc:ID>'.$arr['header']->serie .'-'. $arr['header']->numero.'</cbc:ID>
  <cbc:IssueDate>'.date_format(date_create($arr["header"]->fechadoc), "Y-m-d").'</cbc:IssueDate>
  <cbc:IssueTime>'.date_format(date_create($arr['header']->issuetime), 'H:i:s').'</cbc:IssueTime>
  <cbc:DueDate>'.date_format(date_create($arr["header"]->fechavence), "Y-m-d").'</cbc:DueDate>
  <cbc:InvoiceTypeCode listID="0101" listAgencyName="PE:SUNAT" listName="Tipo de Documento" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo01" name="Tipo de Operacion" listSchemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo51">0'.$arr["header"]->idcomprobante.'</cbc:InvoiceTypeCode>
  <cbc:Note languageLocaleID="1000">'.$arr["header"]->AdditionalProperty_Value.'</cbc:Note>
  <cbc:DocumentCurrencyCode listID="ISO 4217 Alpha" listAgencyName="United Nations Economic Commission for Europe" listName="Currency">'.$arr["header"]->isomoneda.'</cbc:DocumentCurrencyCode>
  <cac:Signature>
    <cbc:ID>'.$arr["empresa"]->idempresa.'</cbc:ID>
    <cbc:Note>WWW.AQPFACT.PE</cbc:Note>
    <cac:SignatoryParty>
      <cac:PartyIdentification>
        <cbc:ID>'.$arr["empresa"]->idempresa.'</cbc:ID>
      </cac:PartyIdentification>
      <cac:PartyName>
        <cbc:Name>'.$arr["empresa"]->razon.'</cbc:Name>
      </cac:PartyName>
    </cac:SignatoryParty>
    <cac:DigitalSignatureAttachment>
      <cac:ExternalReference>
        <cbc:URI>'.$arr["empresa"]->idempresa.'</cbc:URI>
      </cac:ExternalReference>
    </cac:DigitalSignatureAttachment>
  </cac:Signature>
  <cac:AccountingSupplierParty>
    <cac:Party>
      <cac:PartyIdentification>
        <cbc:ID schemeID="6" schemeName="Documento de Identidad" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">'.$arr["empresa"]->idempresa.'</cbc:ID>
      </cac:PartyIdentification>
      <cac:PartyName>
        <cbc:Name>'.$arr["empresa"]->razon.'</cbc:Name>
      </cac:PartyName>
      <cac:PartyLegalEntity>
        <cbc:RegistrationName>'.$arr["empresa"]->razon.'</cbc:RegistrationName>
        <cac:RegistrationAddress>
          <cbc:ID schemeName="Ubigeos" schemeAgencyName="PE:INEI">'.$arr["empresa"]->iddistrito.'</cbc:ID>
          <cbc:AddressTypeCode listAgencyName="PE:SUNAT" listName="Establecimientos anexos">'.$arr["empresa"]->punto_venta_cod.'</cbc:AddressTypeCode>
          <cbc:CityName>'.$arr["empresa"]->provincia.'</cbc:CityName>
          <cbc:CountrySubentity>'.$arr["empresa"]->departamento.'</cbc:CountrySubentity>
          <cbc:District>'.$arr["empresa"]->distrito.'</cbc:District>
          <cac:AddressLine>
            <cbc:Line>'.$arr["empresa"]->direccion.'</cbc:Line>
          </cac:AddressLine>
          <cac:Country>
            <cbc:IdentificationCode listID="ISO 3166-1" listAgencyName="United Nations Economic Commission for Europe" listName="Country">PE</cbc:IdentificationCode>
          </cac:Country>
        </cac:RegistrationAddress>
      </cac:PartyLegalEntity>
    </cac:Party>
  </cac:AccountingSupplierParty>
  <cac:AccountingCustomerParty>
    <cac:Party>
      <cac:PartyIdentification>
        <cbc:ID schemeID="'.$arr['header']->idtipodni.'" schemeName="Documento de Identidad" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo06">'.$arr['header']->identidad.'</cbc:ID>
      </cac:PartyIdentification>
      <cac:PartyLegalEntity>
        <cbc:RegistrationName><![CDATA['.$arr['header']->razon.']]></cbc:RegistrationName>
      </cac:PartyLegalEntity>
    </cac:Party>
  </cac:AccountingCustomerParty>';
if($arr['header']->totopexo>0){
    $xml_factura.='
  <cac:TaxTotal>
    <cbc:TaxAmount currencyID="PEN">0.00</cbc:TaxAmount>
    <cac:TaxSubtotal>
      <cbc:TaxableAmount currencyID="PEN">'.$arr["header"]->totopexo.'</cbc:TaxableAmount>
      <cbc:TaxAmount currencyID="PEN">0.00</cbc:TaxAmount>
      <cac:TaxCategory>
        <cac:TaxScheme>
          <cbc:ID schemeName="Codigo de tributos" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05">9997</cbc:ID>
          <cbc:Name>EXO</cbc:Name>
          <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
        </cac:TaxScheme>
      </cac:TaxCategory>
    </cac:TaxSubtotal>
  </cac:TaxTotal>';
}
if($arr['header']->totopgra>0) {
    $xml_factura .= '
  <cac:TaxTotal>
    <cbc:TaxAmount currencyID="PEN">'.$arr["header"]->totigv.'</cbc:TaxAmount>
    <cac:TaxSubtotal>
      <cbc:TaxableAmount currencyID="PEN">'.$arr["header"]->totopgra.'</cbc:TaxableAmount>
      <cbc:TaxAmount currencyID="PEN">'.$arr["header"]->totigv.'</cbc:TaxAmount>
      <cac:TaxCategory>
        <cac:TaxScheme>
          <cbc:ID schemeName="Codigo de tributos" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05">1000</cbc:ID>
          <cbc:Name>IGV</cbc:Name>
          <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
        </cac:TaxScheme>
      </cac:TaxCategory>
    </cac:TaxSubtotal>
  </cac:TaxTotal>';
}

$xml_factura .= '
  <cac:LegalMonetaryTotal>
  <cbc:LineExtensionAmount currencyID="PEN">'.(($arr['header']->totopgra>0) ? $arr["header"]->totopgra : $arr["header"]->importetotal).'</cbc:LineExtensionAmount>
    <cbc:TaxInclusiveAmount currencyID="PEN">'.$arr["header"]->importetotal.'</cbc:TaxInclusiveAmount>
    <cbc:AllowanceTotalAmount currencyID="PEN">0.00</cbc:AllowanceTotalAmount>
    <cbc:ChargeTotalAmount currencyID="PEN">0.00</cbc:ChargeTotalAmount>
    <cbc:PrepaidAmount currencyID="PEN">0.00</cbc:PrepaidAmount>
    <cbc:PayableAmount currencyID="PEN">'.$arr["header"]->importetotal.'</cbc:PayableAmount>
  </cac:LegalMonetaryTotal>';

foreach ($arr['detalle'] as $row => $item) {
    $xml_factura .= '
  <cac:InvoiceLine>
    <cbc:ID>'.$item->nro.'</cbc:ID>
    <cbc:InvoicedQuantity unitCode="NIU" unitCodeListID="UN/ECE rec 20" unitCodeListAgencyName="United Nations Economic Commission for Europe">'.round($item->cantidad,10).'</cbc:InvoicedQuantity>
    <cbc:LineExtensionAmount currencyID="PEN">'.round($item->valorventa,2).'</cbc:LineExtensionAmount>
    <cac:PricingReference>
      <cac:AlternativeConditionPrice>
        <cbc:PriceAmount currencyID="PEN">'.(($item->idafectaciond == 10)? round($item->preciounitario,2): round($item->valorunitario,2)).'</cbc:PriceAmount>
        <cbc:PriceTypeCode listAgencyName="PE:SUNAT" listName="Tipo de Precio" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo16">01</cbc:PriceTypeCode>
      </cac:AlternativeConditionPrice>
    </cac:PricingReference>
    <cac:TaxTotal>
      <cbc:TaxAmount currencyID="PEN">'.(($item->idafectaciond == 10)? round($item->igv,2): "0.00").'</cbc:TaxAmount>
      <cac:TaxSubtotal>
        <cbc:TaxableAmount currencyID="PEN">'.round($item->valorventa,2).'</cbc:TaxableAmount>
        <cbc:TaxAmount currencyID="PEN">'.(($item->idafectaciond == 10)? round($item->igv,2): "0.00").'</cbc:TaxAmount>
        <cac:TaxCategory>
          <cbc:Percent>'.(($item->idafectaciond == 10)? "18.00" : "0.00").'</cbc:Percent>
          <cbc:TaxExemptionReasonCode listAgencyName="PE:SUNAT" listName="Afectacion del IGV" listURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo07">'.$item->idafectaciond.'</cbc:TaxExemptionReasonCode>
          <cac:TaxScheme>
            <cbc:ID schemeName="Codigo de tributos" schemeAgencyName="PE:SUNAT" schemeURI="urn:pe:gob:sunat:cpe:see:gem:catalogos:catalogo05">'.(($item->idafectaciond == 10)? "1000" : "9997").'</cbc:ID>
            <cbc:Name>'.(($item->idafectaciond == 10)? "IGV" : "EXO").'</cbc:Name>
            <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
          </cac:TaxScheme>
        </cac:TaxCategory>
      </cac:TaxSubtotal>
    </cac:TaxTotal>
    <cac:Item>
      <cbc:Description>'.$item->detalle.'</cbc:Description>
      <cac:SellersItemIdentification>
        <cbc:ID>'.(($item->idproducto=='0') ? $item->nro : $item->codigo).'</cbc:ID>
      </cac:SellersItemIdentification>
    </cac:Item>
    <cac:Price>
      <cbc:PriceAmount currencyID="PEN">'.round($item->valorref,2).'</cbc:PriceAmount>
    </cac:Price>
  </cac:InvoiceLine>';
}
$xml_factura .= '      
</Invoice>';

