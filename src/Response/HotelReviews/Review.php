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

namespace Trivago\Tas\Response\HotelReviews;

class Review
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $summary;

    /**
     * @var bool
     */
    private $truncated;

    /**
     * @var int
     */
    private $ratingValue;

    /**
     * @var string
     */
    private $info;

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    /**
     * @param array $data
     *
     * @return Review
     *
     * @throws \InvalidArgumentException
     */
    public static function fromArray(array $data)
    {
        $review = new static();

        if (!$data['config'] instanceof Config) {
            throw new \InvalidArgumentException('The config must be instance of "\Trivago\Tas\Response\HotelReviews\Config"');
        }

        $review->config      = $data['config'];
        $review->title       = $data['title'];
        $review->summary     = $data['summary'];
        $review->truncated   = (bool) $data['truncated'];
        $review->ratingValue = (int) $data['rating_value'];
        $review->info        = $data['info'];

        return $review;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @return bool
     */
    public function isTruncated()
    {
        return $this->truncated;
    }

    /**
     * @return int
     */
    public function getRatingValue()
    {
        return $this->ratingValue;
    }

    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }
}
