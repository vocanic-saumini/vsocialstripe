<?php

require_once('init.php');

// Retrieve the request's body and parse it as JSON
$input = @file_get_contents("php://input");
$event_json = json_decode($input);

// Do something with $event_json
if($event_json->type == 'customer.subscription.trial_will_end') {
	$customerId = $event_json->data->object->customer;
	
	try {
		$customer = \Stripe\Customer::retrieve($customerId);
// 		$customer = \Stripe\Customer::retrieve('cus_AFWCpyPxnFJ2Dz');
		
		mail($customer->email, 'Trial Ending Soon', 'Trial Ending Soon');
		
	} catch(Stripe\Error\InvalidRequest $e) {
		
	}
}

http_response_code(200);
