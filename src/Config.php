<?php
namespace Flick\FlickPhpSdk;

class Config
{
    // Config class for passing the API key and selecting between
    const SANDBOX = 'sandbox';
    const PRODUCTION = 'production';

    public $environment;
    public $api_key;

    public function __construct($environment, $api_key)
    {
        if ($environment === self::SANDBOX || $environment === self::PRODUCTION) {
            $this->environment = $environment;
            $this->api_key = $api_key;
        } else {
            throw new InvalidEnvironmentException("Invalid environment type. Use 'sandbox' or 'production'");
        }
    }
}
