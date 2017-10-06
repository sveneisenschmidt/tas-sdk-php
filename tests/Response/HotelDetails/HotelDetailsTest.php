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
use Trivago\Tas\Response\Common\Path;
use Trivago\Tas\Response\HotelDetails\RatingDetails;
use Trivago\Tas\Response\HotelDetails\RatingDetailsAspect;

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
        $this->assertSame('A modern four-star hotel in the pretty Tiergarten district, the Mercure MOA Berlin is located within the Moa Bogen shopping centre. The smoke-free, air-conditioned guest rooms and suites feature a flat-screen television, free Wi-fi, and a comfortable work space. Pets are welcome for an additional fee. Active travellers will find a fitness centre and sauna on site. The Mercure MOA Berlin also offers a 24-hour reception, concierge services, and private parking. Guests can unwind with a pint at the SKY Sports Bar, or enjoy fine European cuisine at the MOA Restaurant, open for breakfast, lunch, and dinner. The Berlin Zoo is only two stops away on the U-Bahn, and shoppers can get to the Kurfürstendamm in three stops. The Palace of Tears, Classic Remise Berlin, and Museum Island are also within a short drive.', $hotelDetails->getDescription());
        $this->assertTrue($hotelDetails->hasDescription());
        $this->assertSame('https://api.trivago.com/webservice/tas/forward.php?&enc=NDYwODI4YzRlMDA%3DRA0CDB5DR1ETUgMHQ0dPSwIVUTgdVFQdAAxAAlwQQQhDXwECVBNQEUATBwwIQUNdBR8VRApSAAZGQFwXRUdTAgkMAFIGCFERBFVaB0VEBFdaYlNTZ0Jdd0cDBUdCFQJOFQdeRBEeGg0VDkxCXXdcHRcHfBMZVQIdX1VaAR9PAkQSIQheRBtXWmcQCEIPCm5YGwYMT1NTFwQAVVUrGgZXEw0EVCtQABJFTBFAEk4SHVJVHRZMEDIHSUoCVEJZEFgOF1FHUEoDBhkXG0AeAE8TBlUVRzYZQgRMVRUGRx1RQF9bAg5TQlx1URhfWBRHTARSLUVCHQQIRBlEFCNCFAU2CBMGQyUMQlpzAFFHLQ5TVGMKCkMVQTZEBkMjEUJadRYEEw5GS1MWUFoXRBgWVFYdR1IrDl9XARMORjoOQgYDVA0hOU9QOgBPABpQVxExBkcTXEQJ', $hotelDetails->getHomepage());
        $this->assertTrue($hotelDetails->hasHomepage());
        $this->assertSame(1622543, $hotelDetails->getItemId());
        $this->assertSame('Mercure Hotel MOA Berlin', $hotelDetails->getName());
        $this->assertSame(3248, $hotelDetails->getRatingCount());
        $this->assertSame(85.33, $hotelDetails->getRatingValue());
        $this->assertFalse($hotelDetails->isSuperior());
        $this->assertSame('10559', $hotelDetails->getZip());

        $this->assertContainsOnlyInstancesOf(Image::class, $hotelDetails->getGalleryImages());

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

        $ratingDetails = $hotelDetails->getRatingDetails();
        $this->assertInstanceOf(RatingDetails::class, $ratingDetails);
        
        $aspects = $ratingDetails->getAspects();        
        $this->assertInternalType('array', $aspects);
        $this->assertNotEmpty($aspects);
        foreach ($aspects as $index => $aspect) {
            $this->assertInstanceOf(RatingDetailsAspect::class, $aspect);
            // Test first entry only for given values, 
            // test other entries only for not being empty
            $this->assertNotEmpty($aspect->getType());
            $this->assertNotEmpty($aspect->getName());
            $this->assertNotEmpty($aspect->getRatingPercentage());
            $this->assertNotEmpty($aspect->getText());
            $this->assertNotEmpty($aspect->getIndex());
            if ($index === 0) {
                $this->assertEquals('facilities',   $aspect->getType());
                $this->assertEquals('Facilities',   $aspect->getName());
                $this->assertEquals(82,             $aspect->getRatingPercentage());
                $this->assertEquals('Very good',    $aspect->getText());
                $this->assertEquals(4,              $aspect->getIndex());
            }
        }

        $this->assertContainsOnlyInstancesOf(Tag::class, $hotelDetails->getTags());
    }
}
