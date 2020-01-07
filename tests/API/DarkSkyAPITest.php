<?php


namespace Tests\Suilven\DarkSky\API;


use SilverStripe\Dev\SapphireTest;
use Suilven\DarkSky\API\DarkSkyAPI;
use Suilven\DarkSky\Helper\WeatherDataPopulator;
use Suilven\DarkSky\Model\WeatherDataPoint;
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
        $api = new DarkSkyAPI($testAdapter);

        // Lumpini park in Bangkok, data hardwired using the above test adapter
        /** @var Forecast $forecast */
        $forecast = $api->getForecastAt(13.7309428,100.5408634);

        $this->assertEquals(18, $api->getNumberOfAPICalls());

        $populator = new WeatherDataPopulator();

        $currentWeatherRecord = $populator->createRecord($forecast->getCurrently());
        $currentWeatherRecord->write();

        // note that recordings were made in F, not C, but it does not matter in that we are testing out this module,
        // not the underlying API mechanism
        $this->assertEquals(0, $currentWeatherRecord->CloudCoverage);
        $this->assertEquals(70.73, $currentWeatherRecord->DewPoint);
        $this->assertEquals(0.76, $currentWeatherRecord->Humidity);
        $this->assertEquals('clear-day', $currentWeatherRecord->Icon);
        $this->assertEquals(0, $currentWeatherRecord->MaxTemperature);
        $this->assertEquals(0, $currentWeatherRecord->MinTemperature);
        $this->assertEquals(0, $currentWeatherRecord->MoonPhase);
        $this->assertEquals(0, $currentWeatherRecord->PrecipitationDensity);
        $this->assertEquals(0, $currentWeatherRecord->PrecipitationProbablity);
        $this->assertEquals(10, $currentWeatherRecord->Visibility);
        $this->assertEquals('2020-01-06 00:59:28', $currentWeatherRecord->When);
        $this->assertEquals(2.95, $currentWeatherRecord->WindSpeed);
        $this->assertEquals(30, $currentWeatherRecord->WindBearing);

        $dailyForecasts = $forecast->getDaily();

        /** @var DataPoint $singleDayForecast */
         $singleDayForecast =$dailyForecasts->getData()[4];

         /** @var WeatherDataPoint $singleDayRecord */
         $singleDayRecord = $populator->createRecord($singleDayForecast);

        $this->assertEquals(0.47, $singleDayRecord->CloudCoverage);
        $this->assertEquals(72.74, $singleDayRecord->DewPoint);
        $this->assertEquals(0.69, $singleDayRecord->Humidity);
        $this->assertEquals('partly-cloudy-day', $singleDayRecord->Icon);
        $this->assertEquals(99.03, $singleDayRecord->MaxTemperature);
        $this->assertEquals(76.7, $singleDayRecord->MinTemperature);
        $this->assertEquals(0.49, $singleDayRecord->MoonPhase);
        $this->assertEquals(null, $singleDayRecord->PrecipitationDensity);
        $this->assertEquals(0.05, $singleDayRecord->PrecipitationProbablity);
        $this->assertEquals(10, $singleDayRecord->Visibility);
        $this->assertEquals('2020-01-09 17:00:00', $singleDayRecord->When);
        $this->assertEquals(4.9, $singleDayRecord->WindSpeed);
        $this->assertEquals(198, $singleDayRecord->WindBearing);
    }
}
