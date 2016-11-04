<?php

use QuickBooks\Core\IntuitServicesType;
use QuickBooks\Core\ServiceContext;
use QuickBooks\DataService\DataService;
use QuickBooks\Security\OAuthRequestValidator;
use QuickBooks\Utility\Configuration\ConfigurationManager;

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
if (!$serviceContext)
    exit("Problem while initializing ServiceContext.\n");

// Prep Data Services
$dataService = new DataService($serviceContext);
if (!$dataService)
    exit("Problem while initializing DataService.\n");

// Run a batch
$maxSearch = 500;
$batch = $dataService->CreateNewBatch();
$batch->AddQuery("select * from Customer startPosition 0 maxResults {$maxSearch}", "queryCustomer");
$batch->AddQuery("select * from Vendor startPosition 0 maxResults {$maxSearch}", "queryVendor");
$batch->Execute();

// Echo some formatted output
$batchItemResponse = $batch->intuitBatchItemResponses[0];
echo "Looked for up to {$maxSearch} customers; found " . count($batchItemResponse->entities) . "\n";

$batchItemResponse = $batch->intuitBatchItemResponses[1];
echo "Looked for up to {$maxSearch} vendors; found " . count($batchItemResponse->entities) . "\n";

/*
Example output:

Looked for up to 500 customers; found 318
Looked for up to 500 vendors; found 278
*/
