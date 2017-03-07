<?php

require_once('init.php');

$subscription = \Stripe\Subscription::all(array(
	'customer'	=> 'cus_AF34La3bXOrBwQ'
));

echo $subscription->__toJSON();
