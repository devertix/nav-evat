<?php

namespace NavEvat\Api10;

use NavEvat\Abstracts\Config as ConfigAbstract;

class Config extends ConfigAbstract
{
    public const LIVE_URL = 'https://api.eafa.nav.gov.hu/analyticsService/v1';
    public const TEST_URL = 'https://api-test.eafa.nav.gov.hu/analyticsService/v1';
}