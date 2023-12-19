<?php

namespace NavEvat\Api10;

use NavEvat\Traits\AddQueryData;

class QueryCustomsDeclarationTaxCodeRequestXml extends BaseRequestXml
{
    use AddQueryData;

    public function __construct($config, $cdpsId, $resolutionId, $direction)
    {
        parent::__construct("QueryCustomsDeclarationTaxCodeRequest", $config);

        $this->xml->addChild('cdpsId', $cdpsId);
        $this->xml->addChild('resolutionId', $resolutionId);
        $this->xml->addChild('declarationDirection', $direction);
    }
}
