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

namespace Trivago\Tas\Request;

use Trivago\Tas\Request\Common\Order;
use Trivago\Tas\Request\Common\RoomType;

class HotelCollectionRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Trivago\Tas\Request\InvalidRequestException
     * @expectedExceptionMessage Item ID and path ID are empty. At least one of these is required.
     */
    public function test_request_without_item_and_path()
    {
        new HotelCollectionRequest([]);
    }

    public function test_path_only()
    {
        new HotelCollectionRequest([
            HotelCollectionRequest::PATH => 1234,
        ]);
    }

    public function test_item_only()
    {
        new HotelCollectionRequest([
            HotelCollectionRequest::ITEM => 5678,
        ]);
    }

    public function test_full_request()
    {
        $startDate = new \DateTime('2015-08-08');
        $endDate   = new \DateTime('2015-08-09');

        $request = new HotelCollectionRequest([
            HotelCollectionRequest::PATH         => 1234,
            HotelCollectionRequest::ITEM         => 5678,
            HotelCollectionRequest::START_DATE   => $startDate,
            HotelCollectionRequest::END_DATE     => $endDate,
            HotelCollectionRequest::ROOM_TYPE    => RoomType::DOUBLE_ROOM,
            HotelCollectionRequest::CURRENCY     => 'EUR',
            HotelCollectionRequest::CATEGORY     => [3, 4],
            HotelCollectionRequest::LIMIT        => 10,
            HotelCollectionRequest::OFFSET       => 10,
            HotelCollectionRequest::ORDER        => Order::PRICE,
            HotelCollectionRequest::RATING_CLASS => [3, 4, 5],
            HotelCollectionRequest::HOTEL_NAME   => 'Hyatt',
            HotelCollectionRequest::MAX_PRICE    => 95,
            HotelCollectionRequest::RADIUS       => 31337,
        ]);

        $queryParameters = $request->getQueryParameters();

        $this->assertCount(14, $queryParameters);
        $this->assertArrayHasKey('path', $queryParameters);
        $this->assertSame(1234, $queryParameters['path']);
        $this->assertArrayHasKey('item', $queryParameters);
        $this->assertSame(5678, $queryParameters['item']);
        $this->assertArrayHasKey('start_date', $queryParameters);
        $this->assertSame('2015-08-08T00:00:00+00:00', $queryParameters['start_date']);
        $this->assertArrayHasKey('end_date', $queryParameters);
        $this->assertSame('2015-08-09T00:00:00+00:00', $queryParameters['end_date']);
        $this->assertArrayHasKey('room_type', $queryParameters);
        $this->assertSame(RoomType::DOUBLE_ROOM, $queryParameters['room_type']);
        $this->assertArrayHasKey('currency', $queryParameters);
        $this->assertSame('EUR', $queryParameters['currency']);
        $this->assertArrayHasKey('category', $queryParameters);
        $this->assertSame([3, 4], $queryParameters['category']);
        $this->assertArrayHasKey('limit', $queryParameters);
        $this->assertSame(10, $queryParameters['limit']);
        $this->assertArrayHasKey('offset', $queryParameters);
        $this->assertSame(10, $queryParameters['offset']);
        $this->assertArrayHasKey('order', $queryParameters);
        $this->assertSame(Order::PRICE, $queryParameters['order']);
        $this->assertArrayHasKey('max_price', $queryParameters);
        $this->assertSame(95, $queryParameters['max_price']);
        $this->assertArrayHasKey('rating_class', $queryParameters);
        $this->assertSame([3, 4, 5], $queryParameters['rating_class']);
        $this->assertArrayHasKey('hotel_name', $queryParameters);
        $this->assertSame('Hyatt', $queryParameters['hotel_name']);
        $this->assertArrayHasKey('radius', $queryParameters);
        $this->assertSame(31337, $queryParameters['radius']);
    }
}
