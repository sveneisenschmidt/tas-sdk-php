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

namespace Trivago\Tas\Response\Locations;

class LocationsTest extends \PHPUnit_Framework_TestCase
{
    public function test_create_instance_from_response()
    {
        $locations = Locations::fromResponse(
            include __DIR__ . '/../../_fixtures/location_response.php'
        );

        $this->assertInstanceOf(Locations::class, $locations);
        $this->assertCount(10, $locations);
        $this->assertSame('Berlin', $locations->getQuery());
        $this->assertFalse($locations->isQueryCorrected());

        foreach ($locations as $location) {
            $this->assertInstanceOf(Location::class, $location);
        }

        $locationsAsArray = $locations->toArray();
        $this->assertInternalType('array', $locationsAsArray);
        $this->assertSame(range(0, 9), array_keys($locationsAsArray));

        $location = $locationsAsArray[0];
        $this->assertSame(2007, $location->getCount());
        $this->assertNull($location->getItemId());
        $this->assertSame('{Berlin}', $location->getName());
        $this->assertSame(8514, $location->getPathId());
        $this->assertSame('berlin', $location->getPathName());
        $this->assertSame('path', $location->getType());
        $this->assertFalse($location->isHotel());
        $this->assertFalse($location->isAttraction());
        $this->assertTrue($location->isPath());
    }
}
