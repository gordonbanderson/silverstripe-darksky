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
        'MoonPhase' => 'Float',
        'PrecipitationIntensity' => 'Float',
        'PrecipitationProbablity' => 'Float',
        'Visibility' => 'Float',
        'When' => DBDatetime::class,
        'WindSpeed' => 'Float',
        'WindBearing' => 'Int', // degrees
    ];

    private static $has_one = [
        'Location' => WeatherLocation::class
    ];
}
