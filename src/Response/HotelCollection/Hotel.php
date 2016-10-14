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

namespace Trivago\Tas\Response\HotelCollection;

use Trivago\Tas\Response\Common\Deal;
use Trivago\Tas\Response\Common\Image;

class Hotel
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
     * @var int
     */
    private $category;

    /**
     * @var bool
     */
    private $superior;

    /**
     * @var string
     */
    private $city;

    /**
     * @var float
     */
    private $ratingValue;

    /**
     * @var int
     */
    private $ratingCount;

    /**
     * @var Image
     */
    private $mainImage;

    /**
     * @var Deal[]
     */
    private $deals;

    public function __construct($id, $name, $category, $superior, $city, $ratingValue, $ratingCount, Image $mainImage, array $deals)
    {
        $this->id          = (int) $id;
        $this->name        = $name;
        $this->category    = (int) $category;
        $this->superior    = (bool) $superior;
        $this->city        = $city;
        $this->ratingValue = (float) $ratingValue;
        $this->ratingCount = (float) $ratingCount;
        $this->mainImage   = $mainImage;
        $this->deals       = $deals;
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
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return bool
     */
    public function isSuperior()
    {
        return $this->superior;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return float
     */
    public function getRatingValue()
    {
        return $this->ratingValue;
    }

    /**
     * @return int
     */
    public function getRatingCount()
    {
        return $this->ratingCount;
    }

    /**
     * @return Image
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @return Deal[]
     */
    public function getDeals()
    {
        return $this->deals;
    }

    /**
     * @return bool
     */
    public function hasDeals()
    {
        return count($this->deals) > 0;
    }
    /**
     * @return Deal|null
     */
    public function getBestDeal()
    {
        return isset($this->deals[0]) ? $this->deals[0] : null;
    }
}
