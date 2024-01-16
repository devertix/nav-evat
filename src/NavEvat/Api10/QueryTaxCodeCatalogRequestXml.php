<?php

namespace NavEvat\Api10;

use NavEvat\Traits\AddQueryData;

class QueryTaxCodeCatalogRequestXml extends BaseRequestXml
{
    use AddQueryData;

    public function __construct($config, $taxpointDate)
    {
        parent::__construct("QueryTaxCodeCatalogRequest", $config);

        $invoiceNumberQuery = $this->xml->addChild('invoiceNumberQuery');
        $invoiceNumberQuery->addChild('osaApi:taxpointDate', $taxpointDate, BaseRequestXml::OSA_API_30);
    }
}
