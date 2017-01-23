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

namespace Trivago\Tas\Response\HotelDetails;

use Trivago\Tas\Response\Common\GeoCoordinates;
use Trivago\Tas\Response\Common\Image;

class HotelDetailsTest extends \PHPUnit_Framework_TestCase
{
    public function test_instance_creation_from_response()
    {
        $hotelDetails = HotelDetails::fromResponse(
            include __DIR__ . '/../../_fixtures/hotel_details_response.php'
        );

        $this->assertSame('Stephanstrase 41', $hotelDetails->getAddress());
        $this->assertSame(4, $hotelDetails->getCategory());
        $this->assertSame('Berlin', $hotelDetails->getCity());
        $this->assertSame('Located in Tiergarten, Best Western Premier Hotel Moa Berlin is a perfect starting point from which to explore Berlin. The property features a wide range of facilities to make your stay a pleasant experience. Safety deposit boxes, restaurant, room service, bicycle rental, elevator are on the list of things guests can enjoy. Each guestroom is elegantly furnished and equipped with handy amenities. Enjoy the hotel\'s recreational facilities, including fitness center, before retiring to your room for a well-deserved rest. Discover all Berlin has to offer by making Best Western Premier Hotel Moa Berlin your base.', $hotelDetails->getDescription());
        $this->assertSame(true, $hotelDetails->hasDescription());
        $this->assertSame('http://www.trivago.co.uk:8007/webservice/affiliate/forward.php?&enc=NDYwODI4YzRlMDA%3DRA0CDB5DR1ETUgMHQ0dPSwIVUTgdVFQdAAxAAlwQQQhDXwECVBNQEUATBwwIQUNdBR8VRApSAAZGQFwXRUdTAgkMAFIGCFERBFVaB0VEBFdaYlNTZ0Jdd0cDBUdCFQJOFQdeRBEeGg0VDkxCXXdWBldbZR4OVQIDHHFENF4OGwRTBBpDVVkaBlcTDQwKAFAdFhcbTx8PDAgfVF4dHA4OGwhFSgtUUxEfC0YETBNXXgQVRjQATRIEWUkcWUQZHk9TFwZEWl0GB0FUHU8SXFQMSUJ8FRwOVhcGRCsAUlEYF1R2PUdSKw5fVwETDkY1DkUCUlRe', $hotelDetails->getHomepage());
        $this->assertSame(true, $hotelDetails->hasHomepage());
        $this->assertSame(1622543, $hotelDetails->getItemId());
        $this->assertSame('Best Western Premier Moa Berlin', $hotelDetails->getName());
        $this->assertSame(4352, $hotelDetails->getRatingCount());
        $this->assertSame(86.18, $hotelDetails->getRatingValue());
        $this->assertSame(false, $hotelDetails->isSuperior());
        $this->assertSame('10559', $hotelDetails->getZip());

        foreach ($hotelDetails->getGalleryImages() as $galleryImage) {
            $this->assertInstanceOf(Image::class, $galleryImage);
        }
        $this->assertInstanceOf(Image::class, $hotelDetails->getMainImage());

        $geoCoordinates = $hotelDetails->getGeoCoordinates();
        $this->assertInstanceOf(GeoCoordinates::class, $geoCoordinates);
        $this->assertEquals('13.344209', $geoCoordinates->getLongitude());
        $this->assertEquals('52.532169', $geoCoordinates->getLatitude());

        $path = $hotelDetails->getPath();
        $this->assertInstanceOf(Path::class, $path);
        $this->assertSame(8514, $path->getId());
        $this->assertSame('Berlin', $path->getName());

        $geoCoordinates = $path->getGeoCoordinates();
        $this->assertInstanceOf(GeoCoordinates::class, $geoCoordinates);
        $this->assertEquals('13.378001', $geoCoordinates->getLongitude());
        $this->assertEquals('52.516136', $geoCoordinates->getLatitude());
    }
}
