==============================================
Trivago\\Tas\\Response\\HotelCollection\\Hotel
==============================================

To use these functions you must first get a hotel collection and use the :code:`toArray()` function to return an array of
hotels. From that array you can select a given hotel by the array index and use these functions to gather information
about the hotel.

getId()
=======

.. code-block:: php

    public function int getId()

Returns the item id of the hotel.


getName()
=========

.. code-block:: php

    public function string getName()

Returns the name of the hotel.


getCategory()
=============

.. code-block:: php

    public function int getCategory()

Returns the hotel category.


isSuperior()
============

.. code-block:: php

    public function bool isSuperior()

If the hotel is a superior hotel then :code:`true` else :code:`false` is returned.


getCity()
=========

.. code-block:: php

    public function string getCity()

Returns the name of the city.


getRatingValue()
================

.. code-block:: php

    public function int getRatingValue()

The rating value is a float number from 0 to 100. Higher values indicates a better hotel rating.


getRatingCount()
================

.. code-block:: php

    public function int getRatingCount()

Returns the number of ratings the rating value is based on.


getMainImage()
==============

.. code-block:: php

    public function int getMainImage()

Returns the main image of the hotel.


getDeals()
==========

.. code-block:: php

    public function Deal[] getDeals()

Returns the deals as an array. The deals are ordered by price.


hasDeals()
==========

.. code-block:: php

    public function bool hasDeals()

Checks if there is at least one deal available for this hotel.


getBestDeal()
=============

.. code-block:: php

    public function Deal getBestDeal()

Returns the best (cheapest) deal.
