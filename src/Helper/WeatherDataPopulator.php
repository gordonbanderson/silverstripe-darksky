<?php
namespace Suilven\DarkSky\Helper;

use Carbon\Carbon;
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
        $record->CurrentTemperature = $darkSkyDataPoint->getTemperature()->getCurrent();
        $record->DewPoint = $darkSkyDataPoint->getDewPoint();
        $record->Humidity = $darkSkyDataPoint->getHumidity();
        $record->Icon = $darkSkyDataPoint->getIcon();
        $record->MaxTemperature = $darkSkyDataPoint->getTemperature()->getMax();
        $record->MinTemperature = $darkSkyDataPoint->getTemperature()->getMin();
        $record->MoonPhase = $darkSkyDataPoint->getMoonPhase();
        $record->PrecipitationIntensity = $darkSkyDataPoint->getPrecipitation()->getIntensity();
        $record->PrecipitationProbablity = $darkSkyDataPoint->getPrecipitation()->getProbability();
        $record->Visibility = $darkSkyDataPoint->getVisibility();

        $time = $darkSkyDataPoint->getTime()->format('Y-m-d H:i:s');
        //$carbon = Carbon::createFromTimestamp($time->getTimestamp());
        $record->When = $time;

        $record->WindSpeed = $darkSkyDataPoint->getWindSpeed();
        $record->WindBearing = $darkSkyDataPoint->getWindBearing();
        return $record;
    }

}
