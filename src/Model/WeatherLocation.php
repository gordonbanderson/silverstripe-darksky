<?php declare(strict_types = 1);

namespace Suilven\DarkSky\Model;

use SilverStripe\ORM\DataObject;

class WeatherLocation extends DataObject
{
    private static $table_name = 'SuilvenWeatherLocation';

    private static $db = [
        'Title' => 'Varchar(50)',
      'Location' => 'Geometry',
    ];

    private static $has_many = [
        'DataPoints' => WeatherDataPoint::class,
    ];
}
