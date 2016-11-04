<?php

use Intuit\Data\IPPAccountBasedExpenseLineDetail;
use Intuit\Data\IPPLine;
use Intuit\Data\IPPPurchase;
use Intuit\Data\IPPReferenceType;
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

// Create a new Purchase Object
$randomPurchaseObj = CreatePurchaseObj($dataService);
$purchaseObjConfirmation = $dataService->Add($randomPurchaseObj);
echo "Created Purchase object, and received Id={$purchaseObjConfirmation->Id}\n";

// Find the recently-created Purchase Object by Id
$purchaseObj = new IPPPurchase();
$purchaseObj->Id = $purchaseObjConfirmation->Id;
$purchaseObj->domain = $purchaseObjConfirmation->domain;
$crudResultObj = $dataService->FindById($purchaseObj);
if ($crudResultObj)
    echo "Found the purchase object that we just created.\n";
else
    echo "Did not find the purchase object that we just created.\n";


/**
 * Create a valid Purchase object locally, caller will convey to the cloud via CREATE
 */
function CreatePurchaseObj($dataServices)
{
    $AccountArray = [];

    $AccountArray['Banks'] = $dataServices->Query("SELECT * FROM Account WHERE AccountType='Bank'", 1, 10);
    if (!$AccountArray['Banks'])
        return [];
    $bankAccountId = $AccountArray['Banks'][0]->Id;

    $AccountArray['Expense'] = $dataServices->Query("SELECT * FROM Account WHERE AccountType='Expense'", 1, 10);
    if (!$AccountArray['Expense'])
        return [];
    $expenseAccountId = $AccountArray['Expense'][0]->Id;

    $oneLine = new IPPLine(['Description' => 'some line item',
            'Amount' => '7.50',
            'DetailType' => 'AccountBasedExpenseLineDetail',
            'AccountBasedExpenseLineDetail' =>
                new IPPAccountBasedExpenseLineDetail(
                    ['AccountRef' =>
                        new IPPReferenceType(['value' => $expenseAccountId]),
                        'DetailType' => 'AccountBasedExpenseLineDetail',
                    ]
                ),
        ]
    );

    $targetObj = new IPPPurchase();
    $targetObj->Name = 'Some Name' . rand();
    $targetObj->TotalAmt = '15.00';
    $targetObj->PaymentType = 'Check';
    $targetObj->AccountRef = new IPPReferenceType(['value' => $bankAccountId]);
    $targetObj->Line = [$oneLine, $oneLine];

    return $targetObj;

}

/*
Example output:

Created Purchase object, and received Id=807
Found the purchase object that we just created.
*/
