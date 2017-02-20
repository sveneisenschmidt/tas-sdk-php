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

$config    = require_once __DIR__ . '/../config.php';
$tas       = new \Trivago\Tas\Tas($config);
$hotelTags = $tas->getHotelTags(new \Trivago\Tas\Request\HotelTagsRequest());

?>

<h2>Hotel-Tag-Groups</h2>
<table border="1">
    <thead>
        <tr>
            <th>Group-ID</th>
            <th>Name</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($hotelTags->getTagGroups() as $tagGroup): ?>
        <tr>
            <td><?php echo $tagGroup->getGroupId() ?></td>
            <td><?php echo $tagGroup->getName() ?></td>
            <td><?php echo $tagGroup->getType() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<h2>Hotel-Tags</h2>
<table border="1">
    <thead>
    <tr>
        <th>Tag-ID</th>
        <th>Group-ID</th>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($hotelTags->getTags() as $tag): ?>
        <tr>
            <td><?php echo $tag->getId() ?></td>
            <td><?php echo $tag->getGroupId() ?></td>
            <td><?php echo $tag->getName() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
