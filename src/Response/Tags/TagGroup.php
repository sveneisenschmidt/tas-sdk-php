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

class TagGroup implements \Iterator, \Countable
{
    /**
     * @var int
     */
    private $group_id = 0;

    /**
     * @var string
     */
    private $type = '';

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var Tag[]
     */
    private $tags = [];

    /**
     * @param int    $group_id
     * @param string $type
     * @param string $name
     * @param Tag[]  $tags
     */
    public function __construct($group_id, $type, $name, array $tags)
    {
        $this->group_id = (int)$group_id;
        $this->type     = $type;
        $this->name     = $name;
        $this->tags     = $tags;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return Tag[]
     */
    public function toArray()
    {
        return $this->tags;
    }

    /**
     * @return Tag|false
     */
    public function current()
    {
        return current($this->tags);
    }

    public function next()
    {
        next($this->tags);
    }

    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->tags);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return current($this->tags) !== false;
    }

    public function rewind()
    {
        reset($this->tags);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->tags);
    }
}
