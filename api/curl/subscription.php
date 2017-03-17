<?php

// Inputs
$customerId = $_GET ['customer'];

// Get user subscriptions
$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, "https://api.stripe.com/v1/subscriptions?customer=$customerId" );
curl_setopt ( $ch, CURLOPT_USERPWD, 'sk_test_SHbu5VHieCiBSe7jdwwgZJ0H:' );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

$subscriptions = json_decode ( curl_exec ( $ch ) );

curl_close ( $ch );

// Get all the plans
$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, 'https://api.stripe.com/v1/plans' );
curl_setopt ( $ch, CURLOPT_USERPWD, 'sk_test_SHbu5VHieCiBSe7jdwwgZJ0H:' );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

$plans = json_decode ( curl_exec ( $ch ) );

curl_close ( $ch );

// Loop through the plan & look for product user not subscribed
$notSubscribedProducts = array ();
$subscribedProducts = array ();

foreach ( $subscriptions->data as $sub ) {
	if (! in_array ( $sub->plan->metadata->product, $subscribedProducts )) {
		$subscribedProducts [] = $sub->plan->metadata->product;
	}
}

foreach ( $plans->data as $plan ) {
	
	if (! in_array ( $plan->metadata->product, $subscribedProducts ) && ! array_key_exists ( $plan->metadata->product, $notSubscribedProducts )) {
		
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
$result ['subscribed'] = $subscriptions;
$result ['notsubscribed'] = $notSubscribedProducts;

echo json_encode ( $result );
