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

namespace Trivago\Tas\Response\TopOptions;

class TopOption
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Tag[]
     */
    private $tags = [];

    /**
     * @var RateAttribute[]
     */
    private $rateAttributes = [];

    public function __construct($id, $type, $name, $tags = [], $rateAttributes = [])
    {
        $this->id   = (int) $id;
        $this->type = $type;
        $this->name = $name;

        foreach ($tags as $tag) {
            $this->tags[] = new Tag($tag['tag_id']);
        }

        foreach ($rateAttributes as $rateAttribute) {
            $this->rateAttributes[] = new RateAttribute($rateAttribute['value']);
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return RateAttribute[]
     */
    public function getRateAttributes()
    {
        return $this->rateAttributes;
    }
}
