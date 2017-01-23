<?php
/**
 * @author    Björn Mayer <bjoern.mayer@trivago.com>
 * @since     2017-01-23
 * @copyright 2017 (c) trivago GmbH, Düsseldorf
 * @license   All rights reserved.
 */

namespace Trivago\Tas\Response\HotelCollection;

class Poi
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $distance;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $text;

    /**
     * @param array $data
     *
     * @return static|null
     */
    public static function fromArray(array $data)
    {
        if (empty($data)) {
            return null;
        }

        $poi = new static();

        $poi->id       = (int)$data['id'];
        $poi->distance = (int)$data['distance'];
        $poi->name     = $data['name'];
        $poi->text     = $data['text'];

        return $poi;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
