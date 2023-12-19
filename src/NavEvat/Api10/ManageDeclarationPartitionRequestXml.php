<?php

namespace NavEvat\Api10;

use NavEvat\Traits\AddQueryData;

class ManageDeclarationPartitionRequestXml extends BaseRequestXml
{
    use AddQueryData;

    public function __construct($config, $declarationUploadId, $partition)
    {
        parent::__construct("ManageDeclarationPartitionRequest", $config);

        $this->xml->addChild('declarationUploadId', $declarationUploadId);
        $this->xml->addChild('partition', $partition);
    }
}