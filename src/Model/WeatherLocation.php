<?php declare(strict_types = 1);

namespace Suilven\DarkSky\Model;

use SilverStripe\ORM\DataObject;

class WeatherLocation extends DataObject
{
    /** @var string  */
    private static $table_name = 'SuilvenWeatherLocation';

    /** @var array<string,string> */
    private static $db = [
        'Title' => 'Varchar(50)',
      'Location' => 'Geometry',
    ];

    /** @var array<string,string> */
    private static $has_many = [
        'DataPoints' => WeatherDataPoint::class,
    ];
}
