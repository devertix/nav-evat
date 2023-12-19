<?php

namespace NavEvat;

class Config
{
    public static function factory($apiVersion, $isLive, $user, $software)
    {
        return new Api10\Config($apiVersion, $isLive, $user, $software);
    }
}
