<?php

require_once('init.php');

$invoice = \Stripe\Invoice::all(array(
	'customer'	=> 'cus_AF34La3bXOrBwQ'
));

echo $invoice->__toJSON();
