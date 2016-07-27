==============================================
Trivago\\Tas\\Response\\HotelDeals\\HotelDeals
==============================================

This class is a collection of :code:`Trivago\Tas\Response\Common\Deal`. You can iterate using :code:`foreach`. This class implements the :code:`\Iterator` interface.

count()
=======

.. code-block:: php

    public function int count()

Returns the number of deals.


getSearchParams()
=================

.. code-block:: php

    public function array getSearchParams()

Returns the search parameters applied to the collection search.


pollingFinished()
=================

.. code-block:: php

    public function bool pollingFinished()

Indicates if the polling was finished. If the polling was not finished there might be updated prices. The request has to be repeated until the polling finished.


toArray()
=========

.. code-block:: php

    public function Deal[] toArray()

Returns all :code:`Trivago\Tas\Response\Common\Deal` objects in an array.
