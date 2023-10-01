<?php
include './conn.php';
include './functions.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $oldPassword = $_POST["old_password"];
    $newPassword = $_POST["new_password"];
    $email = $_POST["email"];
    $userId = $_SESSION['id'];

    $userPassword = getUserDetails($userId)['password'];


   

    $userData = (object)[
        "id" => $_SESSION['id'] ?? null,
        "newEmail" => $email ?? null,
        "newPassword" => $newPassword ?? null,

    ];

   

    

    if( $oldPassword != $userPassword || $userPassword == $newPassword){

        $Data = array("success" => false, "message" => "Old password is not correct");

        echo json_encode($Data);

    }else{

        $message = updateUserLogDetails($userData);

        $Data = array("success" => true, "message" => "user log details updated");
    
        echo json_encode($Data);

    }

    


    
   
}
?>
