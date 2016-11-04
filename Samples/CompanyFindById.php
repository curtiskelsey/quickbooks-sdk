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

$allCompanies = $dataService->FindAll('CompanyInfo');
foreach ($allCompanies as $oneCompany) {
    $oneCompanyReLookedUp = $dataService->FindById($oneCompany);
    echo "Company Name: {$oneCompanyReLookedUp->CompanyName}\n";
}

/*

Example output:

Company Name: MyCo Production LLC
Company Name: ACME Inc.
Company Name: Jones Corp

*/