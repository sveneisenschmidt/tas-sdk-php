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

use Trivago\Tas\Response\HotelDetails\RatingDetailsAspect;

class RatingDetails
{

    /**
     * @var RatingDetailsAspect[]
     */
    private $aspects;

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
        $ratingDetails           = new static();
        $ratingDetails->aspects  = [];

        foreach($data['aspects'] as $aspect) {
            $ratingDetails->aspects []= RatingDetailsAspect::fromArray($aspect);
        }

        return $ratingDetails;
    }

    /**
     * @return array
     */
    public function getAspects()
    {
        return $this->aspects;
    }
}
