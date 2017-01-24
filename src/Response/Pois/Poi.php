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
