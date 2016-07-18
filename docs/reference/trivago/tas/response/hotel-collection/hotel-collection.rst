========================================================
Trivago\\Tas\\Response\\HotelCollection\\HotelCollection
========================================================

This class is a collection of :code:`Trivago\Tas\Response\HotelCollection\Hotel` instances.


count()
=======

.. code-block:: php

    public function int count()

Returns the number of hotels in the collection.


getNextPageOffset()
===================

.. code-block:: php

    public function int|null getNextPageOffset()

Returns the next offset. If the collection represents the last page, :code:`null` is returned.


getPrevPageOffset()
===================

.. code-block:: php

    public function int|null getPrevPageOffset()

Returns the previous offset. If the collection represents the first page, :code:`null` is returned.


hasNextPage()
=============

.. code-block:: php

    public function bool hasNextPage()

Checks if there is a next page. Returns :code:`false` if the current page is the last one.


hasPrevPage()
=============

.. code-block:: php

    public function bool hasPrevPage()

Checks if there is a previous page. Returns :code:`false` if the current page is the first one.


pollingFinished()
=================

.. code-block:: php

    public function bool pollingFinished()

Indicates if the polling was finished. If the polling was not finished there might be updated prices. The request has to be repeated until the polling finished.


toArray()
=========

.. code-block:: php

    public function Hotel[] toArray()

Returns all hotels in an array.
