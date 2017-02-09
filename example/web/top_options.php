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

$config     = require_once __DIR__ . '/../config.php';
$tas        = new \Trivago\Tas\Tas($config);
$topOptions = $tas->getTopOptions(new \Trivago\Tas\Request\TopOptionsRequest());
?>

<h2>Top Options</h2>
<table border="1">
    <thead>
        <tr>
            <th>Id</th>
            <th>Type</th>
            <th>Name</th>
            <th>Tags</th>
            <th>RateAttributes</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($topOptions as $topOption): ?>
            <tr>
                <td><?php echo $topOption->getId() ?></td>
                <td><?php echo $topOption->getType() ?></td>
                <td><?php echo $topOption->getName() ?></td>
                <td><?php echo implode(', ', $topOption->getTags()) ?></td>
                <td><?php echo implode(', ', $topOption->getRateAttributes()) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
