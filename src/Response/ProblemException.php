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

class ProblemException extends \Exception
{
    private $problemType;
    private $title;
    private $response;

    /**
     * @param string   $type
     * @param string   $title
     * @param string   $detail
     * @param string   $code
     * @param Response $response
     */
    public function __construct($type, $title, $detail, $code, Response $response)
    {
        parent::__construct($detail);

        $this->problemType = $type;
        $this->response    = $response;
        $this->title       = $title;
        $this->code        = $code;
    }

    /**
     * @return int
     */
    public function getHttpCode()
    {
        return $this->response->getHttpCode();
    }

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return int
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getProblemType()
    {
        return $this->problemType;
    }
}
