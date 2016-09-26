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

namespace Trivago\Tas\Response\Tags;

class TagsTest extends \PHPUnit_Framework_TestCase
{
    public function test_create_instance_from_response()
    {
        $tagGroups = TagGroups::fromResponse(
            include __DIR__ . '/../../_fixtures/tags_response.php'
        );

        $this->assertInstanceOf(TagGroups::class, $tagGroups);
        $this->assertCount(10, $tagGroups);

        foreach ($tagGroups as $tagGroup) {
            $this->assertInstanceOf(TagGroup::class, $tagGroup);

            foreach ($tagGroup as $tag) {
                $this->assertInstanceOf(Tag::class, $tag);
            }
        }

        $tagGroupsAsArray = $tagGroups->toArray();
        $this->assertInternalType('array', $tagGroupsAsArray);
        $this->assertSame(range(0, 9), array_keys($tagGroupsAsArray));

        $tagGroup = $tagGroupsAsArray[0];
        $this->assertSame(1, $tagGroup->getGroupId());
        $this->assertSame('or', $tagGroup->getType());
        $this->assertSame('Hotel chain', $tagGroup->getName());

        $tag = $tagGroup->toArray()[0];
        $this->assertSame('1_1076', $tag->getTagId());
        $this->assertSame('7 Days Inn', $tag->getName());
    }
}
