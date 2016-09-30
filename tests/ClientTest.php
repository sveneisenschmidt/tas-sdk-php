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

use Prophecy\Argument;
use Trivago\Tas\HttpHandler\HttpHandler;
use Trivago\Tas\HttpHandler\HttpRequest;
use Trivago\Tas\Request\RawRequest;
use Trivago\Tas\Response\Response;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function test_apply_and_use_trivago_tracking_id()
    {
        $request1 = new RawRequest('http://foo/bar/?request=1');
        $request2 = new RawRequest('http://foo/bar/?request=2');

        $httpHandler = $this->prophesize(HttpHandler::class);
        $httpHandler
            ->sendRequest(Argument::type(HttpRequest::class))
            ->willReturn(new Response(
                '[]',
                200,
                [
                    'set-cookie' => [
                        'tid=TRACKINGID;',
                    ],
                    'content-type' => 'application/json',
                ]
            ))
        ;

        $trackingIdStore = new TestTrackingIdStore();
        $config          = new Config([
            Config::API_KEY                  => '1234',
            Config::HTTP_HANDLER             => $httpHandler->reveal(),
            Config::GET_TRACKING_ID_CALLBACK => function () use ($trackingIdStore) {
                return $trackingIdStore->trackingId;
            },
            Config::STORE_TRACKING_ID_CALLBACK => function ($trackingId) use ($trackingIdStore) {
                $trackingIdStore->trackingId = $trackingId;
            },
        ]);

        $client = new Client($config);
        $client->sendRequest($request1);
        $this->assertSame('TRACKINGID', $trackingIdStore->trackingId);

        $unitTest = $this;
        $httpHandler->sendRequest(Argument::type(HttpRequest::class))
            ->will(function (array $arguments) use ($unitTest) {
                /** @var HttpRequest $httpRequest */
                $httpRequest = $arguments[0];

                if (!in_array('Cookie: tid=TRACKINGID', $httpRequest->getHeaders())) {
                    $unitTest->fail('Cookie must be added to the second request.');
                }

                return new Response('[]', 200, ['content-type' => 'application/json']);
            });
        $client->sendRequest($request2);
    }

    /**
     * @expectedException \Trivago\Tas\Exception\UnexpectedResponseException
     * @expectedExceptionMessage The response is not a valid JSON response.
     */
    public function test_invalid_json()
    {
        $request = new RawRequest('http://foo/bar/?request=1');

        $httpHandler = $this->prophesize(HttpHandler::class);
        $httpHandler
            ->sendRequest(Argument::type(HttpRequest::class))
            ->willReturn(new Response('no valid json', 200, ['content-type' => 'text/html']))
        ;

        $config = new Config([
            Config::API_KEY                    => '1234',
            Config::HTTP_HANDLER               => $httpHandler->reveal(),
            Config::GET_TRACKING_ID_CALLBACK   => function () {},
            Config::STORE_TRACKING_ID_CALLBACK => function ($trackingId) {},
        ]);

        $client = new Client($config);
        $client->sendRequest($request);
    }
}

class TestTrackingIdStore
{
    public $trackingId;
}
