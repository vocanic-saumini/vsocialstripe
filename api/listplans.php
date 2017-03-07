<?php

require_once('init.php');

$plans = \Stripe\Plan::all();
echo $plans->__toJSON();
