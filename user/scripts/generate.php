<?php

include('../../scripts/functions.php');

$feedback = generate_and_insert_coupons($count = 20);

if($feedback){
    $response = array(
        'success' => true,
        'message' => '20 coupons generated'
    );
}else{
    $response = array(
        'success' => false,
        'message' => 'no coupons generated'
    );
}



?>