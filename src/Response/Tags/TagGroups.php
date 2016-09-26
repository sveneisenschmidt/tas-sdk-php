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

use Trivago\Tas\Response\Response;

class TagGroups implements \Iterator, \Countable
{
    /**
     * @var TagGroup[]
     */
    private $tagGroups = [];

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    /**
     * Returns a filled TagGroups object using a TagsRequest response
     *
     * @param Response $response
     *
     * @return static
     */
    public static function fromResponse(Response $response)
    {
        $data = $response->getContentAsArray();

        $tagGroups            = new static();
        $tagGroups->tagGroups = array_map(
            function (array $tagGroupData) {
                return new TagGroup(
                    $tagGroupData['group_id'],
                    $tagGroupData['type'],
                    $tagGroupData['name'],
                    array_map(
                        function (array $tagData) {
                            return new Tag($tagData['tag_id'], $tagData['name']);
                        },
                        $tagGroupData['tags']
                    )
                );
            },
            $data['tag_groups']
        );

        return $tagGroups;
    }

    /**
     * @return TagGroup[]
     */
    public function toArray()
    {
        return $this->tagGroups;
    }

    /**
     * @return TagGroup|false
     */
    public function current()
    {
        return current($this->tagGroups);
    }

    public function next()
    {
        next($this->tagGroups);
    }

    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->tagGroups);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return current($this->tagGroups) !== false;
    }

    public function rewind()
    {
        reset($this->tagGroups);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->tagGroups);
    }
}
