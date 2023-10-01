<?php
// Include necessary files
include './conn.php';
include './functions.php';

// Check if the HTTP request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve user input data from the POST request
    $full_name = $_POST["full_name"];
    $phone_number = $_POST["phone_number"];
    $coupon_code = $_POST["coupon"];
    $referee_code = $_POST["referal_code"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $date = date("Y-m-d H:i:s");

    // Hash the user's password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Create a user data object with the provided input
    $userData = (object) [
        "full_name" => $full_name,
        "phone_number" => $phone_number,
        "email" => $email,
        "password" => $hashed_password,
        "date" => $date,
        "coupon_code" => $coupon_code,
        "referee_code" => $referee_code // Corrected variable name
    ];

    // Call the createUser function to attempt user registration
    $feedback = createUser($userData);

    // Check if user registration was successful
    if ($feedback['success']) {
        // Retrieve the user's ID by their email
        $user_id = getUserDetails($email, "email")['user_id'];

        // Check if the user ID exists, indicating a valid user account
        if (!$user_id) {
            // Respond with an error message if the account is not credited
            echo json_encode(array('success' => false, 'message' => 'Account is not credited'));
        } else {
            // Credit the user's account with an initial amount
            $amount = 4000;
            $message = CreditUser($user_id, $amount);

            deactivateCoupon($coupon_code);

            // Check if the user has a referee code
            if ($referee_code != "none") {
                $referrer = getUserDetails($referee_code, "referal_code");

                if ($referrer) {
                    $referrer_id = $referrer['user_id'];

                    // Credit the referee with $1000
                    $amount = 1000;
                    $feedback = updateEarnings($referrer_id, $amount, "referal_earning");

                    // Check if the referee has a referrer (second-level referral)
                    if ($referrer['referee_code']) {
                        $second_referrer = getUserDetails($referrer['referee_code'], "referal_code");

                        if ($second_referrer) {
                            $second_referrer_id = $second_referrer['user_id'];

                            // Credit the second-level referee with $500
                            $amount = 500;
                            $feedback = updateEarnings($second_referrer_id, $amount, "referal_earning");
                        }
                    }
                }
            }

            $response = array(
              'success' => true,
              'message' => 'Registration Successful'
          );

          // Set the Content-Type header to indicate JSON
          header('Content-Type: application/json');

          // Encode the response as JSON and send it to the client
          echo json_encode($response);
        }
    } else {
      $response = array(
        'success' => false,
        'message' => $feedback['message']
    );

    // Set the Content-Type header to indicate JSON
    header('Content-Type: application/json');

    // Encode the response as JSON and send it to the client
    echo json_encode($response);
    }
}
?>
