<?php
    $callbackJSONData=file_get_contents('php://input');
    //perform your processing here, e.g. log to file....
    // require_once("include/DBconnect.php");
    // $db = new DBconnect();
    // $conn = $db->connect();
    $file = fopen("callbacklog.txt", "a"); //url fopen should be allowed for this to occur
    if(fwrite($file, $callbackJSONData) === FALSE)
    {
        fwrite("Error: no data written");
    }

    fwrite("\r\n");
    fclose($file);

    $callbackData=json_decode($callbackJSONData);
    $resultType=$callbackData->Result->ResultType;
    $resultCode=$callbackData->Result->ResultCode;
    $resultDesc=$callbackData->Result->ResultDesc;
    $originatorConversationID=$callbackData->Result->OriginatorConversationID;
    $conversationID=$callbackData->Result->ConversationID;
    $transactionID=$callbackData->Result->TransactionID;
    $accountBalance=$callbackData->Result->ResultParameters->ResultParameter[0]->Value;
    $BOCompletedTime=$callbackData->Result->ResultParameters->ResultParameter[1]->Value;
    $result=[
        "resultDesc"=>$resultDesc,
        "resultCode"=>$resultCode,
        "originatorConversationID"=>$originatorConversationID,
        "conversationID"=>$conversationID,
        "transactionID"=>$transactionID,
        "accountBalance"=>$accountBalance,
        "BOCompletedTime"=>$BOCompletedTime,
        "resultType"=>$resultType
    ];
    echo json_encode('{"ResponseCode":"00000000","ResultDesc":"Success"}');
    return json_encode($result);

?>