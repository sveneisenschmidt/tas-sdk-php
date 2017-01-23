<?php

/*
 * Copyright 2016 trivago GmbH
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *    http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Trivago\Tas\Response\HotelDetails;

use Trivago\Tas\Response\Common\GeoCoordinates;

class Path
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

    /**
     * @param int            $id
     * @param string         $name
     * @param GeoCoordinates $geoCoordinates
     */
    public function __construct($id, $name, GeoCoordinates $geoCoordinates)
    {
        $this->geoCoordinates = $geoCoordinates;
        $this->id             = (int) $id;
        $this->name           = $name;
    }

    public static function fromArray(array $data)
    {
        return new static($data['id'], $data['name'], GeoCoordinates::fromArray($data['geo_coordinates']));
    }

    /**
     * @return GeoCoordinates
     */
    public function getGeoCoordinates()
    {
        return $this->geoCoordinates;
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
}
