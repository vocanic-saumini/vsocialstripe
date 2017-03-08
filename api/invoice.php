<?php

require_once('init.php');

$customerId	= $_GET['customer'];
$invoice = \Stripe\Invoice::all(array(
	'customer'	=> $customerId
));

echo $invoice->__toJSON();
