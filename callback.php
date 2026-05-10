<?php
// Receive and log the callback
$callbackData = file_get_contents('php://input');
$logFile = fopen("callback.log", "a");
fwrite($logFile, date('Y-m-d H:i:s') . ": " . $callbackData . "\n");
fclose($logFile);

// Parse the callback data
$callbackData = json_decode($callbackData);

if ($callbackData) {
    // Handle the callback response
    $resultCode = $callbackData->Body->stkCallback->ResultCode;
    $resultDesc = $callbackData->Body->stkCallback->ResultDesc;
    
    // Log the result
    $logFile = fopen("transaction_status.log", "a");
    fwrite($logFile, date('Y-m-d H:i:s') . ": Code: $resultCode, Desc: $resultDesc\n");
    fclose($logFile);
}

// Respond to M-Pesa
header('Content-Type: application/json');
echo json_encode(['ResultCode' => 0, 'ResultDesc' => 'Success']);