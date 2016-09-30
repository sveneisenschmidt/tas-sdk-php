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

use Trivago\Tas\HttpHandler\HttpHandler;

class ConfigTest extends \PHPUnit_Framework_TestCase
{
    public function test_default_config()
    {
        $getTrackingIdCallback   = new TrackingIdCallable();
        $storeTrackingIdCallback = new TrackingIdCallable();

        $configArray                                     = $this->getValidConfigArray();
        $configArray[Config::GET_TRACKING_ID_CALLBACK]   = $getTrackingIdCallback;
        $configArray[Config::STORE_TRACKING_ID_CALLBACK] = $storeTrackingIdCallback;

        $config = new Config($configArray);

        $this->assertSame($config->getAcceptLanguage(), 'en-GB');
        $this->assertSame($getTrackingIdCallback, $config->getTrackingIdCallback());
        $this->assertSame($storeTrackingIdCallback, $config->getStoreTrackingIdCallback());
        $this->assertSame('1234', $config->getApiKey());
        $this->assertSame('https://api.trivago.com/webservice/affiliate', $config->getBaseUrl());
        $this->assertInstanceOf(HttpHandler::class, $config->getHttpHandler());
    }

    /**
     * @expectedException \Trivago\Tas\Exception\TasException
     * @expectedExceptionMessage api_key required and is not supplied in the config
     */
    public function test_empty_api_key()
    {
        $configArray = $this->getValidConfigArray();
        unset($configArray[Config::API_KEY]);

        new Config($configArray);
    }

    /**
     * @expectedException \Trivago\Tas\Exception\TasException
     * @expectedExceptionMessage get_tracking_id_callback is required and needs to be callable
     */
    public function test_empty_get_tracking_id_callback()
    {
        $configArray = $this->getValidConfigArray();
        unset($configArray[Config::GET_TRACKING_ID_CALLBACK]);

        new Config($configArray);
    }

    /**
     * @expectedException \Trivago\Tas\Exception\TasException
     * @expectedExceptionMessage store_tracking_id_callback is required and needs to be callable
     */
    public function test_empty_store_tracking_id_callback()
    {
        $configArray = $this->getValidConfigArray();
        unset($configArray[Config::STORE_TRACKING_ID_CALLBACK]);

        new Config($configArray);
    }

    /**
     * @expectedException \Trivago\Tas\Exception\TasException
     * @expectedExceptionMessage http_handler must be instance of HttpHandler but integer was given
     */
    public function test_http_handler_is_no_object()
    {
        $configArray                       = $this->getValidConfigArray();
        $configArray[Config::HTTP_HANDLER] = 1;

        new Config($configArray);
    }

    /**
     * @expectedException \Trivago\Tas\Exception\TasException
     * @expectedExceptionMessage http_handler must be instance of HttpHandler but instance of stdClass was given
     */
    public function test_http_handler_is_no_instance_of_http_handler()
    {
        $configArray                       = $this->getValidConfigArray();
        $configArray[Config::HTTP_HANDLER] = new \stdClass();

        new Config($configArray);
    }

    public function test_override_http_handler()
    {
        $httpHandler                       = $this->prophesize(HttpHandler::class)->reveal();
        $configArray                       = $this->getValidConfigArray();
        $configArray[Config::HTTP_HANDLER] = $httpHandler;

        $config = new Config($configArray);
        $this->assertSame($httpHandler, $config->getHttpHandler());
    }

    /**
     * Returns a valid config array.
     *
     * @return array
     */
    private function getValidConfigArray()
    {
        return [
            Config::API_KEY                    => '1234',
            Config::STORE_TRACKING_ID_CALLBACK => new TrackingIdCallable(),
            Config::GET_TRACKING_ID_CALLBACK   => new TrackingIdCallable(),
        ];
    }
}

class TrackingIdCallable
{
    public function __invoke()
    {
    }
}
