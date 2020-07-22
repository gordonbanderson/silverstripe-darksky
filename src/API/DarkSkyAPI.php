<?php declare(strict_types = 1);

namespace Suilven\DarkSky\API;

use SilverStripe\Core\Config\Config;
use Suilven\DarkSky\ClientAdapters\CachedClientAdapter;
use Suilven\DarkSky\Interfaces\DarkSkyClientInterface;
use VertigoLabs\Overcast\Overcast;

class DarkSkyAPI
{
    /** @var \Suilven\DarkSky\Interfaces\DarkSkyClientInterface */
    private $client;

    /**
     * DarkSkyAPI constructor.
     */
    public function __construct(?ClientAdapter $clientAdapter = null)
    {
        if (empty($clientAdapter)) {
            $clientAdapter = new CachedClientAdapter();
        }
         $this->createClient($clientAdapter);
    }


    public function setClient(DarkSkyClientInterface $newClient): void
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


    private function getAPIKey()
    {
        return Config::inst()->get(DarkSkyAPI::class, 'api_key');
    }


    private function createClient(?ClientAdapter $clientAdapter = null): void
    {
        $apiKey = $this->getAPIKey();
        $this->client = $clientAdapter === null ? new Overcast($apiKey) : new Overcast($apiKey, $clientAdapter);
    }
}
