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

namespace Trivago\Tas;

use Trivago\Tas\Request\HotelCollectionRequest;
use Trivago\Tas\Request\HotelDetailsRequest;
use Trivago\Tas\Request\HotelRatesRequest;
use Trivago\Tas\Request\HotelTagsRequest;
use Trivago\Tas\Request\LocationsRequest;
use Trivago\Tas\Request\PoisRequest;
use Trivago\Tas\Response\HotelCollection\HotelCollection;
use Trivago\Tas\Response\HotelDetails\HotelDetails;
use Trivago\Tas\Response\HotelRates\HotelRates;
use Trivago\Tas\Response\HotelTags\HotelTags;
use Trivago\Tas\Response\Locations\Locations;
use Trivago\Tas\Response\Pois\Pois;
use Trivago\Tas\Response\ProblemException;

/**
 * @method Locations       getLocations(LocationsRequest $request)
 * @method HotelTags       getHotelTags(HotelTagsRequest $request)
 * @method HotelRates      getHotelRates(HotelRatesRequest $request)
 * @method HotelDetails    getHotelDetails(HotelDetailsRequest $request)
 * @method HotelCollection getHotelCollection(HotelCollectionRequest $request)
 * @method Pois            getPois(PoisRequest $request)
 */
class Tas
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private static $responseMap = [
        'getLocations' => [
            'response' => Locations::class,
            'request'  => LocationsRequest::class,
        ],
        'getHotelTags' => [
            'response' => HotelTags::class,
            'request'  => HotelTagsRequest::class,
        ],
        'getHotelRates' => [
            'response' => HotelRates::class,
            'request'  => HotelRatesRequest::class,
        ],
        'getHotelDetails' => [
            'response' => HotelDetails::class,
            'request'  => HotelDetailsRequest::class,
        ],
        'getHotelCollection' => [
            'response' => HotelCollection::class,
            'request'  => HotelCollectionRequest::class,
        ],
        'getPois' => [
            'response' => Pois::class,
            'request'  => PoisRequest::class
        ],
    ];

    public function __construct(Config $config)
    {
        $this->client = new Client($config);
    }

    public function __call($name, $arguments)
    {
        if (!isset(static::$responseMap[$name])) {
            throw new \BadMethodCallException("Method {$name} does not exist.");
        }

        $request      = $arguments[0];
        $requestClass = static::$responseMap[$name]['request'];
        if (!$request instanceof static::$responseMap[$name]['request']) {
            throw new \InvalidArgumentException("Invalid Request: Expected {$requestClass} but got " . get_class($request));
        }

        $response = $this->client->sendRequest($request);

        $httpStatus = $response->getHttpCode();
        if ($httpStatus >= 200 && $httpStatus <= 299) {
            return call_user_func([
                static::$responseMap[$name]['response'],
                'fromResponse',
            ], $response);
        }

        $data = $response->getContentAsArray();

        throw new ProblemException(
            isset($data['type']) ? $data['type'] : '',
            isset($data['title']) ? $data['title'] : '',
            isset($data['detail']) ? $data['detail'] : '',
            isset($data['code']) ? $data['code'] : '',
            $response
        );
    }
}
