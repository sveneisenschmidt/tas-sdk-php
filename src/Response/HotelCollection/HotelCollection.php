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
use Trivago\Tas\Response\Response;

class HotelCollection implements \Countable, \Iterator
{
    /**
     * @var Hotel[]
     */
    private $hotel = [];

    /**
     * @var array
     */
    private $searchParams = [];

    /**
     * @var ResultInfo
     */
    private $resultInfo;

    /**
     * @var Tag[]
     */
    private $tags = [];

    /**
     * @var bool
     */
    private $pollingFinished = false;

    /**
     * @var bool
     */
    private $hasNextPage = false;

    /**
     * @var bool
     */
    private $hasPrevPage = false;

    /**
     * @var int|null
     */
    private $nextPageOffset = null;

    /**
     * @var int|null
     */
    private $prevPageOffset = null;

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    /**
     * @param Response $response
     *
     * @return HotelCollection
     */
    public static function fromResponse(Response $response)
    {
        $responseData                     = $response->getContentAsArray();
        $hotelCollection                  = new static();
        $hotelCollection->pollingFinished = $response->getHttpCode() === 200;
        $hotelCollection->searchParams    = $responseData['search_params'];
        $hotelCollection->resultInfo      = ResultInfo::fromArray($responseData['result_info']);

        if (isset($responseData['_links']['next'])) {
            $hotelCollection->hasNextPage    = true;
            $hotelCollection->nextPageOffset = static::extractOffsetFromUrl($responseData['_links']['next']['href']);
        }

        if (isset($responseData['_links']['prev'])) {
            $hotelCollection->hasPrevPage    = true;
            $hotelCollection->prevPageOffset = static::extractOffsetFromUrl($responseData['_links']['prev']['href']);
        }

        foreach ($responseData['hotels'] as $data) {
            $hotelDetails = $data['_embedded']['hotel_details'];
            $hotelRates   = $data['_embedded']['hotel_rates'];

            $hotelCollection->hotel[] = new Hotel(
                $hotelDetails['id'],
                $hotelDetails['name'],
                $hotelDetails['category'],
                $hotelDetails['superior'],
                $hotelDetails['city'],
                $hotelDetails['rating_value'],
                $hotelDetails['rating_count'],
                Image::fromArray($hotelDetails['main_image']),
                array_map(function (array $deal) {
                    return Deal::fromArray($deal);
                }, $hotelRates),
                isset($data['_embedded']['poi']) ? Poi::fromArray($data['_embedded']['poi']) : null
            );
        }

        foreach ($responseData['_embedded']['hotel_tags']['tags'] as $data) {
            $hotelCollection->tags[] = Tag::fromArray($data);
        }

        return $hotelCollection;
    }

    /**
     * @param $url
     *
     * @return int|null
     */
    private static function extractOffsetFromUrl($url)
    {
        preg_match('/offset=([0-9]+)/', $url, $matches);

        return isset($matches[1]) ? (int) $matches[1] : null;
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
     * @return array
     */
    public function getSearchParams()
    {
        return $this->searchParams;
    }

    /**
     * @return ResultInfo
     */
    public function getResultInfo()
    {
        return $this->resultInfo;
    }

    /**
     * @return Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return bool
     */
    public function hasNextPage()
    {
        return $this->hasNextPage;
    }

    /**
     * @return int|null
     */
    public function getNextPageOffset()
    {
        return $this->nextPageOffset;
    }

    /**
     * @return bool
     */
    public function hasPrevPage()
    {
        return $this->hasPrevPage;
    }

    /**
     * @return int|null
     */
    public function getPrevPageOffset()
    {
        return $this->prevPageOffset;
    }

    /**
     * @return Hotel[]
     */
    public function toArray()
    {
        return $this->hotel;
    }

    /**
     * @return Hotel|false
     */
    public function current()
    {
        return current($this->hotel);
    }

    public function next()
    {
        next($this->hotel);
    }

    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->hotel);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return current($this->hotel) !== false;
    }

    public function rewind()
    {
        reset($this->hotel);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->hotel);
    }
}
