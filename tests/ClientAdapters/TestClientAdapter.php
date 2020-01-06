<?php

namespace Tests\Suilven\DarkSky\ClientAdapters;

use VertigoLabs\Overcast\ClientAdapterInterface;
use VertigoLabs\Overcast\ClientAdapters\ClientAdapter;

class TestClientAdapter extends ClientAdapter implements ClientAdapterInterface
{

    /** @var array */
    private $headers;

    /**
     * @inheritDoc
     */
    public function getForecast($latitude, $longitude, \DateTime $time = NULL, array $parameters = NULL)
    {
        $path = getcwd() . '/tests/vcr/test-forecast-at-location.yml';
        error_log('PATH: ' . $path);
        $yaml = file_get_contents($path);
        $parsed = yaml_parse($yaml);

        $response = $parsed[0]['response'];

        // these are needed to avoid Forecast erroring out with no debug message
        $this->headers = [
            'responseTime' => (int)($response['headers']['x-response-time']),
            'apiCalls' => (int)($response['headers']['x-forecast-api-calls']),
            'cache' => [
                'maxAge' => '600',
                'expires' => 'Mon, 06 Jan 2020 21:55:07 +0000'
            ]
        ];

        $body = $parsed[0]['response']['body'];
        return json_decode($body, true);
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}