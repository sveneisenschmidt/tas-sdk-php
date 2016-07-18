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

abstract class Request
{
    /**
     * @var string
     */
    private $baseUrl = '';

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    abstract public function getPath();

    /**
     * @return string
     */
    public function getMethod()
    {
        return 'GET';
    }

    /**
     * @return array
     */
    public function getQueryParameters()
    {
        return [];
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * Returns the request with a new base url.
     *
     * @param $baseUrl
     *
     * @return static
     */
    public function withBaseUrl($baseUrl)
    {
        $new          = clone $this;
        $new->baseUrl = $baseUrl;

        return $new;
    }

    /**
     * Returns the complete URL for this request.
     *
     * @return string
     */
    public function __toString()
    {
        $url             = $this->getBaseUrl() . $this->getPath();
        $queryParameters = $this->getQueryParameters();
        if (!empty($queryParameters)) {
            $url .= '?' . http_build_query($this->getQueryParameters(), null, '&');
        }

        return $url;
    }
}
