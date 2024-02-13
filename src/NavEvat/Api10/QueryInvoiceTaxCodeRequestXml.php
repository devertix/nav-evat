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
        $invoiceNumberQuery->addChild('invoiceNumber', $invoiceNumber);
        $invoiceNumberQuery->addChild('invoiceDirection', $invoiceDirection);

        $this->addQueryData(
            $this->xml,
            'additionalInvoiceTaxCodeQueryParams',
            [
                'invoiceItemLine' => $invoiceItemLine ? 'true' : 'false',
            ]
        );
    }
}
