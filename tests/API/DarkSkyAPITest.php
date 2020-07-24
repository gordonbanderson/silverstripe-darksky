<?php declare(strict_types = 1);

namespace Tests\Suilven\DarkSky\API;

use SilverStripe\Dev\SapphireTest;
use Suilven\DarkSky\API\DarkSkyAPI;
use Suilven\DarkSky\Helper\WeatherDataPopulator;
use Suilven\DarkSky\Model\WeatherDataPoint;
use Suilven\DarkSky\Model\WeatherLocation;
use Tests\Suilven\DarkSky\ClientAdapters\TestClientAdapter;

class DarkSkyAPITest extends SapphireTest
{
    protected $ignoreHeaders = [
        'Accept',
        'Connect-Time',
        'Total-Route-Time',
        'X-Request-Id',
     ];


    public function testForecastAtLocation(): void
    {
        $testAdapter = new TestClientAdapter();
        $api = new DarkSkyAPI($testAdapter);

        // Lumpini park in Bangkok, data hardwired using the above test adapter
        /** @var \VertigoLabs\Overcast\Forecast $forecast */
        $forecast = $api->getForecastAt(13.7309428, 100.5408634);



        $this->assertEquals(18, $api->getNumberOfAPICalls());

        $populator = new WeatherDataPopulator();

        $nDataRecordsAtStart = WeatherDataPoint::get()->count();

        $currentWeatherRecord = $populator->createPopulatedRecordWithLocation(
            $forecast->getLatitude(),
            $forecast->getLongitude(),
            $forecast->getCurrently()
        );



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

        /** @var \VertigoLabs\Overcast\ValueObjects\DataPoint $singleDayForecast */
         $singleDayForecast =$dailyForecasts->getData()[4];

         /** @var \Suilven\DarkSky\Model\WeatherDataPoint $singleDayRecord */
         $singleDayRecord = $populator->generatePopulatedRecord($singleDayForecast);

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


        $location = $currentWeatherRecord->Location;
        $this->assertEquals(1, WeatherLocation::get()->count());
        $this->assertEquals($location, WeatherLocation::get()->first());

        // test an arbitrary couple of days from the weekly forecast
        $allDailyData = $forecast->getDaily()->getData();
        $currentWeatherRecord = $populator->createPopulatedRecordWithLocation(
            $forecast->getLatitude(),
            $forecast->getLongitude(),
            $allDailyData[0]
        );
        $this->assertEquals(0.01, $currentWeatherRecord->CloudCoverage);
        $this->assertEquals(0.35, $currentWeatherRecord->MoonPhase);
        $this->assertEquals(96.74, $currentWeatherRecord->MaxTemperature);
        $this->assertEquals(75.61, $currentWeatherRecord->MinTemperature);

        $currentWeatherRecord = $populator->createPopulatedRecordWithLocation(
            $forecast->getLatitude(),
            $forecast->getLongitude(),
            $allDailyData[4]
        );
        $this->assertEquals(0.47, $currentWeatherRecord->CloudCoverage);
        $this->assertEquals(0.49, $currentWeatherRecord->MoonPhase);
        $this->assertEquals(99.03, $currentWeatherRecord->MaxTemperature);
        $this->assertEquals(76.7, $currentWeatherRecord->MinTemperature);



        $this->assertEquals(1, WeatherLocation::get()->count());
        $nDataRecordsAtEnd = WeatherDataPoint::get()->count();
        $delta = $nDataRecordsAtEnd - $nDataRecordsAtStart;
        $this->assertEquals(3, $delta);
    }
}
