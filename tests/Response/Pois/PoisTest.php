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

namespace Trivago\Tas\Response\Pois;

use Trivago\Tas\Response\Common\GeoCoordinates;

class PoisTest extends \PHPUnit_Framework_TestCase
{
    public function test_pois_response_first_element()
    {
        $pois = Pois::fromResponse(
            include __DIR__ . '/../../_fixtures/pois_response_200.php'
        );

        $this->assertInstanceOf(Pois::class, $pois);
        $this->assertCount(47, $pois);

        $allPois = $pois->toArray();

        $this->assertInstanceOf(Poi::class, $poi = $allPois[0]);
        $this->assertSame(164640, $poi->getId());
        $this->assertSame('Alte Nikolaikirche', $poi->getName());
        $this->assertInstanceOf(GeoCoordinates::class, $coordinates = $poi->getGeoCoordinates());
        $this->assertSame(50.110001, $coordinates->getLatitude());
        $this->assertSame(8.6824, $coordinates->getLongitude());
    }

    public function test_all_poi_elements()
    {
        $pois = Pois::fromResponse(
            include __DIR__ . '/../../_fixtures/pois_response_200.php'
        );

        foreach ($pois as $poi)
        {
            $this->assertInstanceOf(Poi::class, $poi);
        }
    }
}
