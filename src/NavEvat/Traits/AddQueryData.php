<?php

namespace NavEvat\Traits;

trait AddQueryData
{
    protected function addQueryData(\SimpleXMLElement $xmlNode, $type, $data, $namespace = null) {
        $node = $xmlNode->addChild($type, null, $namespace);

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $this->addQueryData($node, $key, $value, $namespace);
            } else {
                $node->addChild($key, $value, $namespace);
            }
        }
    }
}
