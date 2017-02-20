===================================================
Trivago\\Tas\\Response\\HotelCollection\\ResultInfo
===================================================

getMinPrice()
=============

.. code-block:: php

    public function int getMinPrice()

Returns the minimum price in the hotel collection.


getMaxPrice()
=============

.. code-block:: php

    public function int getMaxPrice()

Returns the maximum price in the hotel collection.


getCurrency()
=============

.. code-block:: php

    public function string getCurrency()

Returns the currency of the min and max prices.


hasPath()
=========

.. code-block:: php

    public function bool hasPath()

Returns true when the result info has a path block.


getPath()
=========

.. code-block:: php

    public function Path getPath()

Returns the path of the result info. Returns null when no path is there.
