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

namespace Trivago\Tas\Response;

class Response
{
    /**
     * @var int
     */
    private $httpCode;

    /**
     * @var string
     */
    private $content;

    /**
     * @var array
     */
    private $contentAsArray;

    /**
     * @var array
     */
    private $headers;

    /**
     * @param string $content
     * @param int    $httpCode
     * @param array  $headers
     */
    public function __construct(
        $content = '',
        $httpCode = 200,
        array $headers = [])
    {
        $this->content  = $content;
        $this->httpCode = (int) $httpCode;
        $this->headers  = $headers;
    }

    /**
     * @return int
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function getContentAsArray()
    {
        if ($this->contentAsArray === null) {
            $this->contentAsArray = json_decode($this->content, true) ?: [];
        }

        return $this->contentAsArray;
    }

    public function getTrivagoTrackingId()
    {
        if (!isset($this->headers['set-cookie'])) {
            return;
        }

        $setCookies = $this->headers['set-cookie'];
        foreach ($setCookies as $cookie) {
            $matches = [];
            if (preg_match('/^tid=([a-zA-Z0-9]+);/', $cookie, $matches)) {
                return $matches[1];
            }
        }

        return;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
