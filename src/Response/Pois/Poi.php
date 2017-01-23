<?php
/**
 *
 *
 * @author    Jan Eichhorn <jan.eichhorn@trivago.com>
 * @since     2017-01-23
 * @copyright 2017 (c) trivago GmbH, Düsseldorf
 * @license   All rights reserved.
 */

namespace Trivago\Tas\Response\Pois;

use Trivago\Tas\Response\Common\GeoCoordinates;

class Poi
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var GeoCoordinates
     */
    private $geoCoordinates;

    public function __construct($id, $name, GeoCoordinates $coordinates)
    {
        $this->id             = (int) $id;
        $this->name           = $name;
        $this->geoCoordinates = $coordinates;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return GeoCoordinates
     */
    public function getGeoCoordinates()
    {
        return $this->geoCoordinates;
    }
}
