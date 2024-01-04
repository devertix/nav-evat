<?php

namespace NavEvat\Api10;

use NavEvat\Traits\AddQueryData;

class ManageDeclarationPartitionRequestXml extends BaseRequestXml
{
    use AddQueryData;

    private $hash;

    public function __construct($config, $declarationUploadId, $partition, $hash)
    {
        $this->hash = $hash;

        parent::__construct("ManageDeclarationPartitionRequest", $config);

        $this->xml->addChild('declarationUploadId', $declarationUploadId);
        $this->xml->addChild('partition', $partition);
    }

    protected function getRequestSignatureString()
    {
        $string = "";
        $string .= $this->requestId;
        $string .= preg_replace("/\.\d{3}|\D+/", "", $this->timestamp);
        $string .= $this->config->user["signKey"];
        $string .= $this->hash;

        return $string;
    }
}