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

namespace Trivago\Tas\Response\Locations;

class Location
{
    /**
     * @var int
     */
    private $count = 0;

    /**
     * @var int|null
     */
    private $itemId;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var int
     */
    private $pathId;

    /**
     * @var string
     */
    private $pathName = '';

    /**
     * @var string
     */
    private $type;

    /**
     * @param int      $count
     * @param int|null $itemId
     * @param string   $name
     * @param int      $pathId
     * @param string   $pathName
     * @param string   $type
     */
    public function __construct($count, $itemId, $name, $pathId, $pathName, $type)
    {
        $this->count    = (int)$count;
        $this->itemId   = $itemId;
        $this->name     = $name;
        $this->pathId   = (int)$pathId;
        $this->pathName = $pathName;
        $this->type     = $type;
    }

    /**
     * Returns the number of hotels.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Returns the item id.
     *
     * Returns null if $this is a path.
     *
     * @return int|null
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Returns the name of the hotel, attraction or path.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPathId()
    {
        return $this->pathId;
    }

    /**
     * @return string
     */
    public function getPathName()
    {
        return $this->pathName;
    }

    /**
     * @see LocationType
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isHotel()
    {
        return $this->type === LocationType::HOTEL;
    }

    /**
     * @return bool
     */
    public function isAttraction()
    {
        return $this->type === LocationType::ATTRACTION;
    }

    /**
     * @return bool
     */
    public function isPath()
    {
        return $this->type === LocationType::PATH;
    }
}
