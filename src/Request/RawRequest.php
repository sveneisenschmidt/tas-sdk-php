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

class RawRequest extends Request
{
    /**
     * @var array
     */
    private $queryParameters = [];

    /**
     * @var string
     */
    private $path = '';

    /**
     * @param string $url
     */
    public function __construct($url)
    {
        $urlParts = parse_url($url);

        if (isset($urlParts['path'])) {
            $this->path = $urlParts['path'];
        }

        if (isset($urlParts['query'])) {
            parse_str($urlParts['query'], $this->queryParameters);
        }

        parent::__construct($this->createBaseUrl($urlParts));
    }

    /**
     * @return array
     */
    public function getQueryParameters()
    {
        return $this->queryParameters;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param array $urlParts
     *
     * @return string
     */
    private function createBaseUrl(array $urlParts)
    {
        if (!isset($urlParts['host'])) {
            return '';
        }

        $url = isset($urlParts['scheme']) ? $urlParts['scheme'] : 'http';
        $url .= '://' . $urlParts['host'];

        if (isset($urlParts['port'])) {
            $url .= ':' . $urlParts['port'];
        }

        return $url;
    }
}
