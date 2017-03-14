============================================
Trivago\\Tas\\Response\\HotelReviews\\Review
============================================

Representation of a review.


getConfig()
===========

.. code-block:: php

    public function Config getConfig()

Metainformation about the review.


getTitle()
==========

.. code-block:: php

    public function string getTitle()

The title of the review.


getSummary()
============

.. code-block:: php

    public function string getSummary()

A review summary.


isTruncated()
=============

.. code-block:: php

    public function bool isTruncated()

Indicator if the summary was truncated or not.


getRatingValue()
================

.. code-block:: php

    public function int getRatingValue()

The rating value the reviewer gave for the hotel.



getInfo()
=========

.. code-block:: php

    public function string getInfo()

Info is a combination of the reviewer-name and the date when this review was submitted.

