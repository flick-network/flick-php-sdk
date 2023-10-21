<?php

namespace Flick\FlickPhpSdk;

use Flick\FlickPhpSdk\FlickAPI;

class Bills
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function onboard_egs($egs_data)
    {
        $client = new FlickAPI($this->config);
        return $client->postAsync('/egs/onboard', $egs_data);
        
    }

    public function do_compliance_check($egs_uuid)
    {
        $client = new FlickAPI($this->config);
        $response = $client->getAsync("/egs/compliance-check/$egs_uuid");
        return $response;
    }

    public function generate_invoice($invoice_data)
    {
        $client = new FlickAPI($this->config);
        $response = $client->postAsync('/invoice/generate', $invoice_data);
        return $response;
    }
}
