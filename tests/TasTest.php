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

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Trivago\Tas\HttpHandler\HttpHandler;
use Trivago\Tas\HttpHandler\HttpRequest;
use Trivago\Tas\Request\HotelCollectionRequest;
use Trivago\Tas\Request\HotelDetailsRequest;
use Trivago\Tas\Request\LocationsRequest;
use Trivago\Tas\Response\HotelCollection\HotelCollection;
use Trivago\Tas\Response\HotelDetails\HotelDetails;
use Trivago\Tas\Response\Locations\Locations;
use Trivago\Tas\Response\ProblemException;
use Trivago\Tas\Response\Response;

class TasTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HttpHandler|ObjectProphecy
     */
    private $httpHandler;

    protected function setUp()
    {
        $this->httpHandler = $this->prophesize(HttpHandler::class);
    }

    public function test_get_location()
    {
        $this->httpHandler->sendRequest(Argument::type(HttpRequest::class))->willReturn(
            include __DIR__ . '/_fixtures/location_response.php'
        );

        $tas       = $this->createTas();
        $locations = $tas->getLocations(new LocationsRequest('Berlin'));

        $this->assertInstanceOf(Locations::class, $locations);
        $this->assertCount(10, $locations); // assert that data was written to the Locations object.
    }

    public function test_get_hotel_collection()
    {
        $this->httpHandler->sendRequest(Argument::type(HttpRequest::class))->willReturn(
            include __DIR__ . '/_fixtures/hotel_collection_response_200.php'
        );

        $tas    = $this->createTas();
        $hotels = $tas->getHotelCollection(new HotelCollectionRequest([
                HotelCollectionRequest::PATH       => 8514,
                HotelCollectionRequest::START_DATE => new \DateTime('+1 days'),
                HotelCollectionRequest::END_DATE   => new \DateTime('+2 days'),
        ]));

        $this->assertInstanceOf(HotelCollection::class, $hotels);
        $this->assertCount(19, $hotels); // assert that data was written to the HotelCollection object.
    }

    public function test_get_hotel_details()
    {
        $this->httpHandler->sendRequest(Argument::type(HttpRequest::class))->willReturn(
            include __DIR__ . '/_fixtures/hotel_details_response.php'
        );

        $tas          = $this->createTas();
        $hotelDetails = $tas->getHotelDetails(new HotelDetailsRequest(1622543));

        $this->assertInstanceOf(HotelDetails::class, $hotelDetails);
        $this->assertSame('Best Western Premier Moa Berlin', $hotelDetails->getName());
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Method getUnkownResource does not exist.
     */
    public function test_call_undefined_method()
    {
        $tas = $this->createTas();
        $tas->getUnkownResource();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid Request: Expected Trivago\Tas\Request\LocationsRequest but got Trivago\Tas\Request\HotelDetailsRequest
     */
    public function test_call_get_method_with_wrong_request()
    {
        $tas = $this->createTas();
        $tas->getLocations(new HotelDetailsRequest(5555));
    }

    public function test_throw_problem_exception_on_error()
    {
        $httpResponse = new Response(
            '{"type":"http:\/\/www.w3.org\/Protocols\/rfc2616\/rfc2616-sec10.html","title":"Internal Server Error","detail":"An error occurred.","code":"GENERIC-ERROR"}',
            '500',
            [
                'content-type' => 'application/json',
            ]
        );
        $this->httpHandler->sendRequest(Argument::type(HttpRequest::class))->willReturn($httpResponse);

        $tas = $this->createTas();

        try {
            $locations = $tas->getLocations(new LocationsRequest('Berlin'));
            $this->fail('Excepted that an exception will be thrown.');
        } catch (ProblemException $exception) {
            $this->assertSame(500, $exception->getHttpCode());
            $this->assertSame('http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html', $exception->getProblemType());
            $this->assertSame('Internal Server Error', $exception->getTitle());
            $this->assertSame('An error occurred.', $exception->getMessage());
            $this->assertSame('GENERIC-ERROR', $exception->getCode());
        }
    }

    private function createTas()
    {
        return new Tas(new Config([
            Config::API_KEY                    => '1234',
            Config::GET_TRACKING_ID_CALLBACK   => function () {},
            Config::STORE_TRACKING_ID_CALLBACK => function () {},
            Config::HTTP_HANDLER               => $this->httpHandler->reveal(),
        ]));
    }
}
