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

class HotelCollectionRequest extends Request
{
    const PATH         = 'path';
    const ITEM         = 'item';
    const START_DATE   = 'start_date';
    const END_DATE     = 'end_date';
    const ROOM_TYPE    = 'room_type';
    const CURRENCY     = 'currency';
    const CATEGORY     = 'category';
    const LIMIT        = 'limit';
    const OFFSET       = 'offset';
    const ORDER        = 'order';
    const RATING_CLASS = 'rating_class';
    const HOTEL_NAME   = 'hotel_name';
    /**
     * @var int|null
     */
    private $path;

    /**
     * @var int|null
     */
    private $item;

    /**
     * @var DateTime
     */
    private $startDate;

    /**
     * @var DateTime
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
     * @see \Trivago\Tas\Request\Common\Order
     *
     * @var null|string
     */
    private $order;

    /**
     * @var array|null
     */
    private $category;

    /**
     * @see \Trivago\Tas\Request\Common\RoomType
     *
     * @var int|null
     */
    private $roomType;

    /**
     * @var array|null
     */
    private $ratingClass;

    /**
     * @var string|null
     */
    private $hotelName;

    /**
     * @var array
     */
    private $optionalParameterMap = [
        'item'        => 'item',
        'path'        => 'path',
        'currency'    => 'currency',
        'limit'       => 'limit',
        'offset'      => 'offset',
        'order'       => 'order',
        'category'    => 'category',
        'roomType'    => 'room_type',
        'ratingClass' => 'rating_class',
        'hotelName'   => 'hotel_name',
    ];

    /**
     * @param array $options
     *
     * @throws InvalidRequestException
     */
    public function __construct($options = [])
    {
        $options = array_merge([
            static::PATH         => null,
            static::ITEM         => null,
            static::START_DATE   => new DateTime('+1 day'),
            static::END_DATE     => new DateTime('+2 days'),
            static::ROOM_TYPE    => null,
            static::CURRENCY     => null,
            static::CATEGORY     => null,
            static::LIMIT        => null,
            static::OFFSET       => null,
            static::ORDER        => null,
            static::RATING_CLASS => null,
            static::HOTEL_NAME   => null,
        ], $options);

        $this->path        = $options[static::PATH];
        $this->item        = $options[static::ITEM];
        $this->startDate   = $options[static::START_DATE];
        $this->endDate     = $options[static::END_DATE];
        $this->roomType    = $options[static::ROOM_TYPE];
        $this->currency    = $options[static::CURRENCY];
        $this->category    = $options[static::CATEGORY];
        $this->limit       = $options[static::LIMIT];
        $this->offset      = $options[static::OFFSET];
        $this->order       = $options[static::ORDER];
        $this->ratingClass = $options[static::RATING_CLASS];
        $this->hotelName   = $options[static::HOTEL_NAME];

        if (empty($this->item) && empty($this->path)) {
            throw new InvalidRequestException('Item ID and path ID are empty. At least one of these is required.');
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
        return '/hotels';
    }
}
