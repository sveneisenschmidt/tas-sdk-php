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

        $this->assertCount(58, $hotelDeals);
        $this->assertTrue($hotelDeals->pollingFinished());

        foreach ($hotelDeals as $deal) {
            $this->assertInstanceOf(Deal::class, $deal);
        }

        $hotelDealsAsArray = $hotelDeals->toArray();
        $this->assertInternalType('array', $hotelDealsAsArray);
        $this->assertCount(58, $hotelDealsAsArray);

        $deal = $hotelDealsAsArray[0];
        $this->assertSame('http://www.trivago.co.uk:8007/webservice/affiliate/forward.php?&enc=NDYwODI4YzRlMDA%3DQhEUVBJAWBNBBgNASUVQFURUElNbF1cGHRxTS1AXXl0XWQAXBB5DVBdfSVNFFxkMV0tTFVBJQ1EAFzZIExgcOF4IAUJCWxBFUwcXDlZVSUBYF0BHSDcdWFMRT1sWRVAWQR9FDUxDWBJQFVgXCgwEUhs6TAMTQgJSBRYEEx1LS1kUVlsXUQYAAFUXDRxVXwAGREVYEFAFRBcOQ0QBAAweRFEQUV8GAUBUG0wZDH4TFkFVSUVPfAITSFpbUwdSLQ5MSwASVl1XAREQDEYTVxJfWwFSQkIMRkJHfhEODANBQQ0SFQdFAl8XWTYADEIdB0AUG3heFx4cRxMFHFdJWHIGFwhIEABSEyxUXgAiG0oVBBxXSVVZByIbHkRQF0EbXVRJBwIFAghFWj9GVSdEWBVEUBkMJ2lFGRs4RCAqbVdXQAkzVABzPwUcUV0HFgABVBJCVxlUXQcGQkZPUwRcFFBfARYHPghNERRAAAp9XxcTBUZLNGpBHH1RGhUcQhEEYggLVA0RHA%3D%3D', $deal->getBookingLink());
        $this->assertSame('//ie2.trivago.com/images/partnerlogos/1692_mx.png', $deal->getBookingSiteLogo());
        $this->assertSame('priceline', $deal->getBookingSiteName());
        $this->assertSame('Executive Double Room - Book now, pay when you stay - Free WiFi', $deal->getDescription());

        $price = $deal->getPrice();
        $this->assertInstanceOf(Price::class, $price);
        $this->assertSame('GBP', $price->getCurrency());
        $this->assertSame('£216', (string) $price);

        $rateAttributes = $deal->getRateAttributes();
        $this->assertCount(1, $rateAttributes);
        $rateAttribute = $rateAttributes[0];
        $this->assertInstanceOf(RateAttribute::class, $rateAttribute);
        $this->assertFalse($rateAttribute->isPositive());
        $this->assertSame('Breakfast not included', $rateAttribute->getLabel());
        $this->assertSame('NoRateAttributes', $rateAttribute->getType());
    }
}
