<?php


namespace Suilven\DarkSky\Interfaces;


interface DarkSkyClientInterface
{
    public function getForecast($latitude, $longitude, \DateTime $time = null, array $parameters = null);

}
