<?php

// Include the necessary dependencies
require '../vendor/autoload.php';

use Flick\FlickPhpSdk\Bills;
use Flick\FlickPhpSdk\Config;

// Initialize the Bills class with your API key and specify the environment ('sandbox' or 'production')
$bills = new Bills(new Config('sandbox', 'your-api-key-here'));

// Define the data for onboarding EGS
$egsData = [
  'vat_name' => 'Test Co.',
  'vat_number' => '300000000000003',
  'devices' => [
    [
      'device_name' => 'TestEGS1',
      'city' => 'Riyadh',
      'city_subdiv' => 'Test Dist.',
      'street' => 'Test St.',
      'plot' => '1234',
      'building' => '1234',
      'postal' => '12345',
      'branch_name' => 'Riyad Branch 1',
      // This will be a 10-digit TIN if you are onboarding a VAT-Group Member
      'branch_industry' => 'Retail',
      'otp' => '123321',
    ],
    [
      'device_name' => 'TestEGS2',
      'city' => 'Riyadh',
      'city_subdiv' => 'Test Dist.',
      'street' => 'Test St.',
      'plot' => '1234',
      'building' => '1234',
      'postal' => '12345',
      'branch_name' => 'Riyad Branch 2',
      // This will be a 10-digit TIN if you are onboarding a VAT-Group Member
      'branch_industry' => 'Retail',
      'otp' => '321123',
    ],
  ],
];

// Perform the EGS onboarding operation asynchronously and handle the result or error
$promise = $bills->onboard_egs($egsData);

$promise->then(function ($result) {
  // Handle the successful result
  print($result);
})->otherwise(function ($exception) {
  // Handle the error 
  print($exception->getResponse()->getBody()->getContents());
})->wait();
