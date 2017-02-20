<?php
/**
 * @author    Björn Mayer <bjoern.mayer@trivago.com>
 * @since     2017-02-20
 * @copyright 2017 (c) trivago GmbH, Düsseldorf
 * @license   All rights reserved.
 */

namespace Trivago\Tas\Response\HotelCollection;

class Tag
{

    /**
     * @var string
     */
    private $tag_id;

    /**
     * @var int
     */
    private $group_id;

    /**
     * @var int
     */
    private $count;


    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    public static function fromArray(array $data)
    {
        $tag           = new static();
        $tag->tag_id   = $data['tag_id'];
        $tag->group_id = (int) $data['group_id'];
        $tag->count    = (int) $data['count'];

        return $tag;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->tag_id;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

}
