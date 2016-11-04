<?php

use QuickBooks\Core\IntuitServicesType;
use QuickBooks\Core\ServiceContext;
use QuickBooks\ReportService\ReportName;
use QuickBooks\ReportService\ReportService;
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
$reportService = new ReportService($serviceContext);
if (!$reportService)
    exit("Problem while initializing ReportService.\n");


$reportService->setStartDate("2015-01-01");
$reportService->setAccountingMethod("Accrual");
$profitAndLossReport = $reportService->executeReport(ReportName::PROFITANDLOSS);

if (!$profitAndLossReport){
    exit("ProfitAndLossReport Is Null.\n");
}
else{
    $reportName = strtolower($profitAndLossReport->Header->ReportName);
    echo ("ReportName: " . $reportName . "\n");
    echo ("Profit And Loss Report Execution Successful!" . "\n");
}