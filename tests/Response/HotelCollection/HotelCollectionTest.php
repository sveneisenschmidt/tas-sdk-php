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

class HotelCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function test_create_instance_from_response()
    {
        $hotels = HotelCollection::fromResponse(
            include __DIR__ . '/../../_fixtures/hotel_collection_response_200.php'
        );

        $this->assertInstanceOf(HotelCollection::class, $hotels);
        $this->assertCount(25, $hotels);
        $this->assertTrue($hotels->pollingFinished());
        $this->assertTrue($hotels->hasNextPage());
        $this->assertFalse($hotels->hasPrevPage());
        $this->assertSame(25, $hotels->getNextPageOffset());

        $paramsArray = $hotels->getSearchParams();
        $this->assertCount(10, $paramsArray);
        $this->assertInternalType('array', $paramsArray);
        $this->assertArrayHasKey('path', $paramsArray);
        $this->assertArrayHasKey('start_date', $paramsArray);
        $this->assertArrayHasKey('end_date', $paramsArray);
        $this->assertArrayHasKey('category', $paramsArray);
        $this->assertInternalType('array', $paramsArray['category']);
        $this->assertArrayHasKey('offset', $paramsArray);
        $this->assertArrayHasKey('limit', $paramsArray);
        $this->assertArrayHasKey('room_type', $paramsArray);
        $this->assertArrayHasKey('order', $paramsArray);
        $this->assertArrayHasKey('rating_class', $paramsArray);
        $this->assertInternalType('array', $paramsArray['rating_class']);
        $this->assertArrayNotHasKey('max_price', $paramsArray);

        $resultInfo = $hotels->getResultInfo();
        $this->assertSame(38, $resultInfo->getMinPrice());
        $this->assertSame(127, $resultInfo->getMaxPrice());
        $this->assertSame('GBP', $resultInfo->getCurrency());

        foreach ($hotels as $hotel) {
            $this->assertInstanceOf(Hotel::class, $hotel);
        }

        $hotelsArray = $hotels->toArray();
        $this->assertInternalType('array', $hotelsArray);
        $this->assertCount(25, $hotelsArray);
        $this->assertSame(range(0, 24), array_keys($hotelsArray));

        $hotel = $hotelsArray[0];
        $this->assertSame(9864, $hotel->getId());
        $this->assertSame('Mercure Hotel Berlin Tempelhof Airport', $hotel->getName());
        $this->assertSame(4, $hotel->getCategory());
        $this->assertSame(false, $hotel->isSuperior());
        $this->assertSame('Berlin', $hotel->getCity());
        $this->assertSame(80.53, $hotel->getRatingValue());
        $this->assertSame(3361.0, $hotel->getRatingCount());
        $this->assertSame(true, $hotel->hasDeals());
        $this->assertSame(true, $hotel->hasPoi());
        $this->assertInstanceOf(Poi::class, $hotel->getPoi());

        $image = $hotel->getMainImage();
        $this->assertInstanceOf(Image::class, $image);
        $this->assertSame('https://imgec.trivago.com/itemimages/98/64/9864_v7_m.jpeg', $image->getMedium());
        $this->assertSame('https://imgec.trivago.com/itemimages/98/64/9864_v7_m.jpeg', (string) $image);
        $this->assertSame('https://imgec.trivago.com/gtximages/itemimages/98/64/9864_v7_y.jpeg', $image->getExtraLarge());
        $this->assertSame('https://imgec.trivago.com/gtximages/itemimages/98/64/9864_v7_y@2x.jpeg', $image->getRetina());

        foreach ($hotel->getDeals() as $deal) {
            $this->assertInstanceOf(Deal::class, $deal);
        }

        $bestDeal = $hotel->getBestDeal();
        $this->assertInstanceOf(Deal::class, $bestDeal);
    }
}
