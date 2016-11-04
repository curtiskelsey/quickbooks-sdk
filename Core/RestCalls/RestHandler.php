<?php

namespace QuickBooks\Core\RestCalls;

use QuickBooks\Core\CoreHelper;
use QuickBooks\Core\Interfaces\ICompressor;
use QuickBooks\Core\ServiceContext;
use QuickBooks\Utility\IEntitySerializer;

/**
 * Rest Handler class.
 */
class RestHandler
{

    /**
     * The contex
     * @var ServiceContext
     */
    private $serviceContext;

    /**
     * Response serializer.
     * @var IEntitySerializer
     */
    private $ResponseSerializer;

    /**
     * Gets or sets Request compressor.
     * @var ICompressor
     */
    private $RequestCompressor;

    /**
     * Gets or sets Response compressor.
     * @var ICompressor
     */
    private $ResponseCompressor;

    /**
     * Gets or sets Request serializer.
     * @var IEntitySerializer
     */
    private $RequestSerializer;

    /**
     * Initializes a new instance of the RestHandler class.
     *
     * @param ServiceContext $context The Service Context
     */
    protected function __construct($context)
    {
        $this->serviceContext = $context;
        $this->RequestCompressor = CoreHelper::GetCompressor($this->serviceContext, true);
        $this->ResponseCompressor = CoreHelper::GetCompressor($this->serviceContext, false);
        $this->RequestSerializer = CoreHelper::GetSerializer($this->serviceContext, true);
        $this->ResponseSerializer = CoreHelper::GetSerializer($this->serviceContext, false);
        $this->RequestLogging = CoreHelper::GetRequestLogging($this->serviceContext);
    }
}
