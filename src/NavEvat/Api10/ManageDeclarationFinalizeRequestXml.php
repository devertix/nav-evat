<?php

namespace NavEvat\Api10;

use NavEvat\Traits\AddQueryData;

class ManageDeclarationFinalizeRequestXml extends BaseRequestXml
{
    use AddQueryData;

    public function __construct($config, $declarationUploadId, $preliminaryConfirmation)
    {
        parent::__construct("ManageDeclarationFinalizeRequest", $config);

        $this->xml->addChild('declarationUploadId', $declarationUploadId);
        $this->xml->addChild('preliminaryConfirmation', $preliminaryConfirmation ? 'true' : 'false');
    }
}