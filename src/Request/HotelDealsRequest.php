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

use DateTime;

class HotelDealsRequest extends Request
{
    const ITEM       = 'item';
    const START_DATE = 'start_date';
    const END_DATE   = 'end_date';
    const ROOM_TYPE  = 'room_type';
    const CURRENCY   = 'currency';
    const LIMIT      = 'limit';
    const OFFSET     = 'offset';

    /**
     * @var int
     */
    private $item;

    /**
     * @var \DateTime
     */
    private $startDate;

    /**
     * @var \DateTime
     */
    private $endDate;

    /**
     * @link https://en.wikipedia.org/wiki/ISO_4217
     *
     * @var null|string
     */
    private $currency;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @see \Trivago\Tas\Request\Common\RoomType
     *
     * @var int|null
     */
    private $roomType;

    /**
     * @var array
     */
    private $optionalParameterMap = [
        'currency' => 'currency',
        'limit'    => 'limit',
        'offset'   => 'offset',
        'roomType' => 'room_type',
    ];

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        $options = array_merge([
            static::ITEM       => null,
            static::START_DATE => new DateTime('+1 day'),
            static::END_DATE   => new DateTime('+2 days'),
            static::CURRENCY   => null,
            static::LIMIT      => null,
            static::OFFSET     => null,
            static::ROOM_TYPE  => null,
        ], $options);

        $this->item      = $options[static::ITEM];
        $this->startDate = $options[static::START_DATE];
        $this->endDate   = $options[static::END_DATE];
        $this->currency  = $options[static::CURRENCY];
        $this->limit     = $options[static::LIMIT];
        $this->offset    = $options[static::OFFSET];
        $this->roomType  = $options[static::ROOM_TYPE];

        if (empty($this->item)) {
            throw new \InvalidArgumentException('Cannot create HotelDealsRequest without an item.');
        }
    }

    /**
     * @return array
     */
    public function getQueryParameters()
    {
        $parameters = [
            'start_date' => $this->startDate->format(DateTime::ATOM),
            'end_date'   => $this->endDate->format(DateTime::ATOM),
        ];

        foreach ($this->optionalParameterMap as $propertyKey => $queryParameterKey) {
            if (isset($this->$propertyKey)) {
                $parameters[$queryParameterKey] = $this->$propertyKey;
            }
        }

        return $parameters;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return '/hotels/' . $this->item . '/deals';
    }
}
