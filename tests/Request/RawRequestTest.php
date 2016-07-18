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

class RawRequestTest extends \PHPUnit_Framework_TestCase
{
    public function test_raw_request()
    {
        $request = new RawRequest('https://www.example.net:8080/this/is/the/path?foo=bar');

        $this->assertSame('https://www.example.net:8080', $request->getBaseUrl());
        $this->assertSame('/this/is/the/path', $request->getPath());
        $this->assertSame([
            'foo' => 'bar',
        ], $request->getQueryParameters());
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('https://www.example.net:8080/this/is/the/path?foo=bar', (string) $request);
    }
}
