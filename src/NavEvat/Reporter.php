<?php

namespace NavEvat;

class Reporter
{
    public static function factory(\NavEvat\Abstracts\Config $config)
    {
        return new Api10\Reporter($config);
    }
}
