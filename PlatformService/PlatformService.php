<?php

namespace QuickBooks\PlatformService;

use QuickBooks\Core\CoreConstants;
use QuickBooks\Core\RestCalls\RequestParameters;
use QuickBooks\Core\RestCalls\SyncRestHandler;
use QuickBooks\Core\ServiceContext;
use QuickBooks\Exception\SdkExceptions\InvalidParameterException;
use QuickBooks\Utility\Configuration\CompressionFormat;
use QuickBooks\Utility\Configuration\SerializationFormat;

/**
 * This file contains Intuit Platform services.
 */
class PlatformService
{

    /**
     * The Service context object.
     * @var ServiceContext
     */
    public $serviceContext;

    /**
     * The Rest request handler object.
     * @var RequestHandler
     */
    public $restRequestHandler;

    /**
     * Request Xml Document
     * @var unknown
     */
    private $requestXmlDocument;

    /**
     * Initializes a new instance of the PlatformService class.
     *
     * @param ServiceContext IPP Service Context
     * @throws InvalidParameterException
     */
    public function __construct($serviceContext)
    {
        if (null == $serviceContext) {
            throw new ArgumentNullException('Resources.ServiceContextCannotBeNull');
        }

        if (!is_object($serviceContext)) {
            throw new InvalidParameterException('Wrong arg type passed - is not an object.');
        }

        if (0 !== strcmp('ServiceContext', get_class($serviceContext))) {
            throw new InvalidParameterException('Wrong arg type passed - is not the correct class.');
        }

        $this->serviceContext = $serviceContext;
        $this->restRequestHandler = new SyncRestHandler($serviceContext);

        // Set the serviceContext IPP configuration to what IPP is accepting.
        $this->serviceContext->IppConfiguration->Message->Request->SerializationFormat = SerializationFormat::Xml;
        $this->serviceContext->IppConfiguration->Message->Request->CompressionFormat = CompressionFormat::None;
        $this->serviceContext->IppConfiguration->Message->Response->SerializationFormat = SerializationFormat::Xml;
        $this->serviceContext->IppConfiguration->Message->Response->CompressionFormat = CompressionFormat::None;

        // Set the service type to IPP by calling a method
        $this->serviceContext->UsePlatformServices();

        $this->serviceContext = $serviceContext;
        $this->restRequestHandler = new SyncRestHandler($serviceContext);
    }

    /**
     * Get App Menu
     *
     * @return string Html of App Menu
     */
    public function GetAppMenu()
    {
        $this->requestXmlDocument = '';
        $uriFragment = implode(CoreConstants::SLASH_CHAR, ['v1', 'Account', 'AppMenu']);
        $requestParameters = new RequestParameters(null, 'GET', null, $uriFragment);
        list($respCode, $respHtml) = $this->restRequestHandler->GetResponse($requestParameters, $this->requestXmlDocument, null);
        return $respHtml;
    }

    /**
     * Reconnect generates a new OAuth access token and invalidates the OAuth access token used
     * in the request, thereby extending the life span by six months.
     *
     * @return \SimpleXMLElement Xml of Reconnect response
     */
    public function Reconnect()
    {
        $this->requestXmlDocument = '';
        $uriFragment = implode(CoreConstants::SLASH_CHAR, ['v1', 'Connection', 'Reconnect']);
        $requestParameters = new RequestParameters(null, 'GET', null, $uriFragment);
        list($respCode, $respXml) = $this->restRequestHandler->GetResponse($requestParameters, $this->requestXmlDocument, null);
        return simplexml_load_string($respXml);
    }

    /**
     * Disconnect invalidates the OAuth access token in the request, thereby disconnecting
     * the user from QuickBooks for this app.
     *
     * @return \SimpleXMLElement Xml of Disconnect response
     */
    public function Disconnect()
    {
        $this->requestXmlDocument = '';
        $uriFragment = implode(CoreConstants::SLASH_CHAR, ['v1', 'Connection', 'Disconnect']);
        $requestParameters = new RequestParameters(null, 'GET', null, $uriFragment);
        list($respCode, $respXml) = $this->restRequestHandler->GetResponse($requestParameters, $this->requestXmlDocument, null);
        return simplexml_load_string($respXml);
    }


    /**
     * Returns user information such as first name, last name, and email address.
     *
     * @return \SimpleXMLElement Xml of Disconnect response
     */
    public function CurrentUser()
    {
        $this->requestXmlDocument = '';
        $uriFragment = implode(CoreConstants::SLASH_CHAR, ['v1', 'user', 'current']);
        $requestParameters = new RequestParameters(null, 'GET', null, $uriFragment);
        list($respCode, $respXml) = $this->restRequestHandler->GetResponse($requestParameters, $this->requestXmlDocument, null);
        return simplexml_load_string($respXml);
    }

}
