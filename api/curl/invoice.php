<?php

// Inputs
$customerId = $_GET ['customer'];

// Get user inovices
$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, "https://api.stripe.com/v1/invoices?customer=$customerId" );
curl_setopt ( $ch, CURLOPT_USERPWD, 'sk_test_SHbu5VHieCiBSe7jdwwgZJ0H:' );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

$invoices = curl_exec ( $ch );

curl_close ( $ch );
echo $invoices;
