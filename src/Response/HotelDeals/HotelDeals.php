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

namespace Trivago\Tas\Response\HotelDeals;

use Trivago\Tas\Response\Common\Deal;
use Trivago\Tas\Response\Response;

class HotelDeals implements \Countable, \Iterator
{
    /**
     * @var Deal[]
     */
    private $deals = [];

    /**
     * @var array
     */
    private $searchParams = null;

    /**
     * @var bool
     */
    private $pollingFinished;

    /**
     * @param Response $response
     *
     * @return static
     */
    public static function fromResponse(Response $response)
    {
        $responseData                = $response->getContentAsArray();
        $hotelDeals                  = new static();
        $hotelDeals->pollingFinished = $response->getHttpCode() === 200;
        $hotelDeals->deals           = array_map(function (array $deal) {
            return Deal::fromArray($deal);
        }, $responseData['deals']);
        $hotelDeals->searchParams    = $responseData['search_params'];

        return $hotelDeals;
    }

    /**
     * Indicates if the polling was finished. If the polling was not finished there might be updated prices.
     * The request has to be repeated until the polling finished.
     *
     * @return bool
     */
    public function pollingFinished()
    {
        return $this->pollingFinished;
    }

    /**
     * @return Deal[]
     */
    public function toArray()
    {
        return $this->deals;
    }

    /**
     * @return array
     */
    public function getSearchParams()
    {
        return $this->searchParams;
    }

    /**
     * @return Deal
     */
    public function current()
    {
        return current($this->deals);
    }

    public function next()
    {
        next($this->deals);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->deals);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return current($this->deals) !== false;
    }

    public function rewind()
    {
        reset($this->deals);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->deals);
    }
}
