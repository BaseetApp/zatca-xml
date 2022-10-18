<?php

namespace BaseetApp\UBL;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class SignatureInformation implements XmlSerializable
{

    private string $id;
    private string $referencedSignatureID;


    /**
     * @param string $id
     * @return SignatureInformation
     */
    public function setID(string $id): SignatureInformation
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return string
     */
    public function gettID(): string
    {
        return $this->id;
    }


    /**
     * @param string $referencedSignatureID
     * @return SignatureInformation
     */
    public function setReferencedSignatureID(string $referencedSignatureID): SignatureInformation
    {
        $this->referencedSignatureID = $referencedSignatureID;
        return $this;
    }


    /**
     * @return string
     */
    public function getReferencedSignatureID(string $id): string
    {
        return $this->referencedSignatureID;
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
            [Schema::CBC . 'ID' => $this->id],
            [Schema::SBC . 'ReferencedSignatureID' => $this->referencedSignatureID]
        ]);
    }
}
