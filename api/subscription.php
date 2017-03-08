<?php

require_once('init.php');

$customerId	= $_GET['customer'];
$subscription = \Stripe\Subscription::all(array(
	'customer'	=> $customerId
));

echo $subscription->__toJSON();
