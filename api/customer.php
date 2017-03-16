<?php

require_once('init.php');

// Inputs
$customerId	= $_GET['customer'];

// Get customer
try {
	
	$customer	= \Stripe\Customer::retrieve($customerId);
	
} catch(Exception $e) {
	echo json_encode(array('error' => array('message' => $e->getMessage())));
	return;
}

echo $customer->__toJSON();
