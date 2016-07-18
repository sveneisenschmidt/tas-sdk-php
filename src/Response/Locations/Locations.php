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

use Trivago\Tas\Response\Response;

class Locations implements \Iterator, \Countable
{
    /**
     * @var array|Location[]
     */
    private $locations = [];

    /**
     * @var string
     */
    private $query = '';

    /**
     * @var bool
     */
    private $queryCorrected = false;

    private function __constructor()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    public static function fromResponse(Response $response)
    {
        $data = $response->getContentAsArray();

        $locations                 = new static();
        $locations->query          = $data['query'];
        $locations->queryCorrected = $data['query_corrected'];
        foreach ($data['_embedded']['locations'] as $locationData) {
            $locations->locations[] = new Location(
                $locationData['count'],
                $locationData['item'],
                $locationData['name'],
                $locationData['path'],
                $locationData['path_name'],
                $locationData['type']
            );
        }

        return $locations;
    }

    /**
     * @return Location[]
     */
    public function toArray()
    {
        return $this->locations;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return bool
     */
    public function isQueryCorrected()
    {
        return $this->queryCorrected;
    }

    /**
     * @return Location|false
     */
    public function current()
    {
        return current($this->locations);
    }

    public function next()
    {
        next($this->locations);
    }

    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->locations);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return current($this->locations) !== false;
    }

    public function rewind()
    {
        reset($this->locations);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->locations);
    }
}
