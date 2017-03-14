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

$config = require_once __DIR__ . '/../config.php';
$tas    = new \Trivago\Tas\Tas($config);

$hotelId        = !empty($_GET['item']) ? $_GET['item'] : null;
$reviewsRequest = new \Trivago\Tas\Request\HotelReviewsRequest($hotelId);
$reviews        = $tas->getHotelReviews($reviewsRequest);
?>

<!doctype html>
<html>
<head>
</head>
<body>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>When/Who</th>
            <th>Rating</th>
            <th>Partner-Logo</th>
            <th>Partner-Name</th>
        </tr>
        <?php foreach ($reviews as $review): ?>
        <tr>
            <td><?php echo $review->getTitle(); ?></td>
            <td><?php echo $review->getInfo(); ?></td>
            <td><?php echo $review->getRatingValue(); ?></td>
            <td><img src="<?php echo $review->getConfig()->getLogo(); ?>"></td>
            <td><?php echo $review->getConfig()->getPartnerName(); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
