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

class ReviewsTest extends \PHPUnit_Framework_TestCase
{
    public function test_reviews_mapping()
    {
        $reviews = Reviews::fromResponse(
            include __DIR__ . '/../../_fixtures/hotel_reviews_response_200.php'
        );

        $this->assertInstanceOf(Reviews::class, $reviews);
        $this->assertCount(17, $reviews);

        foreach ($reviews as $review) {
            $this->assertInstanceOf(Review::class, $review);
        }

        $this->assertInternalType('array', $reviewsArray = $reviews->toArray());

        $review = $reviewsArray[0];

        $this->assertSame('Excellent location and experience.', $review->getTitle());
        $this->assertContains('This hotel maintains the expected standard of the Ritz-Carlton chain. The amenities,', $review->getSummary());
        $this->assertFalse($review->isTruncated());
        $this->assertSame(10000, $review->getRatingValue());
        $this->assertSame('Reviewed January 2017 by Traveller', $review->getInfo());

        $config = $review->getConfig();

        $this->assertInstanceOf(Config::class, $config);
        $this->assertSame(1580, $config->getPartnerId());
        $this->assertSame('Orbitz', $config->getPartnerName());
        $this->assertTrue($config->isLogoEnabled());
        $this->assertSame('//ie1.trivago.com/images/layoutimages/Rating/Partner/1580_mx.png', $config->getLogo());
        $this->assertSame('Powered by', $config->getLogoText());
        $this->assertTrue($config->isLinkEnabled());
        $this->assertSame('', $config->getLink());
    }
}
