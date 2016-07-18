===========================================
Trivago\\Tas\\Response\\Locations\\Location
===========================================

The Location represents a search result from the locations endpoint. A Location can be a hotel, an attraction or a path.

count()
=======

.. code-block:: php

    public function int count()

Returns the number of hotels for the given path. Count will always return :code:`0` for hotels and attractions.


getItemId()
===========

.. code-block:: php

    public function int|null getItemId()

The ID of a hotel or an attraction. Returns always :code:`null` if location is a path.


getName()
=========

.. code-block:: php

    public function string getName()

Returns the name of the location.


getPathId()
===========

.. code-block:: php

    public function int getPathId()

Return the ID of the path. If location is a path.


getPathName()
=============

.. code-block:: php

    public function string getPathName()

- If the location is a hotel or an attraction, the city name is returned.
- If the location is a path, the parent path name is returned.


getType()
=========

.. code-block:: php

    public function string getType()

Returns the type of the location. This can be one of this values:

- hotel
- attraction
- path


isAttraction()
==============

.. code-block:: php

    public function bool isAttraction()

Returns :code:`true` if the location is an attraction. Otherwise :code:`false` is returned.


isHotel()
=========

.. code-block:: php

    public function bool isHotel()

Returns :code:`true` if the location is a hotel. Otherwise :code:`false` is returned.


isPath()
========

.. code-block:: php

    public function bool isPath()

Returns :code:`true` if the location is a path. Otherwise :code:`false` is returned.
