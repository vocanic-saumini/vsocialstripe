<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/plans');
curl_setopt($ch, CURLOPT_USERPWD, "sk_test_SHbu5VHieCiBSe7jdwwgZJ0H:");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$plans = curl_exec($ch);

curl_close($ch);
echo $plans;
