<?php

// Inputs
$subscriptionId = $_POST ['subscription'];

// Cancel subscription
$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, "https://api.stripe.com/v1/subscriptions/$subscriptionId" );
curl_setopt ( $ch, CURLOPT_USERPWD, 'sk_test_SHbu5VHieCiBSe7jdwwgZJ0H:' );
curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'DELETE' );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

$result = curl_exec ( $ch );

echo $result;
