=============================================
Trivago\\Tas\\Response\\HotelReviews\\Reviews
=============================================

Reviews is a simple collection for hotel-reviews. It holds as many reviews the requests hotel has.
You can use :code:`foreach` to iterate over all reviews or use :code:`toArray()` to retrieve all reviews as an array.


count()
=======

.. code-block:: php

    public function int count()

Returns the number of reviews.


toArray()
=========

.. code-block:: php

    public function Review[] toArray()

Returns all reviews in an array.
