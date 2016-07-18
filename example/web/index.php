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
 * Replaces highlighted terms with corret HTML.
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

/**
 * Generates the URL to the search result page.
 *
 * A Location can be an item or a path.
 * An item can be a hotel or an attraction.
 * A path is a geographical region like a city, country or continent.
 *
 * @param \Trivago\Tas\Response\Locations\Location $location
 *
 * @return string Url to the search result page.
 */
function create_link_from_location(\Trivago\Tas\Response\Locations\Location $location)
{
    $url         = 'hotel_collection.php';
    $queryParams = [];

    if ($location->isHotel() || $location->isAttraction()) {
        $queryParams['item'] = $location->getItemId();
    }

    // A hotel has prices and we can show the detail page directly.
    if ($location->isHotel()) {
        $url = 'hotel.php';
    }

    if ($location->isPath() || $location->isAttraction()) {
        $queryParams['path'] = $location->getPathId();
    }

    return $url . '?' . http_build_query($queryParams, null, '&');
}

?>

<!doctype html>
<html>
<head>
</head>
<body>

    <h1>trivago affiliate demo application</h1>
    <p>
        Please enter a search term to start your search.
    </p>
    <form method="get">
        <label for="search-term">Search Term</label>
        <input type="search" name="query" id="search-term" placeholder="Berlin" value="<?php echo htmlentities($searchTerm) ?>" required>
        <button type="submit">Search</button>
    </form>

    <?php if (count($locations)): ?>
        <hr>

        <ul>
            <?php foreach ($locations as $location): ?>
                <li>
                    <a href="<?php echo create_link_from_location($location) ?>">
                        <?php echo highlight_search_term($location->getName()) . ', ' . $location->getPathName() ?>
                        <?php if ($location->getCount()): ?>
                            (<?php echo $location->getCount() ?> Hotels)
                        <?php endif ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>

</body>
</html>
