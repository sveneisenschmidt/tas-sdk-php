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
    const PATH           = 'path';
    const ITEM           = 'item';
    const ITEM_LIST      = 'item_list';
    const REFERENCE_LIST = 'reference_list';
    const START_DATE     = 'start_date';
    const END_DATE       = 'end_date';
    const ROOM_TYPE      = 'room_type';
    const CURRENCY       = 'currency';
    const CATEGORY       = 'category';
    const LIMIT          = 'limit';
    const OFFSET         = 'offset';
    const ORDER          = 'order';
    const RATING_CLASS   = 'rating_class';
    const HOTEL_NAME     = 'hotel_name';
    const MAX_PRICE      = 'max_price';
    const RADIUS         = 'radius';

    /**
     * @var int|null
     */
    private $path;

    /**
     * @var int|null
     */
    private $item;

    /**
     * @var int[]|null
     */
    private $itemList;

    /**
     * @var string[]|null
     */
    protected $referenceList;

    /**
     * @var DateTime
     */
    private $startDate;

    /**
     * @var DateTime
     */
    private $endDate;

    /**
     * @see \Trivago\Tas\Request\Common\RoomType
     *
     * @var int|null
     */
    private $roomType;

    /**
     * @link https://en.wikipedia.org/wiki/ISO_4217
     *
     * @var null|string
     */
    private $currency;

    /**
     * @var array|null
     */
    private $category;

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
    private $ratingClass;

    /**
     * @var string|null
     */
    private $hotelName;

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     */
    private $radius;

    /**
     * @var array
     */
    private $optionalParameterMap = [
        'path'          => 'path',
        'item'          => 'item',
        'itemList'      => 'item_list',
        'referenceList' => 'reference_list',
        'roomType'      => 'room_type',
        'currency'      => 'currency',
        'limit'         => 'limit',
        'offset'        => 'offset',
        'order'         => 'order',
        'category'      => 'category',
        'ratingClass'   => 'rating_class',
        'hotelName'     => 'hotel_name',
        'maxPrice'      => 'max_price',
        'radius'        => 'radius',
    ];

    /**
     * @param array $options
     *
     * @throws InvalidRequestException
     */
    public function __construct($options = [])
    {
        $options = array_merge([
            static::PATH           => null,
            static::ITEM           => null,
            static::ITEM_LIST      => null,
            static::REFERENCE_LIST => null,
            static::START_DATE     => new DateTime('+1 day'),
            static::END_DATE       => new DateTime('+2 days'),
            static::ROOM_TYPE      => null,
            static::CURRENCY       => null,
            static::CATEGORY       => null,
            static::LIMIT          => null,
            static::OFFSET         => null,
            static::ORDER          => null,
            static::RATING_CLASS   => null,
            static::HOTEL_NAME     => null,
            static::MAX_PRICE      => null,
            static::RADIUS         => null,
        ], $options);

        $this->path          = $options[static::PATH];
        $this->item          = $options[static::ITEM];
        $this->itemList      = $options[static::ITEM_LIST];
        $this->referenceList = $options[static::REFERENCE_LIST];
        $this->startDate     = $options[static::START_DATE];
        $this->endDate       = $options[static::END_DATE];
        $this->roomType      = $options[static::ROOM_TYPE];
        $this->currency      = $options[static::CURRENCY];
        $this->category      = $options[static::CATEGORY];
        $this->limit         = $options[static::LIMIT];
        $this->offset        = $options[static::OFFSET];
        $this->order         = $options[static::ORDER];
        $this->ratingClass   = $options[static::RATING_CLASS];
        $this->hotelName     = $options[static::HOTEL_NAME];
        $this->maxPrice      = $options[static::MAX_PRICE];
        $this->radius        = $options[static::RADIUS];

        if (empty($this->item) && empty($this->path) && empty($this->itemList) && empty($this->referenceList)) {
            throw new InvalidRequestException('Item ID, Item ID list, Reference ID list and path ID are empty. At least one of these is required.');
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
