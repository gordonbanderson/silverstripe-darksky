<?php


namespace Suilven\DarkSky\API;


use SilverStripe\Core\Config\Config;
use Suilven\DarkSky\Client\OvercastClient;
use Suilven\DarkSky\Client\TestOvercastClient;
use Suilven\DarkSky\Interfaces\DarkSkyClientInterface;
use VertigoLabs\Overcast\Overcast;

class DarkSkyAPI
{
    /**
     * @var DarkSkyClientInterface
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
        $this->client = new Overcast($apiKey);
    }

    public function setClient(DarkSkyClientInterface $newClient)
    {
        $this->client = $newClient;
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
