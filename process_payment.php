<?php
header('Content-Type: application/json');

// M-Pesa API credentials
define('CONSUMER_KEY', 'Replace with your actual consumer key');
define('CONSUMER_SECRET', 'Replace with your actual consumer secret');
define('BUSINESS_SHORT_CODE', 'Replace with your actual business short code');
define('PASSKEY', 'Replace with your actual passkey');
define('CALLBACK_URL', 'Replace with your actual callback URL');

try {
    // Validate incoming data
    $data = json_decode(file_get_contents('php://input'));
    
    // Validate phone number format (must be 254XXXXXXXXX)
    if (!preg_match('/^254[0-9]{9}$/', $data->phone)) {
        throw new Exception('Invalid phone number format. Use 254XXXXXXXXX');
    }
    
    // Validate amount (must be between 1 and 300000)
    if (!is_numeric($data->amount) || $data->amount < 1 || $data->amount > 300000) {
        throw new Exception('Amount must be between 1 and 300000');
    }

    // Get access token
    $token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $token_data = base64_encode(CONSUMER_KEY . ':' . CONSUMER_SECRET);

    $token_curl = curl_init($token_url);
    curl_setopt_array($token_curl, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ['Authorization: Basic ' . $token_data],
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2
    ]);

    $token_response = curl_exec($token_curl);
    
    if (curl_errno($token_curl)) {
        throw new Exception('Failed to connect to M-Pesa API: ' . curl_error($token_curl));
    }
    
    $token_result = json_decode($token_response);
    curl_close($token_curl);

    if (!isset($token_result->access_token)) {
        throw new Exception('Invalid API credentials');
    }

    // Prepare STK Push
    $timestamp = date('YmdHis');
    $password = base64_encode(BUSINESS_SHORT_CODE . PASSKEY . $timestamp);
    
    // Update in the stk_data array
    $stk_data = [
        'BusinessShortCode' => BUSINESS_SHORT_CODE,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => (int)$data->amount,
        'PartyA' => $data->phone,
        'PartyB' => BUSINESS_SHORT_CODE,
        'PhoneNumber' => $data->phone,
        'CallBackURL' => CALLBACK_URL,
        'AccountReference' => $data->package,
        'TransactionDesc' => 'Subscription payment for ' . $data->package
    ];

    // Send STK Push request
    $stk_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $stk_curl = curl_init($stk_url);
    curl_setopt_array($stk_curl, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($stk_data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $token_result->access_token,
            'Content-Type: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2
    ]);

    $stk_response = curl_exec($stk_curl);
    
    if (curl_errno($stk_curl)) {
        throw new Exception('STK Push failed: ' . curl_error($stk_curl));
    }
    
    $stk_result = json_decode($stk_response);
    curl_close($stk_curl);

    if (!$stk_result) {
        throw new Exception('Invalid response from M-Pesa');
    }

    if (isset($stk_result->ResponseCode) && $stk_result->ResponseCode === '0') {
        echo json_encode([
            'success' => true,
            'message' => 'Please check your phone to complete payment',
            'CheckoutRequestID' => $stk_result->CheckoutRequestID
        ]);
    } else {
        throw new Exception($stk_result->errorMessage ?? 'Payment request failed');
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}