<?php
include './conn.php';
include './functions.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Get data from the AJAX request
        $full_name = $_POST["full_name"];
        $phone_number = $_POST["phone_number"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $date = date("Y-m-d H:i:s");

        // Check if the email already exists
        // if (emailExists($email)) {
        //     $ReturnData = (object)[
        //         "success" => false,
        //         "message" => "Email already exists",
        //     ];
        //     $jsonResponse = json_encode($ReturnData);
        //     echo $jsonResponse;
        //     exit; // Terminate script
        // }

        $userData = (object) [
            "full_name" => $full_name,
            "phone_number" => $phone_number,
            "email" => $email,
            "password" => $password,
            "date" => $date,
        ];

        // Call the createUser function
        $message = createUser($userData);

        if ($message['success'] == true) {
            // Get the user details using the email
            $userId = getUserDetails($email);

            if (is_array($userId) && isset($userId['patient_id'])) {
                $patientID = $userId['patient_id'];

                $billObject = (object) [
                    "patientID" => $patientID,
                    "amount" => 500.00,
                    "reason" => "Card Creation",
                    "discount" => 0,
                    "providerID" => 0,
                    "Paid" => false,
                ];

                // Call the insertBillFromObject function
                insertBillFromObject($billObject);
            }

            $appointment_purpose = $_POST["appointment_purpose"];
            $section = $_POST["section"];
            $time = $_POST["time"];
            $date = $_POST["date"];
            $date_booked = date("Y-m-d H:i:s");

            $appointmentData = (object) [
                "patientID" => $patientID,
                "appointment_purpose" => $appointment_purpose,
                "section" => $section,
                "time" => $time,
                "date" => $date,
            ];

            // Call the bookAppointment function
            $message = bookAppointment($appointmentData);

            if ($message['success'] == true) {
                $ReturnData = (object)[
                    "success" => true,
                    "message" => "Account created successfully and Appointment Booked",
                ];

                $jsonResponse = json_encode($ReturnData);
                echo $jsonResponse;
            } else {
                $ReturnData = (object)[
                    "success" => false,
                    "message" => "Appointment Booking Error",
                ];

                $jsonResponse = json_encode($ReturnData);
                echo $jsonResponse;
            }
        } else {
            $ReturnData = (object)[
                "success" => false,
                "message" => "Account not created successfully",
            ];

            $jsonResponse = json_encode($ReturnData);
            echo $jsonResponse;
        }
    } catch (Exception $e) {
        $ReturnData = (object)[
            "success" => false,
            "message" => $e->getMessage(),
        ];

        $jsonResponse = json_encode($ReturnData);
        echo $jsonResponse;
    }
}
?>
