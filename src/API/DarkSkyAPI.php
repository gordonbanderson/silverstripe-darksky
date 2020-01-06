<?php


namespace Suilven\DarkSky\API;


use SilverStripe\Core\Config\Config;
use VertigoLabs\Overcast\Overcast;

class DarkSkyAPI
{
    /**
     * @var Overcast
     */
    private $client;

    public function __construct()
    {
         $this->createClient();
    }

    private function getAPIKey()
    {
        return Config::inst()->get(DarkSkyAPI::class, 'api_key');
    }

    private function createClient()
    {
        error_log('Creating client');
        $apiKey = $this->getAPIKey();
        error_log('APIKEY: ' . $apiKey);
        $this->client = new Overcast($apiKey);
    }

    public function getForecastAt($latitude, $longitude)
    {
        return $this->client->getForecast($latitude, $longitude);
    }

    public function getNumberOfAPICalls()
    {
        return $this->client->getApiCalls();
    }
}
