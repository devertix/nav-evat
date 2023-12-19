<?php

namespace NavEvat\Api10;

use NavEvat\Traits\AddQueryData;

class ManageDeclarationUploadRequestXml extends BaseRequestXml
{
    use AddQueryData;

    public function __construct($config, $partitionCount, $contentHash, $declarationSchema)
    {
        parent::__construct("ManageDeclarationUploadRequest", $config);

        $this->xml->addChild('partitionCount', $partitionCount);
        $this->xml->addChild('contentHash', $contentHash)->addAttribute("cryptoType", "SHA3-512");
        $this->xml->addChild('declarationSchema', $declarationSchema);
        // $this->xml->addChild('attachmentIdList', $attachmentIdList);
    }
}
