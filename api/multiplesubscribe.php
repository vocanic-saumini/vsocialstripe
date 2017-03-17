<?php
require_once ('init.php');

// Inputs
$customer	= $_POST ['customer'];
$newPlan	= $_POST ['plan'];

try {
	
	$subscription = \Stripe\Subscription::create(array(
		'customer'	=> $customer,
		'plan'		=> $newPlan 
	));
	
} catch(Exception $e) {
	echo json_encode(array(
			'error' => array(
				'message' => $e->getMessage() 
			)
	));
	return;
}

echo $subscription->__toJSON ();
