<?php

require_once('init.php');

// Inputs
$customerId = $_GET['customer'];

// Get user invoices
try {
	
	$invoices = \Stripe\Invoice::all(array(
		'customer' => $customerId
	));
	
} catch(Exception $e) {
	echo json_encode(array('error' => array('message' => $e->getMessage())));
	return;
}

echo $invoices->__toJSON();
