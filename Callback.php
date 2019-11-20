<?php
    $postData = file_get_contents('php://input');
    //perform your processing here, e.g. log to file....
    require_once("include/DBconnect.php");
    $db = new DBconnect();
    $conn = $db->connect();
    $file = fopen("callbacklog.txt", "a"); //url fopen should be allowed for this to occur
    if(fwrite($file, $postData) === FALSE)
    {
        fwrite("Error: no data written");
    }

    fwrite("\r\n");
    fclose($file);

    $callbackData=json_decode($postData);
    $resultCode=$callbackData->Body->stkCallback->ResultCode;
    $resultDesc=$callbackData->Body->stkCallback->ResultDesc;
    $merchantRequestID=$callbackData->Body->stkCallback->MerchantRequestID;
    $checkoutRequestID=$callbackData->Body->stkCallback->CheckoutRequestID;

    $amount=$callbackData->stkCallback->Body->CallbackMetadata->Item[0]->Value;
    $mpesaReceiptNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[1]->Value;
    $balance=$callbackData->stkCallback->Body->CallbackMetadata->Item[2]->Value;
    $b2CUtilityAccountAvailableFunds=$callbackData->Body->stkCallback->CallbackMetadata->Item[3]->Value;
    $transactionDate=$callbackData->Body->stkCallback->CallbackMetadata->Item[4]->Value;
    $phoneNumber=$callbackData->Body->stkCallback->CallbackMetadata->Item[5]->Value;
    // $query1 = "Insert into lipanampesa(merchantRequestID,ResultCode,ResultDesc) values(?,?,?)";
    // $stmt = $conn->prepare($query1);
    // $stmt->bind_param('sss',$merchantRequestID,$resultCode,$resultDesc);
    // $stmt->execute();
    // $stmt->close();
    
    if($resultCode == 0){
        $query = "Update lipanampesa set mpesaReceiptNumber = '$mpesaReceiptNumber',balance ='$balance',
        ResultCode = '$resultCode',ResultDesc = '$resultDesc' where merchantRequestID = '$merchantRequestID'";
        $stmt = $conn->query($query);
        if($stmt){
            echo "Data inserted successfully";
        }    
        else{
            echo "Data could not be inserted";
        } 
    }
    else{
        $query1 = "Update lipanampesa set ResultCode = '$resultCode',ResultDesc='$resultDesc' where 
        merchantRequestID='$merchantRequestID'";
        $stmt1 = $conn->query($query1);
        if($stmt1){
            echo "Data added successfully";
        } 
        else{
            echo "Data could not be added";
        }
    }
    
    echo json_encode('{"ResponseCode":"00000000","ResultDesc":"Success"}');
?>