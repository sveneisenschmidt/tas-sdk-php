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

namespace Trivago\Tas\Response\HotelReviews;

use Trivago\Tas\Response\Response;

class Reviews implements \Countable, \Iterator
{
    /**
     * @var Review[]
     */
    private $reviews = [];

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instaces.
    }

    public static function fromResponse(Response $response)
    {
        $data = $response->getContentAsArray();

        $configs = [];
        foreach ($data['configs'] as $config) {
            if (!isset($configs[$config['partner_id']])) {
                $configs[$config['partner_id']] = Config::fromArray($config);
            }
        }

        $rawReviews = [];
        foreach ($data['reviews'] as $review) {
            $review['config'] = $configs[$review['partner_id']];
            $rawReviews[] = Review::fromArray($review);
        }

        $reviews = new static();
        $reviews->reviews = $rawReviews;

        return $reviews;
    }

    /**
     * @return Review|false
     */
    public function current()
    {
        return current($this->reviews);
    }

    public function next()
    {
        next($this->reviews);
    }

    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->reviews);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return current($this->reviews) !== false;
    }

    public function rewind()
    {
        reset($this->reviews);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->reviews);
    }
}
