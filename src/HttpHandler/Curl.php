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

namespace Trivago\Tas\HttpHandler;

use Trivago\Tas\Response\Response;

class Curl implements HttpHandler
{
    /**
     * @var array
     */
    private $responseHeaders = [];

    public function sendRequest(HttpRequest $request)
    {
        if ($request->getMethod() !== 'GET') {
            throw new \Exception("Method {$request->getMethod()} not supported.");
        }

        $this->responseHeaders = [];

        $ch = curl_init($request->getUri());

        curl_setopt($ch, CURLOPT_HTTPHEADER, $request->getHeaders());
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, [$this, 'fetchHeader']);

        $this->setCurlOptions($ch);
        $content = curl_exec($ch);

        if ($content === false) {
            throw new \RuntimeException(curl_error($ch));
        }

        $response = new Response(
            substr($content, curl_getinfo($ch, CURLINFO_HEADER_SIZE)),
            curl_getinfo($ch, CURLINFO_HTTP_CODE),
            $this->responseHeaders
        );

        curl_close($ch);

        return $response;
    }

    /**
     * @param resource $ch - curl handle
     */
    protected function setCurlOptions($ch)
    {
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate,sdch');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    }

    /**
     * @param resource $ch     - curl handle
     * @param string   $header
     *
     * @return int
     */
    private function fetchHeader($ch, $header)
    {
        $headerParts = explode(': ', $header, 2);

        if (2 === count($headerParts)) {
            $headerName = strtolower($headerParts[0]);

            if ('set-cookie' === $headerName) {
                $this->responseHeaders[$headerName][] = trim($headerParts[1]);

                return strlen($header);
            }

            $this->responseHeaders[$headerName] = trim($headerParts[1]);
        }

        return strlen($header);
    }
}
