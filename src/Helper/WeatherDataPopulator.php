<?php declare(strict_types = 1);

namespace Suilven\DarkSky\Helper;

use Smindel\GIS\GIS;
use Suilven\DarkSky\Model\WeatherDataPoint;
use Suilven\DarkSky\Model\WeatherLocation;

class WeatherDataPopulator
{
    /** @param \Suilven\DarkSky\Helper\DataPoint $darkSkyDataPoint data from dark sky */
    public function generatePopulatedRecord(DataPoint $darkSkyDataPoint): WeatherDataPoint
    {
        $record = new WeatherDataPoint();
        $record->CloudCoverage = $darkSkyDataPoint->getCloudCover();
        $record->CurrentTemperature = $darkSkyDataPoint->getTemperature()->getCurrent();
        $record->DewPoint = $darkSkyDataPoint->getDewPoint();
        $record->Humidity = $darkSkyDataPoint->getHumidity();
        $record->Icon = $darkSkyDataPoint->getIcon();
        $record->MaxTemperature = $darkSkyDataPoint->getTemperature()->getMax();
        $record->MinTemperature = $darkSkyDataPoint->getTemperature()->getMin();
        $record->FeelsLikeTemperature = $darkSkyDataPoint->getApparentTemperature()->getCurrent();
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


    /** @throws \SilverStripe\ORM\ValidationException */
    public function createPopulatedRecordWithLocation(
        float $latitude,
        float $longitude,
        DataPoint $darkSkyDataPoint
    ): WeatherDataPoint {
        $weatherRecord = $this->generatePopulatedRecord($darkSkyDataPoint);
        $weatherRecord->write();

        $gis = GIS::create([$longitude, $latitude]);

        $matchingLocations = WeatherLocation::get()->filter('Location:ST_Equals', $gis->ewkt);

        /** @var \Suilven\DarkSky\Model\WeatherLocation $location */
        $location = null;
        if ($matchingLocations->count() === 0) {
            $location = new WeatherLocation();
            $location->Location = $gis->ewkt;
            $location->write();
        } else {
            $location = $matchingLocations->first();
        }

        $location->DataPoints()->add($weatherRecord);

        return $weatherRecord;
    }
}
