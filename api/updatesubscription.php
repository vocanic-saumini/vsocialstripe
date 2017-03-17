<?php
require_once ('init.php');

$subscriptionId	= $_POST ['subscription'];
$newPlan		= $_POST ['plan'];

$subscription = \Stripe\Subscription::retrieve($subscriptionId);
$subscription->plan = $newPlan;
$subscription->save();

echo $subscription->__toJSON ();
