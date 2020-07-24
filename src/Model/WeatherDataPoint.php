<?php declare(strict_types = 1);

namespace Suilven\DarkSky\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;

/**
 * Class WeatherDataPoint
 *
 * @package Suilven\DarkSky\Model
 *
 * These are methods to be used in templates
 * phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
 * @property float $CurrentTemperature
 * @property float $CloudCoverage
 * @property float $DewPoint
 * @property float $Humidity
 * @property string $Icon
 * @property float $MaxTemperature
 * @property float $MinTemperature
 * @property float $FeelsLikeTemperature
 * @property float $MoonPhase
 * @property float $PrecipitationIntensity
 * @property float $PrecipitationProbablity
 * @property float $Visibility
 * @property string $When
 * @property float $WindSpeed
 * @property int $WindBearing
 * @property int $LocationID
 * @method \Suilven\DarkSky\Model\WeatherLocation Location()
 */
class WeatherDataPoint extends DataObject
{
    /** @var string */
    private static $table_name = 'SuilvenWeatherDataPoint';

    /** @var array<string,string> */
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
        // degrees
        'WindBearing' => 'Int',
    ];

    /** @var array<string,string> */
    private static $has_one = [
        'Location' => WeatherLocation::class,
    ];


    /**
     * @param float $value the number to round
     * @param int $precision the number of decimal places
     */
    public function Rounded(float $value, int $precision = 0): float
    {
        return \round($value, $precision);
    }


    /** @return float the fraction as a percentage */
    public function Percentage(float $fraction): float
    {
        return 100*$fraction;
    }
}
