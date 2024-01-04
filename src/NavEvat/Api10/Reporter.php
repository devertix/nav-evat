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
        $responseXml = $this->connector->post("/queryDocumentList", $requestXml);

        return $responseXml;
    }

    public function queryDocumentListResult($queryId)
    {
        if (empty($queryId)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryDocumentListResultRequestXml($this->config, $queryId);
        $responseXml = $this->connector->post("/queryDocumentListResult", $requestXml);

        return $responseXml;
    }

    public function queryInvoiceTaxCode($invoiceNumber, $invoiceDirection, $invoiceItemLine)
    {
        if (empty($invoiceNumber) || empty($invoiceDirection) || empty($invoiceItemLine)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryInvoiceTaxCodeRequestXml($this->config, $invoiceNumber, $invoiceDirection, $invoiceItemLine);
        $responseXml = $this->connector->post("/queryInvoiceTaxCode", $requestXml);

        return $responseXml;
    }

    public function queryCustomsDeclarationTaxCode($cdpsId, $resolutionId, $direction)
    {
        if (empty($cdpsId) || empty($resolutionId) || empty($direction)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new QueryCustomsDeclarationTaxCodeRequestXml($this->config, $cdpsId, $resolutionId, $direction);
        $responseXml = $this->connector->post("/queryCustomsDeclarationTaxCode", $requestXml);

        return $responseXml;
    }

    public function manageDeclarationUpload($partitionCount, $contentHash, $declarationSchema)
    {
        if (empty($partitionCount) || empty($contentHash) || empty($declarationSchema)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new ManageDeclarationUploadRequestXml($this->config, $partitionCount, $contentHash, $declarationSchema);
        $responseXml = $this->connector->post("/manageDeclarationUpload", $requestXml);

        return $responseXml;
    }

    public function manageDeclarationPartition($declarationUploadId, $partition, $attachement, $hash)
    {
        if (empty($declarationUploadId) || empty($partition)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new ManageDeclarationPartitionRequestXml($this->config, $declarationUploadId, $partition, $hash);
        $responseXml = $this->connector->post("/manageDeclarationPartition", $requestXml, $attachement);

        return $responseXml;
    }

    public function manageDeclarationFinalize($declarationUploadId, $preliminaryConfirmation = false)
    {
        if (empty($declarationUploadId)) {
            throw new MissingMandatoryParameterException();
        }

        $requestXml = new ManageDeclarationFinalizeRequestXml($this->config, $declarationUploadId, $preliminaryConfirmation);
        $responseXml = $this->connector->post("/manageDeclarationFinalize", $requestXml);

        return $responseXml;
    }
}