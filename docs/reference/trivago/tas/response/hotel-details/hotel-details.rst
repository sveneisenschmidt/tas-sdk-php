==================================================
Trivago\\Tas\\Response\\HotelDetails\\HotelDetails
==================================================

getAddress()
============

.. code-block:: php

    public function string getAddress()

Returns the address of the hotel containing street and depending on the country other information.


getCategory()
=============

.. code-block:: php

    public function int getCategory()

Returns the hotel category.


getCity()
=========

.. code-block:: php

    public function string getCity()

Returns the name of the city.


getDescription()
================

.. code-block:: php

    public function string|null getDescription()

Returns a description text about the hotel. If no descritpion is available null is returned.


getGalleryImages()
==================

.. code-block:: php

    public function Image[] getGalleryImages()

Returns an array of :code:`Trivago\Tas\Response\Common\Image`.


getGeoCoordinates()
===================

.. code-block:: php

    public function GeoCoordinates getGeoCoordinates()

Returns the geo location of the hotel.


getHomepage()
=============

.. code-block:: php

    public function string|null getHomepage()

Returns the URL to the hotel’s homepage. The method returns :code:`null` if no homepage is available for this hotel.


getItemId()
===========

.. code-block:: php

    public function int getItemId()

Returns the item ID of the hotel.


getMainImage()
==============

.. code-block:: php

    public function Image getMainImage()

Returns the main image of the hotel.


getName()
=========

.. code-block:: php

    public function string getName()

Returns the name of the hotel.


getPath()
=========

.. code-block:: php

    public function Path getPath()

Returns the path of the hotel. This will be the city where the hotel is located.


getRatingCount()
================

.. code-block:: php

    public function int getRatingCount()

Returns the number of ratings the rating value is based on.


getRatingValue()
================

.. code-block:: php

    public function float getRatingValue()

The rating value is a float number from 0 to 100. Higher values indicates a better hotel rating.


getZip()
========

.. code-block:: php

    public function string getZip()

Returns the postal code of the hotel’s address.


hasDescription()
================

.. code-block:: php

    public function bool hasDescription()

Returns :code:`true` if there’s a description for the hotel.


hasHomepage()
=============

.. code-block:: php

    public function bool hasHomepage()

Returns :code:`true` if the hote has an own homepage and :code:`getHomepage()` will return an URL.


isSuperior()
============

.. code-block:: php

    public function bool isSuperior()

If the hotel is a superior hotel then :code:`true` else :code:`false` is returned.
