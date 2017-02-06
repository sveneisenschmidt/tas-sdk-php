<?php
/**
 * @author    Björn Mayer <bjoern.mayer@trivago.com>
 * @since     2017-02-06
 * @copyright 2017 (c) trivago GmbH, Düsseldorf
 * @license   All rights reserved.
 */

namespace Trivago\Tas\Response\TopOptions;

class TopOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function test_top_options_response_first_element()
    {
        $topOptions = TopOptions::fromResponse(
            include __DIR__ . '/../../_fixtures/top_options_response_200.php'
        );

        $this->assertInstanceOf(TopOptions::class, $topOptions);
        $this->assertCount(7, $topOptions);

        $allTopOptions = $topOptions->toArray();

        $this->assertInstanceOf(TopOption::class, $topOption = $allTopOptions[0]);
        $this->assertSame(1, $topOption->getId());
        $this->assertSame('Free WiFi', $topOption->getName());
        $this->assertInstanceOf(Tag::class, $tag = $topOption->getTags()[0]);
        $this->assertSame(437, $tag->getId());
    }

    public function test_all_top_option_elements()
    {
        $topOptions = TopOptions::fromResponse(
            include __DIR__ . '/../../_fixtures/top_options_response_200.php'
        );

        foreach ($topOptions as $topOption)
        {
            $this->assertInstanceOf(TopOption::class, $topOption);
        }
    }
}
