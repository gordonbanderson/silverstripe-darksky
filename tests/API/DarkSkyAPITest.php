<?php


namespace Tests\Suilven\DarkSky\API;


use SilverStripe\Dev\SapphireTest;
use Suilven\DarkSky\API\DarkSkyAPI;
use Suilven\DarkSky\Helper\WeatherDataPopulator;
use Tests\Suilven\DarkSky\Client\TestOvercastClient;
use Tests\Suilven\DarkSky\ClientAdapters\TestClientAdapter;
use VertigoLabs\Overcast\Forecast;
use VertigoLabs\Overcast\Overcast;
use VertigoLabs\Overcast\ValueObjects\DataPoint;

class DarkSkyAPITest extends SapphireTest
{
    protected $ignoreHeaders = array(
        'Accept',
        'Connect-Time',
        'Total-Route-Time',
        'X-Request-Id',
    );


    public function test_forecast_at_location()
    {
        $testAdapter = new TestClientAdapter();
        $api = new DarkSkyAPI();

        // Lumpini park in Bangkok, data hardwired using the above test adapter
        /** @var Forecast $forecast */
        $forecast = $api->getForecastAt(13.7309428,100.5408634);

        echo $api->getNumberOfAPICalls().' API Calls Today'."\n";

// temperature current information
        echo 'Current Temp: '.$forecast->getCurrently()->getTemperature()->getCurrent()."\n";
        echo 'Feels Like: '.$forecast->getCurrently()->getApparentTemperature()->getCurrent()."\n";
        echo 'Min Temp: '.$forecast->getCurrently()->getTemperature()->getMin()."\n";
        echo 'Max Temp: '.$forecast->getCurrently()->getTemperature()->getMax()."\n";

// get daily summary
        echo 'Daily Summary: '.$forecast->getDaily()->getSummary()."\n";

        $populator = new WeatherDataPopulator();

        $currentWeatherRecord = $populator->createRecord($forecast->getCurrently());
        $currentWeatherRecord->write();

// loop daily data points
        /** @var DataPoint $dailyData */
        foreach($forecast->getDaily()->getData() as $dailyData) {
            echo "ICON: " . $dailyData->getIcon() . "\n";
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

    }
}
