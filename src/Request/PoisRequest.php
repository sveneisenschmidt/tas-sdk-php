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

namespace Trivago\Tas\Request;

class PoisRequest extends Request
{
    /**
     * @var int
     */
    private $pathId;

    /**
     * PoisRequest constructor.
     *
     * @param int $pathId
     */
    public function __construct($pathId)
    {
        $this->pathId = (int) $pathId;
    }

    /**
     * @return array
     */
    public function getQueryParameters()
    {
        return [
            'path_id' => $this->pathId
        ];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return '/pois';
    }
}
