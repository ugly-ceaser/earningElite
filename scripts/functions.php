<?php
function connectToDatabase() {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";
    try {
        $dsn = "mysql:host=$host;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);
        
        // Set PDO attributes
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        return $pdo;
    } catch (PDOException $e) {
        // Handle connection errors
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}

function generateUniqueRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    do {
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
    } while (isReferalCodeExists($randomString));

    return $randomString;
}

function isReferalCodeExists($code) {
    // Connect to your database and perform a query to check if the code exists
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE referal_code = ?");
        $stmt->execute([$code]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    } catch (PDOException $e) {
        // Handle the database error as needed
        echo "Error: " . $e->getMessage();
        return false; // Assume it doesn't exist on error
    }
}

function createUser($userData)
{
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    $full_name = $userData->full_name;
    $phone_number = $userData->phone_number;
    $email = $userData->email;
    $hashed_password = $userData->password;
    $date = $userData->date;
    $coupon_code = $userData->coupon_code;
    $referee_code = $userData->referee_code;

    $referal_code = generateUniqueRandomString(10); 

    try {
        // Establish a PDO database connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare an SQL query to insert a new user record
        $stmt = $pdo->prepare("INSERT INTO users (`fullname`, `email`, `password`, `phone_number`, `referal_code`, `referee_code`, `date_joined`, `coupon_code`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$full_name, $email, $hashed_password, $phone_number, $referal_code, $referee_code, $date, $coupon_code]);

        // Check if the insert was successful
        
            return array('success' => true, 'message' => 'Registration Successful');
        
    } catch (PDOException $e) {
        return array('success' => false, 'message' => 'Registration Error: ' . $e->getMessage());
    }
}



function CreditUser($user_id,$amount) {
   

    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";


    $date = date("Y-m-d H:i:s");
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO `user_account` (`user_id`, `total_earning`,`post_earning`,`referal_earning`) VALUES (?, ?,?,?)");
        $stmt->execute([$user_id,$amount,0,0]);
        
        return  $response = array('success' => true); // Return true if insertion is successful
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return  $response = array('success' => false);; // Return false on error
    }
}




function updateEarnings($user_id, $amount, $column) {
    $allowedColumns = ["total_earning", "post_earning", "referal_earning"]; // Add valid column names here

    if (!in_array($column, $allowedColumns)) {
        return array('success' => false, 'message' => 'Invalid column name');
    }

    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM user_account WHERE user_id = ?");
        $stmt->execute([$user_id]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return array('success' => false, 'message' => 'User not found');
        }

        $initial_value = $user[$column];

        $amount = $amount + $initial_value;

        $stmt = $pdo->prepare("UPDATE user_account SET $column = ? WHERE user_id = ?");
        $stmt->execute([$amount, $user_id]);

        return array('success' => true);
    } catch (PDOException $e) {
        return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
    }
}



function loginUser($email, $pass)
{
    session_start();

    if (empty($email) || empty($pass)) {
        return array('success' => false, 'message' => 'Please fill in all fields.', 'data' => null);
    } else {
        // Perform database validation
        $host = "localhost";
        $dbname = "ndpwraxuew_earningeitedb";
        $username = "ndpwraxuew_root";
        $password = "marti08139110216";



        try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `email` = ?");
            $stmt->execute([$email]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($pass, $user['password'])) {
                    $user_id = $user['user_id'];
                   

                    if($user['role'] == 'admin') {
                        
                        $_SESSION['admin'] = $user_id;
                        $role = $user['role'];
                    }else{
                        $_SESSION['id'] = $user_id;
                        $role = $user['role'];
                    }

                    $feedback = checkIfUserIsVendor($user_id);


                    if ($feedback) {
                        $_SESSION['vendor'] = $user_id;
                    }
                    

                    return array('success' => true, 'message' => 'Login successful.', 'data' => $role);
                } else {
                    // Incorrect password
                    return array('success' => false, 'message' => 'Incorrect password.', 'data' => null);
                }
            } else {
                // User not found
                return array('success' => false, 'message' => 'User not found.', 'data' => $email);
            }
        } catch (PDOException $e) {
            return array('success' => false, 'message' => 'Database error: ' . $e->getMessage(), 'data' => null);
        }
    }
}







function updateUserRecord($info,$column) {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
     

        $query = "UPDATE users SET $column = ?  WHERE user_id = ?";
        $values[] = $patientRecord->patientID; // Assuming you have patient_id in the object

        $stmt = $pdo->prepare($query);
        $stmt->execute([$info,$user_id]);

        return true; // Return true if update is successful
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // Return false on error
    }
}


function getUserDetails($info ,$column) {
   

        $host = "localhost";
        $dbname = "ndpwraxuew_earningeitedb";
        $username = "ndpwraxuew_root";
        $password = "marti08139110216";
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               

        // Check if the input is numeric (assuming it's user ID)
       
            $stmt = $pdo->prepare("SELECT * FROM users WHERE $column = ?");
    
        $stmt->execute([$info]);
        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        return $userDetails;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}


function UserAccountDetails($info ,$column) {
   

    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           

    // Check if the input is numeric (assuming it's user ID)
   
        $stmt = $pdo->prepare("SELECT * FROM user_account WHERE $column = ?");

    $stmt->execute([$info]);
    $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    return $userDetails;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    return null;
}
}

function checkcouponStatus($coupon_code) {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    $status = true; // Assuming true represents a valid coupon status

    try {
        // Establish a PDO database connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a SQL query to count records with the provided coupon code and status
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM coupon_codes WHERE coupon_code = ? AND status = ?");
        $stmt->execute([$coupon_code, $status]);

        // Fetch the count of matching records
        $rowCount = $stmt->fetchColumn();

        // Return true if there are matching records (coupon is valid), false otherwise
        return $rowCount > 0;
    } catch (PDOException $e) {
        // Handle any database connection or query errors and return false
        echo "Error: " . $e->getMessage();
        return false;
    }
}



function user_taskStatus($user_id,$post_id) {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM post_tasks WHERE user_id = ? AND post_id = ? ");
        $stmt->execute([$user_id, $post_id]);

        $rowCount = $stmt->fetchColumn();
        
        return  $response = array('success' => !($rowCount > 0)); // Return true if record exists, false otherwise
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // Return false on error
    }
}

function checkIfUserIsVendor($user_id){

    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM vendor_user WHERE user_id = ? ");
        $stmt->execute([$user_id]);

        $rowCount = $stmt->fetchColumn();
        
        return $rowCount > 0; // Return true if record exists, false otherwise
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // Return false on error
    }

}


function fetch_all_posts(){

    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM posts ");
        $stmt->execute();

        $posts = $stmt->fetch(PDO::FETCH_ASSOC);

          return  $posts;
     
            
        
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}


function fetch_all_valid_coupon()
{
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM coupon_codes WHERE status = ?");
        $stmt->execute([1]);

        $coupons = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $coupons;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



function request_withdraw($user_id,$amount){

    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $status = "pending";
        $date_requested = date("Y-m-d H:i:s");

    

        $stmt = $pdo->prepare("INSERT INTO `withdrawal_request` (`user_id`, `amount`, `status`, `date_requested`) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $amount, $status, $date_requested]);
        


        return  $response = array('success' => true);

    } catch (PDOException $e) {
        return  $response = array('success' => $e);
        
    }

}

function generate_and_insert_coupons($count = 20)
{
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $coupons = [];

        for ($i = 0; $i < $count; $i++) {
            $coupon_code = generate_unique_coupon_code();
            $date_created = date("Y-m-d H:i:s");

            // Insert the new coupon into the database
            $stmt = $pdo->prepare("INSERT INTO coupon_codes (coupon_code, status, date_created) VALUES (?, 1, ?)");
            $stmt->execute([$coupon_code, $date_created]);

            $coupons[] = $coupon_code;
        }

        return true; // Return true if the process is completed successfully
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // Return false if an error occurs
    }
}


function generate_unique_coupon_code($length = 10)
{
    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $coupon_code = "";

    do {
        $coupon_code = "";
        for ($i = 0; $i < $length; $i++) {
            $coupon_code .= $characters[rand(0, strlen($characters) - 1)];
        }
    } while (coupon_code_exists($coupon_code));

    return $coupon_code;
}

function coupon_code_exists($coupon_code)
{
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM coupon_codes WHERE coupon_code = ?");
        $stmt->execute([$coupon_code]);

        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



function deactivateCoupon($couponCode)
{
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        // Create a PDO database connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare an SQL query to update the coupon status
        $stmt = $pdo->prepare("UPDATE coupon_codes SET status = 0 WHERE coupon_code = ?");
        $stmt->execute([$couponCode]);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            return true; // Coupon code status updated successfully
        } else {
            return false; // Coupon code not found or status already updated
        }
    } catch (PDOException $e) {
        return false; // Error occurred during database operation
    }
}

// Example usage:

















































function insertPatientRecord($patientRecord) {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO patient_record (patient_id, contact_address, phone_number, date_of_birth, next_of_kin_name, next_of_kin_relationship, next_of_kin_address, provider_id, blood_group, genotype, gender, marital_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $patientRecord->patientID,
            $patientRecord->contact_address,
            $patientRecord->phone_number,
            $patientRecord->date_of_birth,
            $patientRecord->next_of_kin_name,
            $patientRecord->next_of_kin_relationship,
            $patientRecord->next_of_kin_address,
            $patientRecord->insurance_provider,
            $patientRecord->blood_group,
            $patientRecord->genotype,
            $patientRecord->gender,
            $patientRecord->marital_status
        ]);

        return true; // Return true if insertion is successful
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // Return false on error
    }
}



function updateUserLogDetails($userData) {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    $update = false;

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $userId = $userData->id;
        $newEmail = isset($userData->newEmail) ? $userData->newEmail : null;
        $newPassword = isset($userData->newPassword) ? $userData->newPassword : null;

        // Update either email or password based on the provided data
        if ($newEmail !== null) {
            $stmt = $pdo->prepare("UPDATE users SET email = ? WHERE patient_id = ?");
            $stmt->execute([$newEmail, $userId]);

            $update = 1;
        }
        
        if ($newPassword !== null) {
            // You should hash the password before updating
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            // $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE patient_id = ?");
            // $stmt->execute([$hashedPassword, $userId]);

            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE patient_id = ?");
            $stmt->execute([$newPassword, $userId]);

            $update = 2;
        }

        if($update == 1 || $update == 2) {

            return $update;

        }

        return " no Update performed";

        // Return true if update is successful
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // Return false on error
    }
}


function bookAppointment($appointmentData) {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    $dateCreated = date("Y-m-d H:i:s");

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL query with placeholders for the "appointments" table
        $stmt = $pdo->prepare("INSERT INTO appointments (`patient_id`, `appointment_date`, `appointment_time`, `section`, `appointment_purpose`, `date_created`) VALUES (?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            $appointmentData->patientID,
            $appointmentData->date,
            $appointmentData->time,
            $appointmentData->section,
            $appointmentData->appointment_purpose,
            $dateCreated
        ]);

        if ($success) {
            // Return success status
            return ['success' => true];
        } else {
            // Handle any errors here
            $errorInfo = $stmt->errorInfo();
            echo "Error: " . $errorInfo[2];
            
            // Return failure status
            return ['success' => false, 'message' => 'Failed to book appointment'];
        }
    } catch (PDOException $e) {
        // Handle any database connection errors
        echo "Database Error: " . $e->getMessage();

        // Return failure status
        return ['success' => false, 'message' => 'Database connection error'];
    }
}


function getInsuranceProviders() {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM providers");
        $stmt->execute();

        $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $providers;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function getUserBill($userid) {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM billing where patient_id = ?");
        $stmt->execute([$userid]);

        $providers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $providers;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function fetchPrescriptionsByPatientId($userId) {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM prescriptions WHERE patient_id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $prescriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $prescriptions;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}

function fetchAppointmentsByPatientIdAndStatus($userId, $status) {
    // Establish a database connection (you can use the connectToDatabase function from the previous code)
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Prepare and execute the SQL query
        $stmt = $pdo->prepare("SELECT * FROM appointments WHERE patient_id = ? AND appointment_status = ?");
        $stmt->execute([$userId, $status]);

        // Fetch all matching records as an associative array
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Close the database connection
        $pdo = null;

        return $appointments;
    } catch (PDOException $e) {
        // Handle any database query errors
        echo "Error: " . $e->getMessage();
        return []; // Return an empty array on error
    }
}

function fetchLabResults($userId) {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM labsandtests WHERE patient_id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $prescriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $prescriptions;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}


function medicalHistory($userId) {
    $host = "localhost";
    $dbname = "ndpwraxuew_earningeitedb";
    $username = "ndpwraxuew_root";
    $password = "marti08139110216";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT * FROM medicalrecords WHERE patient_id = :userId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $prescriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $prescriptions;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}


?>






















