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

namespace Trivago\Tas\Response\HotelTags;

class HotelTagsTest extends \PHPUnit_Framework_TestCase
{
    public function test_create_instance_from_response()
    {
        $hotelTags = HotelTags::fromResponse(
            include __DIR__ . '/../../_fixtures/hotel_tags_response.php'
        );

        $tagGroups = $hotelTags->getTagGroups();
        $tags      = $hotelTags->getTags();

        $this->assertContainsOnlyInstancesOf(TagGroup::class, $tagGroups);
        $this->assertCount(13, $tagGroups);
        $this->assertContainsOnlyInstancesOf(Tag::class, $tags);

        $tagGroup = $tagGroups[0];
        $this->assertSame(1, $tagGroup->getGroupId());
        $this->assertSame('or', $tagGroup->getType());
        $this->assertSame('Hotelkette', $tagGroup->getName());

        $tag = $tags[0];
        $this->assertSame('1_33', $tag->getTagId());
        $this->assertSame(1, $tag->getGroupId());
        $this->assertSame('Austria Trend', $tag->getName());
    }
}
