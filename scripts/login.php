<?php
include './conn.php';
include './functions.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $email = $_POST["email"];
    $pass = $_POST["password"];

    // Call the loginUser function
    $response = loginUser($email, $pass);
    



    // Check the response from loginUser
    if ($response['success']) {
        echo json_encode($response);
    } else {
        echo json_encode($response);
    }
}
?>
