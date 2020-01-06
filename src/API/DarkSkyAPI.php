<?php


namespace Suilven\DarkSky\API;


use VertigoLabs\Overcast\Overcast;

class DarkSkyAPI
{
    /**
     * @var Overcast
     */
    private $client;

    private function getAPIKey()
    {
        return $this->config()->get('api_key');
    }

    private function getClient()
    {
        $apiKey = $this->getAPIKey();
        $this->client = new Overcast($apiKey);
    }

    public function getForecastAt($latitude, $longitude)
    {

    }
}
