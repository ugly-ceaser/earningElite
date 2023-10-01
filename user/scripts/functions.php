<?php

include("connect.php");



function getAllPatients() {
    global $host, $dbname, $username, $password;

    try {
        
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Set PDO to throw exceptions on errors
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to retrieve all patients
        $sql = "SELECT * FROM patients";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch all patients as an associative array
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Close the database connection
        $conn = null;

        return $patients;
    } catch(PDOException $e) {
        // Handle any database connection or query errors
        die("Database Error: " . $e->getMessage());
    }
}


function getTotalPatients() {
    global $host, $dbname, $username, $password;

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Set PDO to throw exceptions on errors
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to count the total number of patients
        $sql = "SELECT COUNT(*) as total FROM patients";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch the total as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Close the database connection
        $conn = null;

        // Return 0 if no patients are found
        return isset($result['total']) ? $result['total'] : 0;
    } catch(PDOException $e) {
        // Handle any database connection or query errors
        die("Database Error: " . $e->getMessage());
    }
}


function getAllAppointments() {
    global $host, $dbname, $username, $password;

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Set PDO to throw exceptions on errors
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to retrieve all appointments
        $sql = "SELECT * FROM appointments";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch all appointments as an associative array
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Close the database connection
        $conn = null;

        return $appointments;
    } catch(PDOException $e) {
        // Handle any database connection or query errors
        die("Database Error: " . $e->getMessage());
    }
}

// Function to get the total number of appointments where status is pending
function getTotalPendingAppointments() {
    global $host, $dbname, $username, $password;

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Set PDO to throw exceptions on errors
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to count pending appointments
        $sql = "SELECT COUNT(*) as total FROM appointments WHERE appointment_status = 'pending'";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch the total as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Close the database connection
        $conn = null;

        return isset($result['total']) ? $result['total'] : 0;
    } catch(PDOException $e) {
        // Handle any database connection or query errors
        die("Database Error: " . $e->getMessage());
    }
}

// Function to get all lab results
function getAllLabResults() {
    global $host, $dbname, $username, $password;

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Set PDO to throw exceptions on errors
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to retrieve all lab results
        $sql = "SELECT * FROM labsandtests";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch all lab results as an associative array
        $labResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Close the database connection
        $conn = null;

        return $labResults;
    } catch(PDOException $e) {
        // Handle any database connection or query errors
        die("Database Error: " . $e->getMessage());
    }
}

// Function to get the total number of lab results where status is pending
function getTotalPendingLabResults() {
    global $host, $dbname, $username, $password;

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Set PDO to throw exceptions on errors
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to count pending lab results
        $sql = "SELECT COUNT(*) as total FROM labsandtests WHERE status = 'pending'";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch the total as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Close the database connection
        $conn = null;

        return isset($result['total']) ? $result['total'] : 0;
    } catch(PDOException $e) {
        // Handle any database connection or query errors
        die("Database Error: " . $e->getMessage());
    }
}

// Function to get all bills
function getAllBills() {
    global $host, $dbname, $username, $password;

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Set PDO to throw exceptions on errors
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to retrieve all bills
        $sql = "SELECT * FROM billing";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch all bills as an associative array
        $bills = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Close the database connection
        $conn = null;

        return $bills;
    } catch(PDOException $e) {
        // Handle any database connection or query errors
        die("Database Error: " . $e->getMessage());
    }
}

// Function to get the total number of bills where status is pending
function getTotalPendingBills() {
    global $host, $dbname, $username, $password;

    try {
        // Create a PDO connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Set PDO to throw exceptions on errors
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to count pending bills
        $sql = "SELECT COUNT(*) as total FROM billing WHERE payment_status = 0";

        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch the total as an associative array
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Close the database connection
        $conn = null;

        return isset($result['total']) ? $result['total'] : 0;
    } catch(PDOException $e) {
        // Handle any database connection or query errors
        die("Database Error: " . $e->getMessage());
    }
}




?>
