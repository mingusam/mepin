<?php
    $callbackJSONData=file_get_contents('php://input');
    $callbackData=json_decode($callbackJSONData);
    $transactionType=$callbackData->TransactionType;
    $transID=$callbackData->TransID;
    $transTime=$callbackData->TransTime;
    $transAmount=$callbackData->TransAmount;
    $businessShortCode=$callbackData->BusinessShortCode;
    $billRefNumber=$callbackData->BillRefNumber;
    $invoiceNumber=$callbackData->InvoiceNumber;
    $orgAccountBalance=$callbackData->OrgAccountBalance;
    $thirdPartyTransID=$callbackData->ThirdPartyTransID;
    $MSISDN=$callbackData->MSISDN;
    $firstName=$callbackData->FirstName;
    $middleName=$callbackData->MiddleName;
    $lastName=$callbackData->LastName;

    require_once("include/DBconnect.php");
    $db = new DBconnect();
    $conn = $db->connect();

    $query = "Insert into c2b(firstname,middlename,lastname,msisdn,transactiontype,transid,transamount,
    shortcode,billrefnumber,invoicenumber,thirdpartytransid";
    $stmt1 = $conn->query($query);
    if($stmt1){
        echo "Data added successfully";
    } 
    else{
        echo "Data could not be added";
    }
?>