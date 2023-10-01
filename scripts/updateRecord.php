<?php
include './conn.php';
include './functions.php';
session_start();

header('Content-Type: application/json');



if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $userId = $_SESSION['id'];

    $patientRecord = (object) [
        "contact_address" => $_POST["contact_address"],
        "phone_number" => $_POST["phone_number"],
        "date_of_birth" => $_POST["date_of_birth"],
        "next_of_kin_name" => $_POST["next_of_kin_name"],
        "next_of_kin_relationship" => $_POST["next_of_kin_relationship"],
        "next_of_kin_address" => $_POST["next_of_kin_address"],
        "insurance_provider" => $_POST["insurance_provider"],
        "blood_group" => $_POST["blood_group"],
        "genotype" => $_POST["genotype"],
        "gender" => $_POST["gender"],
        "marital_status" => $_POST["marital_status"],
        'patientID' =>   $userId
    ];





    




    $checkRecordExits = checkPatientRecordExist($userId);




    if($checkRecordExits){

        $message = updatePatientRecord($patientRecord);

        if($message){
            $Data = array("success" => true, "message" => "Record successfully Created");

        }else{
            $Data = array("success" => true, "message" => "Update failed");
        }

        

        echo json_encode($Data);

    }else{


        $message = insertPatientRecord($patientRecord);

        if($message){
            $Data = array("success" => true, "message" =>"Record successfully inserted");

        }else{
            $Data = array("success" => true, "message" =>"Update failed");

        }

     

        
    
        echo json_encode($Data);

    }
    
    

      

    }












