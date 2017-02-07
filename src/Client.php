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

namespace Trivago\Tas;

use Trivago\Tas\Exception\UnexpectedResponseException;
use Trivago\Tas\HttpHandler\HttpHandler;
use Trivago\Tas\HttpHandler\HttpRequest;
use Trivago\Tas\Request\Request;
use Trivago\Tas\Response\Response;

class Client
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $acceptLanguage;

    /**
     * @var HttpHandler
     */
    private $httpHandler;

    /**
     * @var TrackingIdHandler
     */
    private $trackingIdHandler;

    public function __construct(Config $config)
    {
        $this->apiKey            = $config->getApiKey();
        $this->baseUrl           = $config->getBaseUrl();
        $this->acceptLanguage    = $config->getAcceptLanguage();
        $this->httpHandler       = $config->getHttpHandler();
        $this->trackingIdHandler = new TrackingIdHandler(
            $config->getTrackingIdCallback(),
            $config->getStoreTrackingIdCallback()
        );
    }

    /**
     * @param Request $request
     *
     * @throws UnexpectedResponseException
     *
     * @return Response
     */
    public function sendRequest(Request $request)
    {
        if ('' === $request->getBaseUrl()) {
            $request = $request->withBaseUrl($this->baseUrl);
        }

        $headers = [
            'Accept-Language: ' . $this->acceptLanguage,
            'Accept: application/vnd.trivago.affiliate.hal+json;version=1',
            'X-Trv-Api-Key: ' . $this->apiKey,
        ];

        if ($this->trackingIdHandler->get() !== '') {
            $headers[] = 'Cookie: tid=' . $this->trackingIdHandler->get();
        }

        $httpRequest = new HttpRequest(
            $request,
            $request->getMethod(),
            $headers
        );

        $response = $this->httpHandler->sendRequest($httpRequest);

        $headers = $response->getHeaders();
        if (!isset($headers['content-type']) || (!preg_match('/json$/', $headers['content-type']))) {
            throw new UnexpectedResponseException('The response is not a valid JSON response.');
        }

        $this->trackingIdHandler->store($response->getTrivagoTrackingId());

        return $response;
    }
}
