# Flick Php SDK
![Platform](https://img.shields.io/badge/php-7.2.5+-orange)
![Platform](https://img.shields.io/badge/php-8+-blue)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)


A php interface for interacting with the APIs of Flick.

- [Installation](#installation)
- [Getting Started](#getting-started)
- [Documentation](#documentation)
- [Examples](#examples)
- [Contribute to our SDK](#contributing)
- [License](#license)
- [Support](#support)

## Installation
To use the Flick Php SDK in your project, you can install it via composer:

```bash
composer require flick/flick-php-sdk
```

## Getting Started
Before using the package, you need to configure it with your API credentials. You should have an apiKey and specify whether you are using the 'sandbox' or 'production' environment.

Here's how you to initiate our SDK in your project:

```php
use Flick\FlickPhpSdk\Bills;
use Flick\FlickPhpSdk\Config;

// Initialize the Bills class with your API key and specify the environment ('sandbox' or 'production')
$bills = new Bills(new Config('sandbox', 'your-api-key-here'));
```
### Note 
You may need to import the autoload file depending on the framework (or lack thereof) you choose
```php
require 'vendor/autoload.php';
```

## Documentation
To learn about available methods and their usage, please refer to the [official API documentation](https://docs.flick.network/).
Here's a glimpse to our Bills Module:

### Bills Client
The Bills client provides access to various functionalities for managing bills. You can interact with the following API endpoints:

#### Onboard EGS to ZATCA:

```php
$egs_data = [ /* your EGS data goes here*/ ]

$response = $bills->onboard_egs($egsData)->wait();
print($response->getBody()->getContents());
```

#### Compliance Check:

```php
$egs_uuid = 'egs-uuid';

$response = $bills->do_compliance_check($egs_uuid);
print($response->getBody()->getContents());
```

#### Generate E-Invoice for Phase-2 in Saudi Arabia:
```php
$invoice_data = [ /* your Invoice data goes here*/ ]

$response = $bills->generate_invoice($egsData)->wait();
print($response->getBody()->getContents());
```

## Examples

1. Here's an Example of how you can **onboard multiple EGS to ZATCA Portal** [If you are onboarding PoS devices or VAT-Group members, this comes handy].

2. Examples are included in the examples folder as well

```php
<?php

// Include the necessary dependencies
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

 
```

2. Here's an Example of how you can **Genereate a ZATCA-Complied E-Invoice**.

```php
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

```

## Contributing

We welcome contributions from the community. If you find issues or have suggestions for improvements, please open an issue or create a pull request.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

If you encounter any issues or have questions, please contact our support team at support@flick.network

## Keywords 

einvoicing, e-invoicing, zatca, phase2, saudi, ksa, fatoora, saudiarabia, egs
