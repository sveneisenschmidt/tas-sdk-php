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

namespace Trivago\Tas\Response\HotelDetails;

use Trivago\Tas\Response\Common\GeoCoordinates;
use Trivago\Tas\Response\Common\Image;
use Trivago\Tas\Response\Common\Path;
use Trivago\Tas\Response\Response;

class HotelDetails
{
    /**
     * @var int
     */
    private $itemId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $zip;

    /**
     * @var string
     */
    private $city;

    /**
     * @var GeoCoordinates
     */
    private $geoCoordinates;

    /**
     * @var int
     */
    private $category;

    /**
     * @var bool
     */
    private $superior;

    /**
     * @var string
     */
    private $homepage;

    /**
     * @var float
     */
    private $ratingValue;

    /**
     * @var int
     */
    private $ratingCount;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var Path
     */
    private $path;

    /**
     * @var Image
     */
    private $mainImage;

    /**
     * @var Image[]
     */
    private $galleryImages = [];

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    public static function fromResponse(Response $response)
    {
        $data = $response->getContentAsArray();

        $hotelDetails                 = new static();
        $hotelDetails->itemId         = (int) $data['item_id'];
        $hotelDetails->name           = $data['name'];
        $hotelDetails->address        = $data['address'];
        $hotelDetails->zip            = $data['zip'];
        $hotelDetails->city           = $data['city'];
        $hotelDetails->geoCoordinates = GeoCoordinates::fromArray($data['geo_coordinates']);
        $hotelDetails->category       = (int) $data['category'];
        $hotelDetails->superior       = (bool) $data['superior'];
        $hotelDetails->homepage       = $data['homepage'];
        $hotelDetails->ratingValue    = (float) $data['rating_value'];
        $hotelDetails->ratingCount    = (int) $data['rating_count'];
        $hotelDetails->description    = $data['description'];
        $hotelDetails->path           = Path::fromArray($data['path']);
        $hotelDetails->mainImage      = Image::fromArray($data['main_image']);
        foreach ($data['gallery'] as $imageData) {
            $hotelDetails->galleryImages[] = Image::fromArray($imageData);
        }

        return $hotelDetails;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function hasDescription()
    {
        return !empty($this->description);
    }

    /**
     * @return Image[]|array
     */
    public function getGalleryImages()
    {
        return $this->galleryImages;
    }

    /**
     * @return GeoCoordinates
     */
    public function getGeoCoordinates()
    {
        return $this->geoCoordinates;
    }

    /**
     * @return string|null
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * @return bool
     */
    public function hasHomepage()
    {
        return $this->homepage !== null;
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @return Image
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return int
     */
    public function getRatingCount()
    {
        return $this->ratingCount;
    }

    /**
     * @return float
     */
    public function getRatingValue()
    {
        return $this->ratingValue;
    }

    /**
     * @return mixed
     */
    public function isSuperior()
    {
        return $this->superior;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }
}
