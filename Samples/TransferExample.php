<?php

use Intuit\Data\IPPReferenceType;
use Intuit\Data\IPPTransfer;
use QuickBooks\Core\IntuitServicesType;
use QuickBooks\Core\ServiceContext;
use QuickBooks\DataService\DataService;
use QuickBooks\Security\OAuthRequestValidator;
use QuickBooks\Utility\Configuration\ConfigurationManager;
use QuickBooks\Utility\Configuration\SerializationFormat;

require_once('../config.php');

//Specify QBO or QBD
$serviceType = IntuitServicesType::QBO;

// Get App Config
$realmId = ConfigurationManager::AppSettings('RealmID');
if (!$realmId)
    exit("Please add realm to App.Config before running this sample.\n");

// Prep Service Context
$requestValidator = new OAuthRequestValidator(ConfigurationManager::AppSettings('AccessToken'),
    ConfigurationManager::AppSettings('AccessTokenSecret'),
    ConfigurationManager::AppSettings('ConsumerKey'),
    ConfigurationManager::AppSettings('ConsumerSecret'));
$serviceContext = new ServiceContext($realmId, $serviceType, $requestValidator);

$serviceContext->IppConfiguration->Message->Response->SerializationFormat = SerializationFormat::Json;
$serviceContext->IppConfiguration->Message->Request->SerializationFormat = SerializationFormat::Json;
$serviceContext->IppConfiguration->BaseUrl->Qbo = ConfigurationManager::BaseURLSettings(strtolower(IntuitServicesType::QBO));
$serviceContext->baseserviceURL = $serviceContext->GetBaseURL();

if (!$serviceContext)
    exit("Problem while initializing ServiceContext.\n");

// Prep Data Services
$dataService = new DataService($serviceContext);
if (!$dataService)
    exit("Problem while initializing DataService.\n");


$result = $dataService->Add(createTransfer());
echo showMe($result);
print_r($result);

################################################################################
# Domain Objects example                                                       #
################################################################################
function createTransfer()
{

    $from = new IPPReferenceType();
    $from->name = "Checking";
    $from->value = 35;

    $to = new IPPReferenceType();
    $to->name = "Savings";
    $to->value = 36;

    $transfer = new IPPTransfer();
    $transfer->FromAccountRef = $from;
    $transfer->ToAccountRef = $to;
    $transfer->Amount = 10;

    return $transfer;
}

/**
 * Output function
 */
function showMe($entity)
{
    $className = get_class($entity);


    return <<<OUTTEXT
Hi!
I am an instance of $className object. 
And I state that transfer was perfromed from "{$entity->FromAccountRef->name}" (id={$entity->FromAccountRef->name})
to "{$entity->ToAccountRef->name}" (id={$entity->ToAccountRef->name}) in amount \${$entity->Amount}

My id is {$entity->Id} and this was for {$entity->domain} domain.

See my whole object:

OUTTEXT;

}