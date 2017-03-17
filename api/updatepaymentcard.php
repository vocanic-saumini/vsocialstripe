<?php

require_once ('init.php');

// Inputs
$stripeToken	= $_POST['token'];
$customerId		= $_POST['customer'];

try {
	
	$customer = \Stripe\Customer::retrieve($customerId);
	$customer->source = $stripeToken;
	$customer->save();
	
	echo $customer->__toJSON();
	
} catch(Exception $e) {
	echo json_encode(array('error' => array('message' => $e->getMessage())));
	return;
}
