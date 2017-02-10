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

use Trivago\Tas\Response\Response;

class TopOptions implements \Iterator, \Countable
{
    /**
     * @var array
     */
    private $topOptions = [];

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    public static function fromResponse(Response $response)
    {
        $data = $response->getContentAsArray();

        $topOptions = new static();
        foreach ($data['_embedded']['top_options'] as $topOption) {
            $topOptions->topOptions[] = new TopOption(
                $topOption['id'],
                $topOption['type'],
                $topOption['name'],
                $topOption['tags'],
                $topOption['rate_attributes']
            );
        }

        return $topOptions;
    }

    /**
     * @return TopOption[]
     */
    public function toArray()
    {
        return $this->topOptions;
    }

    /**
     * @return TopOption|false
     */
    public function current()
    {
        return current($this->topOptions);
    }

    public function next()
    {
        return next($this->topOptions);
    }

    /**
     * @return int|null
     */
    public function key()
    {
        return key($this->topOptions);
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return current($this->topOptions) !== false;
    }

    public function rewind()
    {
        return reset($this->topOptions);
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->topOptions);
    }
}
