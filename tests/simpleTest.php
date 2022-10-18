<?php

// Address country
$country = (new \BaseetApp\UBL\Country())
    ->setIdentificationCode('SA');

// Full address
$address = (new \BaseetApp\UBL\Address())
    ->setStreetName('Korenmarkt')
    ->setBuildingNumber(1)
    ->setCityName('Gent')
    ->setPostalZone('9000')
    ->setCountry($country);

$legalEt = (new \BaseetApp\UBL\LegalEntity())
    ->setRegistrationName('Example Co. LTD');
// Supplier company node
$supplierCompany = (new \BaseetApp\UBL\Party())
    ->setPartyIdentificationId("132131")
    ->setLegalEntity($legalEt)
    ->setName('Supplier Company Name')
    ->setPhysicalLocation($address)
    ->setPostalAddress($address);

// Client contact node
$clientContact = (new \BaseetApp\UBL\Contact())
    ->setName('Client name')
    ->setElectronicMail('email@client.com')
    ->setTelephone('0032 472 123 456')
    ->setTelefax('0032 9 1234 567');

// Client company node
$clientCompany = (new \BaseetApp\UBL\Party())
    ->setName('My client')
    ->setPostalAddress($address)
    ->setContact($clientContact);

$legalMonetaryTotal = (new \BaseetApp\UBL\LegalMonetaryTotal())
    ->setLineExtensionAmount(0)
    ->setTaxExclusiveAmount(0)
    ->setTaxInclusiveAmount(12)
    ->setPayableAmount(10 + 2)
    ->setAllowanceTotalAmount(0);

// Tax scheme
$taxScheme = (new \BaseetApp\UBL\TaxScheme())
    ->setId("VAT");

$classifiedTax = (new \BaseetApp\UBL\ClassifiedTaxCategory())
    ->setPercent(21)
    ->setTaxScheme($taxScheme);
// Product
$productItem = (new \BaseetApp\UBL\Item())
    ->setName('Product Name')
    ->setClassifiedTaxCategory($classifiedTax)
    ->setDescription('Product Description')
    ->setSellersItemIdentification('SELLERID');

// Price
$price = (new \BaseetApp\UBL\Price())
    ->setBaseQuantity(1)
    ->setUnitCode(\BaseetApp\UBL\UnitCode::UNIT)
    ->setPriceAmount(200);

// Invoice Line tax totals
$lineTaxTotal = (new \BaseetApp\UBL\TaxTotal())
    ->setTaxAmount(15);

// InvoicePeriod
$invoicePeriod = (new \BaseetApp\UBL\InvoicePeriod())
    ->setStartDate(new \DateTime());

// Invoice Line(s)
$invoiceLines = [];

$invoiceLines[] = (new \BaseetApp\UBL\InvoiceLine())
    ->setUnitCode("PCE")
    ->setId(0)
    ->setItem($productItem)
    ->setInvoicePeriod($invoicePeriod)
    ->setPrice($price)
    ->setTaxTotal($lineTaxTotal)
    ->setInvoicedQuantity(1);

$invoiceLines[] = (new \BaseetApp\UBL\InvoiceLine())
    ->setId(0)
    ->setItem($productItem)
    ->setInvoicePeriod($invoicePeriod)
    ->setPrice($price)
    ->setAccountingCost('Product 123')
    ->setTaxTotal($lineTaxTotal)
    ->setUnitCode("PCE")
    ->setInvoicedQuantity(1);

$invoiceLines[] = (new \BaseetApp\UBL\InvoiceLine())
    ->setUnitCode("PCE")

    ->setId(0)
    ->setItem($productItem)
    ->setInvoicePeriod($invoicePeriod)
    ->setPrice($price)
    ->setAccountingCostCode('Product 123')
    ->setTaxTotal($lineTaxTotal)
    ->setInvoicedQuantity(1);


// Total Taxes
$taxCategory = (new \BaseetApp\UBL\TaxCategory())
    ->setPercent(21)
    ->setTaxScheme($taxScheme);

$taxSubTotal = (new \BaseetApp\UBL\TaxSubTotal())
    ->setTaxableAmount(900)
    ->setTaxAmount(189)
    ->setTaxCategory($taxCategory);


$taxTotal = (new \BaseetApp\UBL\TaxTotal())
    ->addTaxSubTotal($taxSubTotal)
    ->setTaxAmount(189);


$sign = (new \BaseetApp\UBL\SignatureInformation)
    ->setReferencedSignatureID("urn:oasis:names:specification:ubl:signature:Invoice")
    ->setID('urn:oasis:names:specification:ubl:signature:1');


$ublDecoment = (new \BaseetApp\UBL\UBLDocumentSignatures)
    ->setSignatureInformation($sign);

$extensionContent = (new \BaseetApp\UBL\ExtensionContent)
    ->setUBLDocumentSignatures($ublDecoment);

$UBLExtension[] = (new \BaseetApp\UBL\UBLExtension)
    ->setExtensionURI('urn:oasis:names:specification:ubl:dsig:enveloped:xades')
    ->setExtensionContent($extensionContent);

$UBLExtensions = (new \BaseetApp\UBL\UBLExtensions)
    ->setUBLExtensions($UBLExtension);

// Invoice object
$invoice = (new \BaseetApp\UBL\Invoice())
    ->setUBLExtensions($UBLExtensions)
    ->setUUID('3cf5ee18-ee25-44ea-a444-2c37ba7f28be')
    ->setId(1234)
    ->setIssueDate(new \DateTime())
    ->setIssueTime((new \DateTime()))
    ->setAccountingSupplierParty($supplierCompany)
    ->setAccountingCustomerParty($clientCompany)
    ->setSupplierAssignedAccountID('10001')
    ->setInvoiceLines($invoiceLines)
    ->setLegalMonetaryTotal($legalMonetaryTotal)
    ->setTaxTotal($taxTotal);

$generator = new \BaseetApp\UBL\Generator();
$outputXMLString = $generator->invoice($invoice);

// Create PHP Native DomDocument object, that can be
// used to validate the generate XML
$dom = new \DOMDocument;
$dom->loadXML($outputXMLString);
//$dom->save(public_path('num.xml'));
