<?php
require '../vendor/autoload.php';

// Include the necessary dependencies

use Flick\FlickPhpSdk\Bills;
use Flick\FlickPhpSdk\Config;

// Initialize the Bills class with your API key and specify the environment ('sandbox' or 'production')
$bills = new Bills(new Config('sandbox', 'your-api-key-here'));

// Define the data for generating invoice

$invoiceData = [
  'egs_uuid' => '7b9cc231-0e14-4bff-938c-4603fe10c4bc',
  'invoice_ref_number' => 'INV-5',
  'issue_date' => '2023-01-01',
  'issue_time' => '01:40:40',
  'party_details' => [
    'party_name_ar' => 'شركة اختبار',
    'party_vat' => '300001111100003',
    'party_add_id' => [
      'crn' => 45463464,
    ],
    'city_ar' => 'جدة',
    'city_subdivision_ar' => 'حي الشرفية',
    'street_ar' => 'شارع الاختبار',
    'plot_identification' => '1234',
    'building' => '1234',
    'postal_zone' => '12345',
  ],
  'doc_type' => '388',
  'inv_type' => 'standard',
  'payment_method' => 10,
  'currency' => 'SAR',
  'total_tax' => 142.0,
  'has_advance' => true,
  'advance_details' => [
    'advance_amount' => 575,
    'total_amount' => 2875,
    'advance_invoices' => [
      [
        'tax_category' => 'S',
        'tax_percentage' => 0.15,
        'taxable_amount' => 500,
        'tax_amount' => 75,
        'invoices' => [
          [
            'id' => 'INV-1',
            'issue_date' => '2022-12-10',
            'issue_time' => '12:28:17',
          ],
        ],
      ],
    ],
  ],
  'lineitems' => [
    [
      'name_ar' => 'متحرك',
      'quantity' => 1,
      'tax_category' => 'S',
      'tax_exclusive_price' => 750,
      'tax_percentage' => 0.15,
    ],
    [
      'name_ar' => 'حاسوب محمول',
      'quantity' => 1,
      'tax_category' => 'S',
      'tax_exclusive_price' => 1750,
      'tax_percentage' => 0.15,
    ],
  ],
];



// Perform the EGS onboarding operation asynchronously and handle the result or error
$promise = $bills->generate_invoice($invoiceData);

$promise->then(function ($result) {
  // Handle the successful result
  print($result);
})->otherwise(function ($exception) {
  // Handle the error 
  print($exception->getResponse()->getBody()->getContents());
})->wait();
