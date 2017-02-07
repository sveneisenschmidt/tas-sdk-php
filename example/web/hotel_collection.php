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
use Trivago\Tas\Request\HotelCollectionRequest;

$config = require_once __DIR__ . '/../config.php';
$tas    = new \Trivago\Tas\Tas($config);

$path          = isset($_GET['path']) ? $_GET['path'] : null;
$item          = isset($_GET['item']) ? $_GET['item'] : null;
$itemList      = isset($_GET['item_list']) ? $_GET['item_list'] : null;
$referenceList = isset($_GET['reference_list']) ? $_GET['reference_list'] : null;
$offset        = isset($_GET['offset']) ? $_GET['offset'] : 0;
$radius        = isset($_GET['radius']) ? $_GET['radius'] : null;

// Format reference list if we have one
if ($referenceList) {
    $referenceListParts = explode(',', $referenceList);
    $referenceList      = array_map(
        function ($id) {
            return trim($id);
        }, $referenceListParts
    );
}

$request = new HotelCollectionRequest([
    HotelCollectionRequest::PATH           => $path,
    HotelCollectionRequest::ITEM           => $item,
    HotelCollectionRequest::ITEM_LIST      => $itemList,
    HotelCollectionRequest::REFERENCE_LIST => $referenceList,
    HotelCollectionRequest::LIMIT          => 25,
    HotelCollectionRequest::OFFSET         => $offset,
    HotelCollectionRequest::RADIUS         => $radius,
]);

$hotelCollection = $tas->getHotelCollection($request);

?>

<!doctype html>
<html>
<head>
    <?php if (!$hotelCollection->pollingFinished()): ?>
        <meta http-equiv="refresh" content="2">
    <?php endif ?>
</head>
<body>

    <?php if ($hotelCollection->hasPrevPage()): ?>
        <a href="<?php echo "hotel_collection.php?path={$path}&item={$item}&offset={$hotelCollection->getPrevPageOffset()}&radius={$radius}" ?>">Prev</a>
    <?php endif;

    if ($hotelCollection->hasNextPage()): ?>
        <a href="<?php echo "hotel_collection.php?path={$path}&item={$item}&offset={$hotelCollection->getNextPageOffset()}&radius={$radius}" ?>">Next</a>
    <?php endif ?>

    <table border="1">
        <thead>
            <tr>
                <th>Picture</th>
                <th>Name</th>
                <th>Booking Site</th>
                <th>Rate Attributes</th>
                <th>Deal</th>
                <?php if (count($hotelCollection) > 0 && $hotelCollection->toArray()[0]->getPoi() !== null): ?>
                    <th>Point of Interest</th>
                <?php endif ?>
            </tr>
        </thead>

        <tbody>

            <?php foreach ($hotelCollection as $hotel): ?>
                <tr>
                    <td>
                        <img src="<?php echo $hotel->getMainImage()->getMedium() ?>" alt="">
                    </td>
                    <td>
                        <a href="<?php echo 'hotel.php?item=' . $hotel->getId() ?>">
                            <?php echo $hotel->getName() ?>
                        </a>
                    </td>
                    <?php if ($hotel->hasDeals()): ?>
                        <?php $bestDeal = $hotel->getBestDeal() ?>
                        <td>
                            <img src="<?php echo $bestDeal->getBookingSiteLogo() ?>" alt="<?php echo $bestDeal->getBookingSiteName() ?>">
                        </td>
                        <td>
                            <?php
                            $rateAttributesAsHtml = array_map(function (\Trivago\Tas\Response\Common\RateAttribute $rateAttribute) {
                                return $rateAttribute->isPositive()
                                    ? "<strong>{$rateAttribute->getLabel()}</strong>"
                                    : $rateAttribute->getLabel();
                            }, $bestDeal->getRateAttributes());

                            echo implode(', ', $rateAttributesAsHtml);
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo $bestDeal->getBookingLink() ?>" target="_blank" rel="noopener">
                                <?php echo $bestDeal->getPrice() ?>
                            </a>
                        </td>
                    <?php else: ?>
                        <td colspan="3">No Best Deal</td>
                    <?php endif;
                    if ($hotel->hasPoi()): ?>
                        <td>
                            <span title="<?php echo \Trivago\Tas\Component\Util\DistanceConverter::meterToKilometer($hotel->getPoi()->getDistance()) ?> km"><?php echo $hotel->getPoi()->getText() ?></span>
                        </td>
                    <?php endif ?>
                </tr>

            <?php endforeach ?>

            <?php if (!$hotelCollection->pollingFinished()): ?>
                <tr>
                    <td colspan="5">Loading more hotels...</td>
                </tr>
            <?php elseif (!count($hotelCollection)): ?>
                <tr>
                    <td colspan="5">No hotels available.</td>
                </tr>
            <?php endif ?>

        </tbody>
    </table>

</body>
</html>
