<?php

/*
 * Copyright 2017 trivago N.V.
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

class RatingDetailsAspect
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $ratingPercentage;

    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $index;

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public static function fromArray(array $data)
    {
        $aspect                   = new static();
        $aspect->type             = $data[ 'type' ];
        $aspect->name             = $data[ 'name' ];
        $aspect->ratingPercentage = (float) $data[ 'rating_percentage' ];
        $aspect->text             = $data[ 'text' ];
        $aspect->index            = (int) $data[ 'index' ];

        return $aspect;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getRatingPercentage()
    {
        return $this->ratingPercentage;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }
}
