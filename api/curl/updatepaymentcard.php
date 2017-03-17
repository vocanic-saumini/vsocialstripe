<?php

// Inputs
$stripeToken = $_POST ['token'];
$customerId = $_POST ['customer'];

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, "https://api.stripe.com/v1/customers/$customerId" );
curl_setopt ( $ch, CURLOPT_USERPWD, 'sk_test_SHbu5VHieCiBSe7jdwwgZJ0H:' );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POST, 1 );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, "source=$stripeToken" );

$customer = curl_exec ( $ch );

curl_close ( $ch );
echo $customer;

