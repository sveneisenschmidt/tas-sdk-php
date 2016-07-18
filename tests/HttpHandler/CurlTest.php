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

class CurlTest extends \PHPUnit_Framework_TestCase
{
    public function test_curl()
    {
        $uri = sprintf('http://%s:%d/test?send_cookie=true', WEB_SERVER_HOST, WEB_SERVER_PORT);

        $curl     = new Curl();
        $response = $curl->sendRequest(new HttpRequest($uri, 'GET', []));

        $this->assertSame(200, $response->getHttpCode());

        $data = $response->getContentAsArray();
        $this->assertArrayHasKey('SERVER', $data);
        $this->assertArrayHasKey('SCRIPT_NAME', $data['SERVER']);
        $this->assertSame('/test', $data['SERVER']['SCRIPT_NAME']);

        $this->assertArrayHasKey('GET', $data);
        $this->assertArrayHasKey('send_cookie', $data['GET']);
        $this->assertSame('true', $data['GET']['send_cookie']);

        $this->assertSame('abcdef12345', $response->getTrivagoTrackingId());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Method POST not supported.
     */
    public function test_invalid_method()
    {
        $uri = sprintf('http://%s:%d/test', WEB_SERVER_HOST, WEB_SERVER_PORT);

        $curl = new Curl();
        $curl->sendRequest(new HttpRequest($uri, 'POST', []));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Failed to connect to localhost port 9999: Connection refused
     */
    public function test_server_does_not_exist()
    {
        $uri = sprintf('http://%s:%d/test?send_cookie=true', WEB_SERVER_HOST, 9999);

        $curl     = new Curl();
        $response = $curl->sendRequest(new HttpRequest($uri, 'GET', []));
    }
}
