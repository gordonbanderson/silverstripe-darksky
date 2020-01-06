<?php


namespace Suilven\DarkSky\API;


use SilverStripe\Core\Config\Config;
use Suilven\DarkSky\Client\OvercastClient;
use Suilven\DarkSky\Client\TestOvercastClient;
use Suilven\DarkSky\Interfaces\DarkSkyClientInterface;
use VertigoLabs\Overcast\ClientAdapters\ClientAdapter;
use VertigoLabs\Overcast\Overcast;

class DarkSkyAPI
{
    /**
     * @var DarkSkyClientInterface
     */
    private $client;

    /**
     * DarkSkyAPI constructor.
     * @param ClientAdapter|null $clientAdapter
     */
    public function __construct($clientAdapter = null)
    {
         $this->createClient($clientAdapter);
    }

    private function getAPIKey()
    {
        return Config::inst()->get(DarkSkyAPI::class, 'api_key');
    }

    /**
     * @param ClientAdapter|null $clientAdapter
     */
    private function createClient($clientAdapter = null)
    {
        $apiKey = $this->getAPIKey();
        $this->client = $clientAdapter === null ? new Overcast($apiKey) : new Overcast($apiKey, $clientAdapter);
    }

    public function setClient(DarkSkyClientInterface $newClient)
    {
        $this->client = $newClient;
    }

    public function getForecastAt($latitude, $longitude)
    {
        return $this->client->getForecast($latitude, $longitude, null, ['units' => 'auto']);
    }

    public function getNumberOfAPICalls()
    {
        return $this->client->getApiCalls();
    }
}
