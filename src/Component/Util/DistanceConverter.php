<?php
/**
 * @author    Björn Mayer <bjoern.mayer@trivago.com>
 * @since     2017-01-23
 * @copyright 2017 (c) trivago GmbH, Düsseldorf
 * @license   All rights reserved.
 */

namespace Trivago\Tas\Component\Util;

final class DistanceConverter
{
    public static function footToMeter($feet)
    {
        return $feet * .3048;
    }

    public static function yardToMeter($yards)
    {
        return $yards * .9144;
    }

    public static function mileToMeter($miles)
    {
        return $miles * 1609.344;
    }

    public static function nauticMileToMeter($nauticMiles)
    {
        return $nauticMiles * 1853.184;
    }

    public static function meterToFoot($meters)
    {
        return $meters / .3048;
    }

    public static function meterToYard($meters)
    {
        return $meters / .9144;
    }

    public static function meterToMile($meters)
    {
        return $meters / 1609.344;
    }

    public static function meterToNauticMile($meters) {
        return $meters / 1853.184;
    }

    public static function meterToKilometer($meters)
    {
        return $meters / 1000;
    }

    public static function meterToAstronomicalUnit($meters)
    {
        return $meters / 149597870700;
    }
}
