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
use Trivago\Tas\Request\HotelDetailsRequest;
use Trivago\Tas\Request\HotelRatesRequest;

$config = require_once __DIR__ . '/../config.php';
$tas    = new \Trivago\Tas\Tas($config);

$hotelId      = !empty($_GET['item']) ? $_GET['item'] : null;
$dealsRequest = new HotelRatesRequest([
    HotelRatesRequest::ITEM => $hotelId,
]);

$hotelDeals   = $tas->getHotelRates($dealsRequest);
$hotelDetails = $tas->getHotelDetails(new HotelDetailsRequest($hotelId));

?>

<!doctype html>
<html>
<head>
    <?php if (!$hotelDeals->pollingFinished()): ?>
        <meta http-equiv="refresh" content="2">
    <?php endif ?>
</head>
<body>

    <table border="1">
        <tr>
            <td colspan="2">
                <h1>
                    <?php echo $hotelDetails->getName() ?>
                    <?php echo str_repeat('*', $hotelDetails->getCategory()) ?>
                    <?php echo $hotelDetails->isSuperior() ? 'S' : '' ?>
                </h1>
            </td>
        </tr>
        <tr>
            <td>
                <img src="<?php echo $hotelDetails->getMainImage() ?>" width="200">
            </td>
            <td>
                <?php if ($hotelDetails->hasDescription()): ?>
                    <p>
                        <?php echo htmlentities($hotelDetails->getDescription()) ?>
                    </p>
                <?php endif ?>

                <address>
                    <?php echo htmlentities($hotelDetails->getAddress()) ?><br>
                    <?php echo htmlentities($hotelDetails->getZip()) ?> <?php echo htmlentities($hotelDetails->getCity()) ?>
                </address>

                <p>
                    This hotel is rated <?php echo $hotelDetails->getRatingValue() ?>/100 by <?php echo $hotelDetails->getRatingCount() ?> people.
                </p>

                <?php if ($hotelDetails->hasHomepage()): ?>
                    <p>
                        <a href="<?php echo htmlentities($hotelDetails->getHomepage()) ?>" target="_blank" rel="noopener">Visit hotel website</a>
                    </p>
                <?php endif ?>
            </td>
        </tr>
    </table>

    <table border="1">
        <thead>
            <tr>
                <th>Booking Site</th>
                <th>Room Description</th>
                <th>Rate Attributes</th>
                <th>Deal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hotelDeals as $deal): ?>
                <tr>
                    <td>
                        <img src="<?php echo $deal->getBookingSiteLogo() ?>" alt="<?php echo $deal->getBookingSiteName() ?>">
                    </td>
                    <td><?php echo $deal->getDescription() ?></td>
                    <td>
                        <?php
                        $rateAttributesAsHtml = array_map(function (\Trivago\Tas\Response\Common\RateAttribute $rateAttribute) {
                            return $rateAttribute->isPositive()
                                ? "<strong>{$rateAttribute->getLabel()}</strong>"
                                : $rateAttribute->getLabel();
                        }, $deal->getRateAttributes());

                        echo implode(', ', $rateAttributesAsHtml);
                        ?>
                    </td>
                    <td>
                        <a href="<?php echo $deal->getBookingLink() ?>" target="_blank" rel="noopener">
                            <?php echo $deal->getPrice() ?>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>

            <?php if (!$hotelDeals->pollingFinished()): ?>
                <tr>
                    <td colspan="4">Loading more prices...</td>
                </tr>
            <?php elseif (!count($hotelDeals)): ?>
                <tr>
                    <td colspan="4">No prices available for this hotel.</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>

</body>
</html>
