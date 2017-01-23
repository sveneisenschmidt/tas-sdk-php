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
use Trivago\Tas\Response\Response;

class Pois implements \Iterator, \Countable
{
    /**
     * @var Poi[]
     */
    private $pois;

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    public static function fromResponse(Response $response)
    {
        $data = $response->getContentAsArray();

        $pois = new static();
        foreach ($data['_embedded']['pois'] as $poi) {
            $pois->pois[] = new Poi(
                $poi['id'],
                $poi['name'],
                new GeoCoordinates(
                    $poi['geo_coordinates']['latitude'],
                    $poi['geo_coordinates']['longitude']
                )
            );
        }

        return $pois;
    }

    /**
     * @return Poi[]
     */
    public function toArray()
    {
        return $this->pois;
    }

    /**
     * @return Poi|false
     */
    public function current()
    {
        return current($this->pois);
    }

    public function next()
    {
        next($this->pois);
    }

    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->pois);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return current($this->pois) !== false;
    }

    public function rewind()
    {
        reset($this->pois);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->pois);
    }
}
