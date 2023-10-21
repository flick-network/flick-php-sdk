<?php

// Include the necessary dependencies
require '../vendor/autoload.php';

use Flick\FlickPhpSdk\Bills;
use Flick\FlickPhpSdk\Config;

// Initialize the Bills class with your API key and specify the environment ('sandbox' or 'production')
$bills = new Bills(new Config('sandbox', 'your-api-key-here'));

// Perform the compliance check asynchronously and handle the result or error
$egs_uuid = 'egs-uuid';
$promise = $bills->do_compliance_check($egs_uuid);

$promise->then(function ($result) {
  // Handle the successful result
  print($result);
})->otherwise(function ($exception) {
  // Handle the error 
  print($exception->getResponse()->getBody()->getContents());
})->wait();

