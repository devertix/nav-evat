<?php

namespace NavEvat\Api10;

use NavEvat\Traits\AddQueryData;

class QueryTaxCodeCatalogRequestXml extends BaseRequestXml
{
    use AddQueryData;

    public function __construct($config, $taxpointDate)
    {
        parent::__construct("QueryTaxCodeCatalogRequest", $config);

        $taxCodeCatalogQuery = $this->xml->addChild('taxpointDate', $taxpointDate);
    }
}
