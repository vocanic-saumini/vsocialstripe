<?php

require_once('init.php');

// 1 - Using Stripe PHP library
try {
	
	$plans = \Stripe\Plan::all();
	
} catch(Exception $e) {
	echo json_encode(array('error' => array('message' => $e->getMessage())));
	return;
}

echo $plans->__toJSON();

// // 2 - Using curl
// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/plans');
// curl_setopt($ch, CURLOPT_USERPWD, "sk_test_SHbu5VHieCiBSe7jdwwgZJ0H:");
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// $output = curl_exec($ch);

// curl_close($ch);
// echo $output;
