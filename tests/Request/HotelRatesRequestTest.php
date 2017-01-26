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

use DateTime;
use Trivago\Tas\Request\Common\RoomType;

class HotelRatesRequestTest extends \PHPUnit_Framework_TestCase
{
    public function test_full_request()
    {
        $startDate = new DateTime('+1 day');
        $endDate   = new DateTime('+2 days');

        $request = new HotelRatesRequest([
            HotelRatesRequest::ITEM       => 5555,
            HotelRatesRequest::START_DATE => $startDate,
            HotelRatesRequest::END_DATE   => $endDate,
            HotelRatesRequest::CURRENCY   => 'EUR',
            HotelRatesRequest::LIMIT      => 25,
            HotelRatesRequest::OFFSET     => 0,
            HotelRatesRequest::ROOM_TYPE  => RoomType::DOUBLE_ROOM,
            HotelRatesRequest::RADIUS     => 31337,
        ]);

        $this->assertSame('/hotels/5555/rates', $request->getPath());
        $parameters = $request->getQueryParameters();
        $this->assertSame($startDate->format(DateTime::ATOM), $parameters['start_date']);
        $this->assertSame($endDate->format(DateTime::ATOM), $parameters['end_date']);
        $this->assertSame('EUR', $parameters['currency']);
        $this->assertSame(7, $parameters['room_type']);
        $this->assertSame(25, $parameters['limit']);
        $this->assertSame(0, $parameters['offset']);
        $this->assertSame(31337, $parameters['radius']);
    }

    public function test_request_without_optional_parameters()
    {
        $startDate = new DateTime('+1 day');
        $endDate   = new DateTime('+2 days');

        $request = new HotelRatesRequest([
            HotelRatesRequest::ITEM       => 5555,
            HotelRatesRequest::START_DATE => $startDate,
            HotelRatesRequest::END_DATE   => $endDate,
        ]);

        $this->assertSame('/hotels/5555/rates', $request->getPath());
        $parameters = $request->getQueryParameters();
        $this->assertSame($startDate->format(DateTime::ATOM), $parameters['start_date']);
        $this->assertSame($endDate->format(DateTime::ATOM), $parameters['end_date']);
        $this->assertArrayNotHasKey('currency', $parameters);
        $this->assertArrayNotHasKey('room_type', $parameters);
        $this->assertArrayNotHasKey('limit', $parameters);
        $this->assertArrayNotHasKey('offset', $parameters);
    }

    public function test_request_without_pagination()
    {
        $startDate = new DateTime('+1 day');
        $endDate   = new DateTime('+2 days');

        $request = new HotelRatesRequest([
            HotelRatesRequest::ITEM       => 5555,
            HotelRatesRequest::START_DATE => $startDate,
            HotelRatesRequest::END_DATE   => $endDate,
            HotelRatesRequest::CURRENCY   => 'EUR',
            HotelRatesRequest::ROOM_TYPE  => RoomType::SINGLE_ROOM,
        ]);

        $this->assertSame('/hotels/5555/rates', $request->getPath());
        $parameters = $request->getQueryParameters();
        $this->assertSame($startDate->format(DateTime::ATOM), $parameters['start_date']);
        $this->assertSame($endDate->format(DateTime::ATOM), $parameters['end_date']);
        $this->assertSame('EUR', $parameters['currency']);
        $this->assertSame(1, $parameters['room_type']);
        $this->assertArrayNotHasKey('limit', $parameters);
        $this->assertArrayNotHasKey('offset', $parameters);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function test_request_without_item()
    {
        new HotelRatesRequest([]);
    }
}
