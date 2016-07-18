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

use Trivago\Tas\Request\RawRequest;

class RequestSignerTest extends \PHPUnit_Framework_TestCase
{
    public function test_sign_raw_request()
    {
        $signer     = new RequestSigner(1234, 1234, 1467720410);
        $rawRequest = new RawRequest('http://www.example.org/index.php?foo=bar');

        $signedUrl = $signer->signRequest($rawRequest);

        $this->assertSame(
            'http://www.example.org/index.php?foo=bar&access_id=1234&timestamp=2016-07-05T12%3A06%3A50%2B00%3A00&signature=nrEGFe0Jsttc%2F52k%2Bzbz8hX8GzTItYKEJEnj1pTOvGI%3D',
            $signedUrl
        );
    }
}
