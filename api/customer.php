<?php

require_once('init.php');

$customerId	= $_GET['customer'];
$customer	= \Stripe\Customer::retrieve($customerId);

echo $customer->__toJSON();
