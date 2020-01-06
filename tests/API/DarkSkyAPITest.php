<?php


namespace Tests\Suilven\DarkSky\API;


use SilverStripe\Dev\SapphireTest;
use Suilven\DarkSky\API\DarkSkyAPI;

class DarkSkyAPITest extends SapphireTest
{
    protected $ignoreHeaders = array(
        'Accept',
        'Connect-Time',
        'Total-Route-Time',
        'X-Request-Id',
    );

    public function setUp()
    {
        parent::setUp();
       // \VCR\VCR::configure()->setCassettePath('tests/vcr');
    }

    public function test_forecast_at_location()
    {
    //    \VCR\VCR::turnOn();
    //    \VCR\VCR::insertCassette('test-forecast-at-location.yml');
        $api = new DarkSkyAPI();
        // Lumpini park in Bangkok
        $forecast = $api->getForecastAt(13.7309428,100.5408634);

        error_log('F=' . print_r($forecast, 1));

        echo $api->getNumberOfAPICalls().' API Calls Today'."\n";

// temperature current information
        echo 'Current Temp: '.$forecast->getCurrently()->getTemperature()->getCurrent()."\n";
        echo 'Feels Like: '.$forecast->getCurrently()->getApparentTemperature()->getCurrent()."\n";
        echo 'Min Temp: '.$forecast->getCurrently()->getTemperature()->getMin()."\n";
        echo 'Max Temp: '.$forecast->getCurrently()->getTemperature()->getMax()."\n";

// get daily summary
        echo 'Daily Summary: '.$forecast->getDaily()->getSummary()."\n";

// loop daily data points
        foreach($forecast->getDaily()->getData() as $dailyData) {
            echo 'Date: '.$dailyData->getTime()->format('D, M jS y')."\n";
            // get daily temperature information
            echo 'Min Temp: '.$dailyData->getTemperature()->getMin()."\n";
            echo 'Max Temp: '.$dailyData->getTemperature()->getMax()."\n";

            // get daily precipitation information
            echo 'Precipitation Probability: '.$dailyData->getPrecipitation()->getProbability()."\n";
            echo 'Precipitation Intensity: '.$dailyData->getPrecipitation()->getIntensity()."\n";

            // get other general daily information
            echo 'Wind Speed: '.$dailyData->getWindSpeed()."\n";
            echo 'Wind Direction: '.$dailyData->getWindBearing()."\n";
            echo 'Visibility: '.$dailyData->getVisibility()."\n";
            echo 'Cloud Coverage: '.$dailyData->getCloudCover()."\n";
            echo "\n\n";
        }

      //  \VCR\VCR::turnOff();
    }
}
