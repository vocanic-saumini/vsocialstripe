<?php
require_once ('init.php');

try {
	
	$plans = \Stripe\Plan::all();
	
} catch (Exception $e) {
	echo json_encode(array(
			'error' => array(
				'message' => $e->getMessage() 
			)
	));
	return;
}

echo $plans->__toJSON ();
