<?php

namespace NavEvat;

use CURLFile;
use CURLStringFile;
use Faker\Provider\Base;
use \NavEvat\Exceptions\CurlError;
use \NavEvat\Exceptions\GeneralErrorResponse;
use \NavEvat\Exceptions\GeneralExceptionResponse;
use \NavEvat\Exceptions\HttpResponseError;

class Connector implements ConnectorInterface {

    protected $config;


    /**
     *
     * @param Config  $config
     */
    function __construct($config) {
        $this->config = $config;
    }


    /**
     *
     * @param  string                   $url
     * @param  string|\SimpleXMLElement $requestXml
     * @return \SimpleXMLElement
     * @throws \NavEvat\CurlError
     * @throws \NavEvat\HttpResponseError
     * @throws \NavEvat\GeneralExceptionResponse
     * @throws \NavEvat\GeneralErrorResponse
     */
    public function post($url, $requestXml, $attachement = null) {

        $url = $this->config->baseUrl . $url;
        $xmlString = is_string($requestXml) ? $requestXml : $requestXml->asXML();

        /*if ($this->config->validateApiSchema) {
            Xsd::validate($xmlString, $this->config->getApiXsdFilename());
        }*/

        $ch = $this->getCurlHandle($url, $xmlString, $attachement);

        $result = curl_exec($ch);
        $errno = curl_errno($ch);
        $info = curl_getinfo($ch);
        $httpStatusCode = $info["http_code"];

        curl_close($ch);

        if ($errno) {
            throw new CurlError($errno);
        }

        var_dump($result);
        $responseXml = $this->parseResponse($result);
        print($responseXml->asXML());

        $domXml = new \DOMDocument();
        $domXml->loadXML($responseXml->asXML());

        if (!$responseXml) {
            throw new HttpResponseError($result, $httpStatusCode);
        }

        if ($domXml->documentElement->localName === "GeneralExceptionResponse") {
            throw new GeneralExceptionResponse($domXml);
        }

        if ($domXml->documentElement->localName === "GeneralErrorResponse") {
            throw new GeneralErrorResponse($domXml);
        }

        // TODO: felülvizsgálni, hogy ez minden esetben jó megoldás-e itt, illetve esetleg más típusú Exception dobása
        // Ha a result->funcCode !== OK értékkel, akkor Exception dobása
        if ($this->getFuncCode($domXml) !== "OK") {
            throw new GeneralErrorResponse($domXml);
        }

        // Fejlesztés idő alatt előfordult, hogy funcCode === OK, de a service nem megy
        $message = $this->getMessage($domXml);
        if (!empty($message) and preg_match("/endpoint is currently down/", $message)) {
            throw new GeneralErrorResponse($domXml);
        }

        return $responseXml;
    }


    private function getCurlHandle($url, $requestBody, $attachement = null) {
        $ch = curl_init($url);

        $headers = array(
            "Content-Type: application/xml;charset=\"UTF-8\"",
            "Accept: application/xml",
        );

        if ($attachement) {
            $boundary = uniqid();
            $boundary = '-------------' . $boundary;
            $postData = $this->build_data_files($boundary, ['body' => $requestBody], [['name' => 'file', 'filename' => basename($attachement), 'binary_data' => file_get_contents($attachement)]]);

            // var_dump($postData);
            $headers = array(
                "Content-Type: multipart/form-data; boundary=$boundary",
            );
            //var_dump(file_exists($attachement));
            $postFields = [];
            $postFields['body'] = new CURLStringFile($requestBody, '', 'application/xml');
            $postFields['file'] = new CURLFile($attachement, 'application/octet-stream');
            //$postFields[] = 'file=@' . $attachement . ';type=application/octet-stream';
            //var_dump($postFields);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            //curl_setopt($ch, CURLOPT_VERBOSE, true);
            
            //curl_setopt($ch, CURLOPT_INFILE, fopen($attachement, "r"));
            //curl_setopt($ch, CURLOPT_FILE, curl_file_create($attachement, 'application/octet-stream', basename($attachement)));
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
        }

        if (!$this->config->verifySLL) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        if ($this->config->curlTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->config->curlTimeout);
        }

        return $ch;
    }

    private function build_data_files($boundary, $fields, $files) {
        $data = '';
        $eol = "\r\n";
        $delimiter = $boundary;
        foreach ($fields as $name => $content) {
          $data .= "--" . $delimiter . $eol
            . 'Content-Disposition: form-data; name="' . $name . "\"".$eol
            . 'Content-Type: application/xml'.$eol.$eol
            . $content . $eol;
        }
        foreach ($files as $file) {
          $data .= "--" . $delimiter . $eol
            . 'Content-Disposition: form-data; name="' . $file['name'] . '"; filename="' . $file['filename'] . '"' . $eol
            . 'Content-Type: application/octet-stream'.$eol
            . 'Content-Transfer-Encoding: binary'.$eol.$eol;
    
            $data .= $file['binary_data'] . $eol;
        }
        $data .= "--" . $delimiter . "--".$eol;
        print $data;
        return $data;
    }


    private function parseResponse($result) {
        if (substr($result, 0, 5) !== "<?xml") {
            return null;
        }

        return simplexml_load_string($result);
    }

    private function getFuncCode(\DOMDocument $xml) {
        $result = $xml->getElementsByTagName('result')->item(0);
        $funcCode = $result->getElementsByTagName('funcCode')->item(0);
        if ($funcCode) {
            return $funcCode->nodeValue;
        }
        return null;
    }

    private function getMessage(\DOMDocument $xml) {
        $result = $xml->getElementsByTagName('result')->item(0);
        $message = $result->getElementsByTagName('message')->item(0);
        if ($message) {
            return $message->nodeValue;
        }
        return null;
    }

}
