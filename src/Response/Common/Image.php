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

namespace Trivago\Tas\Response\Common;

class Image
{
    /**
     * URL to medium size version of the image.
     *
     * @var string
     */
    private $medium;

    /**
     * URL to extra large size version of the image.
     *
     * @var string
     */
    private $extraLarge;

    /**
     * URL to retina version of the image.
     *
     * @var string
     */
    private $retina;

    public static function fromArray(array $imageSizes)
    {
        $image             = new static();
        $image->medium     = $imageSizes['medium'];
        $image->extraLarge = $imageSizes['extra_large'];
        $image->retina     = $imageSizes['retina'];

        return $image;
    }

    /**
     * Returns URL to extra large size version of the image.
     *
     * @return string
     */
    public function getExtraLarge()
    {
        return $this->extraLarge;
    }

    /**
     * Returns URL to medium size version of the image.
     *
     * @return string
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * Returns URL to retina version of the image.
     *
     * @return string
     */
    public function getRetina()
    {
        return $this->retina;
    }

    public function __toString()
    {
        return $this->medium;
    }
}
