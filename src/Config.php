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

use Trivago\Tas\Exception\TasException;
use Trivago\Tas\HttpHandler\Curl;
use Trivago\Tas\HttpHandler\HttpHandler;

final class Config
{
    const ACCEPT_LANGUAGE            = 'accept_language';
    const ACCESS_ID                  = 'access_id';
    const BASE_URL                   = 'base_url';
    const GET_TRACKING_ID_CALLBACK   = 'get_tracking_id_callback';
    const SECRET_KEY                 = 'secret_key';
    const STORE_TRACKING_ID_CALLBACK = 'store_tracking_id_callback';
    const HTTP_HANDLER               = 'http_handler';

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @var string
     */
    private $acceptLanguage;

    /**
     * @var string
     */
    private $accessId;

    /**
     * @var string
     */
    private $secretKey;

    /**
     * @var HttpHandler
     */
    private $httpHandler;

    /**
     * @var callable
     */
    private $storeTrackingIdCallback;

    /**
     * @var callable
     */
    private $getTrackingIdCallback;

    public function __construct($options = [])
    {
        $options = array_merge([
            static::ACCEPT_LANGUAGE            => 'en-GB',
            static::ACCESS_ID                  => null,
            static::BASE_URL                   => 'https://api.trivago.com/webservice/affiliate',
            static::GET_TRACKING_ID_CALLBACK   => null,
            static::SECRET_KEY                 => null,
            static::STORE_TRACKING_ID_CALLBACK => null,
            static::HTTP_HANDLER               => null,
        ], $options);

        $this->baseUrl                 = $options[static::BASE_URL];
        $this->acceptLanguage          = $options[static::ACCEPT_LANGUAGE];
        $this->accessId                = $options[static::ACCESS_ID];
        $this->secretKey               = $options[static::SECRET_KEY];
        $this->storeTrackingIdCallback = $options[static::STORE_TRACKING_ID_CALLBACK];
        $this->getTrackingIdCallback   = $options[static::GET_TRACKING_ID_CALLBACK];
        $this->httpHandler             = $options[static::HTTP_HANDLER];

        if ($this->httpHandler === null) {
            $this->httpHandler = new Curl();
        } elseif (!is_object($this->httpHandler)) {
            throw new TasException(static::HTTP_HANDLER . ' must be instance of HttpHandler but ' . gettype($this->httpHandler) . ' was given');
        } elseif (!$this->httpHandler instanceof HttpHandler) {
            throw new TasException(static::HTTP_HANDLER . ' must be instance of HttpHandler but instance of ' . get_class($this->httpHandler) . ' was given');
        }

        if (empty($this->accessId)) {
            throw new TasException(static::ACCESS_ID . ' required and is not supplied in the config');
        }

        if (empty($this->secretKey)) {
            throw new TasException(static::SECRET_KEY . ' required and is not supplied in the config');
        }

        if (!is_callable($this->getTrackingIdCallback)) {
            throw new TasException(static::GET_TRACKING_ID_CALLBACK . ' is required and needs to be callable');
        }

        if (!is_callable($this->storeTrackingIdCallback)) {
            throw new TasException(static::STORE_TRACKING_ID_CALLBACK . ' is required and needs to be callable');
        }
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return mixed
     */
    public function getAcceptLanguage()
    {
        return $this->acceptLanguage;
    }

    /**
     * @return mixed
     */
    public function getAccessId()
    {
        return $this->accessId;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @return HttpHandler
     */
    public function getHttpHandler()
    {
        return $this->httpHandler;
    }

    /**
     * @return callable
     */
    public function getTrackingIdCallback()
    {
        return $this->getTrackingIdCallback;
    }

    /**
     * @return callable
     */
    public function getStoreTrackingIdCallback()
    {
        return $this->storeTrackingIdCallback;
    }
}
