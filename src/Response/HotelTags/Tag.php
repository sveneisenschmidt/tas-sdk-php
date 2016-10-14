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

class Tag
{
    /**
     * @var string
     */
    private $tag_id = '0';

    /**
     * @var int
     */
    private $group_id = 0;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @param string $tag_id
     * @param int    $group_id
     * @param string $name
     */
    public function __construct($tag_id, $group_id, $name)
    {
        $this->tag_id   = $tag_id;
        $this->group_id = $group_id;
        $this->name     = $name;
    }

    /**
     * @return int|string
     */
    public function getTagId()
    {
        return $this->tag_id;
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
    public function getName()
    {
        return $this->name;
    }
}
