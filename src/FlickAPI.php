<?php
namespace Flick\FlickPhpSdk;

use GuzzleHttp\Client as GuzzleClient;

class InvalidEnvironmentException extends \Exception
{
    // For raising invalid environment exceptions
}


class FlickAPI extends GuzzleClient
{
    // A custom Guzzle client for making authenticated requests to a specified base URL

    const SANDBOX_BASE_URL = "https://sandbox-api.flick.network";
    const PRODUCTION_BASE_URL = "https://api.flick.network";

    protected $custom_config;
    protected $base_url;

    public function __construct(Config $config)
    {
        // Initialize the custom client with a custom configuration
        $this->custom_config = $config;
        $this->base_url = $this->get_base_url();

        parent::__construct([
            'base_uri' => $this->base_url,
            'headers' => [
                'Authorization' => 'Bearer ' . $config->api_key,
            ],
        ]);
    }

    protected function get_base_url()
    {
        // Get the base URL for making requests
        if ($this->custom_config->environment === Config::PRODUCTION) {
            return self::PRODUCTION_BASE_URL;
        }
        return self::SANDBOX_BASE_URL;
    }

   
}
?>
