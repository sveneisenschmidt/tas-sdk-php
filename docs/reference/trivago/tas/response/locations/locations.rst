============================================
Trivago\\Tas\\Response\\Locations\\Locations
============================================

The Locations is a collection of locations. You can use :code:`foreach` to iterate over all locations or use :code:`toArray()` to retrieve all locations as an array.


count()
=======

.. code-block:: php

    public function int count()

Returns the number of locations.


getQuery()
==========

.. code-block:: php

    public function string getQuery()

Returns the query used to search for locations. This query might be corrected (for example if there was a spelling mistake) by the server.


isQueryCorrected()
==================

.. code-block:: php

    public function bool isQueryCorrected()

Returns :code:`true` if query was auto corrected.


toArray()
=========

.. code-block:: php

    public function Location[] toArray()

Returns all locations in an array.
