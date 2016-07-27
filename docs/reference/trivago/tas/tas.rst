=================
Trivago\\Tas\\Tas
=================

The main service that provides access to the trivago Affiliate Suite API.


getHotelCollection()
====================

.. code-block:: php

    public function HotelCollection getHotelCollection(HotelCollectionRequest $request)

Triggers a price search and returns the current result.

Searching for prices takes some time. Therefore the returned result might not be complete. You have to implement a polling logic that will ask the hotels collection endpoint again if the result is not final yet. You should display an intermediate result to your user and update the result in an interval of 1 to 2 seconds. The polling can take up to 30 seconds until a final result is available.

.. code-block:: php

    use Trivago\Tas\Request\Common\Order;
    use Trivago\Tas\Request\Common\RoomType;
    use Trivago\Tas\Request\HotelCollectionRequest;

    $request = new HotelCollectionRequest([
        HotelCollectionRequest::PATH         => 38714,
        HotelCollectionRequest::ITEM         => 5678,
        HotelCollectionRequest::START_DATE   => new DateTime('+1 day'),
        HotelCollectionRequest::END_DATE     => new DateTime('+2 days'),
        HotelCollectionRequest::ROOM_TYPE    => RoomType::DOUBLE_ROOM,
        HotelCollectionRequest::CURRENCY     => 'EUR',
        HotelCollectionRequest::CATEGORY     => [3,4,5],
        HotelCollectionRequest::LIMIT        => 10,
        HotelCollectionRequest::OFFSET       => 0,
        HotelCollectionRequest::ORDER        => Order::PRICE,
        HotelCollectionRequest::RATING_CLASS => [3,4,5],
        HotelCollectionRequest::HOTEL_NAME   => 'Hyatt',
    ]);

    $hotels = $tas->getHotelCollection($request);

    while (!$hotels->pollingFinished()) {
        $hotels = $tas->getHotelCollection($request);
    }

Request
-------

The request must be an instance of :code:`Trivago\Tas\Request\HotelCollectionRequest`.

+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| Parameter    | Type      | Default | Required?  | Description                                                                                    |
+==============+===========+=========+============+================================================================================================+
| PATH         | int       | null    | if no item | The path ID.                                                                                   |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| ITEM         | int       | null    | if no path | The item ID.                                                                                   |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| START_DATE   | DateTime  | Date    | no         | The check in date. Must be a date today or in the future.                                      |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| END_DATE     | DateTime  | Date    | no         | The check out date. Must be a date after the check in date.                                    |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| CURRENCY     | string    | null    | no         | The ISO-4217 currency code.                                                                    |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| LIMIT        | int       | null    | no         | The limit must be a value greater equals 0.                                                    |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| OFFSET       | int       | null    | no         | The offset is a multiple of limit.                                                             |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| ORDER        | string    | null    | no         | Possible sorting options are: relevance, price, category, distance, overall_liking, basename   |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| CATEGORY     | array     | null    | no         | Hotel categories/star rating [0-5].                                                            |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| ROOM_TYPE    | int       | null    | no         | Type/size of the room. Possible options: 1 = single-room, 7 = double-room.                     |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| HOTEL_NAME   | string    | null    | no         | The hotel name. This will search for a hotel with the given name in the area defined by `path`.|
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+
| RATING_CLASS | array     | null    | no         | Hotel rating based on customers' ratings and reviews [1-5].                                    |
+--------------+-----------+---------+------------+------------------------------------------------------------------------------------------------+

Response
--------

The method returns an instance of :code:`Trivago\Tas\Response\HotelCollection\HotelCollection`.


getHotelDeals()
===============

.. code-block:: php

    public function HotelDeals getHotelDeals(HotelDealsRequest $request)


With the :code:`getHotelDeals` method you can retrieve prices for a single hotel. This method works similar to the :code:`getHotelCollection` method. Once this method is called a polling needs to be implemented. A search is started on trivago’s servers. The result of this method is the current state of the search. The result should be displayed as fast as possible to the user and the result needs to be updated until the polling is finished.

.. code-block:: php

    use Trivago\Tas\Request\Common\RoomType;
    use Trivago\Tas\Request\HotelDealsRequest;

    $request = new HotelDealsRequest([
        HotelDealsRequest::ITEM       => 5555,
        HotelDealsRequest::START_DATE => new DateTime('+1 day'),
        HotelDealsRequest::END_DATE   => new DateTime('+2 days'),
        HotelDealsRequest::CURRENCY   => 'EUR',
        HotelDealsRequest::LIMIT      => 25,
        HotelDealsRequest::OFFSET     => 0,
        HotelDealsRequest::ROOM_TYPE  => RoomType::SINGLE_ROOM
    ]);

    $deals = $tas->getHotelDeals($request);

    while (!$deals->pollingFinished()) {
        $deals = $tas->getHotelDeals();
    }

Request
-------

The request is an instance of :code:`Trivago\Tas\Request\HotelDealsRequest`.

+------------+-----------+---------+------------+----------------------------------------------------------------------------------------------+
| Parameter  | Type      | Default | Required?  | Description                                                                                  |
+============+===========+=========+============+==============================================================================================+
| ITEM       | int       | null    | yes        | The item ID.                                                                                 |
+------------+-----------+---------+------------+----------------------------------------------------------------------------------------------+
| START_DATE | DateTime  | Date    | no         | The check in date. Must be a date today or in the future.                                    |
+------------+-----------+---------+------------+----------------------------------------------------------------------------------------------+
| END_DATE   | DateTime  | Date    | no         | The check out date. Must be a date after the check in date.                                  |
+------------+-----------+---------+------------+----------------------------------------------------------------------------------------------+
| CURRENCY   | string    | null    | no         | The ISO-4217 currency code.                                                                  |
+------------+-----------+---------+------------+----------------------------------------------------------------------------------------------+
| LIMIT      | int       | null    | no         | The limit must be a value greater equals 0.                                                  |
+------------+-----------+---------+------------+----------------------------------------------------------------------------------------------+
| OFFSET     | int       | null    | no         | The offset is a multiple of limit.                                                           |
+------------+-----------+---------+------------+----------------------------------------------------------------------------------------------+
| ROOM_TYPE  | int       | null    | no         | Type/size of the room. Possible options: 1 = single-room, 7 = double-room.                   |
+------------+-----------+---------+------------+----------------------------------------------------------------------------------------------+


Response
--------

The method reurns an instance of :code:`Trivago\Tas\\Response\HotelDeals\HotelDeals`.


getHotelDetails()
=================

.. code-block:: php

    public function HotelDetails getHotelDetails(HotelDetailsRequest $request)

The :code:`getHotelDetails()` methods returns information about a specific hotel.

.. code-block:: php

    use Trivago\Tas\Request\HotelDetailsRequest;

    $request      = new HotelDetailsRequest(51383);
    $hotelDetails = $tas->getHotelDetails($request);

Request
-------

The :code:`Trivago\Tas\Request\HotelDetailsRequest` object contains only the item ID as parameter.

+------------+-----------+---------+------------+-------------------------+
| Parameter  | Type      | Default | Required?  | Description             |
+============+===========+=========+============+=========================+
| ITEM       | int       | none    | yes        | The item ID.            |
+------------+-----------+---------+------------+-------------------------+


Response
--------

The method returns an instance of :code:`Trivago\Tas\Response\HotelDetails`.


getLocations()
==============

.. code-block:: php

    public function Locations getLocations(LocationsRequest $request)


This method will search for locations by a given query.

.. code-block:: php

    use Trivago\Tas\Request\LocationsRequest;

    $request   = new LocationsRequest('düsseldorf');
    $locations = $tas->getLocations($request);

    foreach ($locations as $location) {
        // ...
    }

Request
-------

The request must be an instance of :code:`Trivago\Tas\Request\LocationsRequest`. It accepts the search query as a parameter.

+------------+-----------+---------+------------+-----------------------------------------------------------+
| Parameter  | Type      | Default | Required?  | Description                                               |
+============+===========+=========+============+===========================================================+
| QUERY      | string    | none    | yes        | A search query. For example "paris" or "eiffel tower".    |
+------------+-----------+---------+------------+-----------------------------------------------------------+


Response
--------

The method returns an object of type :code:`Trivago\Tas\Response\Locations\Locations`. You can use :code:`foreach` to iterate over the result.

A :code:`Trivago\Tas\Response\Locations\Location` instance can be a hotel, an attraction or a path.
