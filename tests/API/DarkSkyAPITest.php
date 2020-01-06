<?php


namespace Tests\Suilven\DarkSky\API;


use SilverStripe\Dev\SapphireTest;
use Suilven\DarkSky\API\DarkSkyAPI;

class DarkSkyAPITest extends SapphireTest
{
    public function test_forecast_at_location()
    {
        $api = new DarkSkyAPI();
        // Lumpini park in Bangkok
        $forecast = $api->getForecastAt(13.7309428,100.5408634);

        error_log(print_r($forecast, 1));
    }
}
