<?php

namespace BaseetApp\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class ExtensionContent implements XmlSerializable
{

    private $UBLDocumentSignatures;



    /**
     * @param UBLDocumentSignatures $UBLDocumentSignatures
     * @return ExtensionContent
     */
    public function setUBLDocumentSignatures(UBLDocumentSignatures $UBLDocumentSignatures): ExtensionContent
    {
        $this->UBLDocumentSignatures = $UBLDocumentSignatures;
        return $this;
    }


    /**
     * The xmlSerialize method is called during xml writing.
     *
     * @param Writer $writer
     * @return void
     */
    public function xmlSerialize(Writer $writer)
    {
        $writer->write([
            Schema::EXT . 'ExtensionContent' => $this->UBLDocumentSignatures
        ]);
    }
}
