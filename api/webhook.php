<?php
require_once ('init.php');

// Retrieve the request's body and parse it as JSON
$input		= @file_get_contents("php://input");
$eventJson	= json_decode($input);

// Do something with $eventJson
if($eventJson->type == 'customer.subscription.trial_will_end') {
	$customerId = $eventJson->data->object->customer;
	
	try {
		$customer = \Stripe\Customer::retrieve($customerId);
		
		// Use VSocial email service
		mail($customer->email, 'Trial Ending Soon', 'Trial Ending Soon');
		
	} catch(Stripe\Error\InvalidRequest $e) {
		
	}
}

http_response_code ( 200 );
