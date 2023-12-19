<?php

namespace NavEvat\Api10;

use NavEvat\Traits\AddQueryData;

class QueryDocumentListResultRequestXml extends BaseRequestXml
{
    use AddQueryData;

    public function __construct($config, $queryId)
    {
        parent::__construct("QueryDocumentListResultRequest", $config);

        $this->xml->addChild('queryId', $queryId);
    }
}
