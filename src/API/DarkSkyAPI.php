<?php declare(strict_types = 1);

namespace Suilven\DarkSky\API;

use SilverStripe\Core\Config\Config;
use Suilven\DarkSky\ClientAdapters\CachedClientAdapter;
use VertigoLabs\Overcast\Overcast;

class DarkSkyAPI
{
    /** @var \VertigoLabs\Overcast\Overcast */
    private $client;

    /**
     * DarkSkyAPI constructor.
     */
    public function __construct(?ClientAdapter $clientAdapter = null)
    {
        if (\is_null($clientAdapter)) {
            $clientAdapter = new CachedClientAdapter();
        }
         $this->createClient($clientAdapter);
    }


    public function setClient(DarkSkyClientInterface $newClient): void
    {
        $this->client = $newClient;
    }


    /** @return \VertigoLabs\Overcast\Forecast */
    public function getForecastAt(float $latitude, float $longitude): Forecast
    {
        return $this->client->getForecast($latitude, $longitude, null, ['units' => 'auto']);
    }


    public function getNumberOfAPICalls(): int
    {
        return $this->client->getApiCalls();
    }


    private function getAPIKey(): string
    {
        return Config::inst()->get(DarkSkyAPI::class, 'api_key');
    }


    private function createClient(?ClientAdapter $clientAdapter = null): void
    {
        $apiKey = $this->getAPIKey();
        $this->client = $clientAdapter === null ? new Overcast($apiKey) : new Overcast($apiKey, $clientAdapter);
    }
}
