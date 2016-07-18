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

class Deal
{
    /**
     * Name of the booking site.
     *
     * @var string
     */
    private $bookingSiteName;

    /**
     * Logo URL of the booking site.
     *
     * The URL is encrypted and already contains all information to assign the conversion to your account.
     * No modification to this URL is needed.
     *
     * @var string
     */
    private $bookingSiteLogo;

    /**
     * URL to the booking site.
     *
     * @var string
     */
    private $bookingLink;

    /**
     * Room description provided by the booking site.
     *
     * Example: 'Junior Suite Breakfast included'
     *
     * @var string
     */
    private $description;

    /**
     * @var Price
     */
    private $price;

    /**
     * @var RateAttribute[]
     */
    private $rateAttributes = [];

    /**
     * @param array $data
     *
     * @return Deal
     */
    public static function fromArray(array $data)
    {
        $deal = new static();

        $deal->bookingLink     = $data['booking_link'];
        $deal->bookingSiteLogo = $data['booking_site']['logo'];
        $deal->bookingSiteName = $data['booking_site']['name'];
        $deal->description     = $data['description'];
        $deal->price           = new Price($data['price']['currency'], $data['price']['formatted']);
        $deal->rateAttributes  = array_map(function ($rateAttribute) {
            return new RateAttribute($rateAttribute['type'], $rateAttribute['label'], $rateAttribute['positive']);
        }, $data['rate_attributes']);

        return $deal;
    }

    /**
     * @return string
     */
    public function getBookingLink()
    {
        return $this->bookingLink;
    }

    /**
     * @return string
     */
    public function getBookingSiteLogo()
    {
        return $this->bookingSiteLogo;
    }

    /**
     * @return string
     */
    public function getBookingSiteName()
    {
        return $this->bookingSiteName;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return RateAttribute[]
     */
    public function getRateAttributes()
    {
        return $this->rateAttributes;
    }
}
