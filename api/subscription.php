<?php
require_once ('init.php');

// Inputs
$customerId = $_GET ['customer'];

// Get user subscriptions
try {
	
	$subscriptions = \Stripe\Subscription::all(array(
		'customer' => $customerId 
	));
	
} catch(Exception $e) {
	echo json_encode(array(
			'error' => array(
				'message' => $e->getMessage() 
			)
	));
	return;
}

// Get all the plans
try {
	
	$plans = \Stripe\Plan::all();
	
} catch(Exception $e) {
	echo json_encode(array(
			'error' => array(
				'message' => $e->getMessage() 
			)
	));
	return;
}

// Loop through the plan & look for product user not subscribed
$notSubscribedProducts	= array ();
$subscribedProducts		= array ();

foreach($subscriptions->data as $sub ) {
	if(!in_array($sub->plan->metadata->product, $subscribedProducts )) {
		$subscribedProducts[] = $sub->plan->metadata->product;
	}
}

foreach($plans->data as $plan) {
	
	if(!in_array($plan->metadata->product, $subscribedProducts ) && ! array_key_exists($plan->metadata->product, $notSubscribedProducts)) {
		
		// Put the code <-> name in constants
		if ($plan->metadata->product == 'cm') {
			$notSubscribedProducts [$plan->metadata->product] = 'VSocial';
		} else if ($plan->metadata->product == 'mc') {
			$notSubscribedProducts [$plan->metadata->product] = 'Mission Control';
		} else if ($plan->metadata->product == 'voice') {
			$notSubscribedProducts [$plan->metadata->product] = 'Voice';
		}
	}
}

$result = array ();
$result ['subscribed']		= $subscriptions;
$result ['notsubscribed']	= $notSubscribedProducts;

echo json_encode ( $result );
