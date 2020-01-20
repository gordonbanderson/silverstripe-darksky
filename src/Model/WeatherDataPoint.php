<?php


namespace Suilven\DarkSky\Model;


use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;

class WeatherDataPoint extends DataObject
{
    private static $table_name = 'SuilvenWeatherDataPoint';

    private static $db = [
        'CurrentTemperature' => 'Float',
        'CloudCoverage' => 'Float',
        'DewPoint' => 'Float',
        'Humidity' => 'Float',
        'Icon' => 'Enum("unknown,clear-day,clear-night,rain,snow,sleet,wind,fog,cloudy,partly-cloudy-day,' .
            'partly-cloudy-night","unknown")',
        'MaxTemperature' => 'Float',
        'MinTemperature' => 'Float',
        'FeelsLikeTemperature' => 'Float',
        'MoonPhase' => 'Float',

        // this is mm per hours
        'PrecipitationIntensity' => 'Float',
        'PrecipitationProbablity' => 'Float',

        //  note Is Precipitation Accumulation of use?

        'Visibility' => 'Float',
        'When' => DBDatetime::class,
        'WindSpeed' => 'Float',
        'WindBearing' => 'Int', // degrees
    ];

    private static $has_one = [
        'Location' => WeatherLocation::class
    ];

    public function Rounded($value, $precision = 0)
    {
        return round($value,$precision);
    }

    public function Percentage($value)
    {
        return 100*$value;
    }
}
