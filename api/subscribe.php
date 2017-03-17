<?php
require_once ('init.php');

// Inputs
$token	= $_POST ['token'];
$email	= $_POST ['email'];
$plan	= $_POST ['plan'];

$customer = \Stripe\Customer::create(array(
	'email'		=> $email,
	'source'	=> $token,
	'plan'		=> $plan 
));

echo $customer->__toJSON ();
