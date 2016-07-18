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

namespace Trivago\Tas\Request\Authentication;

use Trivago\Tas\Request\Request;

final class RequestSigner
{
    /**
     * @var string
     */
    private $accessId;

    /**
     * @var string
     */
    private $key;

    /**
     * @var int
     */
    private $timestamp = 0;

    /**
     * @param string $accessId
     * @param string $key
     * @param int    $timestamp
     */
    public function __construct($accessId, $key, $timestamp = 0)
    {
        if (empty($timestamp)) {
            $timestamp = time();
        }

        $this->accessId  = $accessId;
        $this->key       = $key;
        $this->timestamp = $timestamp;
    }

    /**
     * @param Request $request
     *
     * @return string
     */
    public function signRequest(Request $request)
    {
        $queryParameters = $request->getQueryParameters();
        $urlInfo         = parse_url($request->getBaseUrl() . $request->getPath());

        $queryParameters['access_id'] = $this->accessId;
        $queryParameters['timestamp'] = date(DATE_ATOM, $this->timestamp);
        $queryParameters['signature'] = $this->buildSignature(
            $request->getMethod(),
            $urlInfo['host'],
            $urlInfo['path'],
            $queryParameters
        );

        return $this->createUrl($urlInfo, $queryParameters);
    }

    /**
     * @param string $method
     * @param string $host
     * @param string $pathInfo
     * @param array  $queryParameters
     *
     * @return string
     */
    private function buildSignature($method, $host, $pathInfo, $queryParameters)
    {
        ksort($queryParameters);

        $toSign = implode("\n", [
            $method,
            $host,
            rtrim($pathInfo, '/'),
            http_build_query($queryParameters),
        ]);

        return base64_encode(hash_hmac('sha256', $toSign, $this->key, true));
    }

    /**
     * @param array $urlParts
     * @param array $queryParameters
     *
     * @return string
     */
    private function createUrl(array $urlParts, array $queryParameters)
    {
        return $urlParts['scheme'] . '://'
        . $urlParts['host']
        . (isset($urlParts['port']) ? ':' . $urlParts['port'] : '')
        . (isset($urlParts['path']) ? $urlParts['path'] : '')
        . '?' . http_build_query($queryParameters);
    }
}
