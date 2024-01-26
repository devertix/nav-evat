<?php

namespace NavEvat\Abstracts;

use NavEvat\ConfigInterface;
use Exception;

abstract class Config implements ConfigInterface
{
    public $user;
    public $software;

    public $baseUrl;
    public $verifySLL = false;

    public $curlTimeout = null;

    public $apiVersion = '1.0';

    public const LIVE_URL = '';
    public const TEST_URL = '';

    /**
     * This data is used to store additional information that can be accessed from this config.
     * It is a good place to pass additional data that should be accessible throughout the requests.
     *
     * @var array $additionalData
     */
    public $additionalData = [];

    /**
     * NavOnlineInvoice Reporter osztály számára szükséges konfigurációs objektum készítése
     *
     * @param string $apiVersion NAV API Version
     * @param boolean $isLive Éles vagy teszt működés
     * @param array|string $user User data array vagy json fájlnév
     * @param array|string $software Software data array vagy json fájlnév
     * @throws \Exception
     */
    public function __construct($apiVersion, $isLive, $user, $software)
    {
        $this->setBaseUrl(static::TEST_URL);
        if ($isLive) {
            $this->setBaseUrl(static::LIVE_URL);
        }

        if (!$user) {
            throw new Exception("A user paraméter megadása kötelező!");
        }

        if (empty($software)) {
            throw new Exception("Kötelező megadni a szoftver-adatokat!");
        }

        if (is_string($user)) {
            $this->loadUser($user);
        } else {
            $this->setUser($user);
        }

        if ($software) {
            if (is_string($software)) {
                $this->loadSoftware($software);
            } else {
                $this->setSoftware($software);
            }
        }

        $this->setVersion($apiVersion);
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function setSoftware($data)
    {
        $this->software = $data;
    }

    public function loadSoftware($jsonFile)
    {
        $data = $this->loadJsonFile($jsonFile);
        $this->setSoftware($data);
    }

    public function setUser($data)
    {
        $this->user = $data;
    }

    public function loadUser($jsonFile)
    {
        $data = $this->loadJsonFile($jsonFile);
        $this->setUser($data);
    }

    public function setCurlTimeout($timeoutSeconds)
    {
        $this->curlTimeout = $timeoutSeconds;
    }

    public function setVersion($version)
    {
        $this->apiVersion = $version;
    }

    public function getVersion()
    {
        return $this->apiVersion;
    }

    public function setAdditionalData(array $data)
    {
        $this->additionalData = $data;
    }

    public function getAdditionalData()
    {
        return $this->additionalData;
    }

    public function getVersionDir()
    {
        return str_replace('.', '_', $this->apiVersion);
    }

    public function getDataXsdFilename()
    {
        return __DIR__ . '/../xsd/' . $this->getVersionDir() . '/invoiceData.xsd';
    }

    public function getApiXsdFilename()
    {
        return __DIR__ . '/../xsd/' . $this->getVersionDir() . '/invoiceApi.xsd';
    }

    /**
     * JSON fájl betöltése
     *
     * @param  string $jsonFile
     * @return array
     * @throws \Exception
     */
    protected function loadJsonFile($jsonFile)
    {
        if (!file_exists($jsonFile)) {
            throw new Exception("A megadott json fájl nem létezik: $jsonFile");
        }

        $content = file_get_contents($jsonFile);
        $data = json_decode($content, true);

        if ($data === null) {
            throw new Exception("A megadott json fájlt nem sikerült dekódolni!");
        }

        return $data;
    }
}
