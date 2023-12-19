<?php

namespace NavEvat\Api10;

use NavEvat\Traits\AddQueryData;

class QueryDocumentListRequestXml extends BaseRequestXml
{
    use AddQueryData;

    public function __construct($config, $taxpointDateFrom, $taxpointDateTo)
    {
        parent::__construct("QueryDocumentListRequest", $config);

        $this->xml->addChild('taxpointDateFrom', $taxpointDateFrom);
        $this->xml->addChild('taxpointDateTo', $taxpointDateTo);
    }
}
