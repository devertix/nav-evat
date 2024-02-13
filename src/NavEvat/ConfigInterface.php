<?php

namespace NavEvat;

/**
 * Interface ConfigInterface
 *
 * @package NavEvat
 */
interface ConfigInterface
{
    /**
     * NAV online számla API eléréséhez használt URL
     */
    public function setBaseUrl($baseUrl);

    /**
     * @param array $data
     */
    public function setSoftware($data);
    /**
     * @param  string $jsonFile JSON file name
     * @throws \Exception
     */
    public function loadSoftware($jsonFile);

    /**
     * @param array $data
     */
    public function setUser($data);


    /**
     * @param string $jsonFile JSON file name
     * @throws \Exception
     */
    public function loadUser($jsonFile);

    /**
     * cURL hívásnál timeout beállítása másodpercekben.
     * null vagy 0 esetén nincs explicit timeout beállítás
     *
     * @param null|int $timeoutSeconds
     */
    public function setCurlTimeout($timeoutSeconds);

    /**
     * Set the additional data variable.
     *
     * @param array $data
     */
    public function setAdditionalData(array $data);

    /**
     * Returns the additional data.
     *
     * @return array
     */
    public function getAdditionalData();

    /**
     * API verzió beállítása.
     *
     * @param string $version
     */
    public function setVersion($version);

    /**
     * API verzió mappa visszaadása.
     *
     * @return string
     */
    public function getVersionDir();

    public function getDataXsdFilename();

    public function getApiXsdFilename();
}
