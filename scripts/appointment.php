<?php
include './conn.php';
include './functions.php';
header('Content-Type: application/json');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the AJAX request
    $appointment_purpose = $_POST["appointment_purpose"];
    $section = $_POST["section"];
    $time = $_POST["time"];
    $date = $_POST["date"];
    $date_booked = date("Y-m-d H:i:s");


   
    $appointmentData = (object) [
        "appointment_purpose" => $appointment_purpose,
        "section" => $section,
        "time" => $time,
        "date" => $date,
        "date_booked" => $date_booked,
       
    ];

   

  $message = createUser($userData);

//   var_dump($message);
 


   $userId = getUserDetails($email);
//    var_dump($userId);
  

   if ($userId){

    $patientID =  $userId['patient_id'] ;


  

    $billObject = (object) [
        "patientID" =>  $patientID,
        "amount" => 500.00,
        "reason" => "Card Creation",
        "discount" => 0,
        "providerID" => 0,
        "Paid" => true 
    ];
   
     $ReturnData =  (object)[
         "success" => true,
         "data" => $billObject
     ];
 
     $jsonResponse = json_encode($ReturnData);
 
     echo $jsonResponse; 
 
     
     
   
 

   }else{

    $ReturnData =  (object)[
        "success" => false,
        "data" => null
    ];
    $jsonResponse = json_encode($ReturnData);
 
     echo $jsonResponse; 
   }

   


   
 }
