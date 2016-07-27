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
        $this->assertCount(19, $hotels);
        $this->assertTrue($hotels->pollingFinished());
        $this->assertTrue($hotels->hasNextPage());
        $this->assertFalse($hotels->hasPrevPage());
        $this->assertSame(25, $hotels->getNextPageOffset());

        $paramsArray = $hotels->getSearchParams();
        $this->assertCount(10, $paramsArray);
        $this->assertInternalType('array', $paramsArray);
        $this->assertArrayHasKey('path',$paramsArray);
        $this->assertArrayHasKey('start_date',$paramsArray);
        $this->assertArrayHasKey('end_date',$paramsArray);
        $this->assertArrayHasKey('category',$paramsArray);
        $this->assertInternalType('array', $paramsArray['category']);
        $this->assertArrayHasKey('offset',$paramsArray);
        $this->assertArrayHasKey('limit',$paramsArray);
        $this->assertArrayHasKey('room_type',$paramsArray);
        $this->assertArrayHasKey('order',$paramsArray);
        $this->assertArrayHasKey('rating_class',$paramsArray);
        $this->assertInternalType('array', $paramsArray['rating_class']);
        $this->assertArrayHasKey('max_price', $paramsArray);

        $resultInfo = $hotels->getResultInfo();
        $this->assertCount(1, $resultInfo);
        $this->assertInternalType('array', $resultInfo);
        $this->assertArrayHasKey('price', $resultInfo);
        $this->assertInternalType('array', $resultInfo['price']);

        foreach ($hotels as $hotel) {
            $this->assertInstanceOf(Hotel::class, $hotel);
        }

        $hotelsArray = $hotels->toArray();
        $this->assertInternalType('array', $hotelsArray);
        $this->assertCount(19, $hotelsArray);
        $this->assertSame(range(0,18), array_keys($hotelsArray));

        $hotel = $hotelsArray[0];
        $this->assertSame(8964, $hotel->getId());
        $this->assertSame('Kempinski Ajman', $hotel->getName());
        $this->assertSame(5, $hotel->getCategory());
        $this->assertSame(false, $hotel->isSuperior());
        $this->assertSame('Ajman', $hotel->getCity());
        $this->assertSame(84.1, $hotel->getRatingValue());
        $this->assertSame(1816, $hotel->getRatingCount());
        $this->assertSame(true, $hotel->hasDeals());

        $image = $hotel->getMainImage();
        $this->assertInstanceOf(Image::class, $image);
        $this->assertSame('//imgec.trivago.com/itemimages/89/64/8964_v4_m.jpeg', $image->getMedium());
        $this->assertSame('//imgec.trivago.com/itemimages/89/64/8964_v4_m.jpeg', (string) $image);
        $this->assertSame('//imgec.trivago.com/gtximages/itemimages/89/64/8964_v4_y.jpeg', $image->getExtraLarge());
        $this->assertSame('//imgec.trivago.com/gtximages/itemimages/89/64/8964_v4_y@2x.jpeg', $image->getRetina());

        foreach ($hotel->getDeals() as $deal) {
            $this->assertInstanceOf(Deal::class, $deal);
        }

        $bestDeal = $hotel->getBestDeal();
        $this->assertInstanceOf(Deal::class, $bestDeal);
    }
}
