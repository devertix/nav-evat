<?php

namespace NavEvat\Api10;

use NavEvat\Abstracts\Reporter as ReporterAbstract;
use NavEvat\Exceptions\MissingMandatoryParameterException;

class Reporter extends ReporterAbstract
{
    public function queryDocumentList($taxpointDateFrom, $taxpointDateTo)
    {
        if (empty($taxpointDateFrom) || empty($taxpointDateTo)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryDocumentListRequestXml($this->config, $taxpointDateFrom, $taxpointDateTo);
        print($requestXml->asXML());
        $responseXml = $this->connector->post("/queryDocumentList", $requestXml);

        return $responseXml;
    }

    public function queryDocumentListResult($queryId)
    {
        if (empty($queryId)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryDocumentListResultRequestXml($this->config, $queryId);
        print($requestXml->asXML());
        $responseXml = $this->connector->post("/queryDocumentListResult", $requestXml);

        return $responseXml;
    }

    public function queryInvoiceTaxCode($invoiceNumber, $invoiceDirection, $invoiceItemLine)
    {
        if (empty($invoiceNumber) || empty($invoiceDirection) || empty($invoiceItemLine)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryInvoiceTaxCodeRequestXml($this->config, $invoiceNumber, $invoiceDirection, $invoiceItemLine);
        print($requestXml->asXML());
        $responseXml = $this->connector->post("/queryInvoiceTaxCode", $requestXml);

        return $responseXml;
    }

    public function queryCustomsDeclarationTaxCode($cdpsId, $resolutionId, $direction)
    {
        if (empty($cdpsId) || empty($resolutionId) || empty($direction)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryCustomsDeclarationTaxCodeRequestXml($this->config, $cdpsId, $resolutionId, $direction);
        print($requestXml->asXML());
        $responseXml = $this->connector->post("/queryCustomsDeclarationTaxCode", $requestXml);

        return $responseXml;
    }

    public function manageDeclarationUpload($partitionCount, $contentHash, $declarationSchema)
    {
        if (empty($partitionCount) || empty($contentHash) || empty($declarationSchema)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new ManageDeclarationUploadRequestXml($this->config, $partitionCount, $contentHash, $declarationSchema);
        print($requestXml->asXML());
        $responseXml = $this->connector->post("/manageDeclarationUpload", $requestXml);

        return $responseXml;
    }

    public function manageDeclarationPartition($declarationUploadId, $partition, $attachement)
    {
        if (empty($declarationUploadId) || empty($partition)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new ManageDeclarationPartitionRequestXml($this->config, $declarationUploadId, $partition);
        print($requestXml->asXML());
        /*$responseXml = $this->connector->post("/manageDeclarationPartition", $requestXml, $attachement);

        return $responseXml;*/
    }

    public function manageDeclarationFinalize($declarationUploadId, $preliminaryConfirmation = false)
    {
        if (empty($declarationUploadId)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new ManageDeclarationFinalizeRequestXml($this->config, $declarationUploadId, $preliminaryConfirmation);
        print($requestXml->asXML());
        $responseXml = $this->connector->post("/manageDeclarationFinalize", $requestXml);

        return $responseXml;
    }

    /*public function queryTransactionStatus($transactionId, $returnOriginalRequest = false)
    {
        if (empty($transactionId)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryTransactionStatusRequestXml($this->config, $transactionId, $returnOriginalRequest);
        $responseXml = $this->connector->post("/queryTransactionStatus", $requestXml);

        return $responseXml;
    }

    public function manageInvoice(
        $invoiceOperationsOrXml,
        $operation = "CREATE",
        $electronicInvoice = false,
        $invoiceHash = null
    ) {
        // Ha nem InvoiceOperations példányt adtak át, akkor azzá konvertáljuk
        if ($invoiceOperationsOrXml instanceof InvoiceOperations) {
            $invoiceOperations = $invoiceOperationsOrXml;
        } else {
            $invoiceOperations = new InvoiceOperations($this->config);

            $invoiceOperations->add($invoiceOperationsOrXml, $operation, $electronicInvoice, $invoiceHash);
        }

        if (empty($this->token)) {
            $this->token = $this->tokenExchange();
        }

        $requestXml = new ManageInvoiceRequestXml($this->config, $invoiceOperations, $this->token);
        $responseXml = $this->connector->post("/manageInvoice", $requestXml);

        return $this->getDomValue($responseXml, 'transactionId');
    }

    public function manageAnnulment($annulmentOperations, &$requestXmlString = '')
    {
        if (empty($this->token)) {
            $this->token = $this->tokenExchange();
        }

        $requestXml = new ManageAnnulmentRequestXml($this->config, $annulmentOperations, $this->token);
        $responseXml = $this->connector->post("/manageAnnulment", $requestXml);

        $requestXmlString = $requestXml->asXML();

        return $this->getDomValue($responseXml, 'transactionId');
    }

    public function queryInvoiceData($invoiceNumber, $invoiceDirection)
    {
        if (empty($invoiceDirection) || empty($invoiceNumber)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryInvoiceDataRequestXml($this->config, $invoiceNumber, $invoiceDirection);
        $responseXml = $this->connector->post("/queryInvoiceData", $requestXml);

        return $responseXml;
    }

    public function queryInvoiceDigest($invoiceDirection, $queryData, $page = 1)
    {
        if (empty($invoiceDirection)) {
            throw new MissingMandatoryParameterException();
        }

        if (empty($queryData['mandatoryQueryParams']['originalInvoiceNumber'])
            && (empty($queryData['mandatoryQueryParams']['invoiceIssueDate']['dateFrom']) || empty($queryData['mandatoryQueryParams']['invoiceIssueDate']['dateTo']))
            && (empty($queryData['mandatoryQueryParams']['insDate']['dateTimeFrom']) || empty($queryData['mandatoryQueryParams']['insDate']['dateTimeTo']))
        ) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryInvoiceDigestRequestXml($this->config, $invoiceDirection, $queryData, $page);
        $responseXml = $this->connector->post('/queryInvoiceDigest', $requestXml);

        return $responseXml;
    }

    public function queryInvoiceChainDigest($queryData, $page = 1)
    {
        if (empty($queryData['invoiceNumber'])
            || empty($queryData['invoiceDirection'])
        ) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryInvoiceChainDigestRequestXml($this->config, $queryData, $page);
        $responseXml = $this->connector->post('/queryInvoiceChainDigest', $requestXml);

        return $responseXml;
    }

    private function getDomValue(\SimpleXMLElement $simpleXMLElement, string $tagName)
    {
        $domObject = $this->getDomObject($simpleXMLElement, $tagName);
        return $domObject ? $domObject->nodeValue : null;
    }

    private function getDomObject(\SimpleXMLElement $simpleXMLElement, string $tagName)
    {
        $domXml = new \DOMDocument();
        $domXml->loadXML($simpleXMLElement->asXML());
        return $domXml->getElementsByTagName($tagName)->item(0);
    }*/
}