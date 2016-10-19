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

namespace Trivago\Tas\Response\HotelRates;

use Trivago\Tas\Response\Common\Deal;
use Trivago\Tas\Response\Common\Price;
use Trivago\Tas\Response\Common\RateAttribute;

class HotelRatesTest extends \PHPUnit_Framework_TestCase
{
    public function test_empty_hotel_deals_response()
    {
        $hotelDeals = HotelRates::fromResponse(
            include __DIR__ . '/../../_fixtures/hotel_rates_response_202.php'
        );

        $this->assertCount(0, $hotelDeals);
        $this->assertFalse($hotelDeals->pollingFinished());
        $this->assertSame([], $hotelDeals->toArray());
    }

    public function test_finished_hotel_deals_response()
    {
        $hotelDeals = HotelRates::fromResponse(
            include __DIR__ . '/../../_fixtures/hotel_rates_response_200.php'
        );

        $this->assertCount(22, $hotelDeals);
        $this->assertTrue($hotelDeals->pollingFinished());

        foreach ($hotelDeals as $deal) {
            $this->assertInstanceOf(Deal::class, $deal);
        }

        $hotelDealsAsArray = $hotelDeals->toArray();
        $this->assertInternalType('array', $hotelDealsAsArray);
        $this->assertCount(22, $hotelDealsAsArray);

        $deal = $hotelDealsAsArray[0];
        $this->assertSame('https://trivago.local:8007/webservice/tas/forward.php?&enc=NDYwODI4YzRlMDA%3DQhEUVBVEVwcOXUENR0NfEkFTF1NJVkIbBxkeQFMXQQZFVRlPWxJAUhZRSVNFFxkMV0tWFUEdUEQRLQJGD1x%2BVV4EAUFLXRJGR1EGCFQNRkNdFVAIcRUGUlVJQVkSQlMHFxsMCEVDWAUCGFECUgUWHSEGVgQCRFpbF0AVBgEeRVAYUVoXUQYAAFUXDRxVXwAGRUJYFlAFRBcOQ0QBAAweRFEQUV4BAUJUG0wZDH4TFkFVSUVPfAITSFpaCQJSLQ5MS1cVVlsGVEURUEYQBEBeDgkHRURbGkBHfhEODAcXEV0UTlRFUwkXWTYADEIdB0AUG3heFx4cRxMFHFdJWHIGFwhIEABSEyxUXgAiG0oVBBxXSVVZByIbHkVREEEbXVRJFgwFAghFWhVEBzI5CG8RVxcCKEN7Q0cEV0Y0UzMDfEQGVABzPwUcUV0HFgQAVBRCUQcUI1BeEwcIRBMtTgQOXVVJNiwFBS1ACQhEURMXKkwSBBwDCg%3D%3D', $deal->getBookingLink());
        $this->assertSame('https://ie1.trivago.com/images/partnerlogos/626_mx.png', $deal->getBookingSiteLogo());
        $this->assertSame('Booking.com', $deal->getBookingSiteName());
        $this->assertSame('Doppel- oder Zweibettzimmer - nicht kostenfrei stornierbar - Jetzt buchen, vor Ort zahlen - kostenfreies WLAN', $deal->getDescription());

        $price = $deal->getPrice();
        $this->assertInstanceOf(Price::class, $price);
        $this->assertSame('EUR', $price->getCurrency());
        $this->assertSame('€ 301', (string) $price);

        $rateAttributes = $deal->getRateAttributes();
        $this->assertCount(1, $rateAttributes);
        $rateAttribute = $rateAttributes[0];
        $this->assertInstanceOf(RateAttribute::class, $rateAttribute);
        $this->assertFalse($rateAttribute->isPositive());
        $this->assertSame('Frühstück nicht inbegriffen', $rateAttribute->getLabel());
        $this->assertSame('NoRateAttributes', $rateAttribute->getType());

        $paramsArray = $hotelDeals->getSearchParams();
        $this->assertCount(4, $paramsArray);
        $this->assertInternalType('array', $paramsArray);
        $this->assertArrayHasKey('item', $paramsArray);
        $this->assertArrayHasKey('start_date', $paramsArray);
        $this->assertArrayHasKey('end_date', $paramsArray);
        $this->assertArrayNotHasKey('offset', $paramsArray);
        $this->assertArrayNotHasKey('limit', $paramsArray);
        $this->assertArrayHasKey('room_type', $paramsArray);
    }
}
