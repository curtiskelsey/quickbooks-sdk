<?php

namespace QuickBooks\Core;

/**
 * This Enumeration specifies which Intuit service to connect to. It is  Either QBO or QBD.
 */
class IntuitServicesType
{

    /**
     * QuickBooks Desktop Data through IDS.
     * @var string QBD
     */
    const QBD = "QBD";

    /**
     * QuickBooks Online Data through IDS.
     * @var string QBO
     */
    const QBO = "QBO";

    /**
     * Intuit Platform services.
     * @var string IPP
     */
    const IPP = "IPP";

    /**
     * None service type.
     * @var string None
     */
    const None = "None";
}