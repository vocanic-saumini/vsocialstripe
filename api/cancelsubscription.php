<?php

require_once('init.php');

// Inputs
$subscriptionId	= $_POST['subscription'];

// Cancel subscription
try {
	
	$subscription = \Stripe\Subscription::retrieve($subscriptionId);
	$subscription->cancel();
	
} catch(Exception $e) {
	echo json_encode(array('error' => array('message' => $e->getMessage())));
	return;
}

echo $subscription->__toJSON();
