<?php
namespace Suilven\DarkSky\Helper;

use Suilven\DarkSky\Model\WeatherDataPoint;
use VertigoLabs\Overcast\ValueObjects\DataPoint;

class WeatherDataPopulator
{
    /**
     * @param DataPoint $darkSkyDataPoint
     */
    public function createRecord($darkSkyDataPoint)
    {
        $record = new WeatherDataPoint();
        $record->CloudCoverage = $darkSkyDataPoint->getCloudCover();
        $record->DewPoint = $darkSkyDataPoint->getCloudCover();
        $record->Humidity = $darkSkyDataPoint->getCloudCover();
        $record->Icon = $darkSkyDataPoint->getCloudCover();
        $record->MaxTemperature = $darkSkyDataPoint->getCloudCover();
        $record->MinTemperature = $darkSkyDataPoint->getCloudCover();
        $record->MoonPhase = $darkSkyDataPoint->getCloudCover();
        $record->PrecipitationDensity = $darkSkyDataPoint->getCloudCover();
        $record->PrecipitationProbablity = $darkSkyDataPoint->getCloudCover();
        $record->Visibility = $darkSkyDataPoint->getCloudCover();
        $record->When = $darkSkyDataPoint->getCloudCover();
        $record->WindSpeed = $darkSkyDataPoint->getCloudCover();
        $record->WindBearing = $darkSkyDataPoint->getCloudCover();
        return $record;
    }

}
