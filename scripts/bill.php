<?php
session_start();
include './conn.php';
include './functions.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    

    $inputJSON = file_get_contents('php://input');
    file_put_contents("received_data.txt", $inputJSON);

    $inputData = json_decode($inputJSON);

    $patientID = $inputData->patientID;
    $amount = $inputData->amount;
    $reason = $inputData->reason;
    $discount = $inputData->discount;
    $providerID = $inputData->providerID;
    $paid = $inputData->Paid;

    $billObject = (object) [
        "patientID" => $patientID,
        "amount" => $amount,
        "reason" => $reason,
        "discount" => $discount,
        "providerID" => $providerID,
        "Paid" => $paid
    ];
    
    echo json_encode( (insertBillFromObject($billObject )));

   


}