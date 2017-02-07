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
$pois   = $tas->getPois(new \Trivago\Tas\Request\PoisRequest(9647));
?>

<h2>Points of interest</h2>
<table border="1">
    <thead>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Geo-Coordinates</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($pois as $poi): ?>
        <tr>
            <td><?php echo $poi->getId() ?></td>
            <td><?php echo $poi->getName() ?></td>
            <td><?php echo $poi->getGeoCoordinates()->getLongitude(); ?>;<?php echo $poi->getGeoCoordinates()->getLatitude(); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
