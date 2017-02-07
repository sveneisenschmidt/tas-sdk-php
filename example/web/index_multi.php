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

$searchTerm = isset($_GET['query']) ? $_GET['query'] : '';

$locations = [];
if (!empty($searchTerm)) {
    $locations = $tas->getLocations(new \Trivago\Tas\Request\LocationsRequest($searchTerm));
}

/**
 * Replaces highlighted terms with correct HTML.
 *
 * Example: 'Hotel {Berlin}' becomes 'Hotel <strong>Berlin</strong>'
 *
 * @param string $name
 *
 * @return string
 */
function highlight_search_term($name)
{
    return preg_replace_callback('/(\{[^\}]*\})/', function ($match) {
        $name = substr($match[0], 1, strlen($match[0]) - 2);

        return '<strong>' . $name . '</strong>';
    }, $name);
}
?>

<!doctype html>
<html>
<head>
</head>
<body>

    <h1>trivago affiliate demo application</h1>
    <p>
        Please enter a search term to start your search.<br>
        The results will only display <strong>hotels</strong> and <strong>attractions</strong>; select multiple to start a multi-item search with them.
    </p>
    <form method="get">
        <label for="search-term">Search Term</label>
        <input type="search" name="query" id="search-term" placeholder="Radisson" value="<?php echo htmlentities($searchTerm) ?>" required>
        <button type="submit">Search</button>
    </form>

    <?php if (count($locations)): ?>
        <hr>

        <form action="hotel_collection.php" method="get">
            <ul>
                <?php foreach ($locations as $location): ?>
                    <?php if ($location->isPath()) continue; ?>
                    <li>
                        <label for="<?php echo $location->getItemId(); ?>">
                            <input type="checkbox" name="item_list[]" value="<?php echo $location->getItemId(); ?>">&nbsp;
                            <?php echo highlight_search_term($location->getName()) . ', ' . $location->getPathName() ?>
                            <?php if ($location->getCount()): ?>
                                (<?php echo $location->getCount() ?> Hotels)
                            <?php endif ?>
                        </label>
                    </li>
                <?php endforeach ?>
            </ul>
            <input type="submit" value="Search">
        </form>
    <?php endif ?>

</body>
</html>
