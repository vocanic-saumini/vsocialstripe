<?php

// Inputs
$token	= $_POST ['token'];
$email	= $_POST ['email'];
$plan	= $_POST ['plan'];

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, 'https://api.stripe.com/v1/customers' );
curl_setopt ( $ch, CURLOPT_USERPWD, 'sk_test_SHbu5VHieCiBSe7jdwwgZJ0H:' );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POST, 1 );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, "email=$email&source=$token&plan=$plan" );

$customer = curl_exec ( $ch );

curl_close ( $ch );
echo $customer;
