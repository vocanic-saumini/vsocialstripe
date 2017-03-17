<?php

// Inputs
$subscriptionId = $_POST ['subscription'];
$newPlan = $_POST ['plan'];

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, "https://api.stripe.com/v1/subscriptions/$subscriptionId" );
curl_setopt ( $ch, CURLOPT_USERPWD, 'sk_test_SHbu5VHieCiBSe7jdwwgZJ0H:' );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POST, 1 );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, "plan=$newPlan" );

$subscription = curl_exec ( $ch );

curl_close ( $ch );
echo $subscription;
