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

use Trivago\Tas\Response\Common\Path;

class ResultInfo
{
    /**
     * @var int
     */
    private $minPrice;

    /**
     * @var int
     */
    private $maxPrice;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var Path|null
     */
    private $path;

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    /**
     * @param array $data
     *
     * @return ResultInfo
     */
    public static function fromArray(array $data)
    {
        $resultInfo = new static();

        $price                = $data['price'];
        $resultInfo->minPrice = (int) $price['min'];
        $resultInfo->maxPrice = (int) $price['max'];
        $resultInfo->currency = $price['currency'];

        if (isset($data['path'])) {
            $resultInfo->path = Path::fromArray($data['path']);
        }

        return $resultInfo;
    }

    /**
     * @return int
     */
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * @return int
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    public function hasPath()
    {
        return $this->path !== null;
    }

    /**
     * @return Path|null
     */
    public function getPath()
    {
        return $this->path;
    }

}
