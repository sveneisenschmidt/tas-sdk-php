<?php
/**
 * @author    Björn Mayer <bjoern.mayer@trivago.com>
 * @since     2017-02-20
 * @copyright 2017 (c) trivago GmbH, Düsseldorf
 * @license   All rights reserved.
 */

namespace Trivago\Tas\Response\HotelDetails;

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

    private function __construct()
    {
        // intentionally left empty. use named constructor to create new instances.
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public static function fromArray(array $data)
    {
        $tag           = new static();
        $tag->tag_id   = $data['tag_id'];
        $tag->group_id = (int) $data['group_id'];

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
}
