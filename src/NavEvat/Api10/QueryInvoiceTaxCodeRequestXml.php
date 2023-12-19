<?php

namespace NavEvat\Api10;

use NavEvat\Traits\AddQueryData;

class QueryInvoiceTaxCodeRequestXml extends BaseRequestXml
{
    use AddQueryData;

    public function __construct($config, $invoiceNumber, $invoiceDirection, $invoiceItemLine)
    {
        parent::__construct("QueryInvoiceTaxCodeRequest", $config);

        $invoiceNumberQuery = $this->xml->addChild('invoiceNumberQuery');
        $invoiceNumberQuery->addChild('osaApi:invoiceNumber', $invoiceNumber, BaseRequestXml::OSA_API_30);
        $invoiceNumberQuery->addChild('osaApi:invoiceDirection', $invoiceDirection, BaseRequestXml::OSA_API_30);

        $this->addQueryData(
            $this->xml,
            'additionalInvoiceTaxCodeQueryParams',
            [
                'invoiceItemLine' => $invoiceItemLine ? 'true' : 'false',
            ]
        );
    }
}
