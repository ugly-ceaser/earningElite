<?php
include './conn.php';
include './functions.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $coupon = $_POST["coupon"];

    // Assuming checkcouponStatus returns true for a valid coupon
    $isCouponValid = checkcouponStatus($coupon);

    $response = array('success' => $isCouponValid, 'message' => $isCouponValid ? 'Coupon is valid.' : 'Coupon is invalid.');

    echo json_encode($response);
}
?>
