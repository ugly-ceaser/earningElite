<?php
include './conn.php';
include './functions.php';
session_start();
header('Content-Type: application/json');

$patientID = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get appointment data from the POST request
    $appointment_purpose = $_POST["appointment_purpose"];
    $section = $_POST["section"];
    $time = $_POST["time"];
    $date = $_POST["date"];
    $date_booked = date("Y-m-d H:i:s");

    // Create an object to hold appointment data
    $appointmentData = (object) [
        "patientID" => $patientID,
        "appointment_purpose" => $appointment_purpose,
        "section" => $section,
        "time" => $time,
        "date" => $date,
    ];
    try{
    // Call the bookAppointment function to book the appointment
    $message = bookAppointment($appointmentData);

    if ($message['success'] == true) {

        $data = array("success" => true, "message" => "Appointment successfully booked");
        echo json_encode($data);

       ;
    } else {
       $data = array("success" => false, "message" => "Appointment Booking Error");
        echo json_encode($data);
    }
    }catch (Exception $e) {
        $response = array("success" => false, "message" => $e->getMessage());
        echo json_encode($response);
    }
}
?>
