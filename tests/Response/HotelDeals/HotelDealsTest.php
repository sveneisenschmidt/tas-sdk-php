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
use Trivago\Tas\Response\Common\Price;
use Trivago\Tas\Response\Common\RateAttribute;

class HotelDealsTest extends \PHPUnit_Framework_TestCase
{
    public function test_empty_hotel_deals_response()
    {
        $hotelDeals = HotelDeals::fromResponse(
            include __DIR__ . '/../../_fixtures/hotel_deals_response_202.php'
        );

        $this->assertCount(0, $hotelDeals);
        $this->assertFalse($hotelDeals->pollingFinished());
        $this->assertSame([], $hotelDeals->toArray());
    }

    public function test_finished_hotel_deals_response()
    {
        $hotelDeals = HotelDeals::fromResponse(
            include __DIR__ . '/../../_fixtures/hotel_deals_response_200.php'
        );

        $this->assertCount(25, $hotelDeals);
        $this->assertTrue($hotelDeals->pollingFinished());

        foreach ($hotelDeals as $deal) {
            $this->assertInstanceOf(Deal::class, $deal);
        }

        $hotelDealsAsArray = $hotelDeals->toArray();
        $this->assertInternalType('array', $hotelDealsAsArray);
        $this->assertCount(25, $hotelDealsAsArray);

        $deal = $hotelDealsAsArray[0];
        $this->assertSame('http://trivago.local:8007/webservice/tas/forward.php?&enc=NDYwODI4YzRlMDA%3DQhEUVBFAVAcOXUENRUNbFkNUE1BJVkIbBxkeRFcUQQZFVRlPXBpGVBZRSVNFFxkMV0tTEFVJQ1EAFzZIExgcOF4AAkJDXRVAVAcXDlZVSUBYF0BHSDcdWFMRT1gQQVUXQR9FDUxDWBJQFVgXCgwEUhs6TAMTQgJSBRYEEx1LS1IQXlkEFhUAG0oAAE1aXQEBQkJREkJHRQIfUEIABxtGS1MRVlkBCEVHT1EZDkw4G0hAEU9eBSkVUw5SUAISVDZEGVwUUwkEAEwQDBRCAENXX1QIEEtaGkIEBzgZUA1AR1kbRlAUBFcEFh0wG0YXCkcGHEV5GhEFVhIERVpfF1k2AAxCHQdAFBtyVRoGOVEfAkRaXxdUHQE5UUtQElBJRVwQTxxIUBVIA1IHdkwKUWtGChAfAwVFRAdcVEMyEyk9fHIuQU9KJihFWlkDBlIGGh5HVRdeWgIGQEdaBQYTHFVZAQBSASVCGAZUBghUfBsRCE8TXHQsSUJ8FRwOVhcGRCQAVVVJFwc%3D', $deal->getBookingLink());
        $this->assertSame('//ie2.trivago.com/images/partnerlogos/265_mx.png', $deal->getBookingSiteLogo());
        $this->assertSame('HotelTravel', $deal->getBookingSiteName());
        $this->assertSame('Superior', $deal->getDescription());

        $price = $deal->getPrice();
        $this->assertInstanceOf(Price::class, $price);
        $this->assertSame('EUR', $price->getCurrency());
        $this->assertSame('137€', (string) $price);

        $rateAttributes = $deal->getRateAttributes();
        $this->assertCount(1, $rateAttributes);
        $rateAttribute = $rateAttributes[0];
        $this->assertInstanceOf(RateAttribute::class, $rateAttribute);
        $this->assertFalse($rateAttribute->isPositive());
        $this->assertSame('Breakfast not included', $rateAttribute->getLabel());
        $this->assertSame('NoRateAttributes', $rateAttribute->getType());

        $paramsArray = $hotelDeals->getSearchParams();
        $this->assertCount(7, $paramsArray);
        $this->assertInternalType('array', $paramsArray);
        $this->assertArrayHasKey('item',$paramsArray);
        $this->assertArrayHasKey('start_date',$paramsArray);
        $this->assertArrayHasKey('end_date',$paramsArray);
        $this->assertArrayHasKey('offset',$paramsArray);
        $this->assertArrayHasKey('limit',$paramsArray);
        $this->assertArrayHasKey('room_type',$paramsArray);
    }
}
