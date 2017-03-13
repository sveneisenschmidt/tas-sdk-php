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

class Config
{
    /**
     * @var int
     */
    private $partnerId;

    /**
     * @var string
     */
    private $partnerName;

    /**
     * @var bool
     */
    private $logoEnabled;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $logoText;

    /**
     * @var bool
     */
    private $linkEnabled;

    /**
     * @var string
     */
    private $link;

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instaces.
    }

    /**
     * @param array $data
     *
     * @return Config
     */
    public static function fromArray(array $data)
    {
        $config = new static();
        $config->partnerId   = (int) $data['partner_id'];
        $config->partnerName = $data['partner_name'];
        $config->logoEnabled = (bool) $data['logo_enabled'];
        $config->logo        = $data['logo'];
        $config->logoText    = $data['logo_text'];
        $config->linkEnabled = (bool) $data['link_enabled'];
        $config->link        = $data['link'];

        return $config;
    }

    /**
     * @return int
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * @return string
     */
    public function getPartnerName()
    {
        return $this->partnerName;
    }

    /**
     * @return bool
     */
    public function isLogoEnabled()
    {
        return $this->logoEnabled;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @return string
     */
    public function getLogoText()
    {
        return $this->logoText;
    }

    /**
     * @return bool
     */
    public function isLinkEnabled()
    {
        return $this->linkEnabled;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
}
