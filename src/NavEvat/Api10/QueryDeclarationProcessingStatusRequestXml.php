<?php

namespace NavEvat\Api10;

class QueryDeclarationProcessingStatusRequestXml extends BaseRequestXml
{
    public function __construct($config, $declarationProcessingId)
    {
        parent::__construct("QueryDeclarationProcessingStatusRequest", $config);

        $this->xml->addChild('declarationProcessingId', $declarationProcessingId);
    }
}